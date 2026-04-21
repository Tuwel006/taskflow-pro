<tr {{ $attributes->merge(['class' => 'group']) }} style="transition: background-color 0.15s ease;">
    {{ $slot }}
</tr>

<style>
    tr.group:hover {
        background-color: #f8fafc !important;
    }
</style>
