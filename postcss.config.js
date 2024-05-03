const postcssConfig = require('@runroom/npm-scripts').postcssConfig;

module.exports = {
  ...postcssConfig,
  plugins: [...postcssConfig.plugins, 'postcss-nesting']
};
