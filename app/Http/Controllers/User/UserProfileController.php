<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    /**
     * Display the user profile.
     */
    public function index()
    {
        $user = Auth::user();
        $masyarakat = $user->masyarakat;
        
        return view('user.profile.index', compact('user', 'masyarakat'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $masyarakat = $user->masyarakat;

        // Validate masyarakat data
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:masyarakat,email,' . $masyarakat->id,
            'nik' => 'required|string|size:16|unique:masyarakat,nik,' . $masyarakat->id,
            'telp' => 'required|string|max:15',
            'jabatan' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update masyarakat data
        $masyarakat->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'nik' => $request->nik,
            'telp' => $request->telp,
            'jabatan' => $request->jabatan,
        ]);

        // Update user email if changed
        if ($request->email !== $user->email) {
            $user->update(['email' => $request->email]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}