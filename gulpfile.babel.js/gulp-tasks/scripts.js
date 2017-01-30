'use strict';

import browserSync from 'browser-sync';
import browserify from 'browserify';
import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';
import friendlyFormatter from 'eslint-friendly-formatter';
import source from 'vinyl-source-stream';
import buffer from 'vinyl-buffer';

import routes from './config/routes';
import fn from './config/functions';

const $ = gulpLoadPlugins({ camelize: true });
const COMPONENT_FILES = routes.src.js + '/components/**/*.js';
const APP_FILE = routes.src.js + '/app.js';
const DEV_FILE = routes.src.js + '/development.js';

function scripts(entry_point, destination) {
    return browserify(entry_point)
        .transform('babelify', { presets: ['es2015'] })
        .bundle()
        .on('error', fn.errorAlert)
        .pipe(source(destination))
        .pipe(buffer())
        .pipe($.sourcemaps.init({ loadMaps: true }))
        .pipe($.uglify())
        .pipe($.sourcemaps.write('./'))
        .pipe($.size({ title: 'Scripts' }))
        .pipe(gulp.dest(routes.dist.js));
}

gulp.task('scripts:concat', ['scripts:lint'], () => {
    return scripts(APP_FILE, 'app.min.js');
});

gulp.task('scripts:dev', ['scripts:lint'], () => {
    return scripts(DEV_FILE, 'development.min.js');
});

gulp.task('scripts:lint', () => {
    return gulp.src([APP_FILE, DEV_FILE, COMPONENT_FILES])
        .pipe($.eslint())
        .pipe($.eslint.format(friendlyFormatter))
        .pipe($.eslint.failAfterError());
});

gulp.task('scripts:watch', () => {
    gulp.watch([APP_FILE, COMPONENT_FILES], ['scripts:concat', browserSync.reload]);
    gulp.watch([DEV_FILE], ['scripts:dev', browserSync.reload]);
});

gulp.task('scripts', ['scripts:concat', 'scripts:dev']);
