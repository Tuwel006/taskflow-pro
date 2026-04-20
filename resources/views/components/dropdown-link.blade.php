<a {{ $attributes->merge(['class' => 'dropdown-item px-3 py-2 d-flex align-items-center gap-2 transition-all', 'style' => 'font-size: 0.8125rem; color: #475569; font-weight: 500;']) }}>
    {{ $slot }}
</a>

<style>
    .dropdown-item:hover {
        background-color: #f1f5f9;
        color: #0f172a !important;
    }
    .transition-all {
        transition: all 0.2s ease;
    }
</style>
