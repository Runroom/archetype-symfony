'use strict';

import browserSync from 'browser-sync';
import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';
import routes from './config/routes';
import fn from './config/functions';

const reload = browserSync.reload;
const $ = gulpLoadPlugins({ camelize: true });
const AUTOPREFIXER_ARGS = {
    browsers : [
        'ie >= 10',
        'ie_mob >= 10',
        'ff >= 30',
        'chrome >= 34',
        'safari >= 7',
        'opera >= 23',
        'ios >= 7',
        'android >= 4.4',
        'bb >= 10'
    ],
    cascade : true
};
const STYLE_FILES = routes.src.scss + '/**/*.scss';

gulp.task('styles', () => {
    fn.consoleLog('Start: Sass compilation', 'start');
    return gulp.src(STYLE_FILES)
        .pipe($.plumber({
            errorHandler: (err) => {
                fn.errorAlert(err);
                this.emit('end');
            }
        }))
        .pipe($.sourcemaps.init())
        .pipe($.sass({
            sourceComments: 'map',
            imagePath: routes.src.img
        }))
        .pipe($.combineMq({ beautify: true }))
        .pipe($.pixrem())
        .pipe($.autoprefixer(), AUTOPREFIXER_ARGS)
        .pipe($.cssnano())
        .pipe($.rename({ suffix:'.min' }))
        .pipe($.sourcemaps.write('.', { includeContent : false }))
        .pipe($.size({ title: 'Sass compiled' }))
        .pipe(gulp.dest(routes.dist.css));
});

gulp.task('styles:watch', () => {
    gulp.watch([STYLE_FILES], ['styles', reload]);
});
