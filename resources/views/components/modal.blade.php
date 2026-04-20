@props([
    'name',
    'title' => 'Modal Title',
    'size' => 'md', // sm, md, lg, xl
    'maxWidth' => null,
])

@php
$sizeClass = match($size) {
    'sm' => 'modal-sm',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
    default => ''
};

$maxStyle = $maxWidth ? "max-width: {$maxWidth} !important;" : "";
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') open = false"
    x-on:keydown.escape.window="open = false"
>
    {{-- Trigger --}}
    @isset($trigger)
        {{ $trigger }}
    @endisset

    {{-- Overlay --}}
    <div
        x-show="open"
        x-transition.opacity
        x-cloak
        class="position-fixed top-0 start-0 w-100 h-100 p-3 p-md-5"
        :class="open ? 'd-flex' : 'd-none'"
        style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1050; overflow-y: auto; align-items: start; justify-content: center;"
    >

        {{-- Modal Box --}}
        <div
            x-show="open"
            x-transition
            x-cloak
            @click.outside="open = false"
            class="modal-dialog {{ $sizeClass }} w-100 mx-auto"
            style="{{ $maxStyle }}"
        >
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" style="background: #ffffff;">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
                    <h5 class="mb-0 fw-semibold" style="color: #0f172a;">
                        {{ $title }}
                    </h5>

                    <button class="btn-close" @click="open = false"></button>
                </div>

                {{-- Body --}}
                <div class="p-4">
                    {{ $slot }}
                </div>

                {{-- Footer (optional) --}}
                @isset($footer)
                    <div class="px-4 py-3 border-top bg-light">
                        {{ $footer }}
                    </div>
                @endisset

            </div>
        </div>

    </div>
</div>