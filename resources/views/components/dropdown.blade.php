@props(['align' => 'right', 'contentClasses' => 'py-2 bg-white'])

@php
    $alignmentClasses = match ($align) {
        'left' => 'origin-top-left left-0',
        'top' => 'origin-top',
        default => 'origin-top-right right-0',
    }
@endphp

<div @click.away="open = false" @close.stop="open = false" class="relative" x-data="{ open: false }">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute mt-2 w-full rounded-md shadow-lg {{ $alignmentClasses }}">
        <div class="px-2 rounded-md shadow dark:bg-gray-800 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
