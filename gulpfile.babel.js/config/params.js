const AUTOPREFIXER = {
  browsers: [
    'ie >= 10',
    'ie_mob >= 10',
    'ff >= 30',
    'chrome >= 20',
    'safari >= 5',
    'opera >= 23',
    'ios >= 5',
    'android >= 4.4',
    'bb >= 10'
  ],
  cascade: false
};

const SVGO = {
  plugins: [
    { cleanupIDs: true },
    { collapseGroups: true },
    { convertColors: true },
    { convertShapeToPath: true },
    { removeComments: true },
    { removeDescription: true },
    { removeDoctype: true },
    { removeEmptyAttrs: true },
    { removeMetadata: true },
    { removeStyleElement: true },
    { removeTitle: true },
    { removeUselessStrokeAndFill: true },
    { removeViewBox: false }
  ]
};

export { AUTOPREFIXER, SVGO };
