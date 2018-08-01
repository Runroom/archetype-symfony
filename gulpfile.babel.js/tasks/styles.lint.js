import gulp from 'gulp';
import stylelint from 'gulp-stylelint';

import { STYLES_FILES } from './styles.base';
import lintFormatter from '../config/fn.lint.formatter';

const lint = () => {
  return gulp
    .src(STYLES_FILES)
    .pipe(stylelint({
      syntax: 'scss',
      failAfterError: false,
      reporters: [{ formatter: lintFormatter }]
    }));
};

export default lint;
