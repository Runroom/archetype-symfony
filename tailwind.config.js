const tailwindConfig = require('./assets/packages/tailwind/should-came-from-npm-scripts').tailwind;
const createGlobalCSS = require('./assets/packages/design-tokens');

createGlobalCSS();

module.exports = {
  ...tailwindConfig,
  purge: ['templates/**/*'],
  theme: {
    ...tailwindConfig.screens,
    colors: {
      neutral300: 'var(--neutral-300)',
      neutral400: 'var(--neutral-400)',
      neutral500: 'var(--neutral-500)',
      bYellow200: 'var(--bYellow-200)',
      bYellow500: 'var(--bYellow-500)',
      bYellow900: 'var(--bYellow-900)'
    }
  }
};
