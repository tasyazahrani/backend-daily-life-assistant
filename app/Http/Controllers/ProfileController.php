<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Hanya pengguna yang terautentikasi yang dapat mengakses halaman profil
    }

    // Menampilkan profil pengguna
        public function show($id)
    {
        $user = User::findOrFail($id); // Pastikan ini sesuai dengan ID yang di URL
        return view('profile', compact('user'));
    }


    // Memperbarui profil pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'birthdate' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        
        // Update data pengguna
        $user->update($request->only(['name', 'email', 'phone', 'birthdate']));

        // Update foto profil jika ada
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->update(['profile_picture' => $path]);
        }

        return redirect()->route('profile.show', ['id' => $user->id])->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'], // kamu bisa pake 'confirmed' kalau input pakai 'new_password_confirmation'
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama salah.'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password berhasil diubah.']);
    }

    // Hapus Akun
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        Auth::logout();

        // Hapus akun user
        $user->delete();

        return response()->json(['success' => true, 'message' => 'Akun berhasil dihapus.']);
    }
}
