export default function Touchable() {
  if ('ontouchstart' in window
    || window.navigator.maxTouchPoints > 0
    || window.navigator.msMaxTouchPoints > 0)
  {
    document.documentElement.classList.add('touch');
    document.documentElement.classList.remove('non-touch');
  }
}
