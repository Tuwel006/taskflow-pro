@props(['user', 'size' => '32px', 'fontsize' => '0.75rem'])

@php
    $name = $user->name ?? 'Unknown User';
    $words = explode(' ', trim($name));
    $initials = '';

    if (count($words) >= 2) {
        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[count($words) - 1], 0, 1));
    } else {
        $initials = strtoupper(substr($name, 0, min(2, strlen($name))));
    }

    // Generate a consistent color based on name
    $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4'];
    $colorIndex = abs(crc32($name)) % count($colors);
    $bgColor = $colors[$colorIndex];
@endphp

<div {{ $attributes->merge(['class' => 'd-inline-block position-relative overflow-hidden']) }}
    style="width: {{ $size }}; height: {{ $size }}; flex-shrink: 0; border-radius: 50%;"
    x-data="{ imgError: false }">

    @if ($user && $user->avatar)
        <img src="{{ $user->avatar }}" alt="{{ $name }}"
            class="rounded-circle w-100 h-100 object-fit-cover shadow-sm border border-2 border-white" x-show="!imgError"
            x-on:error="imgError = true" style="display: block;">
    @endif

    <div x-show="imgError || !{{ $user && $user->avatar ? 'true' : 'false' }}" x-cloak
        class="rounded-circle w-100 h-100 d-flex align-items-center justify-content-center fw-bold shadow-sm border border-2 border-white position-absolute top-0 start-0"
        style="background: {{ $bgColor }}; color: #fff; font-size: {{ $fontsize }}; letter-spacing: -0.02em;">
        {{ $initials }}
    </div>
</div>
