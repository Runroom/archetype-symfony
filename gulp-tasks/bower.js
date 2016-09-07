'use strict';

import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';
import routes from './config/routes';
import fn from './config/functions';

const $ = gulpLoadPlugins({ camelize: true });

gulp.task('bower', ['bower:copy', 'bower:concat']);

gulp.task('bower:copy', function () {
    fn.consoleLog('Start: Copying Bower components', 'start');
    return gulp.src(routes.bower.copy)
        .pipe(gulp.dest(routes.dist.js + '/libs'));
});

gulp.task('bower:concat', () => {
    fn.consoleLog('Start: Bower concatenation', 'start');
    let s = $.size({ title: 'Bower' });

    return gulp.src(routes.bower.concat)
        .pipe($.uglify())
        .pipe($.plumber({errorHandler: fn.errorAlert}))
        .pipe(s)
        .pipe($.concat('components.min.js', { newLine: ';' }))
        .pipe(gulp.dest(routes.dist.js))
        .pipe($.notify({
            onLast: true,
            message: () => {
                return 'Total size of scripts ' + s.prettySize;
            }
        }));
});
