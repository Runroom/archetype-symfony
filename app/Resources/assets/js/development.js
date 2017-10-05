'use strict';

document.querySelectorAll('.js-gridAction')
    .forEach(action => {
        action.addEventListener('change', function(event) {
            event.preventDefault();
            document.querySelector('html').classList.toggle(this.value);
        });
    });

document.querySelector('.js-closeGridToggle')
    .addEventListener('click', event => {
        event.preventDefault();
        document.querySelector('.dev-Grid-toggle').classList.remove('is-open');
    });

document.querySelector('.js-openGridToggle')
    .addEventListener('click', event => {
        event.preventDefault();
        document.querySelector('.dev-Grid-toggle').classList.add('is-open');
    });
