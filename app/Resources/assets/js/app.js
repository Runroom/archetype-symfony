'use strict';

import ScrollTo from './components/ScrollTo';

import Cookies from 'js-cookie';
import fastclick from 'fastclick';
import svg4everybody from 'svg4everybody';

$(document).ready(function() {

    $('.js-scroll').on('click', function(event) {
        event.preventDefault();
        let element = $(this).attr('scroll-to');
        ScrollTo($(element));
    });

});
