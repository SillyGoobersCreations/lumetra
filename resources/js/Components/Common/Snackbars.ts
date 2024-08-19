export const TYPE_BASE = "base";
export const TYPE_DANGER = "danger";
export const TYPE_SUCCESSFUL = "successful";

export type SnackbarItem = {
    type: string,
    message: string,
    autohide: boolean,
}
