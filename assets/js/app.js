import { forEach, scrollTo, events, touchable } from '@runroom/purejs';

// In order to keep readability and maintainability on bigger projects
// we recommend to use module import method and import it as needed.
import './helpers/polyfills';
import cookies from './components/cookies';

touchable();

if (!!window.MSInputMethodContext && !!document.documentMode) {
  document.documentElement.classList.add('browser-ie');
}

events.onDocumentReady(() => {
  cookies();

  // For small projects or low use of javascript, you can add events in this
  // same file, as follows. Eventhough the module import method is preferred.
  const anchors = document.querySelectorAll('.js-anchor');

  if (anchors) {
    forEach(anchors, anchor => {
      anchor.addEventListener('click', event => {
        const target =
          event.target.getAttribute('data-anchor') || event.target.getAttribute('href');
        scrollTo.animate(target, 300);
      });
    });
  }
});
