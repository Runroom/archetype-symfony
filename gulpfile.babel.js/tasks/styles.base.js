import gulp from 'gulp';
import autoprefixer from 'gulp-autoprefixer';
import change from 'gulp-change';
import combineMq from 'gulp-combine-mq';
import cssnano from 'gulp-cssnano';
import plumber from 'gulp-plumber';
import rename from 'gulp-rename';
import sass from 'gulp-sass';
import size from 'gulp-size';
import sourcemaps from 'gulp-sourcemaps';

import { STYLES_SRC, STYLES_DEST, IMAGES_SRC } from '../config/routes';
import { AUTOPREFIXER } from '../config/params';
import errorAlert from '../config/fn.error.alert';

const STYLE_FILES = [`${STYLES_SRC}/**/*.scss`, `!${STYLES_SRC}/crp/*.scss`];

const styles = () => {
  return gulp
    .src(STYLE_FILES)
    .pipe(plumber({ errorHandler: errorAlert }))
    .pipe(sourcemaps.init())
    .pipe(sass({ sourceComments: 'map', imagePath: IMAGES_SRC }))
    .pipe(combineMq({ beautify: true }))
    .pipe(cssnano({ zindex: false, reduceIdents: false }))
    .pipe(autoprefixer(AUTOPREFIXER))
    .pipe(rename({ suffix: '.min' }))
    .pipe(sourcemaps.write('.', { includeContent: false }))
    .pipe(plumber.stop())
    .pipe(size({ title: 'Sass compiled' }))
    .pipe(gulp.dest(STYLES_DEST));
};

export { STYLE_FILES };
export default styles;
