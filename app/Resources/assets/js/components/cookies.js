import { cookies, events } from '@runroom/purejs';

const cookiesWrapper = () => {
  const cookiesMessage = document.querySelector('.js-cookies');

  if (!cookies.get('accept_cookie')) {
    cookiesMessage.classList.add('cookies--state-visible');
    document.querySelector('.js-cookies-accept').addEventListener('click', event => {
      cookies.set('accept_cookie');
      cookiesMessage.remove();
    });
  } else {
    cookiesMessage.remove();
  }
};

export default cookiesWrapper;
