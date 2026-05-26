import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';
import FullReload from 'vite-plugin-full-reload';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

export default defineConfig({
  build: {
    outDir: 'govbr/media',
    emptyOutDir: false,
    rollupOptions: {
      input: {
        template: path.resolve(__dirname, 'media/js/template.js'),
        'font-awesome': path.resolve(
          __dirname,
          'node_modules/@fortawesome/fontawesome-free/css/all.min.css'
        ),
        core: path.resolve(__dirname, 'media/js/core.js')
      },
      output: {
        entryFileNames: 'js/[name].js',
        assetFileNames: ({ names }) => {
          const name = names[0] ?? '';
          if (/^fa-.+\.(woff2?|ttf|eot|otf)$/.test(name)) {
            return 'webfonts/[name][extname]';
          }

          if (/\.(woff2?|ttf|eot|otf)$/.test(name))
            return 'fonts/[name][extname]';

          return '[ext]/[name][extname]';
        }
      }
    },
    sourcemap: process.env.NODE_ENV !== 'production'
  },
  css: {
    preprocessorOptions: {
      scss: {
        // TODO: avaliar a necessidade de silenciar estes avisos do GOVBR DS
        silenceDeprecations: ['import', 'color-functions', 'global-builtin']
      }
    }
  },
  plugins: [
    FullReload([
      path.resolve(__dirname, 'govbr/language/**/*.ini'),
      path.resolve(__dirname, 'govbr/*.json'),
      path.resolve(__dirname, 'govbr/*.xml'),
      path.resolve(__dirname, 'govbr/**/*.php')
    ])
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'media')
    }
  },
  server: {
    cors: true,
    hmr: {
      host: 'localhost'
    },
    host: '0.0.0.0',
    origin: 'http://localhost:5173',
    port: 5173,
    strictPort: true,
    watch: {
      usePolling: true
    }
  }
});
