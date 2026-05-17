@extends('layouts.app')

@section('title', 'Admin Dashboard - Ependri')

@push('styles')
<style>
    .bg-gradient-hero {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #10b981 100%) !important;
    }
    .glass-effect {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .main-content-gradient {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #10b981 100%) !important;
        position: relative;
    }
    .main-content-gradient::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(255,255,255,0.95) 0%, rgba(248,250,252,0.9) 50%, rgba(255,255,255,0.95) 100%);
        pointer-events: none;
    }
    
    /* Floating Decorative Elements */
    .floating {
        animation: floating 3s ease-in-out infinite;
    }
    @keyframes floating {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    /* Mobile Sidebar Overlay */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 40;
    }
    
    @media (max-width: 1024px) {
        .sidebar-overlay.active {
            display: block;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-hero">
    <!-- Decorative Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl floating"></div>
        <div class="absolute top-40 right-20 w-48 h-48 bg-emerald-400/10 rounded-full blur-xl floating" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-blue-400/10 rounded-full blur-xl floating" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-40 right-10 w-36 h-36 bg-white/10 rounded-full blur-xl floating" style="animation-delay: 0.5s;"></div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen transition-all duration-300 relative">
        <!-- Mobile Header -->
        <header class="lg:hidden z-50 glass-effect shadow-lg">
            <div class="flex items-center justify-between px-4 py-3">
                <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-bars text-gray-700 text-xl"></i>
                </button>
                <h5 class="text-base font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h5>
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-emerald-500 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Desktop Top Bar -->
        <header class="hidden lg:block z-50 glass-effect shadow-lg">
            <div class="flex items-center justify-between px-8 py-4">
                <div class="flex items-center space-x-4">
                    <h5 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h5>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-emerald-500 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</h6>
                            <span class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Administrator' }}</span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="bg-gradient-to-b from-slate-800 via-blue-800 to-emerald-700 min-h-screen p-8">
            @yield('admin_content')
        </main>
    </div>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.toggle('-translate-x-full');
    sidebar.classList.toggle('translate-x-0');
    overlay.classList.toggle('active');
    
    document.body.classList.toggle('overflow-hidden');
}
</script>
@endsection