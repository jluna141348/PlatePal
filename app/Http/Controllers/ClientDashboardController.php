<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    public function index()
    {
        return view('client.dashboard');
    }

    public function bookings()
    {
        return view('client.bookings');
    }

    public function saved()
    {
        return view('client.saved');
    }

    public function messages()
    {
        return view('client.messages');
    }

    public function myReviews()
    {
        $reviews = Review::with('catererProfile')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('client.reviews', compact('reviews'));
    }

    public function settings()
    {
        return view('client.settings', ['user' => Auth::user()]);
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($data);

        return back()->with('success', 'Settings updated successfully.');
    }
}
