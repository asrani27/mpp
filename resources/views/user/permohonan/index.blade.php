@extends('layouts.master')

@section('title', 'Permohonan Saya - Ependri')

@section('page_title', 'Permohonan Saya')

@section('admin_content')
<!-- Inline Script for Delete Confirmation -->
<script>
function confirmDelete(button) {
    if (confirm('Apakah Anda yakin ingin menghapus permohonan ini?')) {
        button.closest('form').submit();
    }
}
</script>

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
    <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Permohonan Saya</h1>
            <p class="text-blue-100 text-sm mt-1">Kelola permohonan layanan Anda</p>
        </div>
        <a href="{{ route('user.permohonan.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-all shadow-lg">
            <i class="fas fa-plus"></i>
            Ajukan Permohonan
        </a>
    </div>

    <!-- Content -->
    <div class="p-6">
        @if($permohonan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($permohonan as $item)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">{{ $item->nomor }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-concierge-bell text-purple-600 text-sm"></i>
                                </div>
                                <span class="text-sm text-gray-700">{{ $item->layanan->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->tanggal->translatedFormat('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600 line-clamp-1">{{ $item->keterangan }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
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
                            <span class="px-3 py-1 {{ $statusBg }} rounded-full text-xs font-semibold">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('user.permohonan.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if($item->status === 'menunggu')
                            <form action="{{ route('user.permohonan.destroy', $item->id) }}" method="POST" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="text-red-600 hover:text-red-800 font-medium inline-flex items-center gap-1">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $permohonan->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-inbox text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Permohonan</h3>
            <p class="text-gray-500 mb-6">Anda belum mengajukan permohonan layanan apapun</p>
            <a href="{{ route('user.permohonan.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg">
                <i class="fas fa-plus"></i>
                Ajukan Permohonan Baru
            </a>
        </div>
        @endif
    </div>
</div>
@endsection