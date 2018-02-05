'use strict';

import browserSync from 'browser-sync';
import del from 'del';
import fs from 'fs';
import glob from 'glob';
import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';

import routes from '../config/routes';
import fn from '../config/functions';

const $ = gulpLoadPlugins({ camelize: true });
const AUTOPREFIXER_ARGS = {
  browsers: [
    'ie >= 10',
    'ie_mob >= 10',
    'ff >= 30',
    'chrome >= 20',
    'safari >= 5',
    'opera >= 23',
    'ios >= 5',
    'android >= 4.4',
    'bb >= 10'
  ],
  cascade: false
};
const STYLE_FILES = [
  routes.src.scss + '/**/*.scss',
  '!' + routes.src.scss + '/crp/*.scss'
];
const CRP_FILES = routes.src.scss + '/crp/*.scss';
const LINT_FILES = routes.src.scss + '/**/*.scss';

gulp.task('styles:lint', () => {
  return gulp.src(LINT_FILES)
    .pipe($.stylelint({
      syntax: 'scss',
      failAfterError: false,
      reporters: [{ formatter: fn.lintFormatter }]
    }));
});

gulp.task('styles:common', ['styles:lint'], () => {
  return gulp.src(STYLE_FILES)
    .pipe($.plumber({ errorHandler: fn.errorAlert }))
    .pipe($.sourcemaps.init())
    .pipe($.sass({
      sourceComments: 'map',
      imagePath: routes.src.img
    }))
    .pipe($.combineMq({ beautify: true }))
    .pipe($.cssnano({ zindex: false }))
    .pipe($.autoprefixer(AUTOPREFIXER_ARGS))
    .pipe($.rename({ suffix: '.min' }))
    .pipe($.sourcemaps.write('.', { includeContent: false }))
    .pipe($.plumber.stop())
    .pipe($.size({ title: 'Sass compiled' }))
    .pipe(gulp.dest(routes.dist.css));
});

gulp.task('styles:clean-tmp', () => {
  del(routes.tmp + '/*').then(paths => fn.consoleLog('Deleted tmp files', 'crazy'));
});

gulp.task('styles:crp', ['styles:lint', 'styles:clean-tmp'], () => {
  return gulp.src(CRP_FILES)
    .pipe($.plumber({ errorHandler: fn.errorAlert }))
    .pipe($.sass())
    .pipe($.combineMq({ beautify: true }))
    .pipe($.cssnano({ zindex: false }))
    .pipe($.autoprefixer(AUTOPREFIXER_ARGS))
    .pipe($.size({ title: 'Critical Rendering Path compiled' }))
    .pipe(gulp.dest(routes.tmp));
});

gulp.task('styles:inline', ['styles:crp'], () => {
  return glob(CRP_FILES, (er, files) => {
    files.forEach((element, index, array) => {
      let filename = element.replace(/^.*[\\\/]/, '').split('.')[0],
      file_path = routes.tmp + '/' + filename + '.css';

      fs.stat(file_path, (err, stat) => {
        if (err === null) {
          let content = fs.readFileSync(routes.tmp + '/' + filename + '.css', 'utf8');
          let styles = '<style type="text/css">\n' + content + '\n</style>';

          fs.writeFileSync(routes.src.views + '/crp-styles/' + filename + '.html.twig', styles);
        } else {
          fn.consoleLog(file_path + ' does not exists', 'fuck');
        }
      });
    });
  });
});

gulp.task('styles:watch', () => {
  gulp.watch([STYLE_FILES], ['styles', browserSync.reload]);
  gulp.watch([CRP_FILES], ['styles:inline', browserSync.reload]);
});

gulp.task('styles', ['styles:common', 'styles:inline']);
