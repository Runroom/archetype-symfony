const Encore = require('@symfony/webpack-encore');

Encore.setOutputPath('public/build/')
  .setPublicPath('/build')
  .copyFiles([
    {
      from: './assets/img',
      to: 'img/[name].[contenthash].[ext]',
      pattern: /\.(png|jpg|jpeg|gif|ico)$/
    },
    { from: './assets/img', to: 'svg/[name].svg', pattern: /\.svg$/ },
    {
      from: './assets/fonts',
      to: 'fonts/[name].[contenthash].[ext]',
      pattern: /\.(woff|woff2)$/
    },
    {
      from: './node_modules/ckeditor4/',
      to: 'ckeditor/[path][name].[ext]',
      pattern: /\.(js|css)$/,
      includeSubdirectories: false
    },
    { from: './node_modules/ckeditor4/adapters', to: 'ckeditor/adapters/[path][name].[ext]' },
    { from: './node_modules/ckeditor4/lang', to: 'ckeditor/lang/[path][name].[ext]' },
    { from: './node_modules/ckeditor4/plugins', to: 'ckeditor/plugins/[path][name].[ext]' },
    { from: './node_modules/ckeditor4/skins', to: 'ckeditor/skins/[path][name].[ext]' }
  ])
  .enableSingleRuntimeChunk()
  .enableTypeScriptLoader()
  .cleanupOutputBeforeBuild(['**/*', '!.gitignore'])
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  // .enableEslintLoader();
  // .enableSassLoader(options => {
  //   options.sourceMap = true;
  //   options.sassOptions = { sourceComments: !Encore.isProduction() };
  // }, {})
  // .addPlugin(
  //   new StyleLintPlugin({
  //     context: 'assets/scss',
  //     emitWarning: true
  //   })
  // )
  .enablePostCssLoader()
  .addEntry('app', './assets/js/app.ts')
  .addEntry('form', './assets/js/form.js')
  .addStyleEntry('styles', './assets/css/styles.css')
  .addStyleEntry('global', './assets/css/global.css')
  .addStyleEntry('crp.default', './assets/css/crp.default.css');
// .addEntry('styleguide-scripts', './assets/js/styleguide.js')
// .addStyleEntry('styleguide', './assets/scss/styleguide.scss')
// .addStyleEntry('crp.default', './assets/scss/crp/default.scss')
// .addStyleEntry('crp.basics', './assets/scss/crp/basics.scss')
// .addStyleEntry('crp.demo', './assets/scss/crp/demo.scss')
// .addStyleEntry('crp.billboard', './assets/scss/crp/billboard.scss');

module.exports = Encore.getWebpackConfig();

// const Encore = require('@symfony/webpack-encore');
// const StyleLintPlugin = require('stylelint-webpack-plugin');

// Encore.setOutputPath('public/build/')
//   .setPublicPath('/build')
//   .copyFiles([
//     {
//       from: './assets/img',
//       to: 'img/[name].[contenthash].[ext]',
//       pattern: /\.(png|jpg|jpeg|gif|ico)$/
//     },
//     { from: './assets/img', to: 'svg/[name].svg', pattern: /\.svg$/ },
//     { from: './assets/fonts', to: 'fonts/[name].[contenthash].[ext]', pattern: /\.(woff|woff2)$/ },

//     {
//       from: './node_modules/ckeditor4/',
//       to: 'ckeditor/[path][name].[ext]',
//       pattern: /\.(js|css)$/,
//       includeSubdirectories: false
//     },
//     { from: './node_modules/ckeditor4/adapters', to: 'ckeditor/adapters/[path][name].[ext]' },
//     { from: './node_modules/ckeditor4/lang', to: 'ckeditor/lang/[path][name].[ext]' },
//     { from: './node_modules/ckeditor4/plugins', to: 'ckeditor/plugins/[path][name].[ext]' },
//     { from: './node_modules/ckeditor4/skins', to: 'ckeditor/skins/[path][name].[ext]' }
//   ])
//   .enableSingleRuntimeChunk()
//   .cleanupOutputBeforeBuild(['**/*', '!.gitignore'])
//   .enableBuildNotifications()
//   .enableSourceMaps(!Encore.isProduction())
//   .enableVersioning(Encore.isProduction())
//   .enableEslintLoader()
//   // .enableSassLoader(options => {
//   //   options.sourceMap = true;
//   //   options.sassOptions = { sourceComments: !Encore.isProduction() };
//   // }, {})
//   // .addPlugin(
//   //   new StyleLintPlugin({
//   //     context: 'assets/scss',
//   //     emitWarning: true
//   //   })
//   // )
//   .enablePostCssLoader()
//   .addEntry('app', './assets/js/app.js')
//   .addEntry('form', './assets/js/form.js')
//   // .addEntry('styleguide-scripts', './assets/js/styleguide.js')
//   .addStyleEntry('styles', './assets/css/styles.css');
// // .addStyleEntry('styleguide', './assets/scss/styleguide.scss')
// // .addStyleEntry('crp.default', './assets/scss/crp/default.scss')
// // .addStyleEntry('crp.basics', './assets/scss/crp/basics.scss')
// // .addStyleEntry('crp.demo', './assets/scss/crp/demo.scss')
// // .addStyleEntry('crp.billboard', './assets/scss/crp/billboard.scss');

// module.exports = Encore.getWebpackConfig();
