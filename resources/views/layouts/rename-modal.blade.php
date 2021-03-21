<div class='overflow-y-auto fixed inset-0 z-50'
     x-data='renameModal()'
     x-show='isShowModal()'
     @open-rename-modal.window='openModal($event)'>
    <div class='flex justify-center items-center px-4 min-h-screen text-center sm:block sm:p-0'>
        <div class='fixed inset-0 transition-opacity modal-overlay' aria-hidden='true'>
            <div class='absolute inset-0 bg-gray-500 opacity-50'></div>
        </div>

        <span class='hidden sm:inline-block sm:align-middle sm:h-screen' aria-hidden='true'>&#8203;</span>

        <div class='inline-block overflow-hidden w-full max-w-md text-left align-middle bg-white rounded-lg shadow-xl transition-all transform sm:max-w-lg' role='dialog' aria-modal='true' aria-labelledby='modal-headline'>
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="flex flex-col space-y-2">
                    <div class='flex justify-between'>
                        <h3 id='modal-headline' class='text-lg font-semibold leading-6 text-gray-900'>Đổi tên</h3>
                        <span class='block text-sm leading-6 text-right text-gray-400' x-text='remainingCharacterCount()'></span>
                    </div>
                    <x-input class='block w-full' type='text' name='name' x-bind:minlength='minLength' x-bind:maxlength='maxLength' x-model='form.name' required autofocus autocomplete='off' aria-label='Tên tệp tin (thư mục):' />
                    <span class='text-sm font-semibold text-blue-700' x-show='isShowSuccessMessage()' x-text='successMessage'></span>
                    <span class='text-sm font-semibold text-red-700' x-show='isShowErrorMessage()' x-text='errorMessage'></span>
                </div>
            </div>
            <div class='py-3 px-4 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse'>
                <button @click='rename()' type='button' class='inline-flex justify-center py-2 px-4 w-full text-base font-medium text-white bg-blue-600 rounded-md border border-transparent shadow-sm hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm'>
                    Đổi tên
                </button>
                <button @click='closeModal()' type='button' class='inline-flex justify-center py-2 px-4 mt-3 w-full text-base font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm'>
                    Hủy bỏ
                </button>
            </div>
        </div>
    </div>
</div>
