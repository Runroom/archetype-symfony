import { events, touchable } from '@runroom/purejs';
import hamburger from './components/hamburger';

touchable();

events.onDocumentReady(() => {
  hamburger();
});
