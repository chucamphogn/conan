<nav class="hidden sticky top-0 z-10 px-5 h-16 bg-white md:justify-between dark:bg-gray-900 md:flex">
    {{-- TODO: Thiết kế lại khung tìm kiếm --}}
    <div class="hidden md:inline">
        <x-input class="block mt-1 w-full" type="text" name="q" placeholder="Tìm kiếm tệp tin" required />
    </div>

    <div class="hidden sm:inline-flex sm:items-center sm:ml-6">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300">
                    <div class="dark:text-white">{{ auth()->user()->name }}</div>

                    <div class="ml-1">
                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                {{-- TODO: Gán liên kết cho "Cài đặt" --}}
                <x-dropdown-link href="#">Cài đặt</x-dropdown-link>

                <x-dropdown-link :href="route('logout')" @click.prevent="document.getElementById('logout-form').submit();">
                    Đăng xuất
                </x-dropdown-link>

                <form id="logout-form" method="post" action="{{ route('logout') }}">
                    @csrf
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
