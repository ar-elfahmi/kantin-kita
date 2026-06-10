<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private array $roles = ['admin', 'vendor', 'customer', 'guest'];

    public function index(Request $request)
    {
        $query = User::query()->withTrashed();

        if ($search = trim((string) $request->query('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->query('role')) {
            if (in_array($role, $this->roles, true)) {
                $query->where('role', $role);
            }
        }

        $users = $query->orderByDesc('id')->paginate(20)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => $this->roles,
            'search' => $search,
            'roleFilter' => $role,
        ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'roles' => $this->roles,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'role' => ['required', Rule::in($this->roles)],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.users.index')->with('status', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $this->roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $admin = Auth::user();

        if (! $admin->can('update', $user)) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id)->whereNull('deleted_at'),
            ],
            'role' => ['required', Rule::in($this->roles)],
        ]);

        if ($admin->id === $user->id && $data['role'] !== 'admin') {
            return back()->withErrors([
                'role' => 'Anda tidak dapat menurunkan role akun Anda sendiri.',
            ])->withInput();
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $admin = Auth::user();

        if (! $admin->can('delete', $user)) {
            abort(403, 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User berhasil dihapus.');
    }

    public function restore(User $user)
    {
        $user->restore();

        return redirect()->route('admin.users.index')->with('status', 'User berhasil dipulihkan.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.users.edit', $user)->with('status', 'Password berhasil direset.');
    }
}
