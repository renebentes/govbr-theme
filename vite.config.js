import path from 'path';
import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'govbr/media',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'media/js/template.js'),
        template: path.resolve(__dirname, 'media/scss/template.scss')
      },
      output: {
        entryFileNames: 'js/[name].min.js',
        assetFileNames: '[ext]/[name][extname]'
      }
    }
  },
  server: {
    watch: {
      usePolling: true
    }
  }
});
