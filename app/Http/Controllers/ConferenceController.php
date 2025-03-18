<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'organizer' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Conference::create($validated);

        return redirect()->back()->with('success', 'Conference created successfully.');
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $conference = Conference::findOrFail($id);

        $conference->update([
            'title' => $request->title,
            'organizer' => $request->organizer,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->back()->with('success', 'Conference updated successfully.');
    }

    public function cancel(Request $request, $id)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conference = Conference::findOrFail($id);

        if ($conference->start_date <= now()->toDateString()) {
            return response()->back()->with('error', 'You can only cancel conferences that did not start yet');
        }
        $conference->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Conference cancelled successfully.');
    }
    public function getAll(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        //TODO: maybe pagination if will have time
        $conferences = Conference::all();
        return response()->json($conferences);
    }

    public function getOne(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conference = Conference::findOrFail($id);
        return response()->json($conference);
    }
}
