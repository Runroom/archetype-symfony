import gulp from 'gulp';
import imagemin from 'gulp-imagemin';

import { SVGO } from '../config/params';
import { IMAGES_SRC, SPRITES_SRC, SPRITES_DEST } from '../config/routes';

const SVG_FILES = [`${IMAGES_SRC}/*.svg`, `!${SPRITES_SRC}/*`];

const svg = () => {
  return gulp
    .src(SVG_FILES)
    .pipe(imagemin([imagemin.svgo(SVGO)]))
    .pipe(gulp.dest(SPRITES_DEST));
};

export { SVG_FILES };
export default svg;
