'use strict';

import gulp from 'gulp';
import routes from './config/routes';
import fn from './config/functions';

gulp.task('fonts', function () {
    fn.consoleLog('Start: Copying fonts', 'start');
    return gulp.src(routes.src.fonts + '/**/*')
        .pipe(gulp.dest(routes.dist.fonts));
});
