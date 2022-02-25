import forEach from '@runroom/purejs/lib/forEach';
import { OptionValues, ConfigValues } from '../types/intersectionObserver';

const defaults: OptionValues = {
  root: null,
  rootMargin: '50px 0px',
  threshold: 0.8
};

// eslint-disable-next-line no-unused-vars, @typescript-eslint/no-explicit-any
const intersectionObserver = (config: ConfigValues, callback: (...args: any[]) => void) => {
  const elements = document.querySelectorAll(config.elementsClass);
  let observer: IntersectionObserver;

  if ('IntersectionObserver' in window) {
    observer = new IntersectionObserver(
      (changes, obs) => {
        forEach(changes, change => {
          if (change.intersectionRatio > 0) {
            callback(change.target);
            obs.unobserve(change.target);
          }
        });
      },
      { ...defaults, ...config.observer }
    );
    forEach(elements, element => observer.observe(element));
  } else {
    forEach(elements, element => {
      callback(element);
    });
  }
};

export default intersectionObserver;
