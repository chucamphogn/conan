<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Icons -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
    <div class="flex flex-col min-h-screen bg-gray-100 dark:text-gray-200 dark:bg-gray-800 md:flex-row">
        @include('layouts.navigation')

        <div class="flex flex-col w-full md:pl-64 lg:pl-72 xl:pl-80">
            @include('layouts.top-navigation')

            <main class="z-0">
                {{-- Global context menu --}}
                <div data-file-manager-global-context-menu class='flex hidden overflow-hidden absolute z-20 flex-col w-56 bg-gray-100 rounded-lg shadow-2xl'>
                    <div class='flex items-center py-2 px-4 transition duration-500 ease-in-out cursor-pointer hover:bg-blue-200 focus:bg-blue-200'>
                        <i class='mr-4 bx bx-rename'></i>
                        <span class='truncate'>Tải lên</span>
                    </div>
                    <div class='flex items-center py-2 px-4 transition duration-500 ease-in-out cursor-pointer hover:bg-blue-200 focus:bg-blue-200'>
                        <i class='mr-4 bx bx-rename'></i>
                        <span class='truncate'>Tải xuống</span>
                    </div>
                </div>

                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Modal đổi tên tệp tin, thư mục --}}
    @include('layouts.rename-modal')
</body>
</html>
