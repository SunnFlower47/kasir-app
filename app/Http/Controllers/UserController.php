<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::all();  // Ambil semua pengguna
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan halaman untuk membuat user baru
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,kasir',
            'photo' => 'nullable|image|max:2048'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role']
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dibuat');
    }

    // Menampilkan halaman edit untuk user tertentu
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Memperbarui informasi user
    public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'role' => 'required|in:admin,kasir',
        'photo' => 'nullable|image|max:2048'
    ]);

    $updateData = [
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role']
    ];

    if ($request->filled('password')) {
        $updateData['password'] = bcrypt($validated['password']);
    }

    if ($request->hasFile('photo')) {
        // Simpan file foto ke storage
        $path = $request->file('photo')->store('profile-photos', 'public');

        // Jika user sebelumnya sudah ada foto, kamu bisa hapus filenya dulu (opsional)
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $updateData['photo'] = $path;
    }

    $user->update($updateData);

    return redirect()->route('admin.users.index')
                     ->with('success', 'User berhasil diperbarui');
}

}
