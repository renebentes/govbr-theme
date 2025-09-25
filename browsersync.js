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
      throw err;
    }
    console.log(stdout);
    console.error(`stderr: ${stderr}`);
    bs.reload();
  });
});
