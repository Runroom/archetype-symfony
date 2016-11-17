function ScrollTo() {
    let opts = {
        trigger: '.js-scroll',
        element: null,
        speed: 800
    };

    function scrollTo() {
        $('html, body').animate({
            scrollTop: $(opts.element).offset().top
        }, opts.speed);
    }

    function bindUIAction() {
        $(opts.trigger).on('click', function(event) {
            event.preventDefault();
            opts.element = $(this).attr('scroll-to');
            scrollTo();
        });
    }

    return {
        init: bindUIAction
    }
}

export default ScrollTo();
