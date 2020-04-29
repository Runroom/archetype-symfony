const Encore = require('@symfony/webpack-encore');
const glob = require('glob-all');
const path = require('path');
const PurgeCss = require('purgecss-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');

Encore.setOutputPath('public/build/')
  .setPublicPath('/build')
  .copyFiles([
    { from: './assets/img', to: 'img/[name].[contenthash].[ext]', pattern: /\.(png|jpg|jpeg|gif|ico)$/ },
    { from: './assets/img', to: 'svg/[name].svg', pattern: /\.svg$/ },
    { from: './assets/fonts', to: 'fonts/[name].[contenthash].[ext]', pattern: /\.(woff|woff2)$/ },

    { from: './node_modules/ckeditor4/', to: 'ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false },
    { from: './node_modules/ckeditor4/adapters', to: 'ckeditor/adapters/[path][name].[ext]' },
    { from: './node_modules/ckeditor4/lang', to: 'ckeditor/lang/[path][name].[ext]' },
    { from: './node_modules/ckeditor4/plugins', to: 'ckeditor/plugins/[path][name].[ext]' },
    { from: './node_modules/ckeditor4/skins', to: 'ckeditor/skins/[path][name].[ext]' }
  ])
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader(options => {
    options.sourceMap = true;
    options.sassOptions = {
      outputStyle: options.outputStyle,
      sourceComments: !Encore.isProduction()
    };
    delete options.outputStyle;
  }, {})
  .enableEslintLoader()
  .addPlugin(
    new StyleLintPlugin({
      configFile: '.stylelintrc',
      context: 'assets/scss',
      files: '**/*.scss',
      failOnError: false,
      quiet: false
    })
  )
  .addPlugin(
    new PurgeCss({
      paths: glob.sync([path.join(__dirname, 'templates/**/*.html.twig')]),
      whitelist: [],
      whitelistPatterns: [/^js-/, /^u-/],
      extractors: [{
        extractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
        extensions: ['twig']
      }]
    })
  )
  .enablePostCssLoader()
  .addEntry('app', './assets/js/app.js')
  .addEntry('form', './assets/js/form.js')
  .addEntry('development-scripts', './assets/js/development.js')
  .addEntry('styleguide-scripts', './assets/js/styleguide.js')
  .addStyleEntry('styles', './assets/scss/styles.scss')
  .addStyleEntry('development', './assets/scss/development.scss')
  .addStyleEntry('styleguide', './assets/scss/styleguide.scss')
  .addStyleEntry('crp.default', './assets/scss/crp/default.scss')
  .addStyleEntry('crp.statics', './assets/scss/crp/statics.scss')
  .addStyleEntry('crp.demo', './assets/scss/crp/demo.scss')
  .addStyleEntry('crp.billboard', './assets/scss/crp/billboard.scss');

module.exports = Encore.getWebpackConfig();
