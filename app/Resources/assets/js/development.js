'use strict';

$('input[type="checkbox"]').on('change', function(event) {
    event.preventDefault();
    var value = $(this).val();
    if (this.checked) {
        $('html').addClass(value);
    } else {
        $('html').removeClass(value);
    }
});

$('.js-closeGridToggle').on('click', function(event) {
    event.preventDefault();
    $('.dev-Grid-toggle').removeClass('is-open');
});

$('.js-openGridToggle').on('click', function(event) {
    event.preventDefault();
    $('.dev-Grid-toggle').addClass('is-open');
});
