<x-app-layout>
    <div class='my-6'>
        <div class='gap-0 mx-auto max-w-7xl sm:px-6 lg:px-8'>
            <div class='overflow-hidden bg-white shadow-sm sm:rounded-lg'>
                <div class='flex flex-col gap-10 p-6 bg-white border-b border-gray-200'>

                    {{-- Thư mục --}}
                    <div class='grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-5'>
                        <div class='col-span-2 text-sm font-semibold lg:col-span-3 xl:col-span-5'>Thư mục</div>

                        <a href='#' type='button' title='Bản scan phiếu tiến độ' class='flex items-center px-4 h-12 rounded border hover:bg-blue-100 focus:bg-blue-100'>
                            <svg x='0px' y='0px' focusable='false' viewBox='0 0 24 24' height='24px' width='24px' fill='#5f6368'>
                                <g>
                                    <path d='M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z'></path>
                                    <path d='M0 0h24v24H0z' fill='none'></path>
                                </g>
                            </svg>
                            <div class='ml-2 text-sm font-semibold truncate'>Bản scan phiếu tiến độ theo dõi</div>
                        </a>

                        <a href='#' type='button' title='Bản scan phiếu tiến độ' class='flex items-center px-4 h-12 rounded border hover:bg-blue-100 focus:bg-blue-100'>
                            <svg x='0px' y='0px' focusable='false' viewBox='0 0 24 24' height='24px' width='24px' fill='#5f6368'>
                                <g>
                                    <path d='M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z'></path>
                                    <path d='M0 0h24v24H0z' fill='none'></path>
                                </g>
                            </svg>
                            <div class='ml-2 text-sm font-semibold truncate'>Bản scan phiếu tiến độ theo dõi</div>
                        </a>
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
