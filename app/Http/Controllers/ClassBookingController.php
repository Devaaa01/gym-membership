<?php

namespace App\Http\Controllers;

use App\Models\ClassBooking;
use App\Models\GymClass;
use App\Models\Member;
use Illuminate\Http\Request;

class ClassBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassBooking::with(['member', 'gymClass.trainer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $members = Member::where('status', 'active')->orderBy('first_name')->get();
        $classes = GymClass::with('trainer')
            ->where('status', 'scheduled')
            ->where('schedule', '>=', now())
            ->orderBy('schedule')
            ->get();

        $selectedClass  = $request->class_id  ? GymClass::find($request->class_id)  : null;
        $selectedMember = $request->member_id ? Member::find($request->member_id) : null;

        return view('bookings.create', compact('members', 'classes', 'selectedClass', 'selectedMember'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'class_id'  => 'required|exists:classes,id',
            'status'    => 'required|in:booked,attended,cancelled,no_show',
            'notes'     => 'nullable|string|max:500',
        ]);

        // Check for duplicate booking
        $exists = ClassBooking::where('member_id', $validated['member_id'])
            ->where('class_id', $validated['class_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This member is already booked for this class.');
        }

        // Check capacity
        $gymClass = GymClass::findOrFail($validated['class_id']);
        $booked   = $gymClass->bookings()->whereIn('status', ['booked', 'attended'])->count();

        if ($booked >= $gymClass->max_capacity) {
            return back()->with('error', 'This class is fully booked.');
        }

        ClassBooking::create($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully!');
    }

    public function show(ClassBooking $booking)
    {
        $booking->load(['member', 'gymClass.trainer']);
        return view('bookings.show', compact('booking'));
    }

    public function edit(ClassBooking $booking)
    {
        $members = Member::where('status', 'active')->orderBy('first_name')->get();
        $classes = GymClass::with('trainer')->where('status', 'scheduled')->orderBy('schedule')->get();
        return view('bookings.edit', compact('booking', 'members', 'classes'));
    }

    public function update(Request $request, ClassBooking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:booked,attended,cancelled,no_show',
            'notes'  => 'nullable|string|max:500',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    public function destroy(ClassBooking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully!');
    }
}
