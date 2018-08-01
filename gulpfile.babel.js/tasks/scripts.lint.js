import eslint from 'gulp-eslint';
import friendlyFormatter from 'eslint-friendly-formatter';
import gulp from 'gulp';

import { SCRIPTS_FILES } from './scripts.base';

const lint = () => {
  return gulp
    .src([SCRIPTS_FILES])
    .pipe(eslint())
    .pipe(eslint.format(friendlyFormatter))
    .pipe(eslint.failAfterError());
};

export default lint;
