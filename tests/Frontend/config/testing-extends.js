import fs from 'fs';
import { render, Twig } from 'twig-testing-library';
import testNamespaces from './testing-namespaces';
// import DrupalAttribute from 'drupal-attribute';

const twigFunctionsExtends = () => {
  Twig.extendFunction('get_lang_code', () => 'es');
  Twig.extendFunction('asset', a => a);
  Twig.extendFunction('path', p => p);
  Twig.extendFunction('encore_entry_link_tags', p => p);
  Twig.extendFunction('encore_entry_script_tags', p => p);
  Twig.extendFunction('build_meta_information', p => p);
  Twig.extendFunction('build_alternate_links', p => p);
};

const twigIncludeFunction = () => {
  Twig.extendFunction('include', (originalFile, context = {}) => {
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

    return render(file, context, testNamespaces);
  });
  // Twig.extendFunction('include', (file, context = {}, namespaces = testNamespaces) => {
  //   Twig.registryReset = () => {
  //     Twig.Templates.registry = {};
  //   };

  //   twigFunctionsExtends();
  //   Twig.cache(false);
  //   Twig.twigAsync = (options) => {
  //     return new Promise((resolve, reject) => {
  //       options.load = resolve;
  //       options.error = reject;
  //       options.async = false;
  //       options.autoescape = false;
  //       options.namespaces = namespaces;

  //       if (options.data || options.ref) {
  //         try {
  //           resolve(Twig.twig(options));
  //         } catch (error) {
  //           reject(error);
  //         }
  //       } else {
  //         fs.readFile(options.path, 'utf8', (err, data) => {
  //           if (err) {
  //             reject(new Error(`Unable to find template file ${options.path}`));
  //             return;
  //           }
  //           options.load = (template) => {
  //             template.rawMarkup = data;
  //             resolve(template);
  //           };
  //           Twig.twig(options);
  //         });
  //       }
  //     });
  //   };

  //   let realFile = null;
  //   Object.keys(testNamespaces).map(ns => {
  //     if (file.startsWith(`@${ns}`)) {
  //       realFile = file.replace(`@${ns}`, testNamespaces[ns]);
  //     }
  //   });

  //   if (!realFile) return;
  //   return Twig.twigAsync({
  //     path: realFile,
  //   }).then((template) => {
  //     // eslint-disable-next-line no-prototype-builtins
  //     if (!context.hasOwnProperty('attributes')) {
  //       context.attributes = new DrupalAttribute();
  //     }
  //     return template.render(context);
  //   });
  // });
};

const twigFiltersExtends = () => {
  Twig.extendFilter('trans', t => t);
};

const twigExtendsAll = () => {
  twigFunctionsExtends();
  // twigIncludeFunction();
  twigFiltersExtends();
};

export default twigExtendsAll;
export { twigFunctionsExtends, twigFiltersExtends };
