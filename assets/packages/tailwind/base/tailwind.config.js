const tailwindConfig = require('../should-came-from-npm-scripts').tailwind;
const tokens = require('../../design-tokens');

module.exports = {
  ...tailwindConfig,
  purge: {
    content: ['templates/**/*'],
    variables: false
  },
  theme: {
    ...tailwindConfig.screens,
    ...tokens.getTailwindColors()
  }
};
