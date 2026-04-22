<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CatererProfile;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create($catererId)
    {
        $caterer = CatererProfile::with('packages')->findOrFail($catererId);
        $packages = Package::where('caterer_profile_id', $catererId)->get();

        return view('client.booking-create', compact('caterer', 'packages'));
    }

    public function store(Request $request, $catererId)
    {
        $data = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'event_time' => 'required',
            'guest_count' => 'required|integer|min:1',
            'package_id' => 'required|exists:packages,id',
            'venue' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $package = Package::findOrFail($data['package_id']);

        Booking::create([
            'client_id' => Auth::id(),
            'caterer_profile_id' => $catererId,
            'package_id' => $data['package_id'],
            'event_name' => $data['event_name'],
            'event_date' => $data['event_date'],
            'event_time' => $data['event_time'],
            'guest_count' => $data['guest_count'],
            'venue' => $data['venue'],
            'notes' => $data['notes'] ?? null,
            'total_amount' => $package->price * $data['guest_count'],
            'status' => 'pending',
        ]);

        return redirect()->route('client.bookings')->with('success', 'Booking request sent! The caterer will confirm shortly.');
    }

    public function show($id)
    {
        $booking = Booking::with(['catererProfile', 'package'])->where('client_id', Auth::id())->findOrFail($id);

        return view('client.booking-show', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::where('client_id', Auth::id())->findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled.');
    }
}
