'use strict';

import gulp from 'gulp';

import routes from '../config/routes';

gulp.task('fonts', () => {
    return gulp.src(routes.src.fonts + '/**/*')
        .pipe(gulp.dest(routes.dist.fonts));
});
