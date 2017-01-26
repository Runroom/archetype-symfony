'use strict';

import browserSync from 'browser-sync';
import browserify from 'browserify';
import babelify from 'babelify';
import glob from 'glob';
import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';
import friendlyFormatter from 'eslint-friendly-formatter';
import runSequence from 'run-sequence';
import source from 'vinyl-source-stream';
import buffer from 'vinyl-buffer';

import routes from './config/routes';
import fn from './config/functions';

const reload = browserSync.reload;
const $ = gulpLoadPlugins({ camelize: true });
const COMPONENTS_FILES = routes.src.js + '/components/**/*.js';
const LIBS_FILES = [
    routes.src.js + '/libs/**/*.js',
    '!' + routes.src.js + '/libs/**/_*.js'
];
const CONCAT_FILES = routes.src.js + '/app.js';
const DEV_FILES = routes.src.js + '/development.js';

gulp.task('scripts', (callback) => {
    runSequence(
        'scripts:copy',
        'scripts:concat',
        'scripts:polyfills',
        'scripts:dev',
        callback
    );
});

gulp.task('scripts:copy', () => {
    return gulp.src(LIBS_FILES)
        .pipe($.uglify())
        .pipe($.concat('libs.min.js', { newLine: ';' }))
        .pipe(gulp.dest(routes.dist.js));
});

gulp.task('scripts:concat', ['scripts:lint'], function() {
    return browserify(CONCAT_FILES)
        .transform('babelify', {presets: ['es2015']})
        .bundle()
        .on('error', fn.errorAlert)
        .pipe(source('app.min.js'))
        .pipe(buffer())
        .pipe($.uglify())
        .pipe($.size({ title: 'Scripts' }))
        .pipe(gulp.dest(routes.dist.js));
});

gulp.task('scripts:dev', ['scripts:lint'], () => {
    return browserify(DEV_FILES)
        .transform('babelify', {presets: ['es2015']})
        .bundle()
        .on('error', fn.errorAlert)
        .pipe(source('development.min.js'))
        .pipe(buffer())
        .pipe($.uglify())
        .pipe($.size({ title: 'Scripts Dev' }))
        .pipe(gulp.dest(routes.dist.js));
});

gulp.task('scripts:polyfills', () => {
    return gulp.src([
            routes.src.js + '/polyfills/selectivizr.js',
            routes.src.js + '/polyfills/respond.js'
        ])
        .pipe($.uglify())
        .pipe($.concat('polyfills.min.js', { newLine: ';' }))
        .pipe(gulp.dest(routes.dist.js));
});

gulp.task('scripts:lint', function () {
    return gulp.src(CONCAT_FILES)
        .pipe($.eslint())
        .pipe($.eslint.format(friendlyFormatter))
        .pipe($.eslint.failAfterError());
});

gulp.task('scripts:watch', () => {
    gulp.watch([LIBS_FILES], ['scripts:copy', reload]);
    gulp.watch([CONCAT_FILES, COMPONENTS_FILES], ['scripts:concat', reload]);
    gulp.watch([DEV_FILES], ['scripts:dev', reload]);
});
