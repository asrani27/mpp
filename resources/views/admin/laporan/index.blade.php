@extends('layouts.master')

@section('title', 'Laporan - Ependri')

@section('page_title', 'Laporan')

@section('admin_content')
<!-- Alert Messages -->
@if(session('success'))
<div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-xl text-emerald-300 flex items-center gap-3">
    <i class="fas fa-check-circle text-xl"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl text-red-300 flex items-center gap-3">
    <i class="fas fa-exclamation-circle text-xl"></i>
    {{ session('error') }}
</div>
@endif

<!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-purple-600 to-purple-700 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Kelola Laporan</h1>
            <p class="text-purple-100 text-sm mt-1">Export dan generate laporan dalam format PDF</p>
        </div>
    </div>

    <!-- Content -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Laporan Petugas Card -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-tie text-2xl text-white"></i>
                    </div>
                    <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-semibold">
                        PDF
                    </span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Laporan Petugas</h3>
                <p class="text-blue-100 text-sm mb-6">Download laporan data petugas dalam format PDF</p>
                <a href="{{ route('admin.laporan.exportPetugas') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-all duration-200 shadow-lg">
                    <i class="fas fa-download"></i>
                    Export PDF
                </a>
            </div>

            <!-- Laporan Layanan Card -->
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-concierge-bell text-2xl text-white"></i>
                    </div>
                    <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-semibold">
                        PDF
                    </span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Laporan Layanan</h3>
                <p class="text-emerald-100 text-sm mb-6">Download laporan data layanan dalam format PDF</p>
                <a href="{{ route('admin.laporan.exportLayanan') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 bg-white text-emerald-600 font-semibold rounded-xl hover:bg-emerald-50 transition-all duration-200 shadow-lg">
                    <i class="fas fa-download"></i>
                    Export PDF
                </a>
            </div>

            <!-- Laporan Permohonan Card with Date Filter -->
            <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-alt text-2xl text-white"></i>
                    </div>
                    <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-semibold">
                        PDF
                    </span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Laporan Permohonan</h3>
                <p class="text-amber-100 text-sm mb-4">Download laporan permohonan berdasarkan periode tanggal</p>
                <form action="{{ route('admin.laporan.exportPermohonan') }}" method="GET" target="_blank" class="space-y-3">
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label class="block text-xs text-white/80 mb-1">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" required 
                                class="w-full px-3 py-2 rounded-lg text-sm bg-white/20 text-white placeholder-white/60 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/40"
                                placeholder="Mulai">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs text-white/80 mb-1">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" required 
                                class="w-full px-3 py-2 rounded-lg text-sm bg-white/20 text-white placeholder-white/60 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/40"
                                placeholder="Selesai">
                        </div>
                    </div>
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-white text-amber-600 font-semibold rounded-xl hover:bg-amber-50 transition-all duration-200 shadow-lg">
                        <i class="fas fa-download"></i>
                        Export PDF
                    </button>
                </form>
            </div>

            <!-- Laporan Feedback Card -->
            <div class="bg-gradient-to-br from-cyan-500 to-teal-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-comments text-2xl text-white"></i>
                    </div>
                    <span class="px-3 py-1 bg-white/20 text-white rounded-full text-xs font-semibold">
                        PDF
                    </span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Laporan Feedback</h3>
                <p class="text-cyan-100 text-sm mb-6">Download laporan feedback masyarakat dalam format PDF</p>
                <a href="{{ route('admin.laporan.exportFeedback') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 bg-white text-cyan-600 font-semibold rounded-xl hover:bg-cyan-50 transition-all duration-200 shadow-lg">
                    <i class="fas fa-download"></i>
                    Export PDF
                </a>
            </div>

        </div>
    </div>
</div>
@endsection