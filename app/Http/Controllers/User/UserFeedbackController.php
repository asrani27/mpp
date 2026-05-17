<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Permohonan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserFeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::with('layanan')
            ->where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('user.feedback.index', compact('feedback'));
    }

    public function create(Request $request)
    {
        $permohonanList = Permohonan::where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->with('layanan')
            ->get();

        $layananList = Layanan::where('status', 'aktif')->get();

        $selectedLayanan = null;
        if ($request->has('layanan_id')) {
            $selectedLayanan = Layanan::find($request->layanan_id);
        }

        return view('user.feedback.create', compact('permohonanList', 'layananList', 'selectedLayanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $existingFeedback = Feedback::where('user_id', Auth::id())
            ->where('layanan_id', $request->layanan_id)
            ->first();

        if ($existingFeedback) {
            return redirect()->back()
                ->with('error', 'Anda sudah memberikan feedback untuk layanan ini.');
        }

        Feedback::create([
            'tanggal' => Carbon::now(),
            'user_id' => Auth::id(),
            'layanan_id' => $request->layanan_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('user.feedback.index')
            ->with('success', 'Feedback berhasil dikirim. Terima kasih atas pendapat Anda!');
    }

    public function show(Feedback $feedback)
    {
        if ($feedback->user_id !== Auth::id()) {
            abort(403);
        }

        $feedback->load('layanan');
        return view('user.feedback.show', compact('feedback'));
    }

    public function edit(Feedback $feedback)
    {
        if ($feedback->user_id !== Auth::id()) {
            abort(403);
        }

        $layananList = Layanan::where('status', 'aktif')->get();
        $feedback->load('layanan');
        return view('user.feedback.edit', compact('feedback', 'layananList'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        if ($feedback->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $feedback->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('user.feedback.show', $feedback->id)
            ->with('success', 'Feedback berhasil diperbarui.');
    }

    public function destroy(Feedback $feedback)
    {
        if ($feedback->user_id !== Auth::id()) {
            abort(403);
        }

        $feedback->delete();

        return redirect()->route('user.feedback.index')
            ->with('success', 'Feedback berhasil dihapus.');
    }
}