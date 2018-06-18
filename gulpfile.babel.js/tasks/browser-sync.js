import browserSync from 'browser-sync';

const reload = done => {
  browserSync.reload();
  done();
};

const serve = done => {
  browserSync.init({
    https: true,
    proxy: 'https://localhost',
    port: 5000,
    ui: { port: 5001 },
    options: { reloadDelay: 250 },
    open: false,
    notify: false
  });
  done();
};

export { reload, serve };
