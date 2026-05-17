<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Layanan;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasDashboardController extends Controller
{
    /**
     * Display petugas dashboard.
     */
    public function index()
    {
        // Get petugas_id from logged in user
        $petugas = Petugas::where('user_id', Auth::id())->first();
        $petugasId = $petugas ? $petugas->id : null;

        // Get stats for the dashboard (filtered by petugas_id)
        $stats = [
            'total_permohonan' => Permohonan::where('petugas_id', $petugasId)->count(),
            'menunggu' => Permohonan::where('petugas_id', $petugasId)->where('status', 'menunggu')->count(),
            'diproses' => Permohonan::where('petugas_id', $petugasId)->where('status', 'diproses')->count(),
            'selesai' => Permohonan::where('petugas_id', $petugasId)->where('status', 'selesai')->count(),
            'ditolak' => Permohonan::where('petugas_id', $petugasId)->where('status', 'ditolak')->count(),
        ];

        // Recent permohonan (filtered by petugas_id)
        $recentPermohonan = Permohonan::with(['user','layanan'])
            ->where('petugas_id', $petugasId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get layanan for quick stats (filtered by petugas_id)
        $layananStats = [];
        $layananList = Layanan::where('status', 'aktif')->get();
        foreach ($layananList as $layanan) {
            $layananStats[$layanan->id] = [
                'total' => Permohonan::where('petugas_id', $petugasId)->where('layanan_id', $layanan->id)->count(),
                'pending' => Permohonan::where('petugas_id', $petugasId)->where('layanan_id', $layanan->id)->where('status', 'menunggu')->count(),
            ];
        }

        return view('petugas.dashboard.index', compact('stats', 'recentPermohonan', 'layananList', 'layananStats'));
    }
}
