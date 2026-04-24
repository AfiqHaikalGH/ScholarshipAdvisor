<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminAccountController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function create()
    {
        return view('admin.create-admin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_num' => ['nullable', 'string', 'max:20'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_num' => $request->phone_num,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('scholarship.info')->with('status', 'Admin account successfully created.');
    }
}
