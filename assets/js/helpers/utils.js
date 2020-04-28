const keyup = (key, callback) => {
  const defaults = {
    intro: 13,
    escape: 27,
    space: 32,
    left: 37,
    up: 38,
    right: 39,
    down: 40
  };
  let keyCode = key;

  if (typeof key === 'string') {
    if (key in defaults) {
      keyCode = defaults[key];
    } else {
      throw new Error(`The String "${key}" is not available. Try to use the key code value.`);
    }
  }

  document.addEventListener('keyup', event => {
    if (event.keyCode === keyCode) {
      event.preventDefault();
      callback();
    }
  });
};

const preloadImage = url => new Promise((resolve, reject) => {
  const image = new Image();
  image.src = url;
  image.onload = resolve;
  image.onerror = reject;
});

export { keyup, preloadImage };
