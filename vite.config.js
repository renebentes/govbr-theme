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
        assetFileNames: ({ names }) => {
          const name = names ? names[0] : undefined;

          if (name && /\.(woff2?|ttf|eot|otf)$/.test(name))
            return 'fonts/[name][extname]';

          return '[ext]/[name].min[extname]';
        }
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
          dest: 'js'
        },
        {
          src: path.resolve(
            __dirname,
            'node_modules/@fortawesome/fontawesome-free/css/all.min.css'
          ),
          dest: 'css'
        },
        {
          src: path.resolve(
            __dirname,
            'node_modules/@fortawesome/fontawesome-free/webfonts/*.woff2'
          ),
          dest: 'webfonts'
        },
        {
          src: path.resolve(__dirname, 'media/images/*'),
          dest: 'images'
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
