@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white',
    'dropdownClasses' => ''
])

@php
$alignmentClasses = match ($align) {
    'left' => 'start-0',
    'top' => 'bottom-100 mb-2',
    'right' => 'end-0',
    default => 'end-0',
};

$widthClass = match ($width) {
    '48' => 'width-48',
    '64' => 'width-64',
    '80' => 'width-80',
    'auto' => 'w-auto',
    default => $width,
};
@endphp

<div class="position-relative d-inline-block {{ $dropdownClasses }}" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="position-absolute z-3 mt-2 shadow-lg border-0 rounded-3 overflow-hidden {{ $alignmentClasses }} {{ $widthClass }}"
            style="display: none;"
            @click="open = false">
        <div class="rounded-3 ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>

<style>
    .width-48 { width: 12rem; }
    .width-64 { width: 16rem; }
    .width-80 { width: 20rem; }
    
    /* Premium ring effect simulation */
    .ring-1 {
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05), var(--bs-box-shadow-lg) !important;
    }
</style>
