<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HUT RI ke-81 Kabupaten Konawe Admin')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&family=Montserrat:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {theme:{extend:{colors:{primary:'#be0017','primary-container':'#e62129',secondary:'#515d84','secondary-container':'#c4d0fd',surface:'#f8f9fa','surface-container':'#edeeef','surface-container-low':'#f3f4f5','surface-container-high':'#e7e8e9','surface-variant':'#e1e3e4','on-surface':'#191c1d','on-surface-variant':'#5d3f3c'},fontFamily:{body:['Inter'],headline:['Montserrat']}}}}
    </script>
    <style>
        .glass-panel{background:rgba(255,255,255,.68);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.2);box-shadow:0 8px 32px rgba(11,26,61,.05)}
        .mosehe-pattern{background-image:url('data:image/svg+xml;utf8,<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><path d="M20 0L40 20L20 40L0 20L20 0ZM20 4L4 20L20 36L36 20L20 4Z" fill="%23be0017" fill-opacity="0.03"/></svg>')}
        .bg-gradient-primary{background:linear-gradient(135deg,#be0017,#e62129)}
    </style>
    @stack('styles')
</head>
<body class="bg-surface text-on-surface font-body mosehe-pattern flex min-h-screen">
<nav class="bg-surface shadow-sm h-screen w-72 fixed left-0 top-0 flex flex-col py-6 px-4 z-20">
    <div class="px-4 mb-8">
        <div class="h-20 w-20 rounded-2xl bg-white flex items-center justify-center shadow-lg p-2">
            <img class="h-full w-full object-contain" src="{{ asset('assets/logo/hutri81-symbol.png') }}" alt="Logo HUT RI 81">
        </div>
    </div>
    <div class="px-4 mb-6">
        <h1 class="font-headline text-xl font-bold leading-tight text-primary">HUT RI ke-81 Kabupaten Konawe</h1>
        <p class="text-sm text-on-surface-variant font-semibold">Panel Admin</p>
    </div>
    <div class="flex flex-col gap-2 flex-grow">
        <a class="{{ request()->routeIs('admin.dashboard') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.dashboard') }}"><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
        <a class="{{ request()->routeIs('admin.competitions.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.competitions.index') }}"><span class="material-symbols-outlined">event_available</span>Events/Contest</a>
        <a class="{{ request()->routeIs('admin.locations.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.locations.index') }}"><span class="material-symbols-outlined">map</span>Map & Locations</a>
        <a class="{{ request()->routeIs('admin.banners.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.banners.index') }}"><span class="material-symbols-outlined">imagesmode</span>Banner</a>
        <a class="{{ request()->routeIs('admin.videos.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.videos.index') }}"><span class="material-symbols-outlined">play_circle</span>Video</a>
        <a class="{{ request()->routeIs('admin.settings.*') ? 'text-primary font-bold border-r-4 border-primary bg-secondary-container/20' : 'text-on-surface-variant' }} flex items-center gap-3 p-3 rounded-l-lg" href="{{ route('admin.settings.edit') }}"><span class="material-symbols-outlined">settings</span>Pengaturan</a>
        <a class="text-on-surface-variant flex items-center gap-3 p-3 rounded-lg hover:bg-secondary-container/20" href="{{ route('visitor.home') }}"><span class="material-symbols-outlined">public</span>Lihat Portal</a>
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button class="w-full text-on-surface-variant flex items-center gap-3 p-3 rounded-lg hover:bg-secondary-container/20 text-left" type="submit">
                <span class="material-symbols-outlined">logout</span>
                Logout
            </button>
        </form>
    </div>
</nav>
<div class="flex-1 ml-72 min-h-screen">
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
</body>
</html>
