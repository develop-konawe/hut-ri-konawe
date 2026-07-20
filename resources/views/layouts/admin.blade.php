<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HUT RI ke-81 Kabupaten Konawe Admin')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&family=Montserrat:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script>
        tailwind.config = {theme:{extend:{colors:{primary:'#be0017','primary-container':'#e62129',secondary:'#515d84','secondary-container':'#c4d0fd',surface:'#f8f9fa','surface-container':'#edeeef','surface-container-low':'#f3f4f5','surface-container-high':'#e7e8e9','surface-variant':'#e1e3e4','on-surface':'#191c1d','on-surface-variant':'#5d3f3c'},fontFamily:{body:['Inter'],headline:['Montserrat']}}}}
    </script>
    <script>
        if (localStorage.getItem('adminSidebarCollapsed') === 'true') {
            document.documentElement.classList.add('admin-sidebar-collapsed-initial');
        }
    </script>
    <style>
        .glass-panel{background:rgba(255,255,255,.68);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.2);box-shadow:0 8px 32px rgba(11,26,61,.05)}
        .mosehe-pattern{background-image:url('data:image/svg+xml;utf8,<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path d="M20 0L40 20L20 40L0 20L20 0ZM20 4L4 20L20 36L36 20L20 4Z" fill="%23be0017" fill-opacity="0.03"/></svg>')}
        .bg-gradient-primary{background:linear-gradient(135deg,#be0017,#e62129)}
        .admin-sidebar{width:18rem;transition:width .2s ease,padding .2s ease}
        .admin-content{margin-left:18rem;transition:margin-left .2s ease}
        .sidebar-label,.sidebar-brand{transition:opacity .15s ease}
        .admin-sidebar-collapsed-initial .admin-sidebar,
        body.sidebar-collapsed .admin-sidebar{width:5.5rem;padding-left:1rem;padding-right:1rem}
        .admin-sidebar-collapsed-initial .admin-content,
        body.sidebar-collapsed .admin-content{margin-left:5.5rem}
        .admin-sidebar-collapsed-initial .sidebar-label,
        .admin-sidebar-collapsed-initial .sidebar-brand,
        body.sidebar-collapsed .sidebar-label,
        body.sidebar-collapsed .sidebar-brand{display:none;opacity:0}
        .admin-sidebar-collapsed-initial .admin-nav-link,
        body.sidebar-collapsed .admin-nav-link{justify-content:center;border-right-width:0!important;border-radius:.75rem}
        .admin-sidebar-collapsed-initial .sidebar-logo-wrap,
        body.sidebar-collapsed .sidebar-logo-wrap{flex-direction:column;justify-content:center;padding-left:0;padding-right:0}
        .admin-sidebar-collapsed-initial .sidebar-logo,
        body.sidebar-collapsed .sidebar-logo{height:3rem;width:3rem;border-radius:1rem}
        .admin-sidebar-collapsed-initial .sidebar-toggle-icon,
        body.sidebar-collapsed .sidebar-toggle-icon{transform:rotate(180deg)}
        /* Custom Scrollbar */
        .admin-sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .admin-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .admin-sidebar-scroll::-webkit-scrollbar-thumb { background-color: #e62129; border-radius: 10px; }
        .admin-sidebar-scroll { scrollbar-width: thin; scrollbar-color: #e62129 transparent; }
    </style>
    @stack('styles')
</head>
<body class="bg-surface text-on-surface font-body mosehe-pattern flex min-h-screen">
<nav class="admin-sidebar bg-surface shadow-sm h-screen fixed left-0 top-0 flex flex-col py-6 px-4 z-20 overflow-hidden">
    <div class="sidebar-logo-wrap px-4 mb-6 flex items-center justify-between gap-3">
        <div class="sidebar-logo h-20 w-20 rounded-2xl bg-white flex items-center justify-center shadow-lg p-2 shrink-0">
            <img class="h-full w-full object-contain" src="{{ asset('assets/logo/hutri81-symbol.png') }}" alt="Logo HUT RI 81">
        </div>
        <button id="admin-sidebar-toggle" class="h-10 w-10 rounded-full bg-white text-primary shadow flex items-center justify-center hover:bg-secondary-container/20 transition-colors" type="button" aria-label="Perkecil panel menu admin" aria-expanded="true">
            <span class="sidebar-toggle-icon material-symbols-outlined transition-transform">chevron_left</span>
        </button>
    </div>
    <div class="sidebar-brand px-4 mb-6">
        <h1 class="font-headline text-xl font-bold leading-tight text-primary">HUT RI ke-81 Kabupaten Konawe</h1>
        <p class="text-sm text-on-surface-variant font-semibold">Panel Admin</p>
    </div>
    <div class="flex flex-col gap-2 flex-grow overflow-y-auto admin-sidebar-scroll pb-4">
        <a title="Dashboard" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.dashboard') }}"><span class="material-symbols-outlined">dashboard</span><span class="sidebar-label">Dashboard</span></a>
        
        @if(auth()->user()?->isSuperAdmin())
        <a title="Lomba" class="admin-nav-link {{ request()->routeIs('admin.competitions.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.competitions.index') }}"><span class="material-symbols-outlined">event_available</span><span class="sidebar-label">Lomba</span></a>
        @endif
        
        @if(!auth()->user()?->isAdmin())
        <a title="Peserta Lomba" class="admin-nav-link {{ request()->routeIs('admin.registrations.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.registrations.index') }}"><span class="material-symbols-outlined">app_registration</span><span class="sidebar-label">Peserta Lomba</span></a>
        @endif
        
        @if(auth()->user()?->isAdminOrSuperAdmin())
        <a title="Kegiatan" class="admin-nav-link {{ request()->routeIs('admin.locations.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.locations.index') }}"><span class="material-symbols-outlined">map</span><span class="sidebar-label">Kegiatan</span></a>
        <a title="Banner" class="admin-nav-link {{ request()->routeIs('admin.banners.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.banners.index') }}"><span class="material-symbols-outlined">imagesmode</span><span class="sidebar-label">Banner</span></a>
        <a title="Video" class="admin-nav-link {{ request()->routeIs('admin.videos.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.videos.index') }}"><span class="material-symbols-outlined">play_circle</span><span class="sidebar-label">Video</span></a>
        <a title="Live Streaming" class="admin-nav-link {{ request()->routeIs('admin.live_streamings.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.live_streamings.index') }}"><span class="material-symbols-outlined">sensors</span><span class="sidebar-label">Live Streaming</span></a>
        @endif
        @if(auth()->user()?->isSuperAdmin())
        <a title="Manajemen Pengguna" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.users.index') }}"><span class="material-symbols-outlined">group</span><span class="sidebar-label">Pengguna</span></a>
        <a title="Pengaturan" class="admin-nav-link {{ request()->routeIs('admin.settings.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.settings.edit') }}"><span class="material-symbols-outlined">settings</span><span class="sidebar-label">Pengaturan</span></a>
        @endif
        <a title="Lihat Portal" class="admin-nav-link text-on-surface-variant flex items-center gap-3 p-3 rounded-lg hover:bg-secondary-container/20" href="{{ route('visitor.home') }}"><span class="material-symbols-outlined">public</span><span class="sidebar-label">Lihat Portal</span></a>
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button title="Logout" class="admin-nav-link w-full text-on-surface-variant flex items-center gap-3 p-3 rounded-lg hover:bg-secondary-container/20 text-left" type="submit">
                <span class="material-symbols-outlined">logout</span>
                <span class="sidebar-label">Logout</span>
            </button>
        </form>
    </div>
</nav>
<div class="admin-content flex-1 min-h-screen">
    <header class="sticky top-0 bg-surface/80 backdrop-blur-xl border-b border-white/20 shadow-sm flex justify-between items-center w-full px-8 h-16 z-10">
        <div class="font-headline text-2xl font-bold text-primary">@yield('heading', 'HUT RI ke-81 Kabupaten Konawe')</div>
        <div class="text-sm text-on-surface-variant">{{ auth()->user()?->email }}</div>
    </header>
    <main class="p-8">
        @if (session('status'))
            <div class="glass-panel rounded-2xl p-4 text-primary font-semibold mb-6">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
</div>
@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const root = document.documentElement;
        const body = document.body;
        const toggle = document.getElementById('admin-sidebar-toggle');

        const setCollapsed = (collapsed) => {
            root.classList.remove('admin-sidebar-collapsed-initial');
            body.classList.toggle('sidebar-collapsed', collapsed);
            localStorage.setItem('adminSidebarCollapsed', collapsed ? 'true' : 'false');

            if (toggle) {
                toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
                toggle.setAttribute('aria-label', collapsed ? 'Perbesar panel menu admin' : 'Perkecil panel menu admin');
            }
        };

        setCollapsed(localStorage.getItem('adminSidebarCollapsed') === 'true');
        toggle?.addEventListener('click', () => setCollapsed(! body.classList.contains('sidebar-collapsed')));
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        flatpickr("input[type='datetime-local']", {
            enableTime: true,
            dateFormat: "Y-m-d\\TH:i",
            altInput: true,
            altFormat: "d F Y H:i",
            time_24hr: true,
            locale: "id"
        });
    });
</script>
</body>
</html>
