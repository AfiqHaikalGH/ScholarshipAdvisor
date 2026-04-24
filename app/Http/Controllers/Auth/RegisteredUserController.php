<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $role = 'student'; // Force student role

        // Base validation rules
        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone_num' => ['nullable', 'string', 'max:20'],
            'password' => ['required', Rules\Password::defaults()],
            'address'        => ['nullable', 'string', 'max:255'],
            'gender'         => ['nullable', 'in:male,female,other'],
            'marital_status' => ['nullable', 'in:single,married,divorced,widowed'],
            'dob'            => ['nullable', 'date'],
            'nationality'    => ['nullable', 'string', 'max:100'],
            'birth_state'    => ['nullable', 'string', 'max:100'],
            'place_of_study' => ['nullable', 'string', 'max:255'],
            'study_location' => ['nullable', 'string', 'in:Local,Overseas'],
            'study_country'  => ['nullable', 'string', 'max:100'],
        ];

        $validated = $request->validate($rules);

        // Build user data array
        $userData = [
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone_num' => $validated['phone_num'] ?? null,
            'password'  => Hash::make($validated['password']),
            'role'      => $role,
            'address'        => $validated['address'] ?? null,
            'gender'         => $validated['gender'] ?? null,
            'marital_status' => $validated['marital_status'] ?? null,
            'dob'            => $validated['dob'] ?? null,
            'nationality'    => $validated['nationality'] ?? null,
            'birth_state'    => $validated['birth_state'] ?? null,
            'place_of_study' => $validated['place_of_study'] ?? null,
            'study_location' => $validated['study_location'] ?? null,
            'study_country'  => $validated['study_country'] ?? null,
        ];

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('scholarship.info');
    }
}
