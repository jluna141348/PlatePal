<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function show($userId)
    {
        $other = User::findOrFail($userId);

        $messages = Message::where(function ($q) use ($userId) {
            $q->where('sender_id', Auth::id())
                ->where('receiver_id', $userId);
        })
            ->orWhere(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get();

        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $conversations = $this->buildConversationList();

        $activeInitials = strtoupper(substr($other->name, 0, 2));
        $activeName = optional($other->catererProfile)->business_name ?? $other->name;
        $activeCatererId = optional($other->catererProfile)->id;
        $activeUserId = $other->id;
        $activeConversation = $other->id;

        return view('shared.messages', compact(
            'messages', 'conversations',
            'activeInitials', 'activeName',
            'activeCatererId', 'activeUserId', 'activeConversation'
        ));
    }

    public function send(Request $request, $userId)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'body' => $request->body,
        ]);

        broadcast(new MessageSent($message));

        if ($request->expectsJson()) {
            return response()->json([
                'id' => $message->id,
                'body' => $message->body,
                'time' => $message->created_at->format('g:i A'),
            ]);
        }

        return back();
    }

    private function buildConversationList(): array
    {
        $userId = Auth::id();

        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn ($m) => $m->sender_id === $userId ? $m->receiver_id : $m->sender_id);

        $conversations = [];

        foreach ($messages as $partnerId => $msgs) {
            $partner = User::find($partnerId);
            if (! $partner) {
                continue;
            }

            $latest = $msgs->first();
            $unread = $msgs->where('receiver_id', $userId)->where('is_read', false)->count();

            $conversations[] = [
                'id' => $partner->id,
                'name' => optional($partner->catererProfile)->business_name ?? $partner->name,
                'initials' => strtoupper(substr($partner->name, 0, 2)),
                'preview' => $latest->body,
                'time' => $latest->created_at->diffForHumans(short: true),
                'unread' => $unread > 0,
                'online' => false,
            ];
        }

        return $conversations;
    }
}
