<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user (hanya Admin yang bisa akses)
     */
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Menyimpan user baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,barista',
        ], [
            'email.unique'        => 'Email ini sudah terdaftar!',
            'password.min'        => 'Password minimal 6 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'store')
                ->withInput();
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Akun "' . $request->name . '" berhasil ditambahkan!');
    }

    /**
     * Mengupdate data user.
     * Akun dengan role 'admin' tidak dapat diubah.
     */
    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        // Proteksi: akun admin tidak boleh diedit
        if ($user->role === 'admin') {
            return back()->withErrors(['edit' => 'Akun admin tidak dapat diubah.']);
        }

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        $messages = [
            'email.unique'       => 'Email ini sudah digunakan akun lain!',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];

        // Password hanya divalidasi jika diisi
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|confirmed';
        }

        // Jalankan validasi — jika gagal, simpan info user ke session agar modal bisa re-open
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'update')
                ->withInput()
                ->with('edit_user_id',    $id)
                ->with('edit_user_name',  $user->name)
                ->with('edit_user_email', $user->email);
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        // Role tidak diubah — tetap barista

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Akun "' . $user->name . '" berhasil diperbarui!');
    }

    /**
     * Menghapus user (tidak bisa hapus diri sendiri)
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['hapus' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $namaUser = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Akun "' . $namaUser . '" berhasil dihapus.');
    }
}
