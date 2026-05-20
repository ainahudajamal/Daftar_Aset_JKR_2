<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } else {
                $query->where('is_active', false);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|email|unique:users',
                'phone' => 'nullable|string|max:20',
                'department' => 'nullable|string|max:255',
                'password' => 'required|min:6|confirmed',
                'role' => 'required|in:admin,user',
                'is_active' => 'nullable|boolean',
            ], [
                'name.required' => 'Nama penuh diperlukan',
                'username.required' => 'Username diperlukan',
                'username.unique' => 'Username sudah digunakan',
                'email.required' => 'Email diperlukan',
                'email.unique' => 'Email sudah digunakan',
                'password.required' => 'Kata laluan diperlukan',
                'password.min' => 'Kata laluan sekurang-kurangnya 6 aksara',
                'password.confirmed' => 'Kata laluan tidak sepadan',
                'role.required' => 'Role diperlukan',
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $validated['is_active'] = $request->has('is_active') ? true : false;

            User::create($validated);

            return redirect()->route('admin.users.index')
                ->with('success', 'Pengguna berjaya ditambah!');

        } catch (\Exception $e) {

            Log::error('Tambah pengguna: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terdapat ralat semasa menambah pengguna.');

        }
        
    }

    /**
     * Show the form for editing the user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the user
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'phone' => 'nullable|string|max:20',
                'department' => 'nullable|string|max:255',
                'role' => 'required|in:admin,user',
                'is_active' => 'nullable|boolean',
            ], [
                'name.required' => 'Nama penuh diperlukan',
                'username.required' => 'Username diperlukan',
                'username.unique' => 'Username sudah digunakan',
                'email.required' => 'Email diperlukan',
                'email.unique' => 'Email sudah digunakan',
                'role.required' => 'Role diperlukan',
            ]);

            $validated['is_active'] = $request->has('is_active') ? true : false;

            $user->update($validated);

            return redirect()->route('admin.users.index')
                ->with('success', 'Pengguna berjaya dikemaskini!');

        }catch (\Exception $e) {

            Log::error('Error tambah pengguna: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terdapat ralat semasa Kemaskini pengguna.');
        }
        
    }

    /**
     * Remove the user
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak boleh memadam akaun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berjaya dipadam!');
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        // Prevent deactivating own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak boleh menyahaktifkan akaun sendiri!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinyahaktifkan';

        return back()->with('success', "Pengguna berjaya {$status}!");
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm(User $user)
    {
        return view('admin.users.reset-password', compact('user'));
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.required' => 'Kata laluan baru diperlukan',
            'new_password.min' => 'Kata laluan sekurang-kurangnya 6 aksara',
            'new_password.confirmed' => 'Kata laluan tidak sepadan',
        ]);

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Kata laluan berjaya dikemaskini!');
    }
}