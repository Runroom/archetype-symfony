import { CookieValues } from './cookies';

declare global {
  interface Window {
    PERFORMANCE_COOKIES: CookieValues[];
    TARGETING_COOKIES: CookieValues[];
    COOKIES_DEFAULT_DOMAIN: string;
    // eslint-disable-next-line no-unused-vars, @typescript-eslint/no-explicit-any
    gtag: (...args: any[]) => void;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    dataLayer: Record<string, any>;
  }
}

export {};
