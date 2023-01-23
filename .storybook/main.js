module.exports = {
  stories: ['../src/**/*.stories.mdx', '../src/**/*.stories.@(json)'],
  addons: [
    '@storybook/addon-links',
    '@storybook/addon-essentials',
    '@storybook/addon-interactions'
  ],
  framework: '@storybook/server',
  core: {
    builder: 'webpack5'
  }
};
