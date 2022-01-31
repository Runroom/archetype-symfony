import forEach from '@runroom/purejs/lib/forEach';
import Cookies from 'js-cookie';

import { CookieValues } from '../../../etc/types/cookies';

const CLASS_HIDE = 'hidden';
const CLASS_VISIBLE = 'is-visible';
const CLASS_MODAL = 'js-cookies';
const CLASS_MODAL_CLOSE = 'js-cookies-close';
const CLASS_PREFORMANCE = 'js-cookies-performance-checkbox';
const CLASS_TARGETING = 'js-cookies-targeting-checkbox';
const CLASS_ACCEPT_BUTTON = 'js-cookies-accept';
const CLASS_SAVE_BUTTON = 'js-cookies-save-preferences';
const CLASS_FORM_SETTINGS = 'js-cookies-form';
const CLASS_FORM_SETTINGS_SAVED = 'js-cookies-settings-saved';
const COOKIE_MESSAGE_NAME = 'cookie_message';
const COOKIE_PERFORMANCE_NAME = 'performance_cookie';
const COOKIE_TARGETING_NAME = 'targeting_cookie';

// eslint-disable-next-line no-unused-vars
type CookiesFunction = (performance: string, targeting: string) => void;

const performanceCookies: CookieValues[] = window.PERFORMANCE_COOKIES || [];
const targetingCookies: CookieValues[] = window.TARGETING_COOKIES || [];
const cookiesWithAttributes = Cookies.withAttributes({
  domain: window.COOKIES_DEFAULT_DOMAIN || '',
  expires: 365,
  sameSite: 'lax',
  secure: window.location.protocol === 'https:'
});

function gtag() {
  window.dataLayer.push(arguments); // eslint-disable-line
}

const updateConsent: CookiesFunction = (performance, targeting) => {
  // @ts-expect-error: Function without arguments
  gtag('consent', 'update', {
    analytics_storage: performance === 'true' ? 'granted' : 'denied',
    ad_storage: targeting === 'true' ? 'granted' : 'denied'
  });
};

const getCookie = (name: string) => {
  const value = cookiesWithAttributes.get(name);

  if (value === undefined) {
    return 'false';
  }

  return value;
};

const setCookies: CookiesFunction = (performance, targeting) => {
  cookiesWithAttributes.set(COOKIE_MESSAGE_NAME, 'true');
  cookiesWithAttributes.set(COOKIE_PERFORMANCE_NAME, performance);
  cookiesWithAttributes.set(COOKIE_TARGETING_NAME, targeting);

  updateConsent(performance, targeting);
  // @ts-expect-error: Function without arguments
  gtag('event', 'COEvent');
};

const removeCookies = (cookiesJar: CookieValues[]) => {
  forEach(cookiesJar, cookie => {
    Cookies.remove(cookie.name, { domain: cookie.domain || window.COOKIES_DEFAULT_DOMAIN });
  });
};

const acceptCookies = (event: Event) => {
  event.preventDefault();
  setCookies('true', 'true');
  (document.querySelector(`.${CLASS_MODAL}`) as HTMLDivElement).remove();
};

const closeMessage = (event: Event) => {
  event.preventDefault();
  setCookies('false', 'false');
  (document.querySelector(`.${CLASS_MODAL}`) as HTMLDivElement).remove();
};

const saveCookieSettings = (event: Event) => {
  event.preventDefault();
  const performanceCheckbox = (document.getElementById(`.${CLASS_PREFORMANCE}`) as HTMLInputElement)
    .checked;
  const targetingCheckbox = (document.querySelector(`.${CLASS_TARGETING}`) as HTMLInputElement)
    .checked;
  const cookiesMessageNode = document.querySelector(`.${CLASS_MODAL}`) as HTMLDivElement;
  const cookiesSettingsSaved = document.querySelector(
    `.${CLASS_FORM_SETTINGS_SAVED}`
  ) as HTMLParagraphElement;

  setCookies(performanceCheckbox.toString(), targetingCheckbox.toString());

  if (!performanceCheckbox) {
    removeCookies(performanceCookies);
  }

  if (!targetingCheckbox) {
    removeCookies(targetingCookies);
  }

  if (cookiesMessageNode) {
    cookiesMessageNode.remove();
  }

  cookiesSettingsSaved.classList.remove(CLASS_HIDE);

  setTimeout(() => {
    cookiesSettingsSaved.classList.add(CLASS_HIDE);
  }, 3000);
};

const setupSettingsForm: CookiesFunction = (performanceCookie, targetingCookie) => {
  const performanceElement = document.getElementById(`.${CLASS_PREFORMANCE}`) as HTMLInputElement;
  const targetingElement = document.querySelector(`.${CLASS_TARGETING}`) as HTMLInputElement;

  performanceElement.checked = performanceCookie === 'true';
  targetingElement.checked = targetingCookie === 'true';

  (document.querySelector(`.${CLASS_SAVE_BUTTON}`) as HTMLLinkElement).addEventListener(
    'click',
    saveCookieSettings
  );
};

const cookiesWrapper = () => {
  const cookiesMessage = document.querySelector(`.${CLASS_MODAL}`) as HTMLDivElement;
  const messageCookie = getCookie(COOKIE_MESSAGE_NAME);
  const performanceCookie = getCookie(COOKIE_PERFORMANCE_NAME);
  const targetingCookie = getCookie(COOKIE_TARGETING_NAME);

  if (messageCookie !== 'true') {
    (document.querySelector(`.${CLASS_ACCEPT_BUTTON}`) as HTMLLinkElement).addEventListener(
      'click',
      acceptCookies
    );
    (document.querySelector(`.${CLASS_MODAL_CLOSE}`) as HTMLSpanElement).addEventListener(
      'click',
      closeMessage
    );
    cookiesMessage.classList.add(CLASS_VISIBLE);
  } else {
    cookiesMessage.remove();
  }

  if (performanceCookie !== 'true') {
    removeCookies(performanceCookies);
  }

  if (targetingCookie !== 'true') {
    removeCookies(targetingCookies);
  }

  if (document.querySelector(`.${CLASS_FORM_SETTINGS}`) as HTMLFormElement) {
    setupSettingsForm(performanceCookie, targetingCookie);
  }
};

export default cookiesWrapper;
