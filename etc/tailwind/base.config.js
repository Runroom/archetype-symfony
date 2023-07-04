const tailwindConfig = require('@runroom/npm-scripts').tailwindConfig;

module.exports = {
  ...tailwindConfig,
  theme: {
    ...tailwindConfig.theme,
    extend: {
      screens: {
        max: '1280px'
      }
    }
  }
};
