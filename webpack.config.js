const Encore = require('@symfony/webpack-encore');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');

Encore.setOutputPath('public/build/')
  .setPublicPath('/build')
  .copyFiles([
    {
      from: './assets/img',
      to: 'img/[name].[contenthash].[ext]',
      pattern: /\.(png|jpg|jpeg|gif|ico)$/
    },
    { from: './assets/img', to: 'svg/[name].svg', pattern: /\.svg$/ },
    { from: './assets/fonts', to: 'fonts/[name].[contenthash].[ext]', pattern: /\.(woff|woff2)$/ },

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
  .cleanupOutputBeforeBuild(['**/*', '!.gitignore'])
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableTypeScriptLoader(tsConfig => {
    tsConfig.compilerOptions = {
      noEmit: false
    };
  })
  .enablePostCssLoader()
  .enableBuildCache({ config: [__filename] })
  .addPlugin(
    new StyleLintPlugin({
      context: 'assets/css',
      emitWarning: true
    })
  )
  .addPlugin(new ESLintPlugin())
  .addEntry('app', './assets/js/app.ts')
  .addEntry('form', './assets/js/form.ts')
  .addStyleEntry('styles', './assets/css/styles.css')
  .addStyleEntry('globals', './assets/css/globals.css')
  .addStyleEntry('crp.default', './assets/css/crp.default.css');

module.exports = Encore.getWebpackConfig();
