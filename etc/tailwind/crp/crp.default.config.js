const tailwindConfig = require('../base.config');

module.exports = {
  ...tailwindConfig,
  content: [
    'templates/components/billboard.html.twig',
    'templates/components/header.html.twig',
    'templates/components/hamburguer.html.twig',
    'templates/components/skip-link.html.twig',
    'templates/helpers/inline-svg.html.twig',
    'templates/layouts/*'
  ]
};
