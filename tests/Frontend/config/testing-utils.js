/* eslint-disable */
import testNamespaces from './testing-namespaces';
import twigExtendsAll from './testing-extends';
import { render } from 'twig-testing-library';

const _render = (el, data) => {
  return render(el, data, testNamespaces);
};

// eslint-disable-next-line import/prefer-default-export
export { _render as render };
