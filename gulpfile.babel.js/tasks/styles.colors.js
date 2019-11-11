import sassJson from 'gulp-sass-json';
import gulp from 'gulp';
import plumber from 'gulp-plumber';

import { STYLES_SRC, VIEWS_DEST } from '../config/routes';
import errorAlert from '../config/fn.error.alert';

const STYLE_COLORS = [`${STYLES_SRC}/settings/variables/_colors.scss`];
const STYLE_COLORS_DEST = [`${VIEWS_DEST}/styleguide/data`];

const sassjson = () => {
  return gulp
      .src(STYLE_COLORS)
      .pipe(plumber({ errorHandler: errorAlert }))
      .pipe(sassJson())
      .pipe(gulp.dest(STYLE_COLORS_DEST));
};

export { STYLE_COLORS };
export default sassjson;
