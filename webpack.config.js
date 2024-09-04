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
    { from: './assets/fonts', to: 'fonts/[name].[contenthash].[ext]', pattern: /\.(woff|woff2)$/ }
  ])
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild(['**/*', '!.gitignore'])
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableTypeScriptLoader()
  .enablePostCssLoader()
  .enableBuildCache({ config: [__filename] })
  .addEntry('app', './assets/js/app.ts')
  .addEntry('form', './assets/js/form.ts')
  .addStyleEntry('styles', './assets/css/styles.css')
  .addStyleEntry('globals', './assets/css/globals.css')
  .addStyleEntry('crp.default', './assets/css/crp.default.css');

module.exports = Encore.getWebpackConfig();
