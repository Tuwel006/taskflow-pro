@props([
    'name' => null,
    'title' => 'Modal Title',
    'size' => 'md', // sm, md, lg, xl
    'maxWidth' => null,
])
@php
    $maxWidthValue = match ($size) {
        'sm' => '300px',
        'md' => '500px',
        'lg' => '800px',
        'xl' => '1140px',
        default => '500px',
    };
@endphp

<div x-data="{ open: false, name: '{{ $name }}' }"
    x-on:open-modal.window="if (!name || (typeof $event.detail === 'string' ? $event.detail === name : ($event.detail.name === name || (Array.isArray($event.detail) && $event.detail[0] === name)))) open = true"
    x-on:close-modal.window="if (!name || (typeof $event.detail === 'string' ? $event.detail === name : ($event.detail.name === name || (Array.isArray($event.detail) && $event.detail[0] === name)))) open = false"
    x-on:keydown.escape.window="open = false">
    {{-- Trigger --}}
    @isset($trigger)
        {{ $trigger }}
    @endisset

    {{-- Overlay --}}
    <div x-show="open" x-transition.opacity x-cloak class="position-fixed top-0 start-0 w-100 h-100 p-3 p-md-5"
        :class="open ? 'd-flex' : 'd-none'"
        style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1050; overflow-y: auto; align-items: start; justify-content: center;">

        {{-- Modal Box --}}
        <div x-show="open" x-transition x-cloak @click.outside="open = false" class="modal-dialog w-100 mx-auto"
            style="max-width: {{ $maxWidth ?? $maxWidthValue }};">
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
