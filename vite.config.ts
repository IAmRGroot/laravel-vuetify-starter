import { ConfigEnv, defineConfig, UserConfigExport } from 'vite';
import { createVuePlugin as vue2 } from 'vite-plugin-vue2';
import copy from 'rollup-plugin-copy';
import pages from 'vite-plugin-pages';
import eslintPlugin from 'vite-plugin-eslint';
import compression from 'vite-plugin-compression';
import scriptSetup from 'unplugin-vue2-script-setup/vite';
import components from 'unplugin-vue-components/vite';
import { VuetifyResolver } from 'unplugin-vue-components/resolvers';

import { isPublic, getPermissions } from './resources/vue/src/plugins/permissions';

// https://vitejs.dev/config/
export default ({ mode, command }: ConfigEnv): UserConfigExport => {
    // If you need env
    // process.env = {...process.env, ...loadEnv(mode, process.cwd())};

    const is_production = mode === 'production';
    const is_dev_server = command !== 'build';

    const plugins = [
        vue2(),
        scriptSetup(),
        components({
            resolvers: [
                VuetifyResolver(),
            ],
        }),
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
            fix: !is_production,
            include: ['./**/*.ts', './**/*.vue'],
        }),
    ];

    // if (is_production) {
    //     plugins.push(compression());
    //     plugins.push({
    //         ...copy({
    //             targets: [
    //                 {
    //                     src: 'resources/vue/dist/*',
    //                     dest: 'public/vue',
    //                 },
    //             ],
    //             overwrite: true,
    //             hook: 'writeBundle',
    //             preserveTimestamps: true,
    //         }),
    //         enforce: 'post',
    //     });
    // }

    return defineConfig({
        plugins: plugins,
        root: 'resources/vue',
        build: is_production ? {} : {
            outDir: '../../public/vue',
            brotliSize: false,
        },
        base: is_dev_server ? '/' : '/vue/',
        server: { host: '0.0.0.0' },
    });
};
