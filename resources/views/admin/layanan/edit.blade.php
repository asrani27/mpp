@extends('layouts.master')

@section('title', 'Edit Layanan - Ependri')

@section('page_title', 'Layanan')

@section('admin_content')
<!-- Alert Messages -->
@if($errors->any())
<div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-xl text-red-700">
    <div class="flex items-center gap-2 mb-2">
        <i class="fas fa-exclamation-circle text-xl"></i>
        <span class="font-semibold">Terjadi Kesalahan</span>
    </div>
    <ul class="list-disc list-inside pl-7">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Edit Layanan</h1>
            <p class="text-blue-100 text-sm mt-1">Perbarui data layanan permohonan</p>
        </div>
        <a href="{{ route('admin.layanan.index') }}" class="px-4 py-2 bg-white/20 text-white font-medium rounded-xl hover:bg-white/30 transition-all duration-200 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.layanan.update', $layanan->id) }}" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Form Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Instansi -->
            <div>
                <label for="instansi_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-building mr-2 text-blue-500"></i>Instansi *
                </label>
                <select id="instansi_id" name="instansi_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($instansi as $ins)
                    <option value="{{ $ins->id }}" {{ old('instansi_id', $layanan->instansi_id) == $ins->id ? 'selected' : '' }}>{{ $ins->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Layanan -->
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-headset mr-2 text-blue-500"></i>Nama Layanan *
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $layanan->nama) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Masukkan nama layanan">
            </div>

            <!-- Lama Proses -->
            <div>
                <label for="lama_proses" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-clock mr-2 text-blue-500"></i>Lama Proses *
                </label>
                <input type="text" id="lama_proses" name="lama_proses" value="{{ old('lama_proses', $layanan->lama_proses) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: 3x24 Jam">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-toggle-on mr-2 text-blue-500"></i>Status *
                </label>
                <select id="status" name="status" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <option value="aktif" {{ old('status', $layanan->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $layanan->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-info-circle mr-2 text-blue-500"></i>Deskripsi
            </label>
            <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none" placeholder="Masukkan deskripsi layanan (opsional)">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
        </div>

        <!-- Syarat -->
        <div>
            <label for="syarat" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-list-check mr-2 text-blue-500"></i>Syarat
            </label>
            <textarea id="syarat" name="syarat" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none" placeholder="Masukkan syarat layanan (opsional)">{{ old('syarat', $layanan->syarat) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Gunakan newline untuk memisahkan setiap syarat</p>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.layanan.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg flex items-center gap-2">
                <i class="fas fa-save"></i>
                Perbarui
            </button>
        </div>
    </form>
</div>
@endsection