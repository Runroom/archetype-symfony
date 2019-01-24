import { forEach } from '@runroom/purejs';
import cookies from 'js-cookie';

const OPTS = {
  cookiesMessageClass: '.js-cookies',
  cookiesVisibleClass: 'cookies-message--state-visible',
  checkboxPerformanceClass: '.js-cookies-performance-checkbox',
  checkboxTargetingClass: '.js-cookies-targeting-checkbox',
  buttonAcceptClass: '.js-cookies-accept',
  buttonSaveClass: '.js-cookies-savePreferences',
  formCookiesSettingsClass: '.js-cookies-form'
};

const PERFORMANCE_COOKIES = window.PERFORMANCE_COOKIES || [];
const TARGETING_COOKIES = window.TARGETING_COOKIES || [];
const COOKIES_DEFAULT_DOMAIN = window.COOKIES_DEFAULT_DOMAIN || '';

const cookieMessage = 'cookie_message';
const performanceCookie = 'performance_cookie';
const targetingCookie = 'targeting_cookie';
const cookieSettings = {
  secure: true,
  domain: COOKIES_DEFAULT_DOMAIN
};

const removeCookies = cookiesJar => {
  forEach(cookiesJar, cookie => {
    cookies.remove(cookie.name, { domain: cookie.domain || COOKIES_DEFAULT_DOMAIN });
  });
};

const pushEvent = (performance, targeting) => {
  window.dataLayer.push({ event: 'COEvent', COPerformance: performance, COTargeting: targeting });
};

const acceptCookies = event => {
  event.preventDefault();
  cookies.set(cookieMessage, true, cookieSettings);
  cookies.set(performanceCookie, true, cookieSettings);
  cookies.set(targetingCookie, true, cookieSettings);
  pushEvent(true, true);
  document.querySelector(OPTS.cookiesMessageClass).remove();
};

const saveCookieSettings = event => {
  event.preventDefault();
  const performanceCheckbox = document.querySelector(OPTS.checkboxPerformanceClass).checked;
  const targetingCheckbox = document.querySelector(OPTS.checkboxTargetingClass).checked;

  cookies.set(cookieMessage, true, cookieSettings);
  cookies.set(performanceCookie, performanceCheckbox, cookieSettings);
  cookies.set(targetingCookie, targetingCheckbox, cookieSettings);

  pushEvent(performanceCheckbox, targetingCheckbox);

  if (!performanceCheckbox) {
    removeCookies(PERFORMANCE_COOKIES);
  }

  if (!targetingCheckbox) {
    removeCookies(TARGETING_COOKIES);
  }

  const cookiesMessageNode = document.querySelector(OPTS.cookiesMessageClass);
  if (cookiesMessageNode) {
    cookiesMessageNode.remove();
  }
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

  if (cookies.get(cookieMessage) === undefined) {
    document.querySelector(OPTS.buttonAcceptClass).addEventListener('click', acceptCookies);
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
