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
        eslintPlugin({
            // TODO
            // fix: true,
            include: ['./**/*.js', './**/*.jsx', './**/*.ts', './**/*.tsx', './**/*.vue']
        }),
        copy({
            targets: [
                { src: 'resources/vue/dist/*', dest: 'public/vue' },
            ]
        }),
    ],
    root: 'resources/vue',
    build: {
        // TODO
        // outDir: '../../public/vue',
    },
    base: '/vue/',
    server: {
        host: '0.0.0.0',
    },
})
