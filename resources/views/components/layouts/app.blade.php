<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Task Manager' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body>

<div class="d-flex" style="height: 100vh;">

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <div class="flex-grow-1 d-flex flex-column">

        <!-- Navbar -->
        @include('layouts.partials.navbar')

        <!-- Content -->
        <main class="p-4 overflow-auto">
            {{ $slot }}
        </main>

    </div>
</div>

@livewireScripts
</body>
</html>