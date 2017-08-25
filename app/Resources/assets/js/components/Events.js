// see: http://youmightnotneedjquery.com/#ready
function onDocumentReady(fn) {
  const ready = document.attachEvent
    ? document.readyState === 'complete'
    : document.readyState !== 'loading';
  if (ready) {
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

const Events = {
  onDocumentReady
};

export default Events;
