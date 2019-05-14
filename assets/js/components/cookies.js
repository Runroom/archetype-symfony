import { forEach } from '@runroom/purejs';
import cookies from 'js-cookie';

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
const cookiesDefaultDomain = window.COOKIES_DEFAULT_DOMAIN || '';
const cookiesSecure = window.COOKIES_SECURE || false;
const cookieSettings = {
  secure: cookiesSecure,
  domain: cookiesDefaultDomain
};

const pushEvent = (performance, targeting) => {
  window.dataLayer.push({ event: 'COEvent', COPerformance: performance, COTargeting: targeting });
};

const setCookies = (performance, targeting) => {
  cookies.set(COOKIE_MESSAGE_NAME, true, cookieSettings);
  cookies.set(COOKIE_PERFORMANCE_NAME, performance, cookieSettings);
  cookies.set(COOKIE_TARGETING_NAME, targeting, cookieSettings);
  pushEvent(performance, targeting);
};

const removeCookies = cookiesJar => {
  forEach(cookiesJar, cookie => {
    cookies.remove(cookie.name, { domain: cookie.domain || cookiesDefaultDomain });
  });
};

const acceptCookies = event => {
  event.preventDefault();
  setCookies(true, true);
  document.querySelector(`.${CLASS_MODAL}`).remove();
};

const closeMessage = event => {
  event.preventDefault();
  setCookies(true, false);
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

const setupSettingsForm = () => {
  if (cookies.get(COOKIE_PERFORMANCE_NAME)) {
    document.querySelector(`.${CLASS_PREFORMANCE}`).checked = (cookies.get(COOKIE_PERFORMANCE_NAME) === 'true');
  }

  if (cookies.get(COOKIE_TARGETING_NAME)) {
    document.querySelector(`.${CLASS_TARGETING}`).checked = (cookies.get(COOKIE_TARGETING_NAME) === 'true');
  }

  document.querySelector(`.${CLASS_SAVE_BUTTON}`).addEventListener('click', saveCookieSettings);
};

const cookiesWrapper = () => {
  const cookiesMessage = document.querySelector(`.${CLASS_MODAL}`);

  if (typeof cookies.get(COOKIE_MESSAGE_NAME) === 'undefined') {
    document.querySelector(`.${CLASS_ACCEPT_BUTTON}`).addEventListener('click', acceptCookies);
    document.querySelector(`.${CLASS_MODAL_CLOSE}`).addEventListener('click', closeMessage);
    cookiesMessage.classList.add(CLASS_VISIBLE);
  } else {
    cookiesMessage.remove();
  }

  if (cookies.get(COOKIE_PERFORMANCE_NAME) === false) {
    removeCookies(performanceCookies);
  }

  if (cookies.get(COOKIE_TARGETING_NAME) === false) {
    removeCookies(targetingCookies);
  }

  if (document.querySelector(`.${CLASS_FORM_SETTINGS}`)) {
    setupSettingsForm();
  }
};

export default cookiesWrapper;
