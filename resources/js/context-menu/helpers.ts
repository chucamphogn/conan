/**
 * Kiểm tra người dùng có click chuột ra bên ngoài menu hay không
 * Trả về true nếu có và ngược lại trả về false
 */
export function isClickOutside(target: EventTarget | null, selector: string): boolean {
    if (target === null) {
        return true;
    }

    return (target as Element).closest(selector) === null;
}
