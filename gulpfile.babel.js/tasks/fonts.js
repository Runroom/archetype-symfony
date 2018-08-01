import gulp from 'gulp';

import { FONTS_SRC, FONTS_DEST } from '../config/routes';

const fonts = () => gulp.src(`${FONTS_SRC}/**/*`).pipe(gulp.dest(FONTS_DEST));

export default fonts;
