@extends('layouts.master')

@section('title', 'Detail Permohonan - Ependri')

@section('page_title', 'Detail Permohonan')

@section('admin_content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex items-center text-sm text-gray-500">
        <a href="{{ route('user.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('user.permohonan.index') }}" class="hover:text-blue-600">Permohonan</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700">{{ $permohonan->nomor }}</span>
    </nav>
</div>

<!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Detail Permohonan</h1>
            <p class="text-blue-100 text-sm mt-1">Nomor: {{ $permohonan->nomor }}</p>
        </div>
        @php
            $statusBg = match($permohonan->status) {
                'menunggu' => 'bg-yellow-100 text-yellow-700',
                'diproses' => 'bg-blue-100 text-blue-700',
                'selesai' => 'bg-green-100 text-green-700',
                'ditolak' => 'bg-red-100 text-red-700',
                default => 'bg-gray-100 text-gray-700'
            };
            $statusText = match($permohonan->status) {
                'menunggu' => 'Menunggu',
                'diproses' => 'Diproses',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
                default => $permohonan->status
            };
        @endphp
        <span class="px-4 py-2 {{ $statusBg }} rounded-full text-sm font-semibold">
            {{ $statusText }}
        </span>
    </div>

    <!-- Content -->
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Pemohon -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fas fa-user text-blue-600"></i> Data Pemohon
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Nama</p>
                                <p class="font-semibold text-gray-800">{{ $permohonan->nama }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">NIK</p>
                                <p class="font-semibold text-gray-800">{{ $permohonan->nik }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Permohonan -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fas fa-file-alt text-blue-600"></i> Detail Permohonan
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nomor</span>
                            <span class="font-semibold text-gray-800">{{ $permohonan->nomor }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal</span>
                            <span class="font-semibold text-gray-800">{{ $permohonan->tanggal->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Layanan</span>
                            <span class="font-semibold text-gray-800">{{ $permohonan->layanan->nama ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Petugas</span>
                            <span class="font-semibold text-gray-800">{{ $permohonan->petugas->nama ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fas fa-sticky-note text-blue-600"></i> Keterangan
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-gray-700">{{ $permohonan->keterangan }}</p>
                    </div>
                </div>

                @if($permohonan->status === 'selesai')
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fas fa-star text-purple-600"></i> Berikan Feedback
                    </h3>
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
                        <p class="text-sm text-purple-700 mb-3">Bagaimana pelayanan yang Anda terima?</p>
                        <a href="#" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-all">
                            <i class="fas fa-star"></i>
                            Beri Rating
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Status Timeline -->
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fas fa-history text-blue-600"></i> Riwayat Status
                </h3>
                <div class="space-y-4">
                    @forelse($statusTrackings as $tracking)
                    @php
                        $iconBg = match($tracking->status) {
                            'menunggu' => 'bg-yellow-100 text-yellow-600',
                            'diproses' => 'bg-blue-100 text-blue-600',
                            'selesai' => 'bg-green-100 text-green-600',
                            'ditolak' => 'bg-red-100 text-red-600',
                            default => 'bg-gray-100 text-gray-600'
                        };
                        $iconClass = match($tracking->status) {
                            'menunggu' => 'fas fa-clock',
                            'diproses' => 'fas fa-spinner fa-spin',
                            'selesai' => 'fas fa-check-circle',
                            'ditolak' => 'fas fa-times-circle',
                            default => 'fas fa-circle'
                        };
                        $statusLabel = match($tracking->status) {
                            'menunggu' => 'Menunggu',
                            'diproses' => 'Diproses',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak',
                            default => $tracking->status
                        };
                    @endphp
                    <div class="relative">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 {{ $iconBg }} rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="{{ $iconClass }}"></i>
                            </div>
                            <div class="flex-1 pb-4 border-b border-gray-100 last:border-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-semibold text-gray-800">{{ $statusLabel }}</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $tracking->keterangan ?? '-' }}</p>
                                @if($tracking->petugas)
                                <p class="text-xs text-gray-400 mt-1">
                                    <i class="fas fa-user mr-1"></i>{{ $tracking->petugas->nama }}
                                </p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $tracking->created_at->translatedFormat('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">
                        <i class="fas fa-inbox text-3xl mb-2 text-gray-300"></i>
                        <p class="text-sm">Belum ada riwayat status</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('user.permohonan.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-all">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection