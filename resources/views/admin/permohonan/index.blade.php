@extends('layouts.master')

@section('title', 'Kelola Permohonan - Ependri')

@section('page_title', 'Permohonan')

@section('admin_content')
<!-- Alert Messages -->
@if(session('success'))
<div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-xl text-emerald-300 flex items-center gap-3">
    <i class="fas fa-check-circle text-xl"></i>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl text-red-300 flex items-center gap-3">
    <i class="fas fa-exclamation-circle text-xl"></i>
    {{ $errors->first() }}
</div>
@endif

<!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Kelola Permohonan</h1>
            <p class="text-blue-100 text-sm mt-1">Kelola data permohonan layanan</p>
        </div>
        <a href="{{ route('admin.permohonan.create') }}" class="px-5 py-2.5 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 transition-all duration-200 shadow-lg flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Tambah Permohonan
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
        <form method="GET" action="{{ route('admin.permohonan.index') }}" class="space-y-4">
            <div class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nomor, nama, atau NIK..." class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
                <div class="w-full lg:w-40">
                    <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="w-full lg:w-48">
                    <select name="layanan_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        <option value="">Semua Layanan</option>
                        @foreach($layanan as $lay)
                        <option value="{{ $lay->id }}" {{ request('layanan_id') == $lay->id ? 'selected' : '' }}>{{ $lay->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg flex items-center gap-2">
                    <i class="fas fa-search"></i>
                    Cari
                </button>
                @if(request('search') || request('status') || request('layanan_id'))
                <a href="{{ route('admin.permohonan.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200 flex items-center gap-2">
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
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nomor</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pemohon</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($permohonan as $key => $data)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-600">{{ $permohonan->firstItem() + $key }}</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">{{ $data->nomor }}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $data->tanggal->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        <div class="font-medium">{{ $data->layanan->nama ?? '-' }}</div>
                        @if($data->layanan && $data->layanan->instansi)
                        <small class="text-gray-400 text-xs">{{ $data->layanan->instansi->nama }}</small>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-800">{{ $data->nama }}</div>
                        <small class="text-gray-400 text-xs">NIK: {{ $data->nik }}</small>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $data->status_badge }}">
                            {{ $data->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.permohonan.show', $data->id) }}" class="p-2 bg-emerald-100 text-emerald-600 rounded-lg hover:bg-emerald-200 transition-all" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.permohonan.edit', $data->id) }}" class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-all" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.permohonan.destroy', $data->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data permohonan ini?');">
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
                        <i class="fas fa-inbox text-5xl mb-4"></i>
                        <p class="text-lg">Belum ada data permohonan</p>
                        <a href="{{ route('admin.permohonan.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block font-medium">
                            <i class="fas fa-plus mr-1"></i> Tambah Permohonan Baru
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($permohonan->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
    {{ $permohonan->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection