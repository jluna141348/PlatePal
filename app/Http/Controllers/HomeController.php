<?php

namespace App\Http\Controllers;

use App\Models\CatererProfile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCaterers = CatererProfile::where('is_featured', true)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->take(6)
            ->get();

        return view('LandingPage.home', compact('featuredCaterers'));
    }

    public function browse(Request $request)
    {
        $query = CatererProfile::withCount('reviews')->withAvg('reviews', 'rating');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('business_name', 'like', '%'.$request->search.'%')
                    ->orWhere('cuisine_type', 'like', '%'.$request->search.'%')
                    ->orWhere('barangay', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('location')) {
            $query->where('barangay', 'like', '%'.$request->location.'%');
        }

        if ($request->filled('price')) {
            switch ($request->price) {
                case 'budget':
                    $query->where('price_min', '<=', 400);
                    break;
                case 'mid':
                    $query->whereBetween('price_min', [400, 600]);
                    break;
                case 'premium':
                    $query->where('price_min', '>=', 600);
                    break;
            }
        }

        if ($request->filled('rating')) {
            $query->havingRaw('AVG(reviews.rating) >= ?', [$request->rating]);
        }

        $caterers = $query->paginate(6);

        return view('Caterer.browse', compact('caterers'));
    }
}
