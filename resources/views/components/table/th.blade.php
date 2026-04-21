@props([
    'sortable' => false,
    'direction' => null,
    'align' => 'start',
])

@php
    $alignmentClass = match($align) {
        'center' => 'text-center',
        'end' => 'text-end',
        default => 'text-start'
    };
@endphp

<th {{ $attributes->merge(['class' => 'px-4 py-3 ' . $alignmentClass]) }} 
    style="font-size: 0.725rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.025em; white-space: nowrap;">
    @if($sortable)
        <button type="button" class="btn btn-link p-0 text-decoration-none text-inherit d-inline-flex align-items-center gap-1 fw-bold" style="font-size: inherit; color: inherit;">
            {{ $slot }}
            <span class="text-muted opacity-50">
                @if($direction === 'asc')
                    <i class="bi bi-sort-up text-primary"></i>
                @elseif($direction === 'desc')
                    <i class="bi bi-sort-down-alt text-primary"></i>
                @else
                    <i class="bi bi-chevron-expand"></i>
                @endif
            </span>
        </button>
    @else
        {{ $slot }}
    @endif
</th>
