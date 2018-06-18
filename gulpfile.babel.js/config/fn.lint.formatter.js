import colors from 'colors';
import _ from 'underscore';

const lintFormatter = err => {
  let errors = _.values(err),
    icons = {
      info: colors.blue('⬤'),
      success: colors.green('⬤'),
      warning: colors.yellow('⬤'),
      error: colors.red('⬤')
    },
    tab = '    ',
    space = ' ',
    line,
    has_errors = false;

  console.log();
  _.each(err, (value, key, list) => {
    let result = [];
    _.each(value.warnings, (v, k, l) => {
      if (v.text.trim() !== 'This file is ignored') {
        result.push(v);
      }
    });

    if (result.length) {
      has_errors = true;
      console.log();
      console.log(space, colors.underline.white(value.source));
      _.each(value.warnings, (v, k, l) => {
        line = v.line ? colors.gray(v.line + ':' + v.column) : '';
        console.log(tab, icons[v.severity] + space, line + space, colors.white(v.text));
      });
      console.log();
    }
  });

  if (!has_errors) {
    console.log(tab, icons['success'] + space, colors.white('Yeah, no errors or warnings!'));
  }
  console.log();
};

export default lintFormatter;
