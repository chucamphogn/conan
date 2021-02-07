@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block py-2 px-4 mt-2 text-sm font-semibold text-white bg-blue-500 rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 focus:outline-none focus:shadow-outline transition duration-500 ease-in-out'
        : 'block py-2 px-4 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-blue-100 focus:bg-blue-100 focus:outline-none focus:shadow-outline transition duration-500 ease-in-out'
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
