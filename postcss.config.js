const path = require('path');
const postcssConfig = require('@runroom/npm-scripts').postcss;

module.exports = ({ file }) => {
  const filename = file.split('/').pop().replace('.css', '');
  const filepath = filename.indexOf('crp.') >= 0 ? 'crp' : 'base';
  const configFilename = filename.indexOf('crp.') >= 0 ? filename : 'tailwind';

  return {
    plugins: {
      tailwindcss: {
        config: path.resolve(
          __dirname,
          'assets',
          'packages',
          'tailwind',
          filepath,
          `${configFilename}.config.js`
        )
      },
      ...postcssConfig.plugins
    }
  };
};
