@php
    /**
     * @var \App\Models\Account[] $cloudStorageAccounts
     */
@endphp

<aside class='flex-col w-full shadow-lg md:flex md:flex-row md:min-h-screen md:w-auto'>
    <div @click.away='open = false' x-data='{ open: false }'
         class='flex flex-col flex-shrink-0 w-full text-gray-700 bg-white md:w-64 lg:w-72 xl:w-80 dark:text-gray-200 dark:bg-gray-900'>

        <!-- Header -->
        <div class='flex flex-row flex-shrink-0 justify-between items-center py-4 px-8'>
            <a href="{{ route('dashboard') }}"
               class='text-2xl font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark:text-gray-200 focus:outline-none focus:shadow-outline'>
                {{ config('app.name') }}
            </a>

            <!-- Toggle Navigation Bar -->
            <button class='rounded-lg md:hidden focus:outline-none focus:shadow-outline' @click='open = !open'>
                <svg fill='currentColor' viewBox='0 0 20 20' class='w-6 h-6'>
                    {{-- Hiện icon mở navigation bar --}}
                    <path x-show='!open' fill-rule='evenodd' clip-rule='evenodd'
                          d='M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z'></path>

                    {{-- Hiện icon đóng navigation bar --}}
                    <path x-show='open' fill-rule='evenodd' clip-rule='evenodd'
                          d='M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z'></path>
                </svg>
            </button>
        </div>

        <!-- Body -->
        <nav :class="{'block': open, 'hidden': !open}" class='flex-grow px-4 pb-4 md:block md:pb-0 md:overflow-y-auto'>
            <x-nav-link active href="{{ route('dashboard') }}">Tất Cả</x-nav-link>

            <div class='mt-5'>
                <span class='inline-block py-2 px-4 text-xl font-bold'>Vị trí</span>

                <div class='grid gap-2'>
                    <x-nav-link href="{{ route('account.add-cloud-storage') }}" class='flex items-center'>
                        <i class='mr-5 ml-1 bx bx-plus bx-sm'></i>
                        <span>Thêm tài khoản</span>
                    </x-nav-link>

                    @foreach($cloudStorageAccounts as $account)
                        <x-dropdown-cloud-link href='#' :provider='$account->provider'
                                               :title='$account->alias_name' :description='$account->email'/>
                    @endforeach
                </div>
            </div>

            {{--            <x-nav-link href="#">A</x-nav-link>--}}
            {{--            <x-nav-link href="#">B</x-nav-link>--}}
            {{--            <x-nav-link href="#">C</x-nav-link>--}}

            {{--            <x-dropdown>--}}
            {{--                <x-slot name="trigger">--}}
            {{--                    <x-dropdown-button>--}}
            {{--                        <span>X</span>--}}
            {{--                    </x-dropdown-button>--}}
            {{--                </x-slot>--}}

            {{--                <x-slot name="content">--}}
            {{--                    <x-dropdown-link href="#" class="md:mt-0">Link #1</x-dropdown-link>--}}
            {{--                    <x-dropdown-link href="#">Link #2</x-dropdown-link>--}}
            {{--                    <x-dropdown-link href="#">Link #3</x-dropdown-link>--}}
            {{--                </x-slot>--}}
            {{--            </x-dropdown>--}}
        </nav>
    </div>
</aside>
