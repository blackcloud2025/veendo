import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //styles
                'resources/css/app.css',
                'resources/css/slider.css',
                'resources/css/uploadForm.css',
                'resources/css/loggin.css',
                'resources/css/payment.css',

                //scripts
                'resources/js/app.js',
                'resources/js/slider.js',
                'resources/js/uploadImageBox.js',
                'resources/js/logginBehaviour.js',
                'resources/js/payment.js'

            ],
            refresh: true,
        }),
    ],
});
