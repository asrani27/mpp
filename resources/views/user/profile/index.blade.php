@extends('layouts.master')

@section('title', 'Profil Saya - Ependri')

@section('page_title', 'Profil Saya')

@section('admin_content')
<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-100">Profil Saya</h1>
    <p class="text-gray-500 mt-1">Kelola informasi profil dan akun Anda</p>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
    <div class="p-2 bg-green-100 rounded-full">
        <i class="fas fa-check text-green-600"></i>
    </div>
    <span class="text-green-700 font-medium">{{ session('success') }}</span>
</div>
@endif

<!-- Profile Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Profile Summary Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                <i class="fas fa-user text-3xl text-white"></i>
            </div>
            @if($user->role === 'admin')
            <span class="px-3 py-1 bg-white/20 text-white text-xs font-medium rounded-full">
                <i class="fas fa-crown mr-1"></i> Admin
            </span>
            @elseif($user->role === 'petugas')
            <span class="px-3 py-1 bg-white/20 text-white text-xs font-medium rounded-full">
                <i class="fas fa-user-shield mr-1"></i> Petugas
            </span>
            @else
            <span class="px-3 py-1 bg-white/20 text-white text-xs font-medium rounded-full">
                <i class="fas fa-user mr-1"></i> Masyarakat
            </span>
            @endif
        </div>
        <h3 class="text-xl font-bold text-white">{{ $masyarakat->nama }}</h3>
        <p class="text-blue-100 text-sm mt-1">{{ $user->email }}</p>
        <div class="mt-4 pt-4 border-t border-white/20">
            <p class="text-blue-100 text-xs">NIK</p>
            <p class="text-white font-medium">{{ $masyarakat->nik }}</p>
        </div>
    </div>

    <!-- Contact Info Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-address-book text-blue-600"></i>
            Informasi Kontak
        </h3>
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-blue-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Email</p>
                    <p class="text-sm font-medium text-gray-800">{{ $masyarakat->email }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-phone text-green-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Telepon</p>
                    <p class="text-sm font-medium text-gray-800">{{ $masyarakat->telp }}</p>
                </div>
            </div>
            @if($masyarakat->jabatan)
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-briefcase text-purple-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Jabatan</p>
                    <p class="text-sm font-medium text-gray-800">{{ $masyarakat->jabatan }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Account Info Card -->
    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-shield-alt text-blue-600"></i>
            Informasi Akun
        </h3>
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-tag text-gray-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Username</p>
                    <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-gray-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Email Akun</p>
                    <p class="text-sm font-medium text-gray-800">{{ $user->email }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-key text-gray-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Password</p>
                    <p class="text-sm font-medium text-gray-800">••••••••</p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Edit Profile Form -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-edit text-blue-600"></i>
            Edit Profil
        </h3>
    </div>
    
    <form action="{{ route('user.profile.update') }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $masyarakat->nama) }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('nama') border-red-500 @enderror"
                    required>
                @error('nama')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIK -->
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $masyarakat->nik) }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('nik') border-red-500 @enderror"
                    maxlength="16" pattern="[0-9]{16}" required>
                @error('nik')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $masyarakat->email) }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('email') border-red-500 @enderror" required>
                @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Telepon -->
            <div>
                <label for="telp" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                <input type="tel" id="telp" name="telp" value="{{ old('telp', $masyarakat->telp) }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('telp') border-red-500 @enderror"
                    maxlength="15" required>
                @error('telp')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jabatan -->
            <div>
                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan <span class="text-gray-400 text-xs">(Opsional)</span></label>
                <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $masyarakat->jabatan) }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('jabatan') border-red-500 @enderror"
                    placeholder="Contoh: Staff Keuangan">
                @error('jabatan')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username (Read-only) -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username <span class="text-gray-400 text-xs">(Tidak dapat diubah)</span></label>
                <input type="text" id="username" value="{{ $user->name }}" 
                    class="w-full px-4 py-3 border border-gray-200 bg-gray-100 rounded-xl text-gray-500 cursor-not-allowed"
                    disabled>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors flex items-center gap-2">
                <i class="fas fa-save"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection