'use strict';

import gulp from 'gulp';
import fs from 'fs';
import gulpLoadPlugins from 'gulp-load-plugins';
import runSequence from 'run-sequence';

const $ = gulpLoadPlugins({ camelize: true });

fs.readdirSync('./gulp-tasks').filter((file) => {
    return (/\.(js)$/i).test(file);
}).map((file) => {
    require('./gulp-tasks/' + file);
});


gulp.task('default', ['serve']);

gulp.task('help', $.taskListing);

gulp.task('build', (callback) => {
    runSequence(
        ['images', 'styles', 'scripts'],
        'serviceWorker',
        callback
    );
});

gulp.task('serve', (callback) => {
    runSequence(
        'build',
        'watch',
        'browserSync',
        callback
    );
});

gulp.task('watch', ['images:watch', 'styles:watch', 'scripts:watch'])
