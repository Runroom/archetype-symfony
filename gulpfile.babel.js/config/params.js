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

export { SVGO };
