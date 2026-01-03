import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import tailwindcss from '@tailwindcss/vite'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/views'),
            '@components': path.resolve(__dirname, './resources/js/components'),
            '@views': path.resolve(__dirname, './resources/js/views'),
            '@utils': path.resolve(__dirname, './resources/js/utils'),
            '@services': path.resolve(__dirname, './resources/js/services'),
        }
    }
})