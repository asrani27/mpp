@extends('layouts.master')

@section('title', 'Edit Masyarakat - Ependri')

@section('page_title', 'Masyarakat')

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
            <h1 class="text-xl font-bold text-white">Edit Masyarakat</h1>
            <p class="text-blue-100 text-sm mt-1">Perbarui data masyarakat</p>
        </div>
        <a href="{{ route('admin.masyarakat.index') }}" class="px-4 py-2 bg-white/20 text-white font-medium rounded-xl hover:bg-white/30 transition-all duration-200 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.masyarakat.update', $masyarakat->id) }}" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Form Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- NIK -->
            <div>
                <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-id-card mr-2 text-blue-500"></i>NIK *
                </label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $masyarakat->nik) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Masukkan NIK">
            </div>

            <!-- Nama -->
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user mr-2 text-blue-500"></i>Nama Lengkap *
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $masyarakat->nama) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Masukkan nama lengkap">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-blue-500"></i>Email *
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', $masyarakat->email) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Masukkan email">
            </div>

            <!-- Telepon -->
            <div>
                <label for="telp" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-phone mr-2 text-blue-500"></i>Nomor Telepon
                </label>
                <input type="text" id="telp" name="telp" value="{{ old('telp', $masyarakat->telp) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Contoh: 08xxxxxxxxxx">
            </div>
        </div>

        <!-- Jabatan -->
        <div class="max-w-md">
            <label for="jabatan" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-briefcase mr-2 text-blue-500"></i>Jabatan
            </label>
            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $masyarakat->jabatan) }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Masukkan jabatan (opsional)">
        </div>

        <!-- Password Section -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                <i class="fas fa-lock mr-2 text-blue-500"></i>Ubah Password (Opsional)
            </h3>
            <p class="text-sm text-gray-500 mb-4">Kosongkan jika tidak ingin mengubah password</p>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-key mr-2 text-blue-500"></i>Password Baru
                    </label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Minimal 6 karakter">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-key mr-2 text-blue-500"></i>Konfirmasi Password Baru
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Ulangi password baru">
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.masyarakat.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
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