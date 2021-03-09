@php
    /**
     * @var array $directories
     */
@endphp

<x-app-layout>
    <div class='my-6'>
        <div class='mx-auto sm:px-6 lg:px-8 overflow-hidden'>
            <div class='flex flex-col gap-10 p-6'>
                {{-- Thư mục --}}
                <div class='grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-5'>
                    <div class='col-span-2 text-sm font-semibold lg:col-span-3 xl:col-span-5'>Thư mục</div>

                    @foreach ($directories as $directory)
                        @php
                            /** @var \App\Models\Account $account */
                            $account = $directory['account'];

                            /** @var \App\Enums\Provider $provider */
                            $provider = $account->provider;

                            /** @var string $iconUrl */
                            $iconUrl = match (true) {
                                \App\Enums\Provider::GOOGLE()->equals($provider) => asset('images/icons/google-drive-32.png'),
                                \App\Enums\Provider::DROPBOX()->equals($provider) => asset('images/icons/dropbox.svg')
                            }
                        @endphp

                        {{-- TODO: Gắn liên kết cho thẻ anchor --}}
                        <a href='#' class='flex relative flex-col p-4 bg-white rounded-lg border transition duration-300 ease-in-out dark:bg-gray-700 dark:border-0 group hover:bg-blue-100 focus:bg-blue-100 hover:border-transparent focus:border-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600' title='{{ $directory['filename'] ?? $directory['path'] }} - {{ $directory['account']['email'] }}'>
                            <img class='absolute p-1 w-8 h-8 bg-gray-200 bg-opacity-50 rounded-lg transition duration-300 ease-in-out dark:bg-gray-100 group-hover:bg-white dark:group-hover:bg-gray-300' src="{{ $iconUrl }}" alt='{{ $directory['account']['email'] }}'>
                            <x-directory-icon class='mx-auto mb-4 h-24' />
                            <span class='text-sm font-semibold truncate'>{{ $directory['name'] ?? $directory['path'] }}</span>
                            <span class='text-xs text-gray-400 truncate'>{{ $directory['account']['email'] }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Hiển thị các tệp tin khác ngoại trừ thư mục --}}
                <div class='grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-5'>
                    <div class='col-span-2 text-sm font-semibold lg:col-span-3 xl:col-span-5'>Tệp</div>

                    @foreach ($files as $file)
                        @php
                            /** @var \App\Models\Account $account */
                            $account = $file['account'];

                            /** @var \App\Enums\Provider $provider */
                            $provider = $account->provider;

                            /** @var string $iconUrl */
                            $iconUrl = match (true) {
                                \App\Enums\Provider::GOOGLE()->equals($provider) => asset('images/icons/google-drive-32.png'),
                                \App\Enums\Provider::DROPBOX()->equals($provider) => asset('images/icons/dropbox.svg')
                            }
                        @endphp

                        {{-- TODO: Gắn liên kết cho thẻ anchor --}}
                        <a href='#' class='flex overflow-hidden relative flex-col bg-white rounded-lg border transition duration-300 ease-in-out dark:bg-gray-700 dark:border-0 group hover:bg-blue-100 focus:bg-blue-100 hover:border-transparent focus:border-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600' title='{{ $file['filename'] }}.{{ $file['extension'] }} - {{ $account->email }}'>
                            <img class='absolute p-1 m-4 w-8 h-8 bg-gray-200 bg-opacity-50 rounded-lg transition duration-300 ease-in-out dark:bg-gray-100 group-hover:bg-white dark:group-hover:bg-gray-300' src='{{ $iconUrl }}' alt='{{ Str::ucfirst($provider) }}'>
                            @isset($file['thumbnailLink'])
                                <img src="{{ $file['thumbnailLink'] }}" alt='{{ $file['filename'] }}.{{ $file['extension'] }}' class='w-full h-48'>
                            @else
                                <x-unknow-icon />
                            @endisset
                            <div class="p-4">
                                <div class='text-sm font-semibold truncate'>{{ $file['filename'] }}.{{ $file['extension'] }}</div>
                                <div class='text-xs text-gray-400 truncate'>{{ $account->email }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
