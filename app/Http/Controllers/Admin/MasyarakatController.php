<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Masyarakat::with('user');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%');
            });
        }

        $masyarakat = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.masyarakat.index', compact('masyarakat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.masyarakat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|max:20|unique:masyarakat,nik',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'jabatan' => 'nullable|string|max:100',
            'telp' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user first
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),   
            'role' => 'user', // Default role for masyarakat
        ]);

        // Create masyarakat
        Masyarakat::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'telp' => $request->telp,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.masyarakat.index')
            ->with('success', 'Data masyarakat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Masyarakat $masyarakat)
    {
        return view('admin.masyarakat.show', compact('masyarakat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Masyarakat $masyarakat)
    {
        return view('admin.masyarakat.edit', compact('masyarakat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Masyarakat $masyarakat)
    {
        $rules = [
            'nik' => 'required|string|max:20|unique:masyarakat,nik,' . $masyarakat->id,
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'telp' => 'nullable|string|max:20',
        ];

        // Add email validation if changed
        if ($request->email !== $masyarakat->email) {
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
        if ($request->email !== $masyarakat->email) {
            $userData['email'] = $request->email;
        }
        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }
        $masyarakat->user->update($userData);

        // Update masyarakat
        $masyarakat->update($request->except('email', 'password', 'password_confirmation'));

        return redirect()->route('admin.masyarakat.index')
            ->with('success', 'Data masyarakat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Masyarakat $masyarakat)
    {
        // Delete user first
        $masyarakat->user->delete();
        
        // Delete masyarakat
        $masyarakat->delete();

        return redirect()->route('admin.masyarakat.index')
            ->with('success', 'Data masyarakat berhasil dihapus!');
    }
}