const createGlobalCSS = require('./assets/design-tokens');

createGlobalCSS();

module.exports = {
  mode: 'jit',
  purge: ['templates/**/*'],
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      neutral300: 'var(--neutral-300)',
      neutral400: 'var(--neutral-400)',
      neutral500: 'var(--neutral-500)',
      bYellow200: 'var(--bYellow-200)',
      bYellow500: 'var(--bYellow-500)',
      bYellow900: 'var(--bYellow-900)'
    },
    screens: {
      's320': '20em',
      's480': '30em',
      's640': '40em',
      's768': '48em',
      's960': '60em',
      'max-s320': { max: '19.9375em' }
    },
    extend: {}
  },
  variants: { extend: {} },
  plugins: []
};
