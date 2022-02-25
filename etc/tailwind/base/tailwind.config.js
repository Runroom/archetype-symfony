const tailwindConfig = require('../base.config');

module.exports = {
  ...tailwindConfig,
  content: ['templates/**/*', 'vendor/runroom/samples-bundle/src/Resources/views/**/*']
};
