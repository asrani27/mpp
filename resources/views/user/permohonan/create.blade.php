@extends('layouts.master')

@section('title', 'Ajukan Permohonan - Ependri')

@section('page_title', 'Ajukan Permohonan')

@section('admin_content')
<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex items-center text-sm text-gray-500">
        <a href="{{ route('user.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('user.permohonan.index') }}" class="hover:text-blue-600">Permohonan</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700">Ajukan Baru</span>
    </nav>
</div>

<!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-purple-600">
        <h1 class="text-xl font-bold text-white">Ajukan Permohonan Baru</h1>
        <p class="text-blue-100 text-sm mt-1">Pilih layanan yang Anda butuhkan</p>
    </div>

    <!-- Content -->
    <div class="p-6">
        <form action="{{ route('user.permohonan.store') }}" method="POST">
            @csrf
            
            <!-- Data Pemohon Section -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-blue-600"></i>
                    Data Pemohon
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIK -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIK <span class="text-red-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik', $masyarakat->nik ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nik') border-red-500 @enderror"
                            maxlength="16" placeholder="Masukkan NIK Anda" required>
                        @error('nik')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $masyarakat->nama ?? '') }}" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap Anda" required>
                        @error('nama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Permohonan Section -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-file-alt text-blue-600"></i>
                    Detail Permohonan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Select Layanan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Layanan <span class="text-red-500">*</span></label>
                        <select name="layanan_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('layanan_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($layananList as $item)
                            <option value="{{ $item->id }}" {{ old('layanan_id', $layanan?->id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('layanan_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Select Petugas -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Petugas <span class="text-red-500">*</span></label>
                        <select name="petugas_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('petugas_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($petugasList as $item)
                            <option value="{{ $item->id }}" {{ old('petugas_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }} - {{ $item->jabatan }}
                            </option>
                            @endforeach
                        </select>
                        @error('petugas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan <span class="text-red-500">*</span></label>
                <textarea name="keterangan" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('keterangan') border-red-500 @enderror" placeholder="Jelaskan keperluan permohonan Anda..." required>{{ old('keterangan') }}</textarea>
                @error('keterangan')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Box -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    <div>
                        <h4 class="font-semibold text-blue-800 mb-1">Informasi</h4>
                        <p class="text-sm text-blue-600">
                            Permohonan Anda akan diproses oleh petugas. Anda dapat melihat status permohonan di halaman "Permohonan Saya".
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('user.permohonan.index') }}" class="px-6 py-3 text-gray-600 font-medium rounded-xl hover:bg-gray-100 transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    Ajukan Permohonan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection