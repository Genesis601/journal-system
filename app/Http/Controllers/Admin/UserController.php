<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewEditorAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'institution' => $request->institution,
            'country'     => $request->country,
            'phone'       => $request->phone,
        ]);

        $user->assignRole($request->role);

        // Send welcome email to new editors
        if ($request->role === 'editor') {
            try {
                Mail::to($user->email)
                    ->send(new NewEditorAccount(
                        $user->name,
                        $user->email,
                        $request->password
                    ));
            } catch (\Exception $e) {
                Log::error('New editor email failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.users.index')
                         ->with('success', ucfirst($request->role) . ' account created successfully!');
    }

    public function show($id)
    {
        $user  = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('admin.users.show', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User role updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully.');
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.show', $user->id)
                         ->with('success', 'Password reset successfully for ' . $user->name);
    }
}