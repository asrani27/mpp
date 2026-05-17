@extends('layouts.master')

@section('title', 'Permohonan Masuk - Ependri')

@section('page_title', 'Permohonan Masuk')

@section('admin_content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-100">Permohonan Masuk</h1>
    <p class="text-gray-300 mt-1">Kelola dan proses permohonan layanan</p>
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

@if(session('error'))
<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
    <div class="p-2 bg-red-100 rounded-full">
        <i class="fas fa-exclamation-triangle text-red-600"></i>
    </div>
    <span class="text-red-700 font-medium">{{ session('error') }}</span>
</div>
@endif

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
    <a href="{{ route('petugas.permohonan.index') }}" class="bg-white rounded-xl p-4 shadow-md border border-gray-100 hover:shadow-lg transition-all {{ !request('status') ? 'ring-2 ring-blue-500' : '' }}">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Total</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</h3>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-blue-600"></i>
            </div>
        </div>
    </a>
    <a href="{{ route('petugas.permohonan.index', ['status' => 'menunggu']) }}" class="bg-white rounded-xl p-4 shadow-md border border-gray-100 hover:shadow-lg transition-all {{ request('status') == 'menunggu' ? 'ring-2 ring-yellow-500' : '' }}">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Menunggu</p>
                <h3 class="text-2xl font-bold text-yellow-600">{{ $stats['menunggu'] }}</h3>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600"></i>
            </div>
        </div>
    </a>
    <a href="{{ route('petugas.permohonan.index', ['status' => 'diproses']) }}" class="bg-white rounded-xl p-4 shadow-md border border-gray-100 hover:shadow-lg transition-all {{ request('status') == 'diproses' ? 'ring-2 ring-blue-500' : '' }}">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Diproses</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $stats['diproses'] }}</h3>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-spinner text-blue-600"></i>
            </div>
        </div>
    </a>
    <a href="{{ route('petugas.permohonan.index', ['status' => 'selesai']) }}" class="bg-white rounded-xl p-4 shadow-md border border-gray-100 hover:shadow-lg transition-all {{ request('status') == 'selesai' ? 'ring-2 ring-green-500' : '' }}">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Selesai</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $stats['selesai'] }}</h3>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600"></i>
            </div>
        </div>
    </a>
    <a href="{{ route('petugas.permohonan.index', ['status' => 'ditolak']) }}" class="bg-white rounded-xl p-4 shadow-md border border-gray-100 hover:shadow-lg transition-all {{ request('status') == 'ditolak' ? 'ring-2 ring-red-500' : '' }}">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Ditolak</p>
                <h3 class="text-2xl font-bold text-red-600">{{ $stats['ditolak'] }}</h3>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-times-circle text-red-600"></i>
            </div>
        </div>
    </a>
</div>

<!-- Filter and Search -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
    <form action="{{ route('petugas.permohonan.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
            <div class="relative">
                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nomor atau nama pemohon..."
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <!-- Filter by Layanan -->
        <div class="min-w-[200px]">
            <label for="layanan_id" class="block text-sm font-medium text-gray-700 mb-2">Layanan</label>
            <select id="layanan_id" name="layanan_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Layanan</option>
                @foreach($layananList as $layanan)
                <option value="{{ $layanan->id }}" {{ request('layanan_id') == $layanan->id ? 'selected' : '' }}>
                    {{ $layanan->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Filter by Status -->
        <div class="min-w-[200px]">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select id="status" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors flex items-center gap-2">
                <i class="fas fa-filter"></i>
                Filter
            </button>
            <a href="{{ route('petugas.permohonan.index') }}" class="px-4 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition-colors flex items-center gap-2">
                <i class="fas fa-times"></i>
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Permohonan Table -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-list text-blue-600"></i>
            Daftar Permohonan
        </h3>
        <span class="text-sm text-gray-500">{{ $permohonan->total() }} permohonan</span>
    </div>
    <div class="p-0">
        @if($permohonan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($permohonan as $key => $item)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $permohonan->firstItem() + $key }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $item->nomor }}</td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $item->user->masyarakat->nama ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $item->user->masyarakat->nik ?? '-' }}</p>
                            </div>
                        </td>
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
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('petugas.permohonan.show', $item) }}" class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" onclick="openStatusModal({{ $item->id }}, '{{ $item->status }}')" class="p-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-colors" title="Ubah Status">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $permohonan->links() }}
        </div>
        @else
        <div class="p-8 text-center text-gray-500">
            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
            <p>Belum ada permohonan yang ditemukan</p>
        </div>
        @endif
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeStatusModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Ubah Status Permohonan</h3>
            <button onclick="closeStatusModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fas fa-times text-gray-500"></i>
            </button>
        </div>
        <form id="statusForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="modalStatus" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="menunggu">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Tambahkan keterangan (opsional)"></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeStatusModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openStatusModal(id, currentStatus) {
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('modalStatus').value = currentStatus;
    document.getElementById('statusForm').action = '/petugas/permohonan/' + id + '/status';
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}
</script>
@endsection