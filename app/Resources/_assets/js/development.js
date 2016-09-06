$('input[type="checkbox"]').on('change', function(event) {
    event.preventDefault();
    var value = $(this).val();
    if (this.checked) {
        $('html').addClass(value);
    } else {
        $('html').removeClass(value);
    }
});