<x-guest-layout>
    <div class='flex justify-center items-center px-5 h-screen bg-gray-100 shadow-lg dark:bg-gray-900'>
        <div class='flex flex-col p-5 w-full h-96 text-center bg-white rounded-xl sm:w-1/2 lg:w-1/3 2xl:w-1/5 dark:bg-gray-800 dark:text-white'>
            <div class='text-2xl font-bold'>Thêm Tài Khoản</div>

            <div class='flex flex-wrap flex-1 gap-x-5 justify-center items-center my-10'>
                {{-- Google --}}
                <a href="{{ route('account.add-account-google') }}" title='Thêm tài khoản Google Drive'
                   class='p-2 w-20 rounded-lg transition duration-200 ease-in-out hover:bg-gray-200 focus:bg-gray-200 dark:hover:bg-white dark:focus:bg-white'>
                    <img src='{{ asset('images/icons/google-drive-64.png') }}' alt='Google'>
                </a>

                {{-- Dropbox --}}
                <a href="{{ route('account.add-account-dropbox') }}" title='Thêm tài khoản Dropbox'
                   class='p-2 w-20 rounded-lg transition duration-200 ease-in-out hover:bg-gray-200 focus:bg-gray-200 dark:hover:bg-white dark:focus:bg-white'>
                    <img src='{{ asset('images/icons/dropbox.svg') }}' alt='Dropbox'>
                </a>
            </div>

            <a href="{{ route('dashboard') }}" class='text-gray-500'>Quay về trang chủ</a>
        </div>
    </div>
</x-guest-layout>
