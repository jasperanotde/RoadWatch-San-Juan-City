import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/image-handler.js', 'resources/js/password-validation.js', 'resources/js/radial-chart.js'],
            refresh: true,
        }),
    ],
});
