@extends('layouts.master')

@section('title', 'Detail Feedback - Ependri')

@section('page_title', 'Feedback')

@section('admin_content')
<div class="mb-6">
    <a href="{{ route('admin.feedback.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-all">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>

<!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-emerald-600 to-emerald-700">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-white">Detail Feedback</h1>
                <p class="text-emerald-100 text-sm mt-1">Informasi lengkap feedback</p>
            </div>
            <span class="px-4 py-2 bg-white/20 text-white rounded-lg text-sm font-medium">
                <i class="fas fa-calendar mr-1"></i>
                {{ \Carbon\Carbon::parse($feedback->tanggal)->format('d/m/Y') }}
            </span>
        </div>
    </div>

    <!-- Content -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- User Info -->
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-emerald-600"></i>
                    Informasi Pengguna
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Nama</label>
                        <p class="text-gray-800 font-medium">{{ $feedback->user->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Email</label>
                        <p class="text-gray-800">{{ $feedback->user->email ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Service Info -->
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-headset text-emerald-600"></i>
                    Informasi Layanan
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm text-gray-500">Nama Layanan</label>
                        <p class="text-gray-800 font-medium">{{ $feedback->layanan->nama ?? '-' }}</p>
                    </div>
                    @if($feedback->layanan && $feedback->layanan->instansi)
                    <div>
                        <label class="text-sm text-gray-500">Instansi</label>
                        <p class="text-gray-800">{{ $feedback->layanan->instansi->nama }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rating -->
        <div class="mt-6 bg-gray-50 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-star text-yellow-500"></i>
                Rating
            </h3>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }} text-2xl"></i>
                    @endfor
                </div>
                <span class="text-2xl font-bold text-gray-800">{{ $feedback->rating }}/5</span>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold">
                    {{ $feedback->rating_label }}
                </span>
            </div>
        </div>

        <!-- Comment -->
        <div class="mt-6 bg-gray-50 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-comment text-emerald-600"></i>
                Komentar
            </h3>
            <p class="text-gray-700 leading-relaxed">
                {{ $feedback->komentar ?? 'Tidak ada komentar' }}
            </p>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex items-center justify-end gap-4">
            <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus feedback ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-all duration-200 shadow-lg flex items-center gap-2">
                    <i class="fas fa-trash"></i>
                    Hapus Feedback
                </button>
            </form>
        </div>
    </div>
</div>
@endsection