<!-- Menu Navigation -->
<nav class="py-6 px-3">
    <!-- Main Menu -->
    <div class="px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white/50">
        Menu Utama
    </div>
    
    <div class="space-y-1 px-3">
        <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-white/20 text-white font-semibold' : '' }}">
            <i class="fas fa-home w-5 text-center"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('user.profile.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('user.profile.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
            <i class="fas fa-user-circle w-5 text-center"></i>
            <span>Profil</span>
        </a>
    </div>

    <!-- Data Management -->
    <div class="px-4 py-2 mt-6 text-xs font-semibold uppercase tracking-wider text-white/50">
        Manajemen Data
    </div>

    <div class="space-y-1 px-3">
        <a href="{{ route('user.permohonan.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('user.permohonan.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
            <i class="fas fa-file-alt w-5 text-center"></i>
            <span>Permohonan</span>
        </a>

        <a href="{{ route('user.feedback.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('user.feedback.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
            <i class="fas fa-comments w-5 text-center"></i>
            <span>Feedback</span>
        </a>
    </div>

    <!-- Bottom Menu -->
    <div class="mt-auto px-3 pt-6 border-t border-white/10">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin keluar dari aplikasi?')) { document.getElementById('logout-form').submit(); }" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 cursor-pointer">
            <i class="fas fa-sign-out-alt w-5 text-center"></i>
            <span>Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</nav>