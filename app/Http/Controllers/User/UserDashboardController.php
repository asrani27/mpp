<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Layanan;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_permohonan' => Permohonan::where('user_id', $user->id)->count(),
            'pending' => Permohonan::where('user_id', $user->id)->where('status', 'menunggu')->count(),
            'process' => Permohonan::where('user_id', $user->id)->where('status', 'diproses')->count(),
            'completed' => Permohonan::where('user_id', $user->id)->where('status', 'selesai')->count(),
            'total_feedback' => Feedback::where('user_id', $user->id)->count(),
            'avg_rating' => Feedback::where('user_id', $user->id)->avg('rating') ?? 0,
        ];

        $recentPermohonan = Permohonan::with('layanan')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $layanan = Layanan::where('status', 'aktif')->get();

        return view('user.dashboard', compact('stats', 'recentPermohonan', 'layanan'));
    }
}