import fs from 'fs';
import { Twig } from 'twig-testing-library';
import testNamespaces from './testing-namespaces';

const twigFunctionsExtends = () => {
  Twig.extendFunction('get_lang_code', () => 'es');
  Twig.extendFunction('asset', a => a);
  Twig.extendFunction('path', p => p);
  Twig.extendFunction('encore_entry_css_files', p => p);
  Twig.extendFunction('encore_entry_link_tags', p => p);
  Twig.extendFunction('encore_entry_script_tags', p => p);
  Twig.extendFunction('build_meta_information', p => p);
  Twig.extendFunction('build_alternate_links', p => p);
  Twig.extendFunction('build_cookies', p => p);
};

const twigIncludeFunction = () => {
  Twig.extendFunction('include', async (originalFile, context = {}) => {
    let file = null;
    Object.keys(testNamespaces).map(ns => {
      if (originalFile.startsWith(`@${ns}`)) {
        let checkFile = originalFile.replace(`@${ns}`, testNamespaces[ns]);

        if (fs.existsSync(checkFile)) {
          file = checkFile;
        } else if (testNamespaces[`!${ns}`]) {
          checkFile = originalFile.replace(`@${ns}`, testNamespaces[`!${ns}`]);

          if (fs.existsSync(checkFile)) {
            file = checkFile;
          }
        }
      }
    });

    if (!file) return '';

    const subtemplate = await fs.readFileSync(file, 'utf8');
    const rendered = await Twig.twig({ data: subtemplate, namespaces: testNamespaces });
    const output = rendered.render(context);

    return output;
  });
};

const twigFiltersExtends = () => {
  Twig.extendFilter('trans', t => t);
};

const twigExtendsAll = () => {
  twigFunctionsExtends();
  twigIncludeFunction();
  twigFiltersExtends();
};

export default twigExtendsAll;
export { twigFunctionsExtends, twigFiltersExtends };
