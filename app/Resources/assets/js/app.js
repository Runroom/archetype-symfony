import Anchor from './components/Anchor';
import Cookies from './components/Cookies';
import Events from './components/Events';
import Touchable from './components/Touchable';

import fastclick from 'fastclick';
import picturefill from 'picturefill';
import svg4everybody from 'svg4everybody';

Touchable();
fastclick.attach(document.body);
svg4everybody();

Events.onDocumentReady(() => {
  Anchor();
  Cookies();
});
