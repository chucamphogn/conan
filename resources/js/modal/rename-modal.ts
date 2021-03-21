import axios from 'axios';
import { isEmpty } from 'lodash';

type RenameModalState = {
    /**
     * Lưu giữ trạng thái hiện/ẩn của modal
     */
    showModal: boolean;

    /**
     * Độ dài tối thiểu của input
     */
    minLength: number;

    /**
     * Độ dài tối đa của input
     */
    maxLength: number;

    /**
     * Tin nhắn thành công
     */
    successMessage: string;

    /**
     * Tin nhắn thất bại
     */
    errorMessage: string;

    /**
     * Form lưu trữ thông tin để đẩy lên máy chủ
     */
    form: RenameForm,
};

type RenameForm = {
    /**
     * Địa chỉ email
     */
    email: string;

    /**
     * Kho lưu trữ
     */
    provider: string;

    /**
     * Đường dẫn hiện tại của tệp tin, thư mục
     */
    path: string;

    /**
     * Tên hiện tại hoặc tên mới của tệp tin, thư mục
     */
    name: string;
};

type RenameModalFunctions = {
    /**
     * Kiểm tra xem có hiển thị modal hay không
     */
    isShowModal(): boolean;

    /**
     * Hiển thị modal
     * @param $event
     */
    openModal($event: any): void;

    /**
     * Ẩn modal
     */
    closeModal(): void;

    /**
     * Kiểm tra xem có hiển thị success massage hay không
     */
    isShowSuccessMessage(): boolean;

    /**
     * Kiểm tra xem có hiển thị error message hay không
     */
    isShowErrorMessage(): boolean;

    /**
     * Hiển thị thông tin số ký tự còn lại
     *
     * @example Tối đa 255 ký tự và bạn đang nhập 10 ký tự thì sẽ hiển thị: 10 / 255
     */
    remainingCharacterCount(): string;

    /**
     * Gửi request đổi tên tệp tin, thư mục lên máy chủ
     */
    rename(): void;
};

export type RenameModal = RenameModalState & RenameModalFunctions;

window.renameModal = () => {
    return {
        showModal: false,
        minLength: 0,
        maxLength: 255,
        errorMessage: '',
        successMessage: '',
        form: {
            email: '',
            name: '',
            path: '',
            provider: ''
        },

        isShowModal(): boolean {
            return this.showModal;
        },

        openModal(event: CustomEvent<RenameForm>) {
            this.showModal = true;

            // Gán thông tin vào biến form
            this.form.email = event.detail.email;
            this.form.provider = event.detail.provider;
            this.form.path = event.detail.path;

            this.form.name = event.detail.name.substring(0, this.maxLength);
        },

        closeModal() {
            this.showModal = false;

            // Đặt lại (reset) giá trị khi đóng modal
            this.form.path = '';
            this.form.name = '';
            this.form.email = '';
            this.form.provider = '';
            this.successMessage = '';
            this.errorMessage = '';
        },

        isShowSuccessMessage(): boolean {
            return !isEmpty(this.successMessage);
        },

        isShowErrorMessage(): boolean {
            return !isEmpty(this.errorMessage);
        },

        remainingCharacterCount(): string {
            return `${this.form.name.length} / ${this.maxLength}`;
        },

        rename() {
            axios.put('/files/rename', this.form)
                .then(response => {
                    this.successMessage = response.data.message;
                    window.location.reload();
                })
                .catch(error => {
                    this.errorMessage = error.response.data.message;
                });
        }
    };
};
