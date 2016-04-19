'use strict';

import browserSync from 'browser-sync';
import gulp from 'gulp';
import routes from './config/routes';
import fn from './config/functions';

gulp.task('browserSync', () => {
    fn.consoleLog('Start: Browser Sync', 'start');
    browserSync({
        server: {
            baseDir: routes.dist.base
        },
        options: { reloadDelay: 250 },
        notify: false
    });
});
