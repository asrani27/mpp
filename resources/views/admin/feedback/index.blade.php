@extends('layouts.master')

@section('title', 'Kelola Feedback - Ependri')

@section('page_title', 'Feedback')

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
    <div class="px-6 py-5 bg-gradient-to-r from-emerald-600 to-emerald-700 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Kelola Feedback</h1>
            <p class="text-emerald-100 text-sm mt-1">Kelola data feedback dari pengguna</p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
        <form method="GET" action="{{ route('admin.feedback.index') }}" class="space-y-4">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama atau komentar..." class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>
                <div class="w-full lg:w-40">
                    <select name="rating" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                        <option value="">Semua Rating</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>★★★★★ (5)</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>★★★★☆ (4)</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>★★★☆☆ (3)</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>★★☆☆☆ (2)</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>★☆☆☆☆ (1)</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex gap-2 items-center">
                    <label class="text-sm text-gray-600">Tanggal:</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    <span class="text-gray-400">-</span>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 shadow-lg flex items-center gap-2">
                    <i class="fas fa-search"></i>
                    Cari
                </button>
                @if(request('search') || request('rating') || request('tanggal_dari') || request('tanggal_sampai'))
                <a href="{{ route('admin.feedback.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200 flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengguna</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Komentar</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($feedback as $key => $data)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-600">{{ $feedback->firstItem() + $key }}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">{{ $data->user->name ?? '-' }}</div>
                        <small class="text-gray-400 text-xs">{{ $data->user->email ?? '-' }}</small>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        <div class="font-medium">{{ $data->layanan->nama ?? '-' }}</div>
                        @if($data->layanan && $data->layanan->instansi)
                        <small class="text-gray-400 text-xs">{{ $data->layanan->instansi->nama }}</small>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $data->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500">{{ $data->rating }}/5</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm max-w-xs">
                        <p class="truncate">{{ $data->komentar ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.feedback.show', $data->id) }}" class="p-2 bg-emerald-100 text-emerald-600 rounded-lg hover:bg-emerald-200 transition-all" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.feedback.destroy', $data->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus feedback ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-comment-dots text-5xl mb-4"></i>
                        <p class="text-lg">Belum ada data feedback</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($feedback->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
    {{ $feedback->appends(request()->query())->links() }}
    </div>
    @endif
</div>


@endsection