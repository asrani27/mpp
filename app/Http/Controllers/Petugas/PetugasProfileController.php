<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetugasProfileController extends Controller
{
    /**
     * Display petugas profile.
     */
    public function index()
    {
        $user = Auth::user();
        $petugas = Petugas::where('user_id', $user->id)->first();

        return view('petugas.profil.index', compact('user', 'petugas'));
    }

    /**
     * Update petugas profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $petugas = Petugas::where('user_id', $user->id)->first();

        if (!$petugas) {
            return redirect()->back()->with('error', 'Data petugas tidak ditemukan.');
        }

        // Update user email
        $user->email = $request->email;
        $user->save();

        // Update petugas data
        $petugas->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('petugas.profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update petugas password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak cocok.');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('petugas.profil.index')->with('success', 'Password berhasil diperbarui.');
    }
}