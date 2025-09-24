import browserSync from 'browser-sync';
import { exec } from 'child_process';

const bs = browserSync.create();
const files = [
  'govbr/**/*.php',
  'govbr/**/*.ini',
  'govbr/*.xml',
  'src/**/*.js',
  'src/**/*.scss'
];

bs.init({
  proxy: 'http://localhost:8080',
  files: [...files],
  open: false,
  notify: true
});

bs.watch([...files]).on('change', () => {
  exec('vendor/bin/phing dev', (err, stdout, stderr) => {
    if (err) {
      console.error(`exec error: ${err}`);
      return;
    }
    if (stderr) {
      console.error(`stderr: ${stderr}`);
      return;
    }
    console.log(stdout);
    bs.reload();
  });
});
