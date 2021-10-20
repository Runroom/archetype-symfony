import { Twig } from 'twig-testing-library';

const twigFunctionsExtends = () => {
  Twig.extendFunction('get_lang_code', () => 'es');

  Twig.extendFunction('asset', a => a);

  Twig.extendFunction('path', p => p);
};

const twigFiltersExtends = () => {
  Twig.extendFilter('trans', t => t);
};

const twigExtendsAll = () => {
  twigFunctionsExtends();
  twigFiltersExtends();
};

export default twigExtendsAll;
export { twigFunctionsExtends, twigFiltersExtends };
