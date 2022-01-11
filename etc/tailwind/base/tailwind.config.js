const tailwindConfig = require('@runroom/npm-scripts').tailwind;

module.exports = {
  ...tailwindConfig,
  purge: {
    content: ['templates/**/*'],
    variables: false
  }
};
