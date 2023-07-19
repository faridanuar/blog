<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        $user = request()->user();
        return view('password.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required|min:6|current_password',
            'new_password' => 'required|min:6',
            'retype_password' => 'required|min:6|same:new_password',
        ]);

        request()->user()->update([
            'password' => $validated['new_password'],
        ]);

        return back()->with('success', 'Password Updated!');
    }
}
