'use strict';

import gulp from 'gulp';
import watch from 'gulp-watch';

import { serve, reload } from './tasks/browser-sync';
import styles, { STYLES_FILES } from './tasks/styles.base';
import scripts, { SCRIPTS_FILES } from './tasks/scripts.base';
import images, { IMAGES_FILES } from './tasks/images.base';
import imagesSprites, { SPRITES_FILES } from './tasks/images.sprites';
import imagesSvg, { SVG_FILES } from './tasks/images.svg';
import favicon from './tasks/images.favicon';
import stylesLint from './tasks/styles.lint';
import scriptsLint from './tasks/scripts.lint';

const buildStyles = gulp.series(stylesLint, styles);
const buildScripts = gulp.series(scriptsLint, scripts);
const buildImages = gulp.series(gulp.parallel(images, imagesSprites, imagesSvg), favicon);
const build = gulp.parallel(buildStyles, buildImages, buildScripts);

const WATCH_OPTIONS = { usePolling: true };

const watcher = () => {
  watch(STYLES_FILES, WATCH_OPTIONS, gulp.series(buildStyles, reload));
  watch(SCRIPTS_FILES, WATCH_OPTIONS, gulp.series(buildScripts, reload));
  watch(IMAGES_FILES, WATCH_OPTIONS, gulp.series(buildImages, reload));
  watch(SPRITES_FILES, WATCH_OPTIONS, gulp.series(imagesSprites, reload));
  watch(SVG_FILES, WATCH_OPTIONS, gulp.series(imagesSvg, reload));
};

const DEV = gulp.series(build, serve, watcher);
export default DEV;
