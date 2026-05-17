@extends('layouts.master')

@section('title', 'Dashboard Admin - Ependri')

@section('page_title', 'Dashboard')

@section('admin_content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-100">Selamat Datang, Admin!</h1>
    <p class="text-gray-500 mt-1">Berikut adalah ringkasan data pada sistem Ependri</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Instansi Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Instansi</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $stats['instansi'] ?? 0 }}</h3>
                <p class="text-blue-100 text-xs mt-2">Instansi terdaftar</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <i class="fas fa-building text-3xl text-white"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/20">
            <a href="{{ route('admin.instansi.index') }}" class="text-white text-sm hover:underline flex items-center gap-1">
                Lihat Detail <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Layanan Card -->
    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-emerald-100 text-sm font-medium">Total Layanan</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $stats['layanan'] ?? 0 }}</h3>
                <p class="text-emerald-100 text-xs mt-2">Layanan tersedia</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <i class="fas fa-headset text-3xl text-white"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/20">
            <a href="{{ route('admin.layanan.index') }}" class="text-white text-sm hover:underline flex items-center gap-1">
                Lihat Detail <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Masyarakat Card -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Total Masyarakat</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $stats['masyarakat'] ?? 0 }}</h3>
                <p class="text-purple-100 text-xs mt-2">Pengguna sistem</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <i class="fas fa-users text-3xl text-white"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/20">
            <a href="{{ route('admin.masyarakat.index') }}" class="text-white text-sm hover:underline flex items-center gap-1">
                Lihat Detail <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Petugas Card -->
    <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm font-medium">Total Petugas</p>
                <h3 class="text-4xl font-bold text-white mt-2">{{ $stats['petugas'] ?? 0 }}</h3>
                <p class="text-amber-100 text-xs mt-2">Petugas aktif</p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <i class="fas fa-user-tie text-3xl text-white"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-white/20">
            <a href="{{ route('admin.petugas.index') }}" class="text-white text-sm hover:underline flex items-center gap-1">
                Lihat Detail <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

</div>

<!-- Second Row Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Permohonan Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-file-alt text-xl text-blue-600"></i>
            </div>
            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold">
                {{ $stats['permohonan_pending'] ?? 0 }} Pending
            </span>
        </div>
        <h3 class="text-3xl font-bold text-gray-800">{{ $stats['permohonan'] ?? 0 }}</h3>
        <p class="text-gray-500 text-sm mt-1">Total Permohonan</p>
        <div class="mt-4 flex items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-yellow-400 rounded-full"></span>
                <span class="text-xs text-gray-500">Menunggu ({{ $stats['permohonan_pending'] ?? 0 }})</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-blue-400 rounded-full"></span>
                <span class="text-xs text-gray-500">Diproses ({{ $stats['permohonan_process'] ?? 0 }})</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-green-400 rounded-full"></span>
                <span class="text-xs text-gray-500">Selesai ({{ $stats['permohonan_completed'] ?? 0 }})</span>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.permohonan.index') }}" class="text-blue-600 text-sm hover:underline flex items-center gap-1">
                Kelola Permohonan <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Feedback Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-comment-dots text-xl text-purple-600"></i>
            </div>
            <div class="flex items-center gap-1 text-yellow-500">
                <i class="fas fa-star text-sm"></i>
                <span class="text-sm font-semibold">{{ number_format($stats['avg_rating'] ?? 0, 1) }}</span>
            </div>
        </div>
        <h3 class="text-3xl font-bold text-gray-800">{{ $stats['feedback'] ?? 0 }}</h3>
        <p class="text-gray-500 text-sm mt-1">Total Feedback</p>
        <div class="mt-4">
            <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                <span>Rating</span>
                <span>{{ number_format($stats['avg_rating'] ?? 0, 1) }} / 5</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ (($stats['avg_rating'] ?? 0) / 5) * 100 }}%"></div>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.feedback.index') }}" class="text-purple-600 text-sm hover:underline flex items-center gap-1">
                Lihat Feedback <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Quick Actions Card -->
    <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 shadow-lg">
        <h3 class="text-lg font-bold text-white mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.permohonan.create') }}" class="flex items-center gap-3 p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-all">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <span class="text-white text-sm">Tambah Permohonan</span>
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-all">
                <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-bar text-white"></i>
                </div>
                <span class="text-white text-sm">Generate Laporan</span>
            </a>
            <a href="{{ route('admin.petugas.create') }}" class="flex items-center gap-3 p-3 bg-white/10 rounded-xl hover:bg-white/20 transition-all">
                <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                <span class="text-white text-sm">Tambah Petugas</span>
            </a>
        </div>
    </div>

</div>

<!-- Recent Activity & Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Recent Permohonan -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Permohonan Terbaru</h3>
            <a href="{{ route('admin.permohonan.index') }}" class="text-blue-600 text-sm hover:underline">Lihat Semua</a>
        </div>
        <div class="p-0">
            @if(isset($recentPermohonan) && $recentPermohonan->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($recentPermohonan as $item)
                <div class="px-6 py-4 hover:bg-gray-50 transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-alt text-gray-500"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $item->layanan->nama ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
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
                            <p class="text-xs text-gray-400 mt-1">{{ $item->tanggal->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                <p>Belum ada permohonan</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Feedback -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Feedback Terbaru</h3>
            <a href="{{ route('admin.feedback.index') }}" class="text-purple-600 text-sm hover:underline">Lihat Semua</a>
        </div>
        <div class="p-0">
            @if(isset($recentFeedback) && $recentFeedback->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($recentFeedback as $item)
                <div class="px-6 py-4 hover:bg-gray-50 transition-all">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-purple-500"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-gray-800">{{ $item->user->name ?? 'Anonim' }}</p>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-xs {{ $i <= $item->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item->komentar }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $item->tanggal->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-comment-slash text-4xl mb-3 text-gray-300"></i>
                <p>Belum ada feedback</p>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection