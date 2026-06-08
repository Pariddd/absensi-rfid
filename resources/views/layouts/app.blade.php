<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi RFID — @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --blue-50:  #eff6ff;
            --blue-100: #dbeafe;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --blue-800: #1e40af;

            --nav-bg:       #ffffff;
            --nav-border:   #e2e8f0;
            --nav-text:     #1e293b;
            --nav-muted:    #64748b;
            --nav-active-bg:#eff6ff;
            --nav-active:   #2563eb;
            --nav-hover-bg: #f8fafc;

            --body-bg:      #f1f5f9;
            --card-bg:      #ffffff;
            --card-border:  #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary:#64748b;
            --text-muted:   #94a3b8;

            --success-bg:   #f0fdf4;
            --success-border:#bbf7d0;
            --success-text: #166534;
            --error-bg:     #fef2f2;
            --error-border: #fecaca;
            --error-text:   #991b1b;
        }

        html.dark {
            --nav-bg:       #0f172a;
            --nav-border:   #1e293b;
            --nav-text:     #f1f5f9;
            --nav-muted:    #94a3b8;
            --nav-active-bg:#1e3a5f;
            --nav-active:   #60a5fa;
            --nav-hover-bg: #1e293b;

            --body-bg:      #0f172a;
            --card-bg:      #1e293b;
            --card-border:  #334155;
            --text-primary: #f1f5f9;
            --text-secondary:#94a3b8;
            --text-muted:   #475569;

            --success-bg:   #052e16;
            --success-border:#166534;
            --success-text: #86efac;
            --error-bg:     #450a0a;
            --error-border: #991b1b;
            --error-text:   #fca5a5;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-primary);
            transition: background-color 0.2s ease, color 0.2s ease;
            min-height: 100vh;
        }
        .navbar {
            background-color: var(--nav-bg);
            border-bottom: 1px solid var(--nav-border);
            position: sticky;
            top: 0;
            z-index: 50;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.25rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        .nav-logo-icon {
            width: 34px;
            height: 34px;
            background-color: var(--blue-600);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .nav-logo-icon svg {
            width: 18px;
            height: 18px;
            color: #fff;
        }

        .nav-logo-text {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--nav-text);
            letter-spacing: -0.01em;
            line-height: 1;
        }

        .nav-logo-sub {
            font-size: 0.6875rem;
            font-weight: 400;
            color: var(--nav-muted);
            letter-spacing: 0.02em;
            line-height: 1;
            margin-top: 2px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.4rem 0.75rem;
            border-radius: 7px;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--nav-muted);
            text-decoration: none;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .nav-link:hover {
            background-color: var(--nav-hover-bg);
            color: var(--nav-text);
        }

        .nav-link.active {
            background-color: var(--nav-active-bg);
            color: var(--nav-active);
            font-weight: 600;
        }

        .nav-link svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .dark-toggle {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--card-border);
            background-color: transparent;
            color: var(--nav-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
        }

        .dark-toggle:hover {
            background-color: var(--nav-hover-bg);
            color: var(--nav-text);
        }

        .dark-toggle svg {
            width: 16px;
            height: 16px;
        }

        .hamburger {
            display: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--card-border);
            background: transparent;
            color: var(--nav-muted);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
        }

        .hamburger svg { width: 18px; height: 18px; }

        .mobile-menu {
            display: none;
            background-color: var(--nav-bg);
            border-bottom: 1px solid var(--nav-border);
            padding: 0.75rem 1.25rem 1rem;
        }

        .mobile-menu.open { display: block; }

        .mobile-menu .nav-link {
            display: flex;
            width: 100%;
            padding: 0.625rem 0.75rem;
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        .main-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1.75rem 1.25rem;
        }

        .alert {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            border: 1px solid;
            font-size: 0.8125rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
        }

        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        .alert-success {
            background-color: var(--success-bg);
            border-color: var(--success-border);
            color: var(--success-text);
        }

        .alert-error {
            background-color: var(--error-bg);
            border-color: var(--error-border);
            color: var(--error-text);
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hamburger { display: flex; }
            .main-content { padding: 1.25rem 1rem; }
        }

        @media (max-width: 480px) {
            .nav-logo-sub { display: none; }
        }
    </style>
    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ route('dashboard') }}" class="nav-logo">
                <div class="nav-logo-icon">
                    <!-- RFID / signal icon -->
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12.55a11 11 0 0 1 14.08 0"/>
                        <path d="M1.42 9a16 16 0 0 1 21.16 0"/>
                        <path d="M8.53 16.11a6 6 0 0 1 6.95 0"/>
                        <circle cx="12" cy="20" r="1" fill="currentColor"/>
                    </svg>
                </div>
                <div>
                    <div class="nav-logo-text">Absensi RFID</div>
                    <div class="nav-logo-sub">Informatika</div>
                </div>
            </a>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Rekap Absensi
                </a>
                <a href="{{ route('mahasiswa.index') }}"
                   class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Manajemen Mahasiswa
                </a>
            </div>
            <div class="nav-right">
                <button class="dark-toggle" onclick="toggleDark()" aria-label="Toggle dark mode" title="Toggle dark mode">
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                </button>
                <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Rekap Absensi
            </a>
            <a href="{{ route('mahasiswa.index') }}"
               class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Manajemen Mahasiswa
            </a>
        </div>
    </nav>
    <main class="main-content">

        @if(session('success'))
            <div class="alert alert-success">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        function toggleDark() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateDarkIcon(isDark);
        }

        function updateDarkIcon(isDark) {
            const sun  = document.querySelector('.icon-sun');
            const moon = document.querySelector('.icon-moon');
            if (sun && moon) {
                sun.style.display  = isDark ? 'block' : 'none';
                moon.style.display = isDark ? 'none'  : 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateDarkIcon(document.documentElement.classList.contains('dark'));
        });

        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('mobileMenu');
            const hamburger = document.querySelector('.hamburger');
            if (!menu.contains(e.target) && !hamburger.contains(e.target)) {
                menu.classList.remove('open');
            }
        });
    </script>
</body>
</html>