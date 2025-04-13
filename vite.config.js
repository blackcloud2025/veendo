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
                'resources/css/profile.css',
                'resources/css/Prodcard.css',
                'resources/css/dashboard.css',
                'resources/css/publisher.css',
                'resources/css/cart.css',
                'resources/css/home.css',

                
                //scripts
                'resources/js/app.js',
                'resources/js/slider.js',
                'resources/js/uploadImageBox.js',
                'resources/js/logginBehaviour.js',
                'resources/js/payment.js',
                'resources/js/profile.js',
                'resources/js/publisher.js',
                'resources/js/cart.js',
            ],
            refresh: true,
        }),
    ],
});
