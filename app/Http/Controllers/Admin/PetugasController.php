<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\Instansi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Petugas::with(['user', 'instansi']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%');
            });
        }

        // Filter by instansi
        if ($request->has('instansi_id') && $request->instansi_id) {
            $query->where('instansi_id', $request->instansi_id);
        }

        $petugas = $query->orderBy('created_at', 'desc')->paginate(10);
        $instansi = Instansi::where('status', 'aktif')->orderBy('nama')->get();
        
        return view('admin.petugas.index', compact('petugas', 'instansi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instansi = Instansi::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.petugas.create', compact('instansi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:20|unique:petugas,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'jabatan' => 'required|string|max:100',
            'telp' => 'nullable|string|max:20',
            'instansi_id' => 'required|exists:instansi,id',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user first with role 'petugas'
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas', // Automatic role as petugas
        ]);

        // Create petugas
        Petugas::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'telp' => $request->telp,
            'instansi_id' => $request->instansi_id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Petugas $petugas)
    {
        return view('admin.petugas.show', compact('petugas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Petugas $petugas)
    {
        $instansi = Instansi::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.petugas.edit', compact('petugas', 'instansi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Petugas $petugas)
    {
        $rules = [
            'nip' => 'required|string|max:20|unique:petugas,nip,' . $petugas->id,
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:100',
            'telp' => 'nullable|string|max:20',
            'instansi_id' => 'required|exists:instansi,id',
        ];

        // Add email validation if changed
        if ($request->email !== $petugas->email) {
            $rules['email'] = 'required|email|unique:users,email';
        }

        // Add password validation if provided
        if ($request->password) {
            $rules['password'] = 'min:6|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user
        $userData = [
            'name' => $request->nama,
        ];
        if ($request->email !== $petugas->email) {
            $userData['email'] = $request->email;
        }
        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }
        $petugas->user->update($userData);

        // Update petugas
        $petugas->update($request->except('email', 'password', 'password_confirmation'));

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Petugas $petugas)
    {
        // Delete user first
        $petugas->user->delete();
        
        // Delete petugas
        $petugas->delete();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil dihapus!');
    }
}