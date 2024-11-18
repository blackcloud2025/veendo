import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //resources css
                'resources/css/app.css',
                'resources/css/slider.css',

                //resources js
                'resources/js/app.js',
                'resources/js/imageUploadPreview.js',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
