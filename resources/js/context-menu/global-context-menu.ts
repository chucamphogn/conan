import { isClickOutside } from "./helpers";

/**
 * Xử lý ẩn global context menu
 */
function handleHiddenGlobalCtxMenuWhenClickOutside(event: Event) {
    if (isClickOutside(event.target, '[data-file-manager-global-context-menu]')) {
        const contextMenu = document.body.querySelector<HTMLElement>('[data-file-manager-global-context-menu]:not(.hidden)');

        if (contextMenu) {
            contextMenu.classList.add('hidden');

            // Xóa sự kiện click của các action trong context menu
            for (const action of contextMenu.children) {
                (action as HTMLElement).removeEventListener('click', handleCtxMenuAction);
            }
        }

        // Xóa các sự kiện theo dõi chuột để ẩn context menu
        document.removeEventListener('blur', handleHiddenGlobalCtxMenuWhenClickOutside);
        document.removeEventListener('mousedown', handleHiddenGlobalCtxMenuWhenClickOutside);
        document.removeEventListener('wheel', handleHiddenGlobalCtxMenuWhenClickOutside);
    }
}

/**
 * Xử lý các thao tác trong context menu
 *
 * TODO: Xử lý các thao tác trong context menu
 */
function handleCtxMenuAction(event: MouseEvent) {
    console.log((event.currentTarget as HTMLDivElement).innerText);
}

/**
 * Xử lý hiển thị context menu
 */
function initGlobalContextMenu(event: MouseEvent) {
    // Tắt thao tác chuột phải mặc định của trình duyệt
    event.preventDefault();

    const contextMenu = document.body.querySelector<HTMLElement>('[data-file-manager-global-context-menu]');

    if (contextMenu) {
        // Hiển thị context menu
        contextMenu.style.top = `${event.pageY}px`;
        contextMenu.style.left = `${event.pageX}px`;
        contextMenu.classList.remove('hidden');

        // Thêm sự kiện click vào các action trong context menu
        for (const action of contextMenu.children) {
            (action as HTMLElement).addEventListener('click', handleCtxMenuAction);
        }

        // Theo dõi các sự kiện của chuột để ẩn context menu
        document.addEventListener('blur', handleHiddenGlobalCtxMenuWhenClickOutside, false);
        document.addEventListener('mousedown', handleHiddenGlobalCtxMenuWhenClickOutside, false);
        document.addEventListener('wheel', handleHiddenGlobalCtxMenuWhenClickOutside, false);
    }
}

document.body.querySelector('main')?.addEventListener('contextmenu', initGlobalContextMenu, false);
