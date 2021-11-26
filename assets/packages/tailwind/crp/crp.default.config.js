const tailwindConfig = require('../../tailwind/should-came-from-npm-scripts').tailwind;
const tokens = require('../../design-tokens');

module.exports = {
  ...tailwindConfig,
  purge: {
    content: [
      'templates/components/billboard.html.twig',
      'templates/components/header.html.twig',
      'templates/components/hamburguer.html.twig',
      'templates/components/skip-link.html.twig',
      'templates/helpers/inline-svg.html.twig',
      'templates/layouts/*'
    ],
    variables: false
  },
  theme: {
    ...tailwindConfig.screens,
    ...tokens.getTailwindColors()
  }
};
