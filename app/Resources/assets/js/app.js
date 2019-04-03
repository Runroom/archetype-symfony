import { scrollTo, events, touchable } from '@runroom/purejs';
import fastclick from 'fastclick';
import svg4everybody from 'svg4everybody';

// In order to keep readability and maintainability on bigger projects
// we recommend to use module import method and import it as needed.
import './helpers/polyfills';
import cookies from './components/cookies';

touchable();
fastclick.attach(document.body);
svg4everybody();

events.onDocumentReady(() => {
  const anchor = document.querySelector('.js-anchor');

  cookies();

  // For small projects or low use of javascript, you can add events in this
  // same file, as follows. Eventhough the module import method is preferred.
  if (anchor) {
    anchor.addEventListener('click', event => {
      const target = event.target.getAttribute('data-anchor');
      scrollTo.animate(target, 300);
    });
  }
});
