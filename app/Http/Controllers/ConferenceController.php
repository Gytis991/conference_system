<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ConferenceController extends Controller
{
    public function manage(Request $request)
    {
        if (!$request->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $conferences = Conference::latest()->paginate(10);

        return view('conferences.conference-management', compact('conferences'));
    }

    public function getOne($id)
    {
        $conference = Conference::findOrFail($id);

        return view('conferences.conference-details', compact('conference'));
    }

    public function create(Request $request)
    {
        if (!$request->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'organizer'   => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        $conference = Conference::create($validated);

        $message = sprintf('Conference "%s" created successfully.', $conference->title);

        return redirect()->back()->with('success', $message);
    }

    public function update(Request $request, Conference $conference)
    {
        if (!$request->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        if (Carbon::parse($conference->start_date)->isPast()) {
            $message = sprintf('Conference "%s" has already started. You can only update conferences that have not started yet.', $conference->title);

            return redirect()->back()->with('error', $message);
        }

        if ($conference->status === 'cancelled') {
            $message = sprintf('Conference "%s" has been cancelled. You can no longer edit it.', $conference->title);

            return redirect()->back()->with('error', $message);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'organizer'   => 'required|string|max:255',
            'description' => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        $conference->update($validated);

        $message = sprintf('Conference "%s" updated successfully.', $conference->title);

        return redirect()->back()->with('success', $message);
    }

    public function cancel(Request $request, Conference $conference)
    {
        if (!$request->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        if (Carbon::parse($conference->start_date)->isPast()) {
            $message = sprintf('Conference "%s" has already started. You can only cancel conferences that have not started yet.', $conference->title);

            return redirect()->back()->with('error', $message);
        }

        if ($conference->status === 'cancelled') {
            $message = sprintf('Conference "%s" is already cancelled.', $conference->title);

            return redirect()->back()->with('error', $message);
        }

        $conference->update(['status' => 'cancelled']);

        $message = sprintf('Conference "%s" cancelled successfully.', $conference->title);

        return redirect()->back()->with('success', $message);
    }

    public function getAll(Request $request)
    {
        if (!$request->user()->hasRole('client')) {
            abort(403, 'Unauthorized');
        }

        $conferences = Conference::latest()->paginate(10);

        return view('conferences.all-conferences', compact('conferences'));
    }

    public function getMyConferences(Request $request)
    {
        if (!$request->user()->hasRole('client')) {
            abort(403, 'Unauthorized');
        }

        $user = $request->user();
        $conferences = $user->conferences()->paginate(10);

        return view('conferences.my-conferences', compact('conferences'));
    }
}
