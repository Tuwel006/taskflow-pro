<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'TaskFlow – Task Management' }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Sortable.js --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

    {{-- Vite (app.css / app.js) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        #app-wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        #content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        #page-content {
            flex: 1;
            overflow-y: auto;
            padding: 1.25rem;
            background: #f8fafc;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-data="{ mobileSidebarOpen: false }">

    <div id="app-wrapper">

        {{-- Sidebar --}}
        @include('components.layouts.partials.sidebar')

        <div id="content-area">

            {{-- Navbar --}}
            @include('components.layouts.partials.navbar')

            {{-- Main Content --}}
            <main id="page-content">
                {{ $slot }}
            </main>

        </div>
        <x-toast />
    </div>

    {{-- Bootstrap 5 JS Bundle (Popper included) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @livewireScripts

</body>
<script>
    window.userId = {{ auth()->id() }};
</script>

</html>
