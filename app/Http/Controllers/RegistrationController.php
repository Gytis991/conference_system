<?php

namespace App\Http\Controllers;
use App\Models\Conference;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('client')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conference = Conference::findOrFail($request->conference_id);

        if ($conference->start_date <= now()->toDateString()) {
            return response()->back()->with('error', 'You can only register to conferences that did not start yet');
        }

        $conference->users()->attach($user->id, ['status' => 'confirmed']);

        return response()->back()->with('success', 'Successfully registered to a conference');
    }

    public function cancel(Request $request,)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('client')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conference = Conference::findOrFail($request->conference_id);

        if ($conference->start_date <= now()->toDateString()) {
            return response()->back()->with('error', 'You can only register to conferences that did not start yet');
        }

        $conference->users()->attach($user->id, ['status' => 'confirmed']);

        return response()->back()->with('success', 'Successfully registered to a conference');
    }
}
