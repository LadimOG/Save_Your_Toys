export interface FlashMessages {
    success: string | null;
    error: string | null;
}

export interface PropsPage {
    auth: { user: any };
    name: string;
    flash: FlashMessages;
    [key: string]: any;
}
