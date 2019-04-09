import cheerio from 'gulp-cheerio';
import gulp from 'gulp';
import imagemin from 'gulp-imagemin';
import rename from 'gulp-rename';

import { SVGO } from '../config/params';
import { SPRITES_SRC, SPRITES_DEST } from '../config/routes';

const SPRITES_FILES = `${SPRITES_SRC}/*.svg`;

const sprites = () => {
  return gulp
    .src(SPRITES_FILES)
    .pipe(rename({ prefix: 'icon-' }))
    .pipe(imagemin([imagemin.svgo(SVGO)]))
    .pipe(cheerio({
      run: $ => {
        $('[fill]').removeAttr('fill');
      },
      parserOptions: { xmlMode: true }
    }))
    .pipe(gulp.dest(SPRITES_DEST));
};

export { SPRITES_FILES };
export default sprites;
