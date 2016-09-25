function ScrollTo(el) {
    $('html, body').animate({
        scrollTop: el.offset().top
    }, 800);
}

export default ScrollTo;
