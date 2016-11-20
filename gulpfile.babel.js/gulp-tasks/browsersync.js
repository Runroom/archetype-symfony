'use strict';

import browserSync from 'browser-sync';
import gulp from 'gulp';
import routes from './config/routes';
import fn from './config/functions';

gulp.task('browserSync', () => {
    fn.consoleLog('Start: Browser Sync', 'start');
    browserSync({
        proxy: 'localhost',
        port: 5000,
        ui: {
          port: 5001
        },
        options: { reloadDelay: 250 },
        open: false,
        notify: false
    });
});
