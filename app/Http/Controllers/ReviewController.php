<?php

namespace App\Http\Controllers;

use App\Models\CatererProfile;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($catererId)
    {
        $caterer = CatererProfile::findOrFail($catererId);

        return view('client.review-create', compact('caterer'));
    }

    public function store(Request $request, $catererId)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'event_type' => 'required|string|max:100',
        ]);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'caterer_profile_id' => $catererId],
            [
                'rating' => $data['rating'],
                'comment' => $data['comment'],
                'event_type' => $data['event_type'],
            ]
        );

        return redirect()->route('caterer.reviews', $catererId)->with('success', 'Review submitted! Thank you.');
    }
}
