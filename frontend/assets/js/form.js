import events from '@runroom/purejs/lib/events';
import jQuery from 'jquery';
import 'jquery-validation';

events.onDocumentReady(() => {
  function ajaxSubmit(form) {
    const request = new XMLHttpRequest();
    const data = new FormData(form);

    function showMessage(type) {
      const formContainer = jQuery(form).closest('.js-form-container');
      const formDisplay = formContainer.find('.js-form-display');
      const successMessage = formContainer.find('.js-form-success');
      const errorMessage = formContainer.find('.js-form-error');

      formDisplay.hide();

      if (type === 'ok') {
        errorMessage.hide();
        successMessage.show();
        successMessage.attr('aria-hidden', 'false');
      } else {
        errorMessage.show();
        successMessage.hide();
        errorMessage.attr('aria-hidden', 'false');
      }

      jQuery(window).scrollTop(successMessage.offset().top - 80);
    }

    request.open(form.method, form.action, true);

    request.onload = () => {
      if (request.status >= 200 && request.status < 400) {
        const response = JSON.parse(request.response);

        showMessage(response.status);
      } else {
        showMessage('error');
      }
    };

    request.onerror = () => {
      showMessage('error');
    };

    request.send(data);
  }

  jQuery('form.js-validate').validate({
    errorClass: 'form__message--invalid',
    errorElement: 'span',
    highlight: (element, errorClass, validClass) => {
      element.classList.add('form__state--invalid');
    },
    unhighlight: (element, errorClass, validClass) => {
      element.classList.remove('form__state--invalid');
    },
    errorPlacement: (error, element) => {
      if (element.attr('type') === 'radio') {
        element = element.parent();
      }

      element.parent().append(error);
    },
    normalizer: value => (value ? value.trim() : ''),
    submitHandler: form => {
      const formContainer = jQuery(form).closest('.js-form-container');
      const button = formContainer.find('button[type="submit"]');

      button.prop('disabled', true);

      if (form.classList.contains('js-form-ajax')) {
        ajaxSubmit(form);

        return false;
      }

      return true;
    }
  });
});
