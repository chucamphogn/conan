@php
    /**
     * @var array $directories
     * @var array $files
     */
@endphp

<x-app-layout>
    <div class='my-6'>
        <div class='overflow-hidden mx-auto sm:px-6 lg:px-8'>
            <div class='flex flex-col gap-10 p-6'>
                {{-- Thư mục --}}
                <div class='grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-5'>
                    <div class='col-span-full text-sm font-semibold'>Thư mục</div>

                    @forelse ($directories as $directory)
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
                        <div data-file-manager-item class='relative p-4 bg-white rounded-lg border transition duration-300 ease-in-out dark:bg-gray-700 dark:border-0 group hover:bg-blue-100 focus:bg-blue-100 hover:border-transparent focus:border-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600'>
                            <a href='#' class='flex flex-col' title='{{ $directory['filename'] ?? $directory['path'] }} - {{ $directory['account']['email'] }}'>
                                <img class='absolute p-1 w-8 h-8 bg-gray-200 bg-opacity-50 rounded-lg transition duration-300 ease-in-out dark:bg-gray-100 group-hover:bg-white dark:group-hover:bg-gray-300' src="{{ $iconUrl }}" alt='{{ $directory['account']['email'] }}'>
                                <x-directory-icon class='mx-auto mb-4 h-24' />
                                <span class='text-sm font-semibold truncate'>{{ $directory['name'] ?? $directory['path'] }}</span>
                                <span class='text-xs text-gray-400 truncate'>{{ $directory['account']['email'] }}</span>
                            </a>

                            {{-- Menu chuột phải --}}
                            <div data-file-manager-item-context-menu class='flex hidden overflow-hidden absolute z-20 flex-col w-56 bg-gray-100 rounded-lg shadow-2xl'>
                                <div data-action='rename' x-data @click="$dispatch('open-rename-modal', { email: '{{ $account->email }}', provider: '{{ $account->provider }}', path: '{{ $directory['path'] }}', name: '{{ $directory['name'] ?? $directory['path'] }}' })" class='flex items-center py-2 px-4 transition duration-500 ease-in-out cursor-pointer hover:bg-blue-200 focus:bg-blue-200'>
                                    <i class='mr-4 bx bx-rename'></i>
                                    <span class='truncate'>Đổi tên</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <span class='col-span-full text-sm text-center'>Không có dữ liệu</span>
                    @endforelse
                </div>

                {{-- Hiển thị các tệp tin khác ngoại trừ thư mục --}}
                <div class='grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-5'>
                    <div class='col-span-full text-sm font-semibold'>Tệp</div>

                    @forelse ($files as $file)
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
                        <div data-file-manager-item class='relative bg-white rounded-lg border transition duration-300 ease-in-out dark:bg-gray-700 dark:border-0 group hover:bg-blue-100 focus:bg-blue-100 hover:border-transparent focus:border-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600'>
                            <a href='#' class='flex overflow-hidden flex-col rounded-t-lg' title='{{ $file['filename'] }}.{{ $file['extension'] }} - {{ $account->email }}'>
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

                            {{-- Menu chuột phải --}}
                            <div data-file-manager-item-context-menu class='flex hidden overflow-hidden absolute z-20 flex-col w-56 bg-gray-100 rounded-lg shadow-2xl'>
                                <div data-action='rename' x-data @click="$dispatch('open-rename-modal', { email: '{{ $account->email }}', provider: '{{ $account->provider }}', path: '{{ $file['path'] }}', name: '{{ $file['filename'] }}.{{ $file['extension'] }}' })" class='flex items-center py-2 px-4 transition duration-500 ease-in-out cursor-pointer hover:bg-blue-200 focus:bg-blue-200'>
                                    <i class='mr-4 bx bx-rename'></i>
                                    <span class='truncate'>Đổi tên</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <span class='col-span-full text-sm text-center'>Không có dữ liệu</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
