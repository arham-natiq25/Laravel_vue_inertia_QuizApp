import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue({
            template:{
                compilerOptions:{

                },
                transformAssetUrls : {

                }
            }
        }),
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve:{
        alias:{
            vue : "vue/dist/vue.esm-bundler.js"
        }
    }
});
