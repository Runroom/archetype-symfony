import gulp from 'gulp';
import stylelint from 'gulp-stylelint';

import { STYLES_SRC } from '../config/routes';
import lintFormatter from '../config/fn.lint.formatter';

const lint = () => {
  return gulp.src(`${STYLES_SRC}/**/*.scss`).pipe(
    stylelint({
      syntax: 'scss',
      failAfterError: false,
      reporters: [{ formatter: lintFormatter }]
    })
  );
};

export default lint;
