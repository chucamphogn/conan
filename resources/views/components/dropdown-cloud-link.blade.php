@props([
    'active' => false,
    'type' => App\Enums\TokenType::GOOGLE(),
    'title' => 'Không có tên',
    'description' => ''
])

@php
    use App\Enums\TokenType;

    $classes = $active
        ? 'flex items-center py-2 px-4 min-w-0 text-sm font-semibold text-white bg-blue-500 rounded-lg transition duration-500 ease-in-out dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 focus:outline-none focus:shadow-outline transition duration-500 ease-in-out'
        : 'flex items-center py-2 px-4 min-w-0 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 hover:text-gray-900 focus:text-gray-900 hover:bg-blue-100 focus:bg-blue-100 focus:outline-none focus:shadow-outline transition duration-500 ease-in-out';

    $descriptionClasses = $active
        ? 'text-gray-100'
        : 'text-gray-400';

    $icon = match (true) {
        $type->equals(TokenType::DROPBOX()) => 'https://cfl.dropboxstatic.com/static/images/logo_catalog/dropbox_logo_glyph_m1.svg',
        default => 'https://www.google.com/images/icons/product/drive-32.png',
    }
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} title="{{ $title }} - {{ $description }}">
    <img src="{{ $icon }}" alt="{{ $title }}" width="32" height="32">
    <div class="flex flex-col ml-4 min-w-0">
        <span class="truncate">{{ $title }}</span>
        <span class="truncate text-xs {{ $descriptionClasses }}">{{ $description }}</span>
    </div>
</a>
