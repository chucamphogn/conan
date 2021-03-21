import { RenameModal } from "./modal/rename-modal";

declare global {
    interface Window {
        renameModal(): RenameModal;
    }
}
