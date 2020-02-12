const Encore = require('@symfony/webpack-encore');
const glob = require('glob-all');
const PurgeCss = require('purgecss-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');

Encore.setOutputPath('public/build/')
  .setPublicPath('/build')
  .copyFiles({
    from: './assets/img',
    to: 'img/[name].[contenthash].[ext]',
    pattern: /\.(png|jpg|jpeg|gif|ico)$/
  })
  .copyFiles({
    from: './assets/img',
    to: 'svg/[name].svg',
    pattern: /\.svg$/
  })
  .copyFiles({
    from: './assets/fonts',
    to: 'fonts/[name].[contenthash].[ext]',
    pattern: /\.(woff|woff2)$/
  })
  .configureFilenames({
    js: 'js/[name].[contenthash].js',
    css: 'css/[name].[contenthash].css'
  })
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader()
  .enableEslintLoader({ configFile: './.eslintrc' })
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
      whitelist: ['non-touch'],
      whitelistPatterns: [/^js-/],
      extractors: [
        {
          extractor: class {
            static extract(content) {
              return content.match(/[A-z0-9-:\/]+/g) || [];
            }
          },
          extensions: ['twig']
        }
      ]
    })
  )
  .enablePostCssLoader()
  .addEntry('app', './assets/js/app.js')
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
