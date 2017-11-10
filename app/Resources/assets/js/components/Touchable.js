export default function Touchable() {
    const onTouch = 'ontouchstart' in window;
    const maxTouchPoints = window.navigator.maxTouchPoints > 0;
    const msMaxTouchPoints = window.navigator.msMaxTouchPoints > 0;
    const touchsupport = onTouch || maxTouchPoints || msMaxTouchPoints;
    const touchClass = touchsupport ? 'touch' : 'non-touch';
    document.documentElement.classList.add(touchClass);
}
