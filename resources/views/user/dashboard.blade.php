@extends('layouts.master')

@section('title', 'Dashboard - Ependri')

@section('page_title', 'Dashboard')

@section('admin_content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
    <p class="text-gray-500 mt-1">Berikut adalah ringkasan aktivitas Anda pada sistem Ependri</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Total Permohonan Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Permohonan</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $stats['total_permohonan'] ?? 0 }}</h3>
                <p class="text-blue-100 text-xs mt-2">Pengajuan Anda</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <i class="fas fa-file-alt text-3xl text-white"></i>
            </div>
        </div>
    </div>

    <!-- Pending Card -->
    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-medium">Menunggu</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $stats['pending'] ?? 0 }}</h3>
                <p class="text-yellow-100 text-xs mt-2">Permohonan pending</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <i class="fas fa-clock text-3xl text-white"></i>
            </div>
        </div>
    </div>

    <!-- Process Card -->
    <div class="bg-gradient-to-br from-blue-400 to-cyan-500 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Diproses</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $stats['process'] ?? 0 }}</h3>
                <p class="text-blue-100 text-xs mt-2">Sedang diproses</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <i class="fas fa-spinner text-3xl text-white"></i>
            </div>
        </div>
    </div>

    <!-- Completed Card -->
    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-emerald-100 text-sm font-medium">Selesai</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $stats['completed'] ?? 0 }}</h3>
                <p class="text-emerald-100 text-xs mt-2">Telah selesai</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <i class="fas fa-check-circle text-3xl text-white"></i>
            </div>
        </div>
    </div>

</div>

<!-- Quick Actions & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <!-- Quick Actions Card -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-bold text-white mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
            <a href="{{ route('user.permohonan.create') }}" class="flex items-center gap-3 p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-all">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <span class="text-white text-sm">Buat Permohonan Baru</span>
            </a>
            <a href="{{ route('user.permohonan.index') }}" class="flex items-center gap-3 p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-all">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-white"></i>
                </div>
                <span class="text-white text-sm">Lihat Riwayat</span>
            </a>
        </div>
    </div>

    <!-- Available Services Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 lg:col-span-2">
        <h3 class="font-bold text-gray-800 mb-4">Layanan Tersedia</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($layanan as $item)
            <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-concierge-bell text-purple-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800">{{ $item->nama }}</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($item->deskripsi, 60) }}</p>
                        <a href="{{ route('user.permohonan.create', ['layanan_id' => $item->id]) }}" class="text-purple-600 text-xs font-medium mt-2 inline-block hover:underline">
                            Ajukan Permohonan →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2 p-6 text-center text-gray-500">
                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                <p>Belum ada layanan tersedia</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Recent Permohonan -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-gray-800">Permohonan Terbaru</h3>
        <a href="{{ route('user.permohonan.index') }}" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
    </div>
    <div class="p-0">
        @if(isset($recentPermohonan) && $recentPermohonan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentPermohonan as $item)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $item->nomor }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->layanan->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->tanggal->translatedFormat('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusBg = match($item->status) {
                                    'menunggu' => 'bg-yellow-100 text-yellow-700',
                                    'diproses' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                                $statusText = match($item->status) {
                                    'menunggu' => 'Menunggu',
                                    'diproses' => 'Diproses',
                                    'selesai' => 'Selesai',
                                    'ditolak' => 'Ditolak',
                                    default => $item->status
                                };
                            @endphp
                            <span class="px-2 py-1 {{ $statusBg }} rounded-full text-xs font-medium">
                                {{ $statusText }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
            <p>Belum ada permohonan</p>
            <a href="{{ route('user.permohonan.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all">
                <i class="fas fa-plus"></i>
                Buat Permohonan Baru
            </a>
        </div>
        @endif
    </div>
</div>
@endsection