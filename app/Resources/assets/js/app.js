'use strict';

import ScrollTo from './components/ScrollTo';
import Cookies from './components/Cookies';

import fastclick from 'fastclick';
import picturefill from 'picturefill';
import svg4everybody from 'svg4everybody';

fastclick(document.body);
svg4everybody();

$(document).ready(function() {

    ScrollTo.init();
    Cookies.init();

});
