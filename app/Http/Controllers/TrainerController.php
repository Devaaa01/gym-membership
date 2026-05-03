<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    public function index(Request $request)
    {
        $query = Trainer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $trainers = $query->withCount('classes')->latest()->paginate(10)->withQueryString();

        return view('trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('trainers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:trainers,email',
            'phone'          => 'nullable|string|max:20',
            'specialization' => 'required|string|max:100',
            'bio'            => 'nullable|string|max:1000',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'      => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('trainers', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        Trainer::create($validated);

        return redirect()->route('trainers.index')
            ->with('success', 'Trainer added successfully!');
    }

    public function show(Trainer $trainer)
    {
        $trainer->load(['classes' => function ($q) {
            $q->orderBy('schedule', 'desc');
        }]);
        return view('trainers.show', compact('trainer'));
    }

    public function edit(Trainer $trainer)
    {
        return view('trainers.edit', compact('trainer'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:trainers,email,' . $trainer->id,
            'phone'          => 'nullable|string|max:20',
            'specialization' => 'required|string|max:100',
            'bio'            => 'nullable|string|max:1000',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'      => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            if ($trainer->photo) {
                Storage::disk('public')->delete($trainer->photo);
            }
            $validated['photo'] = $request->file('photo')->store('trainers', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $trainer->update($validated);

        return redirect()->route('trainers.show', $trainer)
            ->with('success', 'Trainer updated successfully!');
    }

    public function destroy(Trainer $trainer)
    {
        if ($trainer->classes()->exists()) {
            return back()->with('error', 'Cannot delete trainer with existing classes.');
        }

        if ($trainer->photo) {
            Storage::disk('public')->delete($trainer->photo);
        }

        $trainer->delete();

        return redirect()->route('trainers.index')
            ->with('success', 'Trainer deleted successfully!');
    }
}
