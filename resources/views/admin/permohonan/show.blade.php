@extends('layouts.master')

@section('title', 'Detail Permohonan - Ependri')

@section('page_title', 'Permohonan')

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
    <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Detail Permohonan</h1>
            <p class="text-blue-100 text-sm mt-1">Nomor: {{ $permohonan->nomor }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.permohonan.index') }}" class="px-4 py-2 bg-white/20 text-white font-semibold rounded-xl hover:bg-white/30 transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.permohonan.edit', $permohonan->id) }}" class="px-4 py-2 bg-yellow-500 text-white font-semibold rounded-xl hover:bg-yellow-600 transition-all duration-200 flex items-center gap-2">
                <i class="fas fa-edit"></i>
                Edit
            </a>
        </div>
    </div>

    <div class="p-6">
        <!-- Info Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Nomor Permohonan</label>
                    <p class="text-lg font-bold text-gray-800">{{ $permohonan->nomor }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Tanggal</label>
                    <p class="text-gray-800">{{ $permohonan->tanggal->format('d/m/Y') }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Layanan</label>
                    <p class="text-gray-800 font-medium">{{ $permohonan->layanan->nama ?? '-' }}</p>
                    @if($permohonan->layanan && $permohonan->layanan->instansi)
                    <small class="text-gray-400">{{ $permohonan->layanan->instansi->nama }}</small>
                    @endif
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Status</label>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $permohonan->status_badge }}">
                        {{ $permohonan->status_label }}
                    </span>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Petugas Penanggung Jawab</label>
                    <p class="text-gray-800">{{ $permohonan->petugas->nama ?? 'Belum ditugaskan' }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Pemohon</label>
                    <p class="text-gray-800 font-medium">{{ $permohonan->nama }}</p>
                    <small class="text-gray-400">NIK: {{ $permohonan->nik }}</small>
                </div>
            </div>
        </div>

        <!-- Keterangan -->
        @if($permohonan->keterangan)
        <div class="mb-8">
            <label class="text-sm font-semibold text-gray-500 block mb-2">Keterangan</label>
            <div class="bg-gray-50 p-4 rounded-xl text-gray-700">
                {{ $permohonan->keterangan }}
            </div>
        </div>
        @endif

        <!-- Status Update Section -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Update Status</h3>
        <form action="{{ route('admin.permohonan.updateStatus', $permohonan->id) }}" method="POST" class="flex flex-col md:flex-row gap-4">
                @csrf
                <select name="status" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="menunggu" {{ $permohonan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ $permohonan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="ditolak" {{ $permohonan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai" {{ $permohonan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <input type="text" name="keterangan" placeholder="Keterangan update status" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg">
                    Update
                </button>
            </form>
        </div>

        <!-- Tracking History -->
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Status</h3>
            <div class="space-y-4">
                @forelse($permohonan->statusTrackings->sortByDesc('created_at') as $tracking)
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-gray-800">{{ $tracking->status }}</span>
                            <span class="text-sm text-gray-400">{{ $tracking->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-gray-600 text-sm">{{ $tracking->keterangan ?? 'Tidak ada keterangan' }}</p>
                        @if($tracking->petugas)
                        <small class="text-gray-400 text-xs">Oleh: {{ $tracking->petugas->nama }}</small>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-400 py-8">
                    <i class="fas fa-history text-4xl mb-2"></i>
                    <p>Belum ada riwayat status</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection