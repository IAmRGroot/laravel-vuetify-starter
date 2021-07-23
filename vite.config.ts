import { ConfigEnv, defineConfig, UserConfigExport } from 'vite';
import vue from '@vitejs/plugin-vue';
import copy from 'rollup-plugin-copy';
import pages from 'vite-plugin-pages';
import eslintPlugin from 'vite-plugin-eslint';
import compression from 'vite-plugin-compression';

import { isPublic, getPermissions } from './resources/vue/src/plugins/permissions';

// https://vitejs.dev/config/
export default ({ mode, command }: ConfigEnv): UserConfigExport => {
    // If you need env
    // process.env = {...process.env, ...loadEnv(mode, process.cwd())};

    const prod = mode === 'production';
    const dev_server = command !== 'build';

    const plugins = [
        vue(),
        pages({
            pagesDir: 'src/pages',
            extensions: ['vue', 'ts'],
            importMode() {
                return 'async';
            },
            extendRoute(route) {
                if (isPublic(route.path)) {
                    return route;
                }

                return {
                    ...route,
                    meta: {
                        auth: true,
                        permissions: getPermissions(route.name),
                    },
                };
            },
        }),
        eslintPlugin({
            fix: !prod,
            include: ['./**/*.ts', './**/*.vue'],
        }),
    ];

    if (prod) {
        plugins.push(compression());
        plugins.push({
            ...copy({
                targets: [
                    {
                        src: 'resources/vue/dist/*',
                        dest: 'public/vue',
                    },
                ],
                overwrite: true,
                hook: 'writeBundle',
                preserveTimestamps: true,
            }),
            enforce: 'post',
        });
    }

    return defineConfig({
        plugins: plugins,
        root: 'resources/vue',
        build: prod ? {} : {
            outDir: '../../public/vue',
            brotliSize: false,
        },
        base: dev_server ? '/' : '/vue/',
        server: { host: '0.0.0.0' },
    });
};
