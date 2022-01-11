const tailwindConfig = require('@runroom/npm-scripts').tailwind;

module.exports = {
  ...tailwindConfig,
  content: ['templates/**/*']
};
