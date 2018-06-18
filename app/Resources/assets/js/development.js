import { forEach } from '@runroom/purejs';

const actions = document.querySelectorAll('.js-gridAction');
forEach(actions, action => {
  action.addEventListener('change', function(event) {
    event.preventDefault();
    document.querySelector('html').classList.toggle(this.value);
  });
});

document.querySelector('.js-closeGridToggle').addEventListener('click', event => {
  event.preventDefault();
  document.querySelector('.js-gridToggle').classList.remove('is-open');
});

document.querySelector('.js-openGridToggle').addEventListener('click', event => {
  event.preventDefault();
  document.querySelector('.js-gridToggle').classList.add('is-open');
});
