'use strict';

import browserSync from 'browser-sync';
import { execa } from 'execa';
import gulp from 'gulp';

const config = {
  host: process.env?.GULP_HOST ?? 'http://localhost',
  isProduction: process.env?.NODE_ENV === 'production'
};

const paths = {
  php: './src/**/*.php',
  styles: {
    src: './src/scss/*.scss',
    dest: './src/css/'
  },
  scripts: {
    src: [
      './src/js/*.js',
      '!./src/js/*.min.js'
    ],
    dest: './src/js/'
  }
};

const reload = (done) => {
  browserSync.reload();
  done();
};

const serve = (done) => {
  browserSync.init({
    proxy: config.host,
    open: false
  });

  done();
};

export const clean = () =>
  del([paths.styles.dest]);

const phing = async() => {
  await execa('vendor/bin/phing', ['dev'], { stdio: 'inherit' });
};

const watch = () => {
  const watchOptions = { usePolling: true };
  // gulp.watch([paths.styles.src], gulp.series(css, reload));
  // gulp.watch([paths.scripts.src], gulp.series(js, reload));
  // gulp.watch(['src/images/**/*'], gulp.series(images, reload));
  gulp.watch([paths.php], watchOptions, gulp.series(phing, reload));
}

export const dev = gulp.series(serve, watch);

export default dev;
