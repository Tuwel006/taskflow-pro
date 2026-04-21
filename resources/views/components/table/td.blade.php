@props([
    'align' => 'start',
])

@php
    $alignmentClass = match($align) {
        'center' => 'text-center',
        'end' => 'text-end',
        default => 'text-start'
    };
@endphp

<td {{ $attributes->merge(['class' => 'px-4 py-3 ' . $alignmentClass]) }}>
    <div style="font-size: 0.845rem; color: #334155;">
        {{ $slot }}
    </div>
</td>
