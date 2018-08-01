import filter from 'gulp-filter';
import gulp from 'gulp';
import gulpIf from  'gulp-if';
import named from 'vinyl-named';
import path from 'path';
import plumber from 'gulp-plumber';
import rename from 'gulp-rename';
import webpack from 'webpack';
import webpackStream from 'webpack-stream';

import { STYLES_SRC, STYLES_DEST, VIEWS_DEST } from '../config/routes';
import { WEBPACK_CONFIG } from '../config/webpack';
import errorAlert from '../config/fn.error.alert';

const STYLES_FILES = `${STYLES_SRC}/**/*.scss`;

const styles = () => {
  return gulp
    .src([`${STYLES_SRC}/*.scss`, `${STYLES_SRC}/crp/*.scss`], { base: STYLES_SRC })
    .pipe(named(function(file) {
        return path.relative(file.base, file.path).slice(0, -5);
    }))
    .pipe(plumber({ errorHandler: errorAlert }))
    .pipe(webpackStream(WEBPACK_CONFIG, webpack))
    .pipe(plumber.stop())
    .pipe(filter('**/*.css'))
    .pipe(rename({ extname: '.min.css' }))
    .pipe(gulpIf(function(file) {
        return file.path.includes('crp');
    },
        gulp.dest(VIEWS_DEST),
        gulp.dest(STYLES_DEST)
    ));
};

export { STYLES_FILES };
export default styles;
