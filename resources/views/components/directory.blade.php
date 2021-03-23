@props(['account', 'directory'])

@php
    /** @var \App\Models\Account $account */

    /** @var \App\Enums\Provider $provider */
    $provider = $account->provider;

    /** @var string $iconUrl */
    $iconUrl = match (true) {
        \App\Enums\Provider::GOOGLE()->equals($provider) => asset('images/icons/google-drive-32.png'),
        \App\Enums\Provider::DROPBOX()->equals($provider) => asset('images/icons/dropbox.svg')
    };

    // Đường dẫn cho thẻ anchor
    $href = route('directory.show', [$account->id, base64_encode($directory['path'])]);

    $title = $directory['filename'] . ' - ' . $account->email;
@endphp

<a data-file-manager-item
   class='relative p-4 bg-white rounded-lg border transition duration-300 ease-in-out dark:bg-gray-700 dark:border-0 group hover:bg-blue-100 focus:bg-blue-100 hover:border-transparent focus:border-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600'
   href='{{ $href }}'
   title='{{ $title }}'>
    <div class='flex flex-col'>
        <img class='absolute p-1 w-8 h-8 bg-gray-200 bg-opacity-50 rounded-lg transition duration-300 ease-in-out dark:bg-gray-100 group-hover:bg-white dark:group-hover:bg-gray-300' src="{{ $iconUrl }}" alt='{{ $account->email }}'>
        {{-- Directory icon --}}
        <svg class='mx-auto mb-4 h-24' focusable="false" viewBox='0 0 24 24' fill='#5f6368'>
            <g>
                <path class="dark:fill-current dark:text-gray-500" d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z" />
                <path d="M0 0h24v24H0z" fill="none" />
            </g>
        </svg>
        <span class='text-sm font-semibold truncate'>{{ $directory['filename'] }}</span>
        <span class='text-xs text-gray-400 truncate'>{{ $account->email }}</span>
    </div>

    {{-- Menu chuột phải --}}
    <div data-file-manager-item-context-menu class='flex hidden overflow-hidden absolute z-20 flex-col w-56 bg-gray-100 rounded-lg shadow-2xl'>
        <div data-action='rename' x-data
             @click.prevent="$dispatch('open-rename-modal', { email: '{{ $account->email }}', provider: '{{ $account->provider }}', path: '{{ $directory['path'] }}', name: '{{ $directory['filename'] }}' })"
             class='flex items-center py-2 px-4 transition duration-500 ease-in-out cursor-pointer hover:bg-blue-200 focus:bg-blue-200'>
            <i class='mr-4 bx bx-rename'></i>
            <span class='truncate'>Đổi tên</span>
        </div>
    </div>
</a>
