<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cetak Dokumen' }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css'])
    @livewireStyles

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    
    {{ $slot }}

    @livewireScripts
</body>
</html>