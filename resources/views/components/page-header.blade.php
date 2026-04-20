@props([
    'title',
    'subtitle' => null,
    'breadcrumbItems' => []
])

<div class="page-header mb-4 animate-fade-in">
    <div class="container-fluid p-0">
        {{-- Breadcrumb Section --}}
        @if(!empty($breadcrumbItems))
            <div class="mb-1">
                <x-breadcrumb :items="$breadcrumbItems" />
            </div>
        @endif

        {{-- Header Content --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mt-n1">
            <div>
                <h1 class="h3 fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.025em; font-size: 1.5rem;">
                    {{ $title }}
                </h1>
                @if($subtitle)
                    <p class="text-muted mb-0" style="font-size: 0.8125rem; font-weight: 400;">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>

            {{-- Actions Slot --}}
            @isset($actions)
                <div class="d-flex align-items-center gap-2">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    </div>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.4s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .mt-n1 { margin-top: -0.25rem !important; }
</style>
