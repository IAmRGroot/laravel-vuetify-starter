import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import copy from 'rollup-plugin-copy';
import pages from 'vite-plugin-pages';
import eslintPlugin from 'vite-plugin-eslint';

const public_routes = [
    /^\/login$/,
];
// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        vue(),
        pages({
            pagesDir: 'src/pages',
            extensions: ['vue', 'ts'],
            extendRoute(route) {
                if (public_routes.some(public_route => public_route.test(route.path))) {
                    return route;
                }

                return {
                  ...route,
                  meta: { auth: true },
                };
              },
        }),
        // TODO
        // eslintPlugin({
        //     // fix: ! import.meta.env.PROD
        //     fix: true
        // }),
        copy({
            targets: [
                { src: 'resources/vue/dist/*', dest: 'public/vue' },
            ]
        }),
    ],
    root: 'resources/vue',
    base: '/',
    server: {
        host: '0.0.0.0',
    }
})
