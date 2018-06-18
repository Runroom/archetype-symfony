import gulp from 'gulp';
import autoprefixer from 'gulp-autoprefixer';
import change from 'gulp-change';
import combineMq from 'gulp-combine-mq';
import cssnano from 'gulp-cssnano';
import plumber from 'gulp-plumber';
import rename from 'gulp-rename';
import sass from 'gulp-sass';
import size from 'gulp-size';

import { STYLES_SRC, VIEWS_DEST } from '../config/routes';
import { AUTOPREFIXER } from '../config/params';
import errorAlert from '../config/fn.error.alert';

const CRP_FILES = `${STYLES_SRC}/crp/*.scss`;

const crp = () => {
  return gulp
    .src(CRP_FILES)
    .pipe(plumber({ errorHandler: errorAlert }))
    .pipe(sass())
    .pipe(combineMq({ beautify: true }))
    .pipe(cssnano({ zindex: false, reduceIdents: false }))
    .pipe(autoprefixer(AUTOPREFIXER))
    .pipe(change(content => `<style type="text/css">\n${content}\n</style>`))
    .pipe(rename({ extname: '.html.twig' }))
    .pipe(size({ title: 'Critical Rendering Path compiled' }))
    .pipe(gulp.dest(`${VIEWS_DEST}/crp-styles`));
};

export { CRP_FILES };
export default crp;
