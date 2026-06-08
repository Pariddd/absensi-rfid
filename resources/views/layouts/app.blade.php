<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi RFID — @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-blue-700 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <span class="font-bold text-lg">📡 Absensi RFID</span>
            <div class="flex gap-6 text-sm font-medium">
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'underline' : 'opacity-80 hover:opacity-100' }}">
                    Rekap Absensi
                </a>
                <a href="{{ route('mahasiswa.index') }}"
                   class="{{ request()->routeIs('mahasiswa.*') ? 'underline' : 'opacity-80 hover:opacity-100' }}">
                    Manajemen Mahasiswa
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded text-sm">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

</body>
</html>