import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'], // Arquivos principais que Vite irá processar
            refresh: true, // Permite atualização automática da página
        }),
        vue(), // Plugin Vue.js para Vite
    ],
});
