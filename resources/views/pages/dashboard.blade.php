@php
    /**
     * @var array $directories
     */
@endphp

<x-app-layout>
    <div class='my-6'>
        <div class='gap-0 mx-auto sm:px-6 lg:px-8'>
            <div class='overflow-hidden bg-white shadow-sm sm:rounded-lg'>
                <div class='flex flex-col gap-10 p-6 bg-white border-b border-gray-200'>
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
                            <a href='#' class='flex relative flex-col p-4 rounded-lg border transition duration-300 ease-in-out group hover:bg-blue-100 focus:bg-blue-100 hover:border-transparent focus:border-transparent' title='{{ $directory['filename'] ?? $directory['path'] }} - {{ $directory['account']['email'] }}'>
                                <img class='absolute p-1 w-8 h-8 bg-gray-200 bg-opacity-50 rounded-lg transition duration-300 ease-in-out group-hover:bg-white' src="{{ $iconUrl }}" alt='{{ $directory['account']['email'] }}'>
                                <img class='mx-auto mb-4 h-24' src="{{ asset('images/icons/folder.svg') }}" alt='{{ $directory['filename'] ?? $directory['path'] }}'>
                                <span class='text-sm font-semibold truncate'>{{ $directory['name'] ?? $directory['path'] }}</span>
                                <span class='text-xs text-gray-400 truncate'>{{ $directory['account']['email'] }}</span>
                            </a>
                        @endforeach
                    </div>

                    {{-- Hiển thị các tệp tin khác ngoại trừ thư mục --}}
                    <div class='grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-5'>
                        <div class='col-span-2 text-sm font-semibold lg:col-span-3 xl:col-span-5'>Tệp</div>

                        <div class='h-12 bg-gray-400'></div>
                        <div class='h-12 bg-amber-400'></div>
                        <div class='h-12 bg-red-400'></div>
                        <div class='h-12 bg-gray-400'></div>
                        <div class='h-12 bg-amber-400'></div>
                        <div class='h-12 bg-red-400'></div>
                        <div class='h-12 bg-gray-400'></div>
                        <div class='h-12 bg-amber-400'></div>
                        <div class='h-12 bg-red-400'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
