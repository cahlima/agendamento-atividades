cimport { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': '/resources/js',
    },
  },
  build: {
    rollupOptions: {
      input: '/resources/index.html',
    },
  },
});
