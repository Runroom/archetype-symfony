import jsCookies from 'js-cookie';

let opts = {
  element: '.js-cookies',
  button: '.js-cookies-accept',
  cookieName: 'accept_cookies',
  visibleClass: 'cookies--state-visible',
};

export default function Cookies() {
  const accepted = jsCookies.get(opts.cookieName);

  if (accepted === undefined) {
    document.querySelector(opts.element).classList.add(opts.visibleClass);
  }

  document.querySelector(opts.button).addEventListener('click', event => {
    event.preventDefault();
    jsCookies.set(opts.cookieName, 'true', { expires: 365 });
    document.querySelector(opts.element).classList.remove(opts.visibleClass);
  });
}
