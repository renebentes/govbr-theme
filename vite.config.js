import { exec } from 'node:child_process';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';
import VitePluginBrowserSync from 'vite-plugin-browser-sync';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import FullReload from 'vite-plugin-full-reload';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

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

// const filesToWatch = [
//   'govbr/language/**/*.ini',
//   'govbr/*.json',
//   'govbr/*.xml',
//   'govbr/**/*.php'
// ];

export default defineConfig({
  build: {
    outDir: 'govbr/media',
    emptyOutDir: false,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'media/js/template.js'),
        template: resolve(__dirname, 'media/scss/template.scss'),
        message: resolve(__dirname, 'media/js/components/br-message.js'),
        breadcrumb: resolve(__dirname, 'media/js/components/br-breadcrumb.js')
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
