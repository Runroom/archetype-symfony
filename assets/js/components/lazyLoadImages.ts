import { preloadImage } from '../helpers/utils';
import intersectionObserver from '../helpers/intersectionObserver';
import { ConfigValues } from '../types/intersectionObserver';

const HANDLED_CLASS = 'lazyloaded';

const config: ConfigValues = {
  elementsClass: '.lazyload',
  handleClass: HANDLED_CLASS,
  observer: {
    rootMargin: '20px 0px',
    threshold: 0.2
  }
};

const loadImage = (image: HTMLImageElement) => {
  const bg = image.classList.contains('lazybg');
  const { src } = image.dataset;

  if (!src) return;

  preloadImage(src)
    .then(() => {
      image.classList.add(HANDLED_CLASS);
      if (bg) {
        image.style.backgroundImage = `url(${src})`;
      } else {
        image.src = src;
      }
    })
    .catch(() => {
      // console.warn(err);
    });
};

const lazyLoadImages = () => intersectionObserver(config, loadImage);

export default lazyLoadImages;
