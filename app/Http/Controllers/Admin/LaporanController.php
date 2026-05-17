<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.laporan.index');
    }

    /**
     * Export laporan petugas to PDF.
     */
    public function exportPetugas()
    {
        $petugas = Petugas::with('instansi')->get();
        
        $pdf = PDF::loadView('admin.laporan.pdf.petugas', compact('petugas'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('laporan_petugas_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export laporan layanan to PDF.
     */
    public function exportLayanan()
    {
        $layanan = Layanan::all();
        
        $pdf = PDF::loadView('admin.laporan.pdf.layanan', compact('layanan'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('laporan_layanan_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export laporan permohonan to PDF with date range.
     */
    public function exportPermohonan(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        $permohonan = Permohonan::with(['layanan', 'user'])
            ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_selesai])
            ->orderBy('tanggal', 'asc')
            ->get();
        
        $pdf = PDF::loadView('admin.laporan.pdf.permohonan', compact('permohonan', 'tanggal_mulai', 'tanggal_selesai'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('laporan_permohonan_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export laporan feedback to PDF.
     */
    public function exportFeedback()
    {
        $feedback = Feedback::with('user')->get();
        
        $pdf = PDF::loadView('admin.laporan.pdf.feedback', compact('feedback'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('laporan_feedback_' . date('Y-m-d') . '.pdf');
    }
}