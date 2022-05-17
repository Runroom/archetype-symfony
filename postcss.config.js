const path = require('path');
// const postcssConfig = require('@runroom/npm-scripts').postcss;
const postcssPresetEnv = require('postcss-preset-env');
const tailwind = require('tailwindcss');
const autoprefixer = require('autoprefixer');

module.exports = ({ file }) => {
  const filename = file.split('/').pop().replace('.css', '');
  const filepath = filename.indexOf('crp.') >= 0 ? 'crp' : 'base';
  const configFilename = filename.indexOf('crp.') >= 0 ? filename : 'tailwind';

  return {
    plugins: {
      'tailwindcss/nesting': 'postcss-nesting',
      'tailwindcss': {
        config: path.resolve(__dirname, 'etc', 'tailwind', filepath, `${configFilename}.config.js`)
      },
      'postcss-preset-env': {},
      'postcss-mixins': {},
      // require('postcss-functions'),
      // require('postcss-mixins'),
      'autoprefixer': { cascade: false },

      // ...postcssConfig.plugins,
      // 'tailwindcss/nesting': {},
      // 'tailwindcss': {
      //   config: path.resolve(__dirname, 'etc', 'tailwind', filepath, `${configFilename}.config.js`)
      // }
    }
  };
  // 'postcss-import': {},
  // 'postcss-functions': { functions },
  // 'postcss-space': {
  //   base: 0.5,
  //   unit: 'rem'
  // },
  // 'postcss-simple-vars': {},
  // 'postcss-at-rules-variables': {},
  // 'postcss-sort-media-queries': { sort: 'mobile-first' },
  // 'autoprefixer': { cascade: false },
  // 'cssnano': { zindex: false, reduceIdents: false }
};
