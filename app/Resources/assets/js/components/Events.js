export default {
  // see: http://youmightnotneedjquery.com/#ready
  onDocumentReady: (fn) => {
    const ready = document.attachEvent
      ? document.readyState === 'complete'
      : document.readyState !== 'loading';

    if (ready) {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }
};
