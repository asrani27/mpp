<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Layanan::with('instansi');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('syarat', 'like', '%' . $search . '%')
                  ->orWhere('lama_proses', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by instansi
        if ($request->has('instansi_id') && $request->instansi_id) {
            $query->where('instansi_id', $request->instansi_id);
        }

        $layanan = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $instansi = Instansi::where('status', 'aktif')->orderBy('nama')->get();
        
        return view('admin.layanan.index', compact('layanan', 'instansi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instansi = Instansi::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.layanan.create', compact('instansi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'instansi_id' => 'required|exists:instansi,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'syarat' => 'nullable|string',
            'lama_proses' => 'required|string|max:100',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Layanan::create($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        $layanan->load('instansi');
        return view('admin.layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        $instansi = Instansi::where('status', 'aktif')->orderBy('nama')->get();
        return view('admin.layanan.edit', compact('layanan', 'instansi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        $validator = Validator::make($request->all(), [
            'instansi_id' => 'required|exists:instansi,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'syarat' => 'nullable|string',
            'lama_proses' => 'required|string|max:100',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $layanan->update($request->all());

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}