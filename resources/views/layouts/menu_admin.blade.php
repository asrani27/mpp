<!-- Menu Navigation -->
    <nav class="py-6 px-3">
        <!-- Main Menu -->
        <div class="px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white/50">
            Menu Utama
        </div>
        
        <div class="space-y-1 px-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <i class="fas fa-home w-5 text-center"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Data Management -->
        <div class="px-4 py-2 mt-6 text-xs font-semibold uppercase tracking-wider text-white/50">
            Manajemen Data
        </div>

        <div class="space-y-1 px-3">

            <a href="{{ route('admin.instansi.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.instansi.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <i class="fas fa-building w-5 text-center"></i>
                <span>Instansi</span>
            </a>
            <a href="{{ route('admin.layanan.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.layanan.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <i class="fas fa-headset w-5 text-center"></i>
                <span>Layanan</span>
            </a>

            <a href="{{ route('admin.masyarakat.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.masyarakat.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Masyarakat</span>
            </a>

            <a href="{{ route('admin.petugas.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.petugas.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <i class="fas fa-user-tie w-5 text-center"></i>
                <span>Petugas</span>
            </a>
            <a href="{{ route('admin.permohonan.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.permohonan.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <i class="fas fa-file-alt w-5 text-center"></i>
                <span>Permohonan</span>
            </a>

            <a href="{{ route('admin.feedback.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.feedback.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <i class="fas fa-comment-dots w-5 text-center"></i>
                <span>Feedback</span>
            </a>

        </div>

        <!-- System -->
        <div class="px-4 py-2 mt-6 text-xs font-semibold uppercase tracking-wider text-white/50">
            Sistem
        </div>

        <div class="space-y-1 px-3">
            <a href="{{ route('admin.laporan.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-white/20 text-white font-semibold' : '' }}">
                <i class="fas fa-chart-bar w-5 text-center"></i>
                <span>Laporan</span>
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