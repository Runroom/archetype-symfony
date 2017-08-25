'use strict';

document.querySelectorAll('.js-gridAction').forEach(action => {
    action.addEventListener('change', function(event) {
        event.preventDefault();
        const value = this.value;
        const html = document.querySelector('html');
        if (this.checked) {
            html.classList.add(value);
        } else {
            html.classList.remove(value);
        }
    });
});

document.querySelectorAll('.js-closeGridToggle').forEach(action => {
    action.addEventListener('click', event => {
        event.preventDefault();
        document.querySelector('.dev-Grid-toggle').classList.remove('is-open');
    });
});

document.querySelectorAll('.js-openGridToggle').forEach(action => {
    action.addEventListener('click', event => {
        event.preventDefault();
        document.querySelector('.dev-Grid-toggle').classList.add('is-open');
    });
});
