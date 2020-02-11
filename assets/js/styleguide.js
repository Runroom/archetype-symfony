import events from '@runroom/purejs/lib/events';
import touchable from '@runroom/purejs/lib/touchable';
import menu from './components/menu';

touchable();

events.onDocumentReady(() => {
  menu();
});
