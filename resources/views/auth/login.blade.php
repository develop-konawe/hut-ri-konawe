<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login Admin Konawe 81</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#be0017',
                        'primary-container': '#e62129',
                        secondary: '#515d84',
                        background: '#f8f9fa',
                        surface: '#f8f9fa',
                        'outline-variant': '#e7bdb8',
                        'on-surface': '#191c1d',
                        'on-surface-variant': '#5d3f3c',
                    },
                    fontFamily: {
                        body: ['Inter'],
                        headline: ['Montserrat'],
                    },
                },
            },
        }
    </script>
    <style>
        @keyframes drift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animated-gradient {
            background: linear-gradient(-45deg, #f8f9fa, #fff0f0, #f8f9fa, #ffdad6);
            background-size: 400% 400%;
            animation: drift 15s ease infinite;
        }
        .glass-panel {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.05);
        }
        .primary-gradient-btn {
            background: linear-gradient(135deg, #be0017 0%, #e62129 100%);
            transition: all 0.3s ease;
        }
        .primary-gradient-btn:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-background min-h-screen flex flex-col font-body text-on-surface overflow-x-hidden">
<div class="fixed inset-0 z-[-1] animated-gradient">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#be0017 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/5 rounded-full blur-[100px]"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-secondary/5 rounded-full blur-[100px]"></div>
    <div class="absolute inset-0 flex items-center justify-center overflow-hidden pointer-events-none opacity-[0.04]">
        <span class="material-symbols-outlined text-[600px] select-none">account_balance</span>
    </div>
</div>

<main class="flex-grow flex items-center justify-center p-6 sm:p-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-10 space-y-4">
            <div class="inline-block transition-transform duration-500 hover:scale-105">
                <img alt="Logo HUT RI ke-81 Kabupaten Konawe" class="h-20 sm:h-24 w-auto mx-auto drop-shadow-md" src="{{ asset('assets/logo/hutri81-full-light.png') }}">
            </div>
            <div class="space-y-1">
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary tracking-tight">HUT RI ke-81 Kabupaten Konawe</h1>
                <p class="text-on-surface-variant tracking-wide">Independence Management Portal</p>
            </div>
        </div>

        <div class="glass-panel rounded-xl p-8 sm:p-10 relative overflow-hidden border border-white/50">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-primary-container"></div>

            @if (session('status'))
                <div class="mb-6 rounded-lg bg-green-50 text-green-700 px-4 py-3 text-sm font-semibold">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 text-primary px-4 py-3 text-sm font-semibold">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="space-y-2">
                    <label class="font-semibold text-sm text-on-surface-variant flex items-center gap-2" for="login">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                        Email atau Username
                    </label>
                    <input class="w-full px-4 py-3 bg-white/70 border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-on-surface-variant/40" id="login" name="login" placeholder="admin@konawe81.id" required type="text" value="{{ old('login') }}" autofocus>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="font-semibold text-sm text-on-surface-variant flex items-center gap-2" for="password">
                            <span class="material-symbols-outlined text-[18px]">lock</span>
                            Password
                        </label>
                    </div>
                    <div class="relative">
                        <input class="w-full px-4 py-3 bg-white/70 border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-on-surface-variant/40" id="password" name="password" placeholder="********" required type="password">
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant/60 hover:text-primary transition-colors" id="togglePassword" type="button">
                            <span class="material-symbols-outlined" id="passwordIcon">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary transition-all" id="remember" name="remember" type="checkbox" value="1">
                    <label class="text-on-surface-variant select-none" for="remember">Ingat perangkat ini</label>
                </div>

                <button class="w-full primary-gradient-btn text-white font-semibold py-4 rounded-lg flex items-center justify-center gap-2 group shadow-lg" type="submit">
                    <span>Login ke Dashboard</span>
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>

            <div class="mt-8 flex items-center justify-center gap-2 text-[12px] text-on-surface-variant/60 font-semibold uppercase tracking-widest">
                <span class="material-symbols-outlined text-[16px]">verified_user</span>
                Secure Encrypted Session
            </div>
        </div>

        <div class="mt-8 flex justify-center gap-6">
            <a class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 font-semibold text-[13px]" href="{{ route('visitor.home') }}">
                <span class="material-symbols-outlined text-[18px]">public</span>
                Kembali ke Portal
            </a>
        </div>
    </div>
</main>

<footer class="w-full py-8 text-center px-4">
    <p class="text-on-surface-variant/70 font-semibold text-[13px] leading-relaxed">
        &copy; 2026 Pemerintah Kabupaten Konawe.
        <br class="sm:hidden">
        <span class="text-primary mx-2 hidden sm:inline">-</span>
        Dirgahayu Republik Indonesia ke-81.
    </p>
</footer>

<script>
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');

    toggleBtn.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        passwordIcon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
    });
</script>
</body>
</html>
