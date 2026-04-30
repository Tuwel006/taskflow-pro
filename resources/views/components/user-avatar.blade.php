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

    // Build the correct public URL for the avatar
    $avatarUrl = null;
    if ($user && $user->avatar) {
        $av = $user->avatar;
        if (str_starts_with($av, 'http') || str_starts_with($av, '/')) {
            $avatarUrl = $av;
        } else {
            $avatarUrl = asset('storage/' . $av);
        }
    }
@endphp

<div {{ $attributes->merge(['class' => 'd-inline-flex position-relative align-items-center justify-content-center', 'title' => $name . ($user && !empty($user->email) ? ' (' . $user->email . ')' : '')]) }}
    style="width: {{ $size }}; height: {{ $size }}; flex-shrink: 0; border-radius: 50%; overflow: hidden; background: {{ $bgColor }};">

    {{-- Initials fallback — always underneath --}}
    <span style="font-size: {{ $fontsize }}; font-weight: 700; color: #fff; letter-spacing: -0.02em; line-height: 1; user-select: none;">
        {{ $initials }}
    </span>

    @if ($avatarUrl)
        {{-- Image is absolutely positioned on top of initials.
             On error it hides itself, revealing the initials beneath. --}}
        <img src="{{ $avatarUrl }}"
             alt="{{ $name }}"
             class="rounded-circle"
             style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;"
             onerror="this.style.display='none'">
    @endif

</div>
