let opts = {
  lastScrollTop: 0,
  deltaUp: 10,
  deltaDown: 10,
  classUp: 'scroll-up',
  classDown: 'scroll-down'
};

function clearElementClass() {
  document.documentElement.classList.remove(opts.classUp);
  document.documentElement.classList.remove(opts.classDown);
}

function onPageScroll() {
  const currentScrollTop = this.scrollY || this.scrollTop || 0;

  if (currentScrollTop <= 0) {
    clearElementClass();
    opts.lastScrollTop = currentScrollTop;
  } else if (currentScrollTop > opts.lastScrollTop) {
    if (Math.abs(opts.lastScrollTop - currentScrollTop) >= opts.deltaDown) {
      if (!document.documentElement.classList.contains(opts.classDown)) {
        clearElementClass();
        document.documentElement.classList.add(opts.classDown);
      }
      opts.lastScrollTop = currentScrollTop;
    }
  } else if (Math.abs(opts.lastScrollTop - currentScrollTop) >= opts.deltaUp) {
    if (!document.documentElement.classList.contains(opts.classUp)) {
      clearElementClass();
      document.documentElement.classList.add(opts.classUp);
    }
    opts.lastScrollTop = currentScrollTop;
  }
}

function handleExtend(settings) {
  opts = Object.assign({}, opts, settings);
}

export function getConfig() {
  return opts;
}

export default function ScrollDirection(settings) {
  if (settings) {
    handleExtend(settings);
  }

  if (window.addEventListener) {
    window.addEventListener('scroll', onPageScroll);
  }
}
