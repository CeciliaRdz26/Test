<!-- resources/views/components/nav-link.blade.php -->
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block px-4 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md'
            : 'block px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 rounded-md';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
