<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }










    public function index()
    {

        return view('admin.index');
    }

    public function getAdmins(Request $request)
    {
        $admins = Admin::latest()->get();

        return datatables()->of($admins)
            ->addColumn('action', function($admin) {
                // Use PHP's route() helper to generate URLs
                $editUrl = route('admin.edit', $admin->id);
                $deleteUrl = route('admin.destroy', $admin->id);

                // Return the action buttons as a plain string
                return '<a href="' . $editUrl . '" class="text-blue-600">Edit</a> |
                        <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirmDelete()" class="inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>';
            })
            ->make(true);
    }

    public function create()
    {
        // Fetch all features to associate with the plan
        $admins = Admin::all();
        return view('admin.create', compact('admins'));
    }

    public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email',
        'password' => [
            'required',
            'string',
            'min:8', // At least 8 characters
            'regex:/[a-z]/', // At least one lowercase letter
            'regex:/[A-Z]/', // At least one uppercase letter
            'regex:/[0-9]/', // At least one digit
            'regex:/[@$!%*?&]/', // At least one special character
        ],
    ]);

    // Secure admin creation
    Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.index')->with('success', 'Admin created successfully.');
}


    public function show(Admin $admin)
    {
        // Display the details of a single plan with its features
        return view('admin.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        // Pass the plan and its features for editing
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
{
    $admin = Admin::findOrFail($id);

    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => "required|email|unique:admins,email,{$id}",
        'password' => [
            'nullable',
            'string',
            'min:8',
            'regex:/[a-z]/', // At least one lowercase letter
            'regex:/[A-Z]/', // At least one uppercase letter
            'regex:/[0-9]/', // At least one digit
            'regex:/[@$!%*?&]/', // At least one special character
        ],
    ]);

    // Update admin details
    $admin->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password ? Hash::make($request->password) : $admin->password,
    ]);

    return redirect()->route('admin.index')->with('success', 'Admin updated successfully.');
}

    public function destroy(Admin $admin)
    {
        // Delete the plan and associated features
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin deleted successfully.');
    }

















}

