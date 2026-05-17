<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Layanan;
use App\Models\StatusPermohonan;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasPermohonanController extends Controller
{
    /**
     * Display list of permohonan masuk.
     */
    public function index(Request $request)
    {
        // Get petugas_id from logged in user
        $petugas = Petugas::where('user_id', Auth::id())->first();
        $petugasId = $petugas ? $petugas->id : null;

        $query = Permohonan::with(['user', 'layanan'])->where('petugas_id', $petugasId);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by layanan
        if ($request->has('layanan_id') && $request->layanan_id) {
            $query->where('layanan_id', $request->layanan_id);
        }

        // Search by nomor or nama
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $permohonan = $query->orderBy('created_at', 'desc')->paginate(10);
        $layananList = Layanan::where('status', 'aktif')->orderBy('nama')->get();

        // Stats (filtered by petugas_id)
        $stats = [
            'total' => Permohonan::where('petugas_id', $petugasId)->count(),
            'menunggu' => Permohonan::where('petugas_id', $petugasId)->where('status', 'menunggu')->count(),
            'diproses' => Permohonan::where('petugas_id', $petugasId)->where('status', 'diproses')->count(),
            'selesai' => Permohonan::where('petugas_id', $petugasId)->where('status', 'selesai')->count(),
            'ditolak' => Permohonan::where('petugas_id', $petugasId)->where('status', 'ditolak')->count(),
        ];

        return view('petugas.permohonan.index', compact('permohonan', 'layananList', 'stats'));
    }

    /**
     * Display detail of permohonan.
     */
    public function show(Permohonan $permohonan)
    {
        $permohonan->load(['user', 'layanan', 'statusTrackings']);

        return view('petugas.permohonan.show', compact('permohonan'));
    }

    /**
     * Update status of permohonan.
     */
    public function updateStatus(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $oldStatus = $permohonan->status;

        $permohonan->update([
            'status' => $request->status,
        ]);

        // Create status history
        $statusLabel = [
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        StatusPermohonan::create([
            'permohonan_id' => $permohonan->id,
            'status' => $request->status,
            'keterangan' => $request->keterangan ?? 'Status diubah dari ' . ($statusLabel[$oldStatus] ?? $oldStatus) . ' menjadi ' . ($statusLabel[$request->status] ?? $request->status),
        ]);

        return redirect()->route('petugas.permohonan.index')->with('success', 'Status permohonan berhasil diperbarui.');
    }
}