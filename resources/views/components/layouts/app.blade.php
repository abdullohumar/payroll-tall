<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Payroll' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800 flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    @auth
        <aside class="flex-shrink-0 w-64 bg-gray-900 text-white flex flex-col transition-all duration-300 z-20"
               :class="{'fixed inset-y-0 left-0 transform translate-x-0': sidebarOpen, '-translate-x-full absolute': !sidebarOpen, 'md:relative md:translate-x-0': true}">
            
            <div class="h-16 flex items-center justify-center bg-gray-950 px-4 border-b border-gray-800">
                <span class="text-xl font-bold tracking-wider text-blue-400">PAYROLL<span class="text-white">PRO</span></span>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Menu Utama</p>
                <a href="/" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-800 {{ request()->is('/') ? 'bg-gray-800 text-white' : 'text-gray-300' }}">
                    Dashboard
                </a>

                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Master Data</p>
                <a href="{{ route('departemen.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('departemen.index') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                Departemen
                </a>

                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-800 hover:text-white">
                    Karyawan
                </a>

                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Transaksi</p>
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-800 hover:text-white">
                    Proses Penggajian
                </a>
            </nav>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black opacity-50 z-10 md:hidden"></div>

        <div class="flex-1 flex flex-col w-full min-w-0">
            
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 sm:px-6 z-10">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="hidden md:block"></div>

                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700 hidden sm:block">Halo, {{ auth()->user()->name }}</span>
                    
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium px-3 py-2 rounded-md hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50">
                {{ $slot }}
            </main>
            
        </div>
    @else
        {{ $slot }}
    @endauth
    @livewireScripts
</body>
</html>