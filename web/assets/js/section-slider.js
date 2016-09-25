$(document).ready(function() {
    var slides = $('.js-slide').length;

    $('.js-sectionSlider').fullpage({
        autoScrolling: true,
        css3: true,
        navigation: true,
        navigationPosition: 'right',
        sectionSelector: '.js-slide',
        scrollOverflow: true,
        onLeave: function(index, nextIndex, direction) {
            if (nextIndex == slides) {
                $('html').removeClass('on-billboard');
                $('html').addClass('header-scroll  header-gradient');
                $('#fp-nav').hide();
            }
            else {
                $('html').addClass('on-billboard');
                $('html').removeClass('header-scroll  header-gradient');
                $('#fp-nav').show();
            }
        },
    });
});
