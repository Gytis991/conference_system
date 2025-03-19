<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getClients(Request $request)
    {
        if (!$request->user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $users = User::where('roles', 'LIKE', '%client%')->latest('name')->paginate(10);

        return view('conferences.clients', compact('users'));
    }
}
