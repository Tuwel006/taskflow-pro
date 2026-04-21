@props([
    'items' => null, // The data collection (for pagination and empty check)
    'emptyText' => 'No records found matching your criteria.',
    'emptyIcon' => 'bi-search',
])

<div {{ $attributes->merge(['class' => 'card border-0 shadow-sm']) }} 
     style="background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 12px; overflow: hidden; transition: all 0.3s ease;">
    
    @if(isset($header))
        <div class="card-header bg-white border-0 py-3 px-4">
            {{ $header }}
        </div>
    @endif

    <div class="card-body p-0 position-relative" style="min-height: 200px;">
        {{-- Loading Overlay --}}
        <div wire:loading.flex class="position-absolute w-100 h-100 align-items-center justify-content-center" 
             style="background: rgba(255,255,255,0.6); z-index: 10; top: 0; left: 0; backdrop-filter: blur(1px); transition: all 0.3s ease;">
            <div class="text-center">
                <div class="spinner-border text-primary mb-2" role="status" style="width: 1.5rem; height: 1.5rem; border-width: 0.15em;"></div>
                <div class="text-muted fw-500" style="font-size: 0.75rem;">Updating results...</div>
            </div>
        </div>

        <div class="table-responsive" style="overflow: visible !important;">
            <table class="table align-middle mb-0">
                <thead style="background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                    <tr>
                        {{ $columns }}
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @if($items && $items->count() > 0)
                        {{ $slot }}
                    @else
                        <tr>
                            <td colspan="100" class="py-5 text-center">
                                <div class="py-4">
                                    <i class="bi {{ $emptyIcon }} text-muted opacity-25 mb-3 d-inline-block" style="font-size: 3rem;"></i>
                                    <h6 class="fw-bold text-slate-800 mb-1">{{ $emptyText }}</h6>
                                    <p class="text-muted small mb-0">Try adjusting your filters or search terms.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($items) && method_exists($items, 'links') && $items->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4 border-top border-light">
            {{ $items->links() }}
        </div>
    @elseif(isset($footer))
        <div class="card-footer bg-white border-0 py-3 px-4 border-top border-light">
            {{ $footer }}
        </div>
    @endif
</div>
