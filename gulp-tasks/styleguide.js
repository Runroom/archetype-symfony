'use strict';

import browserSync from 'browser-sync';
import gulp from 'gulp';
import gulpLoadPlugins from 'gulp-load-plugins';
import routes from './config/routes';
import fn from './config/functions';
import runSequence from 'run-sequence';

const reload = browserSync.reload;
const $ = gulpLoadPlugins({ camelize: true });
const MARKUP_FILES = routes.src.styleguide + '/index.twig';
const STYLE_FILES = routes.src.styleguide + '/assets/scss/**/*.scss';
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


gulp.task('styleguide', ['styleguide:styles', 'styleguide:markup']);

gulp.task('styleguide:styles', () => {
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
        .pipe(gulp.dest(routes.dist.styleguide + '/assets/css'));
});


gulp.task('styleguide:markup', () => {
    fn.consoleLog('Start: Markup compilation', 'start');

    let data = {
        colors: {
            white: "#FFFFFF",
            black: "#000000"
        }
    };
    let s = $.size({ title: 'Markup' });
    let twig_arg = {
        data: data,
        cache: false
    };

    return gulp.src(MARKUP_FILES)
        .pipe($.plumber({
            errorHandler: (err) => {
                fn.errorAlert(err);
                this.emit('end');
            }
        }))
        .pipe($.twig(twig_arg))
        .pipe($.htmlmin({
                collapseWhitespace: true
            }))
        .pipe(s)
        .pipe(gulp.dest(routes.dist.styleguide))
        .pipe($.notify({
            onLast: true,
            message: function () {
                return 'Total size of markup ' + s.prettySize;
            }
        }));
});

gulp.task('styleguide:watch', () => {
    gulp.watch([STYLE_FILES], ['styleguide:styles', reload]);
    gulp.watch([MARKUP_FILES], ['styleguide:markup', reload]);
});
