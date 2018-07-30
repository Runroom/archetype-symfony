import { cookies, events } from '@runroom/purejs';

const cookiesWrapper = () => {
  if (!cookies.get('accept_cookie')) {
    document.querySelector('.js-cookies').classList.add('cookies--state-visible');
  } else {
    document.querySelector('.js-cookies').remove();
  }

  document.querySelector('.js-cookies-accept').addEventListener('click', event => {
    cookies.set('accept_cookie');
    document.querySelector('.js-cookies').remove();
  });
};

export default cookiesWrapper;
