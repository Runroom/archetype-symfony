declare global {
  interface Window {
    // eslint-disable-next-line no-unused-vars, @typescript-eslint/no-explicit-any
    gtag: (...args: any[]) => void;
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    dataLayer: Record<string, any>;
  }
}

export {};
