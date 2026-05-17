@extends('layouts.app')

@section('title', 'Register - MPP Handep Hapat')

@section('content')
<style>
    .bg-gradient-hero {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #10b981 100%);
    }
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    .floating {
        animation: floating 3s ease-in-out infinite;
    }
    @keyframes floating {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }
    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
        50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.6); }
    }
</style>

<body class="min-h-screen bg-gradient-hero flex items-center justify-center p-4">
    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl floating"></div>
        <div class="absolute top-40 right-20 w-48 h-48 bg-emerald-400/10 rounded-full blur-xl floating" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-blue-400/10 rounded-full blur-xl floating" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-40 right-10 w-36 h-36 bg-white/10 rounded-full blur-xl floating" style="animation-delay: 0.5s;"></div>
    </div>

    <div class="relative w-full max-w-md">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-6 floating">
                <i class="fas fa-user-plus text-4xl text-blue-600"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2 drop-shadow-lg">
                MALL PELAYANAN PUBLIK
            </h1>
            <h2 class="text-xl md:text-2xl font-bold text-emerald-300 drop-shadow-lg">
                HANDEP HAPAKAT
            </h2>
            <p class="text-white/80 mt-3 text-sm md:text-base">
                Pendaftaran Akun Baru
            </p>
        </div>

        <!-- Register Card -->
        <div class="glass-effect rounded-3xl shadow-2xl p-8 pulse-glow">
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-1">Daftar Akun Baru</h3>
                <p class="text-gray-500 text-sm">Bergabung dengan MPP Handep Hapat</p>
            </div>

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <p class="text-red-600 text-sm">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" class="space-y-5">
                @csrf
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user text-blue-500 mr-2"></i>Nama Lengkap
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            autofocus
                            class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                        >
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-blue-500 mr-2"></i>Email
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                        >
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock text-blue-500 mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Minimal 8 karakter"
                            required
                            minlength="8"
                            class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                        >
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <button 
                            type="button" 
                            id="togglePassword"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock text-blue-500 mr-2"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Ulangi password"
                            required
                            class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 outline-none"
                        >
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-start">
                    <input 
                        type="checkbox" 
                        name="terms" 
                        id="terms"
                        required
                        class="w-4 h-4 mt-1 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                    >
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        Saya agree dengan 
                        <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a>
                        dan
                        <a href="#" class="text-blue-600 hover:underline">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- Register Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-4 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
                >
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>

        <!-- Copyright -->
        <p class="text-center text-white/60 text-xs mt-6">
            &copy; {{ date('Y') }} MPP Handep Hapat. Hak Cipta Dilindungi.
        </p>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
@endsection