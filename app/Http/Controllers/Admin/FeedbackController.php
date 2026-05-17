<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Feedback::with(['user', 'layanan']);

        // Filter by rating
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', $request->rating);
        }

        // Filter by date range
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        // Search by user name or komentar
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->orWhere('komentar', 'like', '%' . $request->search . '%');
        }

        $feedback = $query->orderBy('tanggal', 'desc')->paginate(10);
    
        return view('admin.feedback.index', compact('feedback'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        $feedback->load(['user', 'layanan']);
        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        try {
            $feedback->delete();
            
            return redirect()->route('admin.feedback.index')
                ->with('success', 'Feedback berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.feedback.index')
                ->with('error', 'Gagal menghapus feedback: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard.
     */
    public function getStatistics()
    {
        $stats = [
            'total' => Feedback::count(),
            'average_rating' => Feedback::avg('rating') ? round(Feedback::avg('rating'), 1) : 0,
            'rating_distribution' => Feedback::select('rating', DB::raw('count(*) as total'))
                ->groupBy('rating')
                ->pluck('total', 'rating')
                ->toArray(),
        ];

        // Fill missing ratings
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($stats['rating_distribution'][$i])) {
                $stats['rating_distribution'][$i] = 0;
            }
        }

        return $stats;
    }
}