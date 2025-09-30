import path from 'path';
import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy';

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
  plugins: [
    viteStaticCopy({
      targets: [
        {
          src: path.resolve(
            __dirname,
            'node_modules/@govbr-ds/core/dist/core.min.js'
          ),
          dest: path.resolve(__dirname, 'govbr/media/js')
        },
        {
          src: path.resolve(
            __dirname,
            'node_modules/@fortawesome/fontawesome-free/css/all.min.css'
          ),
          dest: path.resolve(__dirname, 'govbr/media/css')
        },
        {
          src: path.resolve(
            __dirname,
            'node_modules/@fortawesome/fontawesome-free/webfonts/*.woff2'
          ),
          dest: path.resolve(__dirname, 'govbr/media/webfonts')
        }
      ]
    })
  ],
  server: {
    watch: {
      usePolling: true
    }
  }
});
