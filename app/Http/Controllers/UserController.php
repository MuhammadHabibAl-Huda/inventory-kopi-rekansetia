<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,barista',
        ], [
            'email.unique'        => 'Email ini sudah terdaftar!',
            'password.min'        => 'Password minimal 6 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

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
     * Menghapus user (tidak bisa hapus diri sendiri)
     */
    public function destroy($id)
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
