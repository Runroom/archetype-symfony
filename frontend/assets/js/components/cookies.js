import forEach from '@runroom/purejs/lib/forEach';
import Cookies from 'js-cookie';

const CLASS_HIDE = 'u-hide';
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

const performanceCookies = window.PERFORMANCE_COOKIES || [];
const targetingCookies = window.TARGETING_COOKIES || [];
const cookiesWithAttributes = Cookies.withAttributes({
  domain: window.COOKIES_DEFAULT_DOMAIN || '',
  expires: 365,
  sameSite: 'lax',
  secure: window.location.protocol === 'https:'
});

const gtag = function() {
  window.dataLayer.push(arguments); // eslint-disable-line
};

const updateConsent = (performance, targeting) => {
  gtag('consent', 'update', {
    analytics_storage: performance === 'true' ? 'granted' : 'denied',
    ad_storage: targeting === 'true' ? 'granted' : 'denied'
  });
};

const getCookie = name => {
  const value = cookiesWithAttributes.get(name);

  if (value === undefined) {
    return 'false';
  }

  return value;
};

const setCookies = (performance, targeting) => {
  cookiesWithAttributes.set(COOKIE_MESSAGE_NAME, 'true');
  cookiesWithAttributes.set(COOKIE_PERFORMANCE_NAME, performance);
  cookiesWithAttributes.set(COOKIE_TARGETING_NAME, targeting);

  updateConsent(performance, targeting);
  gtag('event', 'COEvent');
};

const removeCookies = cookiesJar => {
  forEach(cookiesJar, cookie => {
    Cookies.remove(cookie.name, { domain: cookie.domain || window.COOKIES_DEFAULT_DOMAIN });
  });
};

const acceptCookies = event => {
  event.preventDefault();
  setCookies('true', 'true');
  document.querySelector(`.${CLASS_MODAL}`).remove();
};

const closeMessage = event => {
  event.preventDefault();
  setCookies('false', 'false');
  document.querySelector(`.${CLASS_MODAL}`).remove();
};

const saveCookieSettings = event => {
  event.preventDefault();
  const performanceCheckbox = document.querySelector(`.${CLASS_PREFORMANCE}`).checked;
  const targetingCheckbox = document.querySelector(`.${CLASS_TARGETING}`).checked;
  const cookiesMessageNode = document.querySelector(`.${CLASS_MODAL}`);
  const cookiesSettingsSaved = document.querySelector(`.${CLASS_FORM_SETTINGS_SAVED}`);

  setCookies(performanceCheckbox, targetingCheckbox);

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

  setTimeout(_ => {
    cookiesSettingsSaved.classList.add(CLASS_HIDE);
  }, 3000);
};

const setupSettingsForm = (performanceCookie, targetingCookie) => {
  const performanceElement = document.querySelector(`.${CLASS_PREFORMANCE}`);
  const targetingElement = document.querySelector(`.${CLASS_TARGETING}`);

  performanceElement.checked = performanceCookie === 'true';
  targetingElement.checked = targetingCookie === 'true';

  document.querySelector(`.${CLASS_SAVE_BUTTON}`).addEventListener('click', saveCookieSettings);
};

const cookiesWrapper = () => {
  const cookiesMessage = document.querySelector(`.${CLASS_MODAL}`);
  const messageCookie = getCookie(COOKIE_MESSAGE_NAME);
  const performanceCookie = getCookie(COOKIE_PERFORMANCE_NAME);
  const targetingCookie = getCookie(COOKIE_TARGETING_NAME);

  if (messageCookie !== 'true') {
    document.querySelector(`.${CLASS_ACCEPT_BUTTON}`).addEventListener('click', acceptCookies);
    document.querySelector(`.${CLASS_MODAL_CLOSE}`).addEventListener('click', closeMessage);
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

  if (document.querySelector(`.${CLASS_FORM_SETTINGS}`)) {
    setupSettingsForm(performanceCookie, targetingCookie);
  }
};

export default cookiesWrapper;
