import events from '@runroom/purejs/lib/events';
import jQuery from 'jquery';
import 'jquery-validation';

events.onDocumentReady(() => {
  function ajaxSubmit(form: HTMLFormElement) {
    const request = new XMLHttpRequest();
    const data = new FormData(form);

    function showMessage(type: string | number) {
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

      const successMessageOffset = successMessage?.offset();
      if (successMessageOffset) {
        jQuery(window).scrollTop(successMessageOffset.top - 80);
      }
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
    highlight: (element: HTMLElement) => {
      element.classList.add('form__state--invalid');
    },
    unhighlight: (element: HTMLElement) => {
      element.classList.remove('form__state--invalid');
    },
    errorPlacement: (error: JQuery<HTMLElement>, element: JQuery<HTMLElement>) => {
      let el = element;
      if (element.attr('type') === 'radio') {
        el = element.parent();
      }

      el.parent().append(error);
    },
    // @ts-expect-error: Missing method in types
    normalizer: value => (value ? value.trim() : ''),
    submitHandler: (form: HTMLFormElement) => {
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
