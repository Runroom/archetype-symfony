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

gulp.task('styles:crp', ['styles:lint'], () => {
  return gulp.src(CRP_FILES)
    .pipe($.plumber({ errorHandler: fn.errorAlert }))
    .pipe($.sass())
    .pipe($.combineMq({ beautify: true }))
    .pipe($.cssnano({ zindex: false }))
    .pipe($.autoprefixer(AUTOPREFIXER_ARGS))
    .pipe($.change((content) => {
      return '<style type="text/css">\n' + content + '\n</style>';
    }))
    .pipe($.rename({ extname: '.html.twig' }))
    .pipe($.size({ title: 'Critical Rendering Path compiled' }))
    .pipe(gulp.dest(routes.src.views + '/crp-styles'));
});

gulp.task('styles:watch', () => {
  gulp.watch([STYLE_FILES], ['styles', browserSync.reload]);
  gulp.watch([CRP_FILES], ['styles:crp', browserSync.reload]);
});

gulp.task('styles', ['styles:common', 'styles:crp']);
