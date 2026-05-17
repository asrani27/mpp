@extends('layouts.master')

@section('title', 'Detail Feedback - Ependri')

@section('page_title', 'Detail Feedback')

@section('admin_content')
<!-- Alert Messages -->
@if(session('success'))
<div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-xl text-emerald-300 flex items-center gap-3">
    <i class="fas fa-check-circle text-xl"></i>
    {{ session('success') }}
</div>
@endif

<!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-emerald-600 to-teal-600 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Detail Feedback</h1>
            <p class="text-emerald-100 text-sm mt-1">Lihat detail feedback Anda</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('user.feedback.edit', $feedback->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-emerald-600 font-semibold rounded-xl hover:bg-emerald-50 transition-all shadow-lg">
                <i class="fas fa-edit"></i>
                Edit
            </a>
            <a href="{{ route('user.feedback.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 text-white font-semibold rounded-xl hover:bg-white/30 transition-all">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tanggal -->
            <div class="bg-gray-50 rounded-xl p-5">
                <label class="block text-sm font-semibold text-gray-500 mb-1">Tanggal</label>
                <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($feedback->tanggal)->translatedFormat('d F Y') }}</p>
            </div>

            <!-- Layanan -->
            <div class="bg-gray-50 rounded-xl p-5">
                <label class="block text-sm font-semibold text-gray-500 mb-1">Layanan</label>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-concierge-bell text-teal-600"></i>
                    </div>
                    <div>
                        <p class="text-lg font-semibold text-gray-800">{{ $feedback->layanan->nama ?? '-' }}</p>
                        @if($feedback->layanan && $feedback->layanan->instansi)
                        <p class="text-sm text-gray-500">{{ $feedback->layanan->instansi->nama }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Rating -->
            <div class="bg-gray-50 rounded-xl p-5">
                <label class="block text-sm font-semibold text-gray-500 mb-2">Rating</label>
                <div class="flex items-center gap-2">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xl"></i>
                    @endfor
                </div>
                <p class="mt-2 text-lg font-semibold text-emerald-600">{{ $feedback->rating }}/5 - {{ $feedback->rating_label }}</p>
            </div>

            <!-- Status -->
            <div class="bg-gray-50 rounded-xl p-5">
                <label class="block text-sm font-semibold text-gray-500 mb-1">Status</label>
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    <i class="fas fa-check-circle"></i>
                    Terkirim
                </span>
            </div>
        </div>

        <!-- Komentar -->
        <div class="mt-6 bg-gray-50 rounded-xl p-5">
            <label class="block text-sm font-semibold text-gray-500 mb-2">Komentar</label>
            @if($feedback->komentar)
            <p class="text-gray-800 leading-relaxed">{{ $feedback->komentar }}</p>
            @else
            <p class="text-gray-400 italic">Tidak ada komentar</p>
            @endif
        </div>

        <!-- Actions -->
        <div class="mt-6 pt-6 border-t border-gray-200 flex items-center gap-4">
            <a href="{{ route('user.feedback.edit', $feedback->id) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-all shadow-lg">
                <i class="fas fa-edit"></i>
                Edit Feedback
            </a>
            <form action="{{ route('user.feedback.destroy', $feedback->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus feedback ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-all shadow-lg flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection