import { escape } from '../helpers/keyEvents';

const OPTS = {
  menuToggle: '.js-toggle',
  bodyClassActive: 'menu-opened',
  menuClassActive: 'is-open',
  classNoScroll: 'u-noscroll'
};

function toggleNavigation(selector) {
  const TARGET = document.querySelector(selector);

  TARGET.classList.toggle(OPTS.menuClassActive);
  document.documentElement.classList.toggle(OPTS.bodyClassActive);
  document.documentElement.classList.toggle(OPTS.classNoScroll);
}

export default function hamburger() {
  const ELEMENTS = [].slice.call(document.querySelectorAll(OPTS.menuToggle));

  ELEMENTS.forEach(element => {
    element.addEventListener('click', event => {
      event.preventDefault();

      toggleNavigation(event.target.dataset.navigation);
    });
  });

  // Click outside menu element
  document.addEventListener('click', event => {
    const menuElement = document.querySelector(`.${OPTS.menuClassActive}`);

    if (menuElement !== null && !menuElement.contains(event.target)) {
      event.preventDefault();
      toggleNavigation(`.${OPTS.menuClassActive}`);
    }
  });

  // Escape Key
  escape(() => {
    if (document.documentElement.classList.contains(OPTS.bodyClassActive)) {
      toggleNavigation(`.${OPTS.menuClassActive}`);
    }
  });
}
