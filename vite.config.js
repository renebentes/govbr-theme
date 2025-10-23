import path from 'path';
import { defineConfig } from 'vite';
import { exec } from 'child_process';
import VitePluginBrowserSync from 'vite-plugin-browser-sync';
import { viteStaticCopy } from 'vite-plugin-static-copy';

const runPhing = () => ({
  name: 'run-phing',
  apply: 'build',
  closeBundle() {
    console.log(`🔧 Runing Phing...`);
    exec('vendor/bin/phing dev', (error, stdout, stderr) => {
      if (error) {
        console.error(`❌ Phing error: ${error.message}`);
        return;
      }

      if (stdout.trim()) {
        console.log(stdout);
      }

      if (stderr.trim()) {
        console.error(`⚠️ stderr: ${stderr}`);
      }
    });
  }
});

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
    },
    sourcemap: true
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
    viteStaticCopy({
      targets: [
        {
          src: 'node_modules/@govbr-ds/core/dist/core.min.js',
          dest: 'js'
        },
        {
          src: 'node_modules/@fortawesome/fontawesome-free/css/all.min.css',
          dest: 'css'
        },
        {
          src: 'node_modules/@fortawesome/fontawesome-free/webfonts/*.woff2',
          dest: 'webfonts'
        },
        {
          src: 'media/images/*',
          dest: 'images'
        }
      ]
    }),
    VitePluginBrowserSync({
      dev: {
        enable: false
      },
      preview: {
        enable: false
      },
      buildWatch: {
        enable: true,
        bs: {
          name: 'bs-vite',
          files: [
            'govbr/language/**/*.ini',
            'govbr/media/css/*.css',
            'govbr/media/js/*.js',
            'govbr/*.json',
            'govbr/*.xml',
            'govbr/**/*.php'
          ],
          open: false,
          proxy: 'http://localhost:8080',
          reloadDebounce: 1000,
          reloadDelay: 1000,
          watchOptions: {
            usePolling: true,
            interval: 300
          }
        }
      }
    }),
    runPhing()
  ],
  server: {
    watch: {
      usePolling: true,
      interval: 100
    }
  }
});
