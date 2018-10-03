const escape = callback => {
  document.addEventListener('keyup', event => {
    if (event.keyCode === 27) {
      event.preventDefault();
      callback();
    }
  });
};

// Temporary. Remove when more events are added
export { escape }; // eslint-disable-line
