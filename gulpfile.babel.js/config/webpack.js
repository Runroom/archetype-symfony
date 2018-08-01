import autoprefixer from 'autoprefixer';
import cssMqpacker from 'css-mqpacker';
import cssnano from 'cssnano';
import miniCssExtract from 'mini-css-extract-plugin';
import uglifyJs from 'uglifyjs-webpack-plugin';
import hardSourceWebpack from 'hard-source-webpack-plugin';

import { AUTOPREFIXER } from '../config/params';
import { IMAGES_SRC } from '../config/routes';

const WEBPACK_CONFIG = {
  mode: 'production',
  cache: true,
  stats: {
    entrypoints: false,
    children: false
  },
  optimization: {
    minimizer: [
      new uglifyJs({
        uglifyOptions: {
          cache: true,
          parallel: true,
          ecma: 8,
          compress: { warnings: false },
          output: {
            comments: false,
            beautify: false
          }
        }
      })
    ],
    splitChunks: {
      cacheGroups: {
        styles: {
          name: 'styles',
          test: /\.css$/,
          chunks: 'all',
          enforce: true
        }
      }
    }
  },
  plugins: [
    new miniCssExtract({
      filename: "[name].css",
      chunkFilename: "[id].css",
      allChunks: true
    }),
    new hardSourceWebpack()
  ],
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          miniCssExtract.loader,
          {
            loader: 'fast-css-loader',
            options: {
              importLoaders: 1,
              sourcemap: false,
              url: false
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              plugins: [
                autoprefixer(AUTOPREFIXER),
                cssMqpacker({ sort: true }),
                cssnano({ zindex: false, reduceIdents: false }),
              ]
            }
          },
          {
            loader: 'fast-sass-loader',
            options: {
              imagePath: IMAGES_SRC
            }
          }
        ]
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
          {
            loader: 'babel-loader?cacheDirectory',
            options: {
              presets: ['env']
            }
          }
        ]
      }
    ]
  }
};

export { WEBPACK_CONFIG };
