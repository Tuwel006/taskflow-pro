@props([
    'items' => []
])

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0 align-items-center" style="background: transparent; padding: 0;">
        {{-- Home Icon --}}
        <li class="breadcrumb-item d-flex align-items-center">
            <a href="/" wire:navigate class="text-decoration-none d-flex align-items-center transition-all" style="color: #94a3b8; font-size: 0.8125rem;">
                <i class="bi bi-house-door me-1" style="font-size: 0.9rem;"></i>
            </a>
        </li>
        
        @foreach($items as $item)
            <li class="breadcrumb-item d-flex align-items-center {{ $loop->last ? 'active' : '' }}" aria-current="{{ $loop->last ? 'page' : '' }}" style="color: #cbd5e1;">
                <i class="bi bi-chevron-right mx-2" style="font-size: 0.6rem; stroke-width: 2;"></i>
                
                @if(!$loop->last && isset($item['url']))
                    <a href="{{ $item['url'] }}" wire:navigate class="text-decoration-none fw-medium transition-all" style="color: #64748b; font-size: 0.8125rem;">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="fw-semibold" style="color: #1e293b; font-size: 0.8125rem;">
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

<style>
    .breadcrumb-item + .breadcrumb-item::before {
        display: none !important;
    }
    .breadcrumb-item a:hover {
        color: #0f172a !important;
    }
    .transition-all {
        transition: all 0.2s ease-in-out;
    }
</style>
