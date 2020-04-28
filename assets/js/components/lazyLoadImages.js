import { preloadImage } from '../helpers/utils';
import intersectionObserver from '../helpers/intersectionObserver';

const HANDLED_CLASS = 'lazyloaded';
const config = {
  elementsClass: '.lazyload',
  handleClass: HANDLED_CLASS,
  observer: {
    rootMargin: '20px 0px',
    threshold: 0.2
  }
};

const loadImage = image => {
  const bg = image.classList.contains('lazybg');
  const { src } = image.dataset;

  preloadImage(src).then(() => {
    image.classList.add(HANDLED_CLASS);
    if (bg) {
      image.style.backgroundImage = `url(${src})`;
    } else {
      image.src = src;
    }
  }).catch(err => {
    // console.warn(err);
  });
};

const lazyLoadImages = () => intersectionObserver(config, loadImage);

export default lazyLoadImages;
