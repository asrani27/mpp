<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\StatusPermohonan;
use App\Models\Layanan;
use App\Models\Petugas;
use App\Models\User;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Permohonan::with(['layanan', 'petugas', 'user']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by layanan
        if ($request->has('layanan_id') && $request->layanan_id) {
            $query->where('layanan_id', $request->layanan_id);
        }

        $permohonan = $query->orderBy('created_at', 'desc')->paginate(10);
        $layanan = Layanan::where('status', 'aktif')->orderBy('nama')->get();
        
        return view('admin.permohonan.index', compact('permohonan', 'layanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $layanan = Layanan::where('status', 'aktif')->orderBy('nama')->get();
        $petugas = Petugas::with('instansi')->orderBy('nama')->get();
        
        // Generate nomor permohonan
        $lastPermohonan = Permohonan::orderBy('id', 'desc')->first();
        $nextNumber = $lastPermohonan ? $lastPermohonan->id + 1 : 1;
        $nomor = 'PLM-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        return view('admin.permohonan.create', compact('layanan', 'petugas', 'nomor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor' => 'required|string|max:50|unique:permohonan,nomor',
            'tanggal' => 'required|date',
            'layanan_id' => 'required|exists:layanan,id',
            'petugas_id' => 'nullable|exists:petugas,id',
            'nik' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if user exists or create new
        $user = User::where('email', $request->email ?? strtolower(str_replace(' ', '', $request->nama)) . '@example.com')->first();
        
        if (!$user) {
            // Create user for masyarakat
            $user = User::create([
                'name' => $request->nama,
                'email' => strtolower(str_replace(' ', '', $request->nama)) . time() . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]);
        }
        
        // Create permohonan
        $permohonan = Permohonan::create([
            'nomor' => $request->nomor,
            'tanggal' => $request->tanggal,
            'layanan_id' => $request->layanan_id,
            'petugas_id' => $request->petugas_id,
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'status' => 'menunggu',
        ]);

        // Create initial status tracking
        StatusPermohonan::create([
            'permohonan_id' => $permohonan->id,
            'status' => 'menunggu',
            'keterangan' => 'Permohonan baru diajukan',
        ]);

        return redirect()->route('admin.permohonan.index')
            ->with('success', 'Data permohonan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permohonan $permohonan)
    {
        $permohonan->load(['layanan.instansi', 'petugas', 'user', 'statusTrackings.petugas']);
        return view('admin.permohonan.show', compact('permohonan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permohonan $permohonan)
    {
        $layanan = Layanan::where('status', 'aktif')->orderBy('nama')->get();
        $petugas = Petugas::with('instansi')->orderBy('nama')->get();
        return view('admin.permohonan.edit', compact('permohonan', 'layanan', 'petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permohonan $permohonan)
    {
        $rules = [
            'nomor' => 'required|string|max:50|unique:permohonan,nomor,' . $permohonan->id,
            'tanggal' => 'required|date',
            'layanan_id' => 'required|exists:layanan,id',
            'nik' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ];

        // Add status validation
        if ($request->status && $request->status !== $permohonan->status) {
            $rules['status'] = 'required|in:menunggu,diproses,ditolak,selesai';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update permohonan
        $permohonan->update($request->except('_token', '_method'));

        // If status changed, create new tracking
        if ($request->status && $request->status !== $permohonan->getOriginal('status')) {
            $statusLabel = [
                'menunggu' => 'Menunggu',
                'diproses' => 'Sedang Diproses',
                'ditolak' => 'Ditolak',
                'selesai' => 'Selesai',
            ];
            
            StatusPermohonan::create([
                'permohonan_id' => $permohonan->id,
                'status' => $request->status,
                'keterangan' => $request->status_keterangan ?? 'Status diubah menjadi ' . ($statusLabel[$request->status] ?? $request->status),
                'petugas_id' => Auth::id() ? Petugas::where('user_id', Auth::id())->first()?->id : null,
            ]);
        }

        return redirect()->route('admin.permohonan.index')
            ->with('success', 'Data permohonan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permohonan $permohonan)
    {
        $permohonan->delete();

        return redirect()->route('admin.permohonan.index')
            ->with('success', 'Data permohonan berhasil dihapus!');
    }

    /**
     * Update status with tracking
     */
    public function updateStatus(Request $request, Permohonan $permohonan)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:menunggu,diproses,ditolak,selesai',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $oldStatus = $permohonan->status;
        $permohonan->update(['status' => $request->status]);

        // Create status tracking
        $statusLabel = [
            'menunggu' => 'Menunggu',
            'diproses' => 'Sedang Diproses',
            'ditolak' => 'Ditolak',
            'selesai' => 'Selesai',
        ];

        StatusPermohonan::create([
            'permohonan_id' => $permohonan->id,
            'status' => $request->status,
            'keterangan' => $request->keterangan ?? 'Status diubah dari ' . ($statusLabel[$oldStatus] ?? $oldStatus) . ' menjadi ' . ($statusLabel[$request->status] ?? $request->status),
            'petugas_id' => Auth::id() ? Petugas::where('user_id', Auth::id())->first()?->id : null,
        ]);

        return redirect()->back()
            ->with('success', 'Status permohonan berhasil diperbarui!');
    }
}