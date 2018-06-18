import gulp from 'gulp';
import eslint from 'gulp-eslint';
import friendlyFormatter from 'eslint-friendly-formatter';

import { SCRIPTS_SRC } from '../config/routes';

const lint = () => {
  return gulp
    .src(`${SCRIPTS_SRC}/**/*.js`)
    .pipe(eslint())
    .pipe(eslint.format(friendlyFormatter))
    .pipe(eslint.failAfterError());
};

export default lint;
