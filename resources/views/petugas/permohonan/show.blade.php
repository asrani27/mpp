@extends('layouts.master')

@section('title', 'Detail Permohonan - Ependri')

@section('page_title', 'Detail Permohonan')

@section('admin_content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-100">Detail Permohonan</h1>
            <p class="text-gray-300 mt-1">Kode: {{ $permohonan->nomor }}</p>
        </div>
        <a href="{{ route('petugas.permohonan.index') }}" class="px-4 py-2 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
    <div class="p-2 bg-green-100 rounded-full">
        <i class="fas fa-check text-green-600"></i>
    </div>
    <span class="text-green-700 font-medium">{{ session('success') }}</span>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Main Info Card -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-file-alt text-blue-600"></i>
                    Informasi Permohonan
                </h3>
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
                <span class="px-3 py-1 {{ $statusBg }} rounded-full text-sm font-medium">
                    {{ $statusText }}
                </span>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kode -->
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Kode Permohonan</p>
                        <p class="font-semibold text-gray-800">{{ $permohonan->nomor }}</p>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                        <p class="font-semibold text-gray-800">{{ $permohonan->tanggal->translatedFormat('d F Y') }}</p>
                    </div>

                    <!-- Layanan -->
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Layanan</p>
                        <p class="font-semibold text-gray-800">{{ $permohonan->layanan->nama ?? '-' }}</p>
                    </div>

                    <!-- Prioritas -->
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Prioritas</p>
                        <p class="font-semibold text-gray-800 capitalize">{{ $permohonan->prioritas ?? 'Normal' }}</p>
                    </div>
                </div>

                @if($permohonan->keterangan)
                <!-- Keterangan -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-xs text-gray-500 mb-1">Keterangan</p>
                    <p class="text-gray-700">{{ $permohonan->keterangan }}</p>
                </div>
                @endif

                @if($permohonan->dokumen)
                <!-- Dokumen -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-xs text-gray-500 mb-2">Dokumen</p>
                    <a href="{{ asset('storage/' . $permohonan->dokumen) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">
                        <i class="fas fa-file-pdf"></i>
                        Lihat Dokumen
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Update Status Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-edit text-blue-600"></i>
                    Ubah Status
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('petugas.permohonan.updateStatus', $permohonan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select id="status" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="menunggu" {{ $permohonan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $permohonan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $permohonan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $permohonan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div>
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" placeholder="Tambahkan keterangan..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Pemohon Info Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user text-blue-600"></i>
                    Data Pemohon
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ $permohonan->user->name ?? '-' }}</h4>
                        <p class="text-sm text-gray-500">{{ $permohonan->user->masyarakat->nik ?? '-' }}</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-envelope text-gray-400 w-5"></i>
                        <span class="text-sm text-gray-600">{{ $permohonan->user->masyarakat->email ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-phone text-gray-400 w-5"></i>
                        <span class="text-sm text-gray-600">{{ $permohonan->user->masyarakat->telp ?? '-' }}</span>
                    </div>
                    @if($permohonan->user->masyarakat->alamat)
                    <div class="flex items-center gap-3">
                        <i class="fas fa-map-marker-alt text-gray-400 w-5"></i>
                        <span class="text-sm text-gray-600">{{ $permohonan->user->masyarakat->alamat }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status History Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-history text-blue-600"></i>
                    Riwayat Status
                </h3>
            </div>
            <div class="p-6">
                @if($permohonan->statusTrackings && $permohonan->statusTrackings->count() > 0)
                <div class="space-y-4">
                    @foreach($permohonan->statusTrackings->sortByDesc('created_at') as $status)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                            @php
                                $iconBg = match($status->status) {
                                    'menunggu' => 'bg-yellow-100 text-yellow-600',
                                    'diproses' => 'bg-blue-100 text-blue-600',
                                    'selesai' => 'bg-green-100 text-green-600',
                                    'ditolak' => 'bg-red-100 text-red-600',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                            @endphp
                            <i class="fas fa-circle text-xs {{ $iconBg }}"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800 capitalize">{{ $status->status }}</p>
                            <p class="text-xs text-gray-500">{{ $status->created_at->translatedFormat('d/m/Y H:i') }}</p>
                            @if($status->keterangan)
                            <p class="text-xs text-gray-600 mt-1">{{ $status->keterangan }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-gray-500 py-4">
                    <i class="fas fa-history text-2xl mb-2 text-gray-300"></i>
                    <p class="text-sm">Belum ada riwayat</p>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection