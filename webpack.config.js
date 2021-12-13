const Encore = require('@symfony/webpack-encore');
const StyleLintPlugin = require('stylelint-webpack-plugin');

Encore.setOutputPath('public/build/')
  .setPublicPath('/build')
  .copyFiles([
    {
      from: './frontend/assets/img',
      to: 'img/[name].[contenthash].[ext]',
      pattern: /\.(png|jpg|jpeg|gif|ico)$/,
    },
    { from: './frontend/assets/img', to: 'svg/[name].svg', pattern: /\.svg$/ },
    {
      from: './frontend/assets/fonts',
      to: 'fonts/[name].[contenthash].[ext]',
      pattern: /\.(woff|woff2)$/,
    },

    {
      from: './node_modules/ckeditor4/',
      to: 'ckeditor/[path][name].[ext]',
      pattern: /\.(js|css)$/,
      includeSubdirectories: false,
    },
    { from: './node_modules/ckeditor4/adapters', to: 'ckeditor/adapters/[path][name].[ext]' },
    { from: './node_modules/ckeditor4/lang', to: 'ckeditor/lang/[path][name].[ext]' },
    { from: './node_modules/ckeditor4/plugins', to: 'ckeditor/plugins/[path][name].[ext]' },
    { from: './node_modules/ckeditor4/skins', to: 'ckeditor/skins/[path][name].[ext]' },
  ])
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild(['**/*', '!.gitignore'])
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader((options) => {
    options.sourceMap = true;
    options.sassOptions = { sourceComments: !Encore.isProduction() };
  }, {})
  .enableEslintLoader()
  .addPlugin(
    new StyleLintPlugin({
      context: 'frontend/assets/scss',
      emitWarning: true,
    })
  )
  .enablePostCssLoader()
  .addEntry('app', './frontend/assets/js/app.js')
  .addEntry('form', './frontend/assets/js/form.js')
  .addEntry('styleguide-scripts', './frontend/assets/js/styleguide.js')
  .addStyleEntry('styles', './frontend/assets/scss/styles.scss')
  .addStyleEntry('styleguide', './frontend/assets/scss/styleguide.scss')
  .addStyleEntry('crp.default', './frontend/assets/scss/crp/default.scss')
  .addStyleEntry('crp.basics', './frontend/assets/scss/crp/basics.scss')
  .addStyleEntry('crp.demo', './frontend/assets/scss/crp/demo.scss')
  .addStyleEntry('crp.billboard', './frontend/assets/scss/crp/billboard.scss');

module.exports = Encore.getWebpackConfig();
