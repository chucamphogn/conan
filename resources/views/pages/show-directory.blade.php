@php
    /**
     * @var \Illuminate\Support\Collection $directories
     * @var \Illuminate\Support\Collection $files
     * @var \App\Models\Account $account
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
                            $account = $directory['account'];
                        @endphp

                        <x-directory :account="$account" :directory="$directory" />
                    @empty
                        <span class='col-span-full text-sm text-center'>Không có thư mục</span>
                    @endforelse
                </div>

                {{-- Hiển thị các tệp tin khác ngoại trừ thư mục --}}
                <div class='grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-5'>
                    <div class='col-span-full text-sm font-semibold'>Tệp</div>

                    @forelse ($files as $file)
                        @php
                            $account = $file['account'];
                        @endphp

                        <x-file :account="$account" :file="$file" />
                    @empty
                        <span class='col-span-full text-sm text-center'>Không có tệp tin</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
