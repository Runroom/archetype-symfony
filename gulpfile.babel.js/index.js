'use strict';

import gulp from 'gulp';
import watch from 'gulp-watch';

import { serve, reload } from './tasks/browser-sync';
import styles, { STYLE_FILES } from './tasks/styles.base';
import stylesCrp, { CRP_FILES } from './tasks/styles.crp';
import scripts, { SCRIPTS_FILES } from './tasks/scripts.base';
import images, { IMAGES_FILES } from './tasks/images.base';
import imagesSprites, { SPRITES_FILES } from './tasks/images.sprites';
import imagesSvg, { SVG_FILES } from './tasks/images.svg';
import favicon from './tasks/images.favicon';
import stylesLint from './tasks/styles.lint';
import scriptsLint from './tasks/scripts.lint';

const buildStyles = gulp.series(stylesLint, styles);
const buildCrp = gulp.series(stylesLint, stylesCrp);
const buildScripts = gulp.series(scriptsLint, scripts);
const buildImages = gulp.series(gulp.parallel(images, imagesSprites, imagesSvg), favicon);
const build = gulp.parallel(buildStyles, buildCrp, buildImages, buildScripts);

const WATCH_OPTIONS = { usePolling: true };

const watcher = () => {
  watch(STYLE_FILES, WATCH_OPTIONS, gulp.series(buildStyles, reload));
  watch(CRP_FILES, WATCH_OPTIONS, gulp.series(buildCrp, reload));
  watch(SCRIPTS_FILES, WATCH_OPTIONS, gulp.series(buildScripts, reload));
  watch(IMAGES_FILES, WATCH_OPTIONS, gulp.series(buildImages, reload));
  watch(SPRITES_FILES, WATCH_OPTIONS, gulp.series(imagesSprites, reload));
  watch(SVG_FILES, WATCH_OPTIONS, gulp.series(imagesSvg, reload));
};

const DEV = gulp.series(build, serve, watcher);
export default DEV;
