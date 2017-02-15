'use strict';

import gulp from 'gulp';
import fs from 'fs';
import taskListing from 'gulp-task-listing';
import runSequence from 'run-sequence';
import cache from 'gulp-cache';

/**
 * Require all tasks from tasks folder
 */
fs.readdirSync('./gulpfile.babel.js/tasks').filter((file) => {
    return (/\.(js)$/i).test(file);
}).map((file) => {
    require('./tasks/' + file);
});

/**
 * Task: Build
 * Call all task for building
 */
gulp.task('build', (callback) => {
    runSequence(
        ['images', 'styles', 'scripts'],
        'serviceWorker',
        callback
    );
});

/**
 * Task: Clean cache
 * Clear Gulp Cache
 */
gulp.task('clean:cache', (done) => cache.clearAll(done));

/**
 * Task: Default
 */
gulp.task('default', ['serve']);

/**
 * Task: Help
 * List all available tasks
 */
gulp.task('help', taskListing);

/**
 * Task: Serve
 * Call the build task and open browser with BrowserSync & Watch
 */
gulp.task('serve', (callback) => {
    runSequence(
        'build',
        'watch',
        'browserSync',
        callback
    );
});

/**
 * Task: Watch
 * Main task to run all watch tasks
 */
gulp.task('watch', ['images:watch', 'styles:watch', 'scripts:watch'])
