'use strict';

import gulp from 'gulp';
import path from 'path';
import swPrecache from 'sw-precache';
import routes from '../config/routes';

gulp.task('serviceWorker', (callback) => {
    swPrecache.write(path.join(routes.dist.base, 'service-worker.js'), {
        staticFileGlobs: [
            routes.dist.img +'/**/*',
            routes.dist.js +'/**/*.js',
            routes.dist.css +'/**/*.css',
            routes.dist.base +'/**/*.{html,json}'
        ],
        stripPrefix: routes.dist.base
    }, callback);
});
