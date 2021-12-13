import animateTo from '@runroom/purejs/lib/animateTo';
import events from '@runroom/purejs/lib/events';
import forEach from '@runroom/purejs/lib/forEach';
import isExplorer from '@runroom/purejs/lib/isExplorer';
import touchable from '@runroom/purejs/lib/touchable';

// polyfills and helpers should be before any other component
import './helpers/polyfills';

// In order to keep readability and maintainability on bigger projects
// we recommend to use module import method and import it as needed.
import lazyLoadImages from './components/lazyLoadImages';
import cookies from './components/cookies';

lazyLoadImages();

if (isExplorer()) document.documentElement.classList.add('browser-ie');
document.documentElement.classList.remove('no-js');

const isTouchable = touchable();
document.documentElement.classList.add(isTouchable ? 'touch' : 'non-touch');

events.onDocumentReady(() => {
  cookies();

  // For small projects or low use of javascript, you can add events in this
  // same file, as follows. Eventhough the module import method is preferred.
  const anchors = document.querySelectorAll('.js-anchor');

  if (anchors) {
    forEach(anchors, anchor => {
      anchor.addEventListener('click', event => {
        const element = event.target.dataset.anchor || event.target.getAttribute('href');
        animateTo({ element, speed: 300 });
      });
    });
  }
});
