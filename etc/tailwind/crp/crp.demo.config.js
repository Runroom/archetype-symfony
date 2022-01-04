const tailwindConfig = require('@runroom/npm-scripts').tailwind;

module.exports = {
  ...tailwindConfig,
  purge: {
    content: [
      'frontend/templates/components/billboard.html.twig',
      'frontend/templates/components/header.html.twig',
      'frontend/templates/components/hamburguer.html.twig',
      'frontend/templates/components/skip-link.html.twig',
      'frontend/templates/helpers/inline-svg.html.twig',
      'frontend/templates/layouts/*'
    ],
    variables: false
  }
};
