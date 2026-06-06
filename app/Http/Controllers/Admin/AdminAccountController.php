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

    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'representative'])
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $providers = \App\Models\Scholarship::whereNotNull('provider')->select('provider')->distinct()->pluck('provider');
        return view('admin.admins.create', compact('providers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_num' => ['nullable', 'string', 'max:20'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,representative'],
            'provider_name' => ['nullable', 'string', 'max:255', 'required_if:role,representative'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_num' => $request->phone_num,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'provider_name' => $request->role === 'representative' ? $request->provider_name : null,
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin account successfully created.');
    }

    public function edit(User $admin)
    {
        if (!in_array($admin->role, ['admin', 'representative'])) {
            abort(404);
        }

        if ($admin->id === auth()->id()) {
            return redirect()->route('profile.edit');
        }

        $providers = \App\Models\Scholarship::whereNotNull('provider')->select('provider')->distinct()->pluck('provider');
        return view('admin.admins.edit', compact('admin', 'providers'));
    }

    public function update(Request $request, User $admin)
    {
        if (!in_array($admin->role, ['admin', 'representative'])) {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', \Illuminate\Validation\Rule::unique(User::class)->ignore($admin->id)],
            'phone_num' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,representative'],
            'provider_name' => ['nullable', 'string', 'max:255', 'required_if:role,representative'],
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone_num = $request->phone_num;
        $admin->role = $request->role;
        $admin->provider_name = $request->role === 'representative' ? $request->provider_name : null;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admins.index')->with('success', 'Admin account updated successfully.');
    }

    public function destroy(User $admin)
    {
        if (!in_array($admin->role, ['admin', 'representative'])) {
            abort(404);
        }
        
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Admin account deleted successfully.');
    }
}
