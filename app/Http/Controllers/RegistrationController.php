<?php

namespace App\Http\Controllers;
use App\Models\Conference;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        if (!$user->hasRole('client')) {
            abort(403, 'Unauthorized');
        }

        $conference = Conference::findOrFail($request->conference_id);

        if ($conference->start_date <= now()->toDateString()) {
            $message = sprintf('Conference "%s" has already started, registration is not allowed.', $conference->title);

            return redirect()->back()->with('error', $message);
        }

        if ($conference->status === 'cancelled') {
            $message = sprintf('Conference "%s" has been cancelled, registration is not allowed.', $conference->title);

            return redirect()->back()->with('error', $message);
        }

        $registration = $conference->users()->where('users.id', $user->id)->first();

        if ($registration) {
            if ($registration->pivot->status === 'confirmed') {
                $message = sprintf('You are already registered for "%s" conference.', $conference->title);

                return redirect()->back()->with('error', $message);
            }

            $conference->users()->updateExistingPivot($user->id, [
                'status' => 'confirmed',
            ]);

            $message = sprintf('Your registration for "%s" has been reactivated.', $conference->title);

            return redirect()->back()->with('success', $message);
        }

        $conference->users()->attach($user->id, ['status' => 'confirmed']);

        $message = sprintf('Successfully registered to a conference "%s".', $conference->title);

        return redirect()->back()->with('success', $message);
    }


    public function cancel(Request $request, Conference $conference)
    {
        $user = $request->user();

        if (!$user->hasRole('client')) {
            abort(403, 'Unauthorized');
        }

        $registration = $conference->users()->where('user_id', $user->id)->first();

        if ($registration?->pivot->status === 'cancelled') {
            $message = sprintf('Your registration for "%s" is already cancelled.', $conference->title);

            return redirect()->back()->with('error', $message);
        }

        if ($conference->start_date <= now()->toDateString()) {
            $message = sprintf('Conference "%s" has already started, cancellation is not allowed.', $conference->title);

            return redirect()->back()->with('error', $message);
        }

        $conference->users()->updateExistingPivot($user->id, [
            'status' => 'cancelled',
        ]);

        $message = sprintf('Successfully cancelled registration for conference "%s".', $conference->title);

        return redirect()->back()->with('success', $message);
    }
}
