<aside id="sidebar" class="fixed left-0 top-0 h-screen w-64 bg-gradient-to-b from-slate-800 via-blue-800 to-emerald-700 shadow-2xl z-40 overflow-y-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <!-- Brand Section -->
    <div class="px-6 py-8 border-b border-white/10">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm shadow-lg">
                <i class="fas fa-shield-alt text-2xl text-white"></i>
            </div>
            <div>
                <h4 class="text-xl font-bold text-white drop-shadow-lg">Ependri</h4>
                <span class="text-xs text-white/70">Sistem Permohonan</span>
            </div>
        </div>
    </div>

    <!-- Menu Navigation -->
    @auth
        @if(Auth::user()->role === 'admin')
            @include('layouts.menu_admin')
        @elseif(Auth::user()->role === 'petugas')
            @include('layouts.menu_petugas')
        @else
            @include('layouts.menu_user')
        @endif
    @else
        @include('layouts.menu_user')
    @endauth
</aside>