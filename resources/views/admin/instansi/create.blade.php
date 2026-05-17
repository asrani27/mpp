@extends('layouts.master')

@section('title', 'Tambah Instansi - Ependri')

@section('page_title', 'Instansi')

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
    <div class="px-6 py-5 bg-gradient-to-r from-emerald-500 to-emerald-600 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Tambah Instansi Baru</h1>
            <p class="text-emerald-100 text-sm mt-1">Tambah data instansi pemerintahan baru</p>
        </div>
        <a href="{{ route('admin.instansi.index') }}" class="px-4 py-2 bg-white/20 text-white font-medium rounded-xl hover:bg-white/30 transition-all duration-200 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.instansi.store') }}" class="p-6 space-y-6">
        @csrf

        <!-- Form Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Nama Instansi -->
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-building mr-2 text-emerald-500"></i>Nama Instansi *
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" placeholder="Masukkan nama instansi">
            </div>

            <!-- Telepon -->
            <div>
                <label for="telp" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-phone mr-2 text-emerald-500"></i>Nomor Telepon
                </label>
                <input type="text" id="telp" name="telp" value="{{ old('telp') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" placeholder="Contoh: 021-xxxxxxx">
            </div>
        </div>

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-map-marker-alt mr-2 text-emerald-500"></i>Alamat *
            </label>
            <textarea id="alamat" name="alamat" rows="3" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-info-circle mr-2 text-emerald-500"></i>Deskripsi
            </label>
            <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none" placeholder="Masukkan deskripsi instansi (opsional)">{{ old('deskripsi') }}</textarea>
        </div>

        <!-- Status -->
        <div class="max-w-md">
            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-toggle-on mr-2 text-emerald-500"></i>Status *
            </label>
            <select id="status" name="status" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.instansi.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 shadow-lg flex items-center gap-2">
                <i class="fas fa-save"></i>
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection