import gulp from 'gulp';
import imagemin from 'gulp-imagemin';
import mozjpeg from 'imagemin-mozjpeg';

import { SVGO } from '../config/params';
import { IMAGES_SRC, IMAGES_DEST } from '../config/routes';

const IMAGES_FILES = [`${IMAGES_SRC}/**/*`, `!${IMAGES_SRC}/**/*.svg`];

const images = () => {
  return gulp
    .src(IMAGES_FILES)
    .pipe(imagemin([
      mozjpeg(),
      imagemin.gifsicle({ interlaced: true }),
      imagemin.optipng({ optimizationLevel: 5 }),
      imagemin.svgo()
    ]))
    .pipe(gulp.dest(IMAGES_DEST));
};

export { IMAGES_FILES };
export default images;
