import { events, touchable } from '@runroom/purejs';
import menu from './components/menu';

touchable();

events.onDocumentReady(() => {
  menu();
});
