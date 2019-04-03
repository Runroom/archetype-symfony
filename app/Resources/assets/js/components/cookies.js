import { forEach } from '@runroom/purejs';
import cookies from 'js-cookie';

const OPTS = {
  cookiesMessageClass: '.js-cookies',
  cookiesVisibleClass: 'cookies-message--state-visible',
  cookiesCloseClass: '.js-cookies-close',
  checkboxPerformanceClass: '.js-cookies-performance-checkbox',
  checkboxTargetingClass: '.js-cookies-targeting-checkbox',
  buttonAcceptClass: '.js-cookies-accept',
  buttonSaveClass: '.js-cookies-savePreferences',
  formCookiesSettingsClass: '.js-cookies-form',
  cookiesSettingsSavedClass: '.js-cookies--settings-saved',
  hideClass: 'u-hide'
};

const PERFORMANCE_COOKIES = window.PERFORMANCE_COOKIES || [];
const TARGETING_COOKIES = window.TARGETING_COOKIES || [];
const COOKIES_DEFAULT_DOMAIN = window.COOKIES_DEFAULT_DOMAIN || '';
const COOKIES_SECURE = window.COOKIES_SECURE || false;

const cookieMessage = 'cookie_message';
const performanceCookie = 'performance_cookie';
const targetingCookie = 'targeting_cookie';
const cookieSettings = {
  secure: COOKIES_SECURE,
  domain: COOKIES_DEFAULT_DOMAIN
};

const pushEvent = (performance, targeting) => {
  window.dataLayer.push({ event: 'COEvent', COPerformance: performance, COTargeting: targeting });
};

const setCookies = (performance, targeting) => {
  cookies.set(cookieMessage, true, cookieSettings);
  cookies.set(performanceCookie, performance, cookieSettings);
  cookies.set(targetingCookie, targeting, cookieSettings);
  pushEvent(performance, targeting);
};

const removeCookies = cookiesJar => {
  forEach(cookiesJar, cookie => {
    cookies.remove(cookie.name, { domain: cookie.domain || COOKIES_DEFAULT_DOMAIN });
  });
};

const acceptCookies = event => {
  event.preventDefault();
  setCookies(true, true);
  document.querySelector(OPTS.cookiesMessageClass).remove();
};

const closeMessage = event => {
  event.preventDefault();
  setCookies(true, false);
  document.querySelector(OPTS.cookiesMessageClass).remove();
};

const saveCookieSettings = event => {
  event.preventDefault();
  const performanceCheckbox = document.querySelector(OPTS.checkboxPerformanceClass).checked;
  const targetingCheckbox = document.querySelector(OPTS.checkboxTargetingClass).checked;
  const cookiesMessageNode = document.querySelector(OPTS.cookiesMessageClass);
  const cookiesSettingsSaved = document.querySelector(OPTS.cookiesSettingsSavedClass);

  setCookies(performanceCheckbox, targetingCheckbox);

  if (!performanceCheckbox) {
    removeCookies(PERFORMANCE_COOKIES);
  }

  if (!targetingCheckbox) {
    removeCookies(TARGETING_COOKIES);
  }

  if (cookiesMessageNode) {
    cookiesMessageNode.remove();
  }

  cookiesSettingsSaved.classList.remove(OPTS.hideClass);

  setTimeout(_ => {
    cookiesSettingsSaved.classList.add(OPTS.hideClass);
  }, 3000);
};

const setupSettingsForm = () => {
  if (cookies.get(performanceCookie)) {
    document.querySelector(OPTS.checkboxPerformanceClass).checked = (cookies.get(performanceCookie) === 'true');
  }

  if (cookies.get(targetingCookie)) {
    document.querySelector(OPTS.checkboxTargetingClass).checked = (cookies.get(targetingCookie) === 'true');
  }

  document.querySelector(OPTS.buttonSaveClass).addEventListener('click', saveCookieSettings);
};

const cookiesWrapper = () => {
  const cookiesMessage = document.querySelector(OPTS.cookiesMessageClass);

  if (typeof cookies.get(cookieMessage) === 'undefined') {
    document.querySelector(OPTS.buttonAcceptClass).addEventListener('click', acceptCookies);
    document.querySelector(OPTS.cookiesCloseClass).addEventListener('click', closeMessage);
    cookiesMessage.classList.add(OPTS.cookiesVisibleClass);
  } else {
    cookiesMessage.remove();
  }

  if (cookies.get(performanceCookie) === false) {
    removeCookies(PERFORMANCE_COOKIES);
  }

  if (cookies.get(targetingCookie) === false) {
    removeCookies(TARGETING_COOKIES);
  }

  if (document.querySelector(OPTS.formCookiesSettingsClass)) {
    setupSettingsForm();
  }
};

export default cookiesWrapper;
