import { fileURLToPath } from 'node:url';

import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

const isCI = process.env.CI === 'true' || process.env.VERCEL === '1';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/vue/app.ts'],
      ssr: 'resources/js/vue/ssr.ts',
      refresh: true,
    }),
    tailwindcss(),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    !isCI &&
      wayfinder({
        formVariants: true,
        path: 'resources/js/vue',
      }),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./resources/js/vue', import.meta.url)),
    },
  },
  server: {
    host: 'jnd-code-challenge',
    cors: process.env.NODE_MODE !== 'production',
  },
});
