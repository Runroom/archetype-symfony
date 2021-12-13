import { keyup } from '../helpers/utils';

const CLASS_MENU = 'js-menu';
const CLASS_MENU_ACTIVE = 'is-open';
const CLASS_MENU_OPEN = 'menu-opened';
const CLASS_NO_SCROLL = 'u-noscroll';

const toggleNavigation = selector => {
  const target = document.querySelector(selector);

  target.classList.toggle(CLASS_MENU_ACTIVE);
  document.documentElement.classList.toggle(CLASS_MENU_OPEN);
  document.documentElement.classList.toggle(CLASS_NO_SCROLL);
};

const menu = () => {
  const triggers = [].slice.call(document.querySelectorAll(`.${CLASS_MENU}`));

  triggers.forEach(element => {
    element.addEventListener('click', event => {
      event.preventDefault();
      toggleNavigation(event.target.dataset.navigation);
    });
  });

  // Click outside menu element
  document.addEventListener('click', event => {
    const activeMenu = document.querySelector(`.${CLASS_MENU_ACTIVE}`);

    if (activeMenu !== null && !activeMenu.contains(event.target)) {
      event.preventDefault();
      toggleNavigation(`.${CLASS_MENU_ACTIVE}`);
    }
  });

  keyup('escape', () => {
    if (document.documentElement.classList.contains(CLASS_MENU_OPEN)) {
      toggleNavigation(`.${CLASS_MENU_ACTIVE}`);
    }
  });
};

export default menu;
