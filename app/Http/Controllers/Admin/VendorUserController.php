<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class VendorUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->withTrashed()->with('vendor')->where('role', 'vendor');

        if ($search = trim((string) $request->query('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderByDesc('id')->paginate(20)->withQueryString();

        return view('admin.vendor-users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('admin.vendor-users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'password' => ['required', 'string', 'min:8'],
            'nama_vendor' => ['required', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'vendor',
            'password' => Hash::make($data['password']),
        ]);

        Vendor::create([
            'user_id' => $user->id,
            'nama_vendor' => $data['nama_vendor'],
            'lokasi' => $data['lokasi'] ?? null,
            'kategori' => $data['kategori'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
        ]);

        return redirect()->route('admin.vendor-users.index')->with('status', 'Vendor user berhasil dibuat.');
    }

    public function edit(User $user)
    {
        if ($user->role !== 'vendor') {
            abort(404);
        }

        $user->load('vendor');

        return view('admin.vendor-users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'vendor') {
            abort(404);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id)->whereNull('deleted_at'),
            ],
            'nama_vendor' => ['required', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        Vendor::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_vendor' => $data['nama_vendor'],
                'lokasi' => $data['lokasi'] ?? null,
                'kategori' => $data['kategori'] ?? null,
                'deskripsi' => $data['deskripsi'] ?? null,
            ]
        );

        return redirect()->route('admin.vendor-users.index')->with('status', 'Vendor user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'vendor') {
            abort(404);
        }

        $admin = Auth::user();
        if (! $admin->can('delete', $user)) {
            abort(403, 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.vendor-users.index')->with('status', 'Vendor user berhasil dihapus.');
    }

    public function restore(User $user)
    {
        $user->restore();

        return redirect()->route('admin.vendor-users.index')->with('status', 'Vendor user berhasil dipulihkan.');
    }

    public function resetPassword(Request $request, User $user)
    {
        if ($user->role !== 'vendor') {
            abort(404);
        }

        $data = $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.vendor-users.edit', $user)->with('status', 'Password berhasil direset.');
    }
}
