'use strict';

import browserSync from 'browser-sync';
import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';
import friendlyFormatter from 'eslint-friendly-formatter';
import runSequence from 'run-sequence';
import routes from './config/routes';
import fn from './config/functions';

const reload = browserSync.reload;
const $ = gulpLoadPlugins({ camelize: true });
const COPY_FILES = routes.src.js + '/libs/**/*.js';
const CONCAT_FILES = routes.src.js + '/app/**/*.js';

gulp.task('scripts', (callback) => {
    runSequence(
        'scripts:copy',
        'scripts:concat',
        'scripts:polyfills',
        callback
    );
});

gulp.task('scripts:copy', () => {
    fn.consoleLog('Start: Copying scripts', 'start');
    return gulp.src(COPY_FILES)
        .pipe(gulp.dest(routes.dist.js));
});

gulp.task('scripts:concat', ['scripts:lint'], () => {
    fn.consoleLog('Start: Scripts concatenation', 'start');
    let s = $.size({ title: 'Scripts' });

    return gulp.src(CONCAT_FILES)
        .pipe($.uglify())
        .pipe($.plumber({
            errorHandler: (err) => {
                fn.errorAlert(err);
                this.emit('end');
            }
        }))
        .pipe(s)
        .pipe($.concat('app.min.js', { newLine: ';' }))
        .pipe(gulp.dest(routes.dist.js))
        .pipe($.notify({
			onLast: true,
			message: () => {
				return 'Total size of scripts ' + s.prettySize;
			}
		}));
});

gulp.task('scripts:polyfills', () => {
    fn.consoleLog('Start: Polyfills concatenation', 'start');
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
        .pipe($.eslint.format(friendlyFormatter));
});

gulp.task('scripts:watch', () => {
    gulp.watch([COPY_FILES], ['scripts:copy', reload]);
    gulp.watch([CONCAT_FILES], ['scripts:concat', reload]);
});
