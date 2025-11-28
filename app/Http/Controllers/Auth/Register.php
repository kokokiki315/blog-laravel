<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class Register extends Controller
{
    public function create()
    {
        return view('auth.register'); // We will create this view next
    }
    /**
     * Handle the Registration Logic
     */
    public function store(Request $request)
    {
        // 1. Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Fire the Registered event (Sends the email!)
        event(new Registered($user));

        // 4. Log them in
        Auth::login($user);

        // 5. Redirect to the Verification Notice page
        // (This is the specific route we created earlier in web.php)
        return redirect()->route('verification.notice');
    }
}