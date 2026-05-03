<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use App\Models\Trainer;
use Illuminate\Http\Request;

class GymClassController extends Controller
{
    public function index(Request $request)
    {
        $query = GymClass::with('trainer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $classes    = $query->orderBy('schedule', 'desc')->paginate(10)->withQueryString();
        $categories = GymClass::distinct()->pluck('category');

        return view('classes.index', compact('classes', 'categories'));
    }

    public function create()
    {
        $trainers = Trainer::where('is_active', true)->orderBy('first_name')->get();
        return view('classes.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trainer_id'       => 'required|exists:trainers,id',
            'name'             => 'required|string|max:100',
            'description'      => 'nullable|string|max:1000',
            'category'         => 'required|string|max:50',
            'schedule'         => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:240',
            'max_capacity'     => 'required|integer|min:1|max:200',
            'room'             => 'nullable|string|max:50',
            'status'           => 'required|in:scheduled,cancelled,completed',
        ]);

        GymClass::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class scheduled successfully!');
    }

    public function show(GymClass $class)
    {
        $class->load(['trainer', 'bookings.member']);
        return view('classes.show', compact('class'));
    }

    public function edit(GymClass $class)
    {
        $trainers = Trainer::where('is_active', true)->orderBy('first_name')->get();
        return view('classes.edit', compact('class', 'trainers'));
    }

    public function update(Request $request, GymClass $class)
    {
        $validated = $request->validate([
            'trainer_id'       => 'required|exists:trainers,id',
            'name'             => 'required|string|max:100',
            'description'      => 'nullable|string|max:1000',
            'category'         => 'required|string|max:50',
            'schedule'         => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:240',
            'max_capacity'     => 'required|integer|min:1|max:200',
            'room'             => 'nullable|string|max:50',
            'status'           => 'required|in:scheduled,cancelled,completed',
        ]);

        $class->update($validated);

        return redirect()->route('classes.show', $class)
            ->with('success', 'Class updated successfully!');
    }

    public function destroy(GymClass $class)
    {
        $class->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Class deleted successfully!');
    }
}
