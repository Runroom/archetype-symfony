import browserSync from 'browser-sync';
import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';
import friendlyFormatter from 'eslint-friendly-formatter';
import named from 'vinyl-named';
import webpack from 'webpack-stream';
import uglifyJs from 'uglifyjs-webpack-plugin';
import routes from '../config/routes';
import fn from '../config/functions';

const $ = gulpLoadPlugins({ camelize: true });
const SCRIPT_FILES = `${routes.src.js}/*.js`;
const WATCH_FILES = `${routes.src.js}/**/*.js`;

gulp.task('scripts', ['scripts:lint'], () => {
  return gulp.src(SCRIPT_FILES)
    .pipe(named())
    .pipe(webpack({
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
        new uglifyJs()
      ]
    }))
    .pipe(gulp.dest(routes.dist.js));
});

gulp.task('scripts:lint', () => {
  return gulp.src(WATCH_FILES)
    .pipe($.eslint())
    .pipe($.eslint.format(friendlyFormatter))
    .pipe($.eslint.failAfterError());
});

gulp.task('scripts:watch', () => {
  gulp.watch([WATCH_FILES], ['scripts', browserSync.reload]);
});
