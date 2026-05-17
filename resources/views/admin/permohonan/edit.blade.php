@extends('layouts.master')

@section('title', 'Edit Permohonan - Ependri')

@section('page_title', 'Permohonan')

@section('admin_content')
<!-- Alert Messages -->
@if($errors->any())
<div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl text-red-300 flex items-center gap-3">
    <i class="fas fa-exclamation-circle text-xl"></i>
    {{ $errors->first() }}
</div>
@endif

<!-- Form Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Edit Permohonan</h1>
            <p class="text-blue-100 text-sm mt-1">Perbarui data permohonan {{ $permohonan->nomor }}</p>
        </div>
        <a href="{{ route('admin.permohonan.index') }}" class="px-5 py-2.5 bg-white/20 text-white font-semibold rounded-xl hover:bg-white/30 transition-all duration-200 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.permohonan.update', $permohonan->id) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Row 1: Nomor & Tanggal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nomor" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Permohonan <span class="text-red-500">*</span></label>
                <input type="text" id="nomor" name="nomor" value="{{ old('nomor', $permohonan->nomor) }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
            <div>
                <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $permohonan->tanggal->format('Y-m-d')) }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
        </div>

        <!-- Row 2: Layanan & Petugas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="layanan_id" class="block text-sm font-semibold text-gray-700 mb-2">Layanan <span class="text-red-500">*</span></label>
                <select id="layanan_id" name="layanan_id" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <option value="">-- Pilih Layanan --</option>
                    @foreach($layanan as $lay)
                    <option value="{{ $lay->id }}" {{ old('layanan_id', $permohonan->layanan_id) == $lay->id ? 'selected' : '' }}>
                        {{ $lay->nama }} - {{ $lay->instansi->nama ?? '-' }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="petugas_id" class="block text-sm font-semibold text-gray-700 mb-2">Petugas Penanggung Jawab</label>
                <select id="petugas_id" name="petugas_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <option value="">-- Pilih Petugas --</option>
                    @foreach($petugas as $pet)
                    <option value="{{ $pet->id }}" {{ old('petugas_id', $permohonan->petugas_id) == $pet->id ? 'selected' : '' }}>
                        {{ $pet->nama }} - {{ $pet->instansi->nama ?? '-' }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Row 3: NIK & Nama -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">NIK <span class="text-red-500">*</span></label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $permohonan->nik) }}" required maxlength="20"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $permohonan->nama) }}" required maxlength="255"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
        </div>

        <!-- Row 4: Status & Keterangan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status Permohonan</label>
                <select id="status" name="status"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <option value="menunggu" {{ old('status', $permohonan->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ old('status', $permohonan->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="ditolak" {{ old('status', $permohonan->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai" {{ old('status', $permohonan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <p class="text-xs text-orange-500 mt-1">Mengubah status akan membuat tracking baru</p>
            </div>
            <div>
                <label for="status_keterangan" class="block text-sm font-semibold text-gray-700 mb-2">Keterangan Status</label>
                <input type="text" id="status_keterangan" name="status_keterangan" value="{{ old('status_keterangan') }}" placeholder="Keterangan perubahan status"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
            </div>
        </div>

        <!-- Row 5: Keterangan -->
        <div>
            <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-2">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="4"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ old('keterangan', $permohonan->keterangan) }}</textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.permohonan.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg flex items-center gap-2">
                <i class="fas fa-save"></i>
                Perbarui Permohonan
            </button>
        </div>
    </form>
</div>
@endsection