import { defineConfig, UserConfig, UserConfigExport } from 'vite';
import vue from '@vitejs/plugin-vue';
import copy from 'rollup-plugin-copy';
import pages from 'vite-plugin-pages';
import eslintPlugin from 'vite-plugin-eslint';

const public_routes = [
    /^\/login$/,
];

// https://vitejs.dev/config/
export default ({ mode }: UserConfig ): UserConfigExport => {
    // If you need env
    // process.env = {...process.env, ...loadEnv(mode, process.cwd())};

    const prod = mode === 'production';

    return defineConfig({
        plugins: [
            vue(),
            pages({
                pagesDir: 'src/pages',
                extensions: ['vue', 'ts'],
                importMode() {
                    return 'async';
                },
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
                fix: ! prod,
                include: ['./**/*.ts', './**/*.vue']
            }),
            copy({
                targets: ! prod ? [] : [
                    { src: 'resources/vue/dist/*', dest: 'public/vue' },
                ]
            }),
        ],
        root: 'resources/vue',
        build: prod ? {} : {
            outDir: '../../public/vue',
        },
        base: prod ? '/vue/' : '/',
        server: {
            host: '0.0.0.0',
        },
    });
};
