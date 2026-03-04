import { exec } from 'node:child_process';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';
import VitePluginBrowserSync from 'vite-plugin-browser-sync';
import { viteStaticCopy } from 'vite-plugin-static-copy';

const __dirname = dirname(fileURLToPath(import.meta.url));

const runPhing = (context = 'auto') => {
  console.log(`🔧 Runing Phing (${context})...`);
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
};

const filesToWatch = [
  'govbr/language/**/*.ini',
  'govbr/*.json',
  'govbr/*.xml',
  'govbr/**/*.php'
];

export default defineConfig({
  base: './',
  build: {
    outDir: 'govbr/media',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'media/js/template.js'),
        template: resolve(__dirname, 'media/scss/template.scss')
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
          src: 'node_modules/@govbr-ds/core/dist/core.min.css',
          dest: 'css'
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
            'govbr/media/css/*.css',
            'govbr/media/js/*.js',
            ...filesToWatch,
            {
              match: [...filesToWatch],
              fn: (event, file) => {
                runPhing('browser-sync');
              }
            }
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
    {
      name: 'run-phing',
      apply: 'build',
      closeBundle() {
        if (process.env.NODE_ENV !== 'production') {
          runPhing('build');
        }
      }
    }
  ],
  server: {
    watch: {
      usePolling: true
    }
  }
});
