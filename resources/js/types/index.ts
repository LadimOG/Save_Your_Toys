export * from './auth';
export * from './navigation';
export * from './ui';

import type { Auth } from './auth';
import type { FlashMessages } from './propsPage';

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    auth: Auth;
    flash: FlashMessages;
    sidebarOpen: boolean;
    [key: string]: unknown;
};
