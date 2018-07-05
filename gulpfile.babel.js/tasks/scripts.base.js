import gulp from 'gulp';
import named from 'vinyl-named';
import webpack from 'webpack-stream';
import uglifyJs from 'uglifyjs-webpack-plugin';

import { SCRIPTS_SRC, SCRIPTS_DEST } from '../config/routes';

const SCRIPTS_FILES = `${SCRIPTS_SRC}/**/*.js`;

const scripts = () => {
  return gulp
    .src(`${SCRIPTS_SRC}/*.js`)
    .pipe(named())
    .pipe(
      webpack({
        module: {
          loaders: [
            {
              loader: 'babel-loader',
              exclude: /node_modules/,
              options: {
                cacheDirectory: true,
                presets: ['env']
              }
            }
          ]
        },
        output: { filename: '[name].min.js' },
        plugins: [
          new uglifyJs({
            uglifyOptions: {
              ecma: 8,
              compress: { warnings: false },
              output: {
                comments: false,
                beautify: false
              }
            }
          })
        ]
      })
    )
    .pipe(gulp.dest(SCRIPTS_DEST));
};

export { SCRIPTS_FILES };
export default scripts;
