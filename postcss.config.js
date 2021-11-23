const postcssConfig = require('@runroom/npm-scripts').postcss;

module.exports = {
  plugins: {
    tailwindcss: {},
    ...postcssConfig.plugins
  },
};
