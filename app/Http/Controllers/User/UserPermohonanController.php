<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Layanan;
use App\Models\Petugas;
use App\Models\StatusPermohonan;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserPermohonanController extends Controller
{
    /**
     * Display a listing of the user's permohonan.
     */
    public function index()
    {
        $permohonan = Permohonan::with('layanan')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.permohonan.index', compact('permohonan'));
    }

    /**
     * Show the form for creating a new permohonan.
     */
    public function create(Request $request)
    {
        $layanan = null;
        if ($request->has('layanan_id')) {
            $layanan = Layanan::find($request->layanan_id);
        }
        
        $layananList = Layanan::where('status', 'aktif')->get();
        $petugasList = Petugas::orderBy('nama')->get();
        
        // Get masyarakat data from authenticated user
        $masyarakat = Auth::user()->masyarakat;

        return view('user.permohonan.create', compact('layanan', 'layananList', 'petugasList', 'masyarakat'));
    }

    /**
     * Store a newly created permohonan in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'petugas_id' => 'required|exists:petugas,id',
            'nik' => 'required|string|max:16',
            'nama' => 'required|string|max:255',
            'keterangan' => 'required|string|max:1000',
        ]);

        $lastPermohonan = Permohonan::orderBy('id', 'desc')->first();
        $nextNumber = $lastPermohonan ? ((int) substr($lastPermohonan->nomor, -4)) + 1 : 1;
        $nomor = 'PMH-' . date('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $permohonan = Permohonan::create([
            'nomor' => $nomor,
            'tanggal' => Carbon::now(),
            'layanan_id' => $request->layanan_id,
            'petugas_id' => $request->petugas_id,
            'user_id' => Auth::id(),
            'nik' => $request->nik,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'status' => 'menunggu',
        ]);

        // Create initial status tracking
        StatusPermohonan::create([
            'permohonan_id' => $permohonan->id,
            'status' => 'menunggu',
            'keterangan' => 'Permohonan berhasil diajukan',
        ]);

        return redirect()->route('user.permohonan.index')
            ->with('success', 'Permohonan berhasil diajukan. Nomor permohonan: ' . $nomor);
    }

    /**
     * Display the specified permohonan.
     */
    public function show(Permohonan $permohonan)
    {
        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        // Load status tracking
        $statusTrackings = StatusPermohonan::where('permohonan_id', $permohonan->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.permohonan.show', compact('permohonan', 'statusTrackings'));
    }

    /**
     * Remove the specified permohonan from storage.
     */
    public function destroy(Permohonan $permohonan)
    {
        // Only allow user to delete their own permohonan
        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow delete if status is 'menunggu'
        if ($permohonan->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Permohonan tidak dapat dihapus karena sudah diproses.');
        }

        // Delete related status trackings
        StatusPermohonan::where('permohonan_id', $permohonan->id)->delete();

        // Delete the permohonan
        $permohonan->delete();

        return redirect()->route('user.permohonan.index')
            ->with('success', 'Permohonan berhasil dihapus.');
    }
}
