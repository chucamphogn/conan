import { isClickOutside } from "./helpers";

/**
 * Ẩn context menu
 */
function hiddenLocalCtxMenu() {
    // Ẩn các context menu đang hiển thị
    document.querySelectorAll('[data-file-manager-item] [data-file-manager-item-context-menu]:not(.hidden)')
        .forEach(contextMenu => {
            // Ẩn context menu
            contextMenu.classList.add('hidden');

            // Xóa các sự kiện click các hành động trong context menu
            for (const action of contextMenu.children) {
                (action as HTMLElement).removeEventListener('click', handleCtxMenuAction)
            }
        });

    // Xóa các sự kiện theo dõi chuột để ẩn context menu
    document.removeEventListener('blur', handleHiddenLocalCtxMenuWhenClickOutside);
    document.removeEventListener('mousedown', handleHiddenLocalCtxMenuWhenClickOutside);
    document.removeEventListener('wheel', handleHiddenLocalCtxMenuWhenClickOutside);
}

/**
 * Xử lý ẩn context menu khi click ra bên ngoài
 */
function handleHiddenLocalCtxMenuWhenClickOutside(event: Event) {
    if (isClickOutside(event.target, '[data-file-manager-item-context-menu]')) {
        hiddenLocalCtxMenu();
    }
}

/**
 * Xử lý các thao tác trong context menu
 *
 * TODO: Xử lý các thao tác trong context menu
 */
function handleCtxMenuAction(event: MouseEvent) {
    const currentTarget = event.currentTarget as HTMLDivElement;

    switch (currentTarget.dataset.action) {
        // case 'rename':
        //     break;
        // case 'download':
        //     break;
    }

    hiddenLocalCtxMenu();
}

/**
 * Xử lý hiển thị context menu
 */
function initContextMenu(element: HTMLElement) {
    element.addEventListener('contextmenu', event => {
        // Tắt thao tác chuột phải mặc định của trình duyệt
        event.preventDefault();
        // Không cho phép lan truyền sự kiện contextmenu đến thẻ cha
        event.stopPropagation();

        const contextMenu = element.querySelector<HTMLElement>('[data-file-manager-item-context-menu]');
        const itemRect = element.getBoundingClientRect();

        // Hiển thị context menu
        if (contextMenu !== null) {
            contextMenu.style.top = `${event.clientY - itemRect.top}px`;
            contextMenu.style.left = `${event.clientX - itemRect.left}px`;
            contextMenu.classList.remove('hidden');

            // Thêm sự kiện click vào các hành động trong context menu
            for (const action of contextMenu.children) {
                (action as HTMLElement).addEventListener('click', handleCtxMenuAction)
            }

            // Theo dõi các sự kiện của chuột để ẩn context menu
            document.addEventListener('blur', handleHiddenLocalCtxMenuWhenClickOutside);
            document.addEventListener('mousedown', handleHiddenLocalCtxMenuWhenClickOutside);
            document.addEventListener('wheel', handleHiddenLocalCtxMenuWhenClickOutside);
        }
    }, false);
}

document.querySelectorAll<HTMLElement>('[data-file-manager-item]')
    .forEach(item => initContextMenu(item));
