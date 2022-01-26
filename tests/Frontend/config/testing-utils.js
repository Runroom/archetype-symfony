/* eslint-disable */
import testNamespaces from './testing-namespaces';
import twigExtendsAll from './testing-extends';
import { render } from 'twig-testing-library';

const _render = (el, data) => {
  twigExtendsAll();
  return render(el, {...data, env: process.env}, testNamespaces);
};

// eslint-disable-next-line import/prefer-default-export
export { _render as render };
