<?php

namespace App\Http\Controllers;

use App\Models\CatererProfile;

class CatererController extends Controller
{
    public function show($id)
    {
        $caterer = CatererProfile::with(['packages', 'user'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        return view('Caterer.caterer-show', compact('caterer'));
    }

    public function reviews($id)
    {
        $caterer = CatererProfile::with(['reviews.user'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        return view('Caterer.caterer-review', compact('caterer'));
    }

    public function gallery($id)
    {
        $caterer = CatererProfile::with(['gallery'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        return view('Caterer.caterer-gallery', compact('caterer'));
    }

    public function about($id)
    {
        $caterer = CatererProfile::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        return view('Caterer.caterer-about', compact('caterer'));
    }
}
