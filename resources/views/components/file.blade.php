@props(['account', 'file'])

@php
    /** @var \App\Models\Account $account */

    /** @var \App\Enums\Provider $provider */
    $provider = $account->provider;

    /** @var string $iconUrl */
    $iconUrl = match (true) {
        \App\Enums\Provider::GOOGLE()->equals($provider) => asset('images/icons/google-drive-32.png'),
        \App\Enums\Provider::DROPBOX()->equals($provider) => asset('images/icons/dropbox.svg')
    };
@endphp

<div data-file-manager-item class='relative bg-white rounded-lg border transition duration-300 ease-in-out dark:bg-gray-700 dark:border-0 group hover:bg-blue-100 focus:bg-blue-100 hover:border-transparent focus:border-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600'>
    <a href='#' class='flex overflow-hidden flex-col rounded-t-lg' title='{{ $file['basename'] }} - {{ $account->email }}'>
        <img class='absolute p-1 m-4 w-8 h-8 bg-gray-200 bg-opacity-50 rounded-lg transition duration-300 ease-in-out dark:bg-gray-100 group-hover:bg-white dark:group-hover:bg-gray-300' src='{{ $iconUrl }}' alt='{{ Str::ucfirst($provider) }}'>
        @isset($file['thumbnailLink'])
            <img src="{{ $file['thumbnailLink'] }}" alt='{{ $file['basename'] }}' class='w-full h-48'>
        @else
            <x-unknow-icon />
        @endisset
        <div class="p-4">
            <div class='text-sm font-semibold truncate'>{{ $file['basename'] }}</div>
            <div class='text-xs text-gray-400 truncate'>{{ $account->email }}</div>
        </div>
    </a>

    {{-- Menu chuột phải --}}
    <div data-file-manager-item-context-menu class='flex hidden overflow-hidden absolute z-20 flex-col w-56 bg-gray-100 rounded-lg shadow-2xl'>
        <div data-action='rename' x-data
             @click="$dispatch('open-rename-modal', { email: '{{ $account->email }}', provider: '{{ $account->provider }}', path: '{{ $file['path'] }}', name: '{{ $file['basename'] }}' })"
             class='flex items-center py-2 px-4 transition duration-500 ease-in-out cursor-pointer hover:bg-blue-200 focus:bg-blue-200'>
            <i class='mr-4 bx bx-rename'></i>
            <span class='truncate'>Đổi tên</span>
        </div>
    </div>
</div>
