<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Layanan;
use App\Models\Masyarakat;
use App\Models\Petugas;
use App\Models\Permohonan;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'instansi' => Instansi::count(),
            'layanan' => Layanan::count(),
            'masyarakat' => Masyarakat::count(),
            'petugas' => Petugas::count(),
            'permohonan' => Permohonan::count(),
            'permohonan_pending' => Permohonan::where('status', 'menunggu')->count(),
            'permohonan_process' => Permohonan::where('status', 'diproses')->count(),
            'permohonan_completed' => Permohonan::where('status', 'selesai')->count(),
            'feedback' => Feedback::count(),
            'avg_rating' => Feedback::avg('rating') ?? 0,
        ];

        $recentPermohonan = Permohonan::with('layanan')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentFeedback = Feedback::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPermohonan', 'recentFeedback'));
    }
}