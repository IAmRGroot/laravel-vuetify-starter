module.exports = {
    root: true,
    env: {
        node: true,
    },
    ignorePatterns: [
        'resources/ts/dist/*',
        '*.svg',
    ],
    extends: [
        'plugin:vue/vue3-recommended',
        // 'eslint:recommended',
        // '@vue/typescript/recommended'
    ],
    parserOptions: {
        sourceType: "module",
        module: "es2020",
        ecmaVersion: 2020,
    },
    rules: {
        // 'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
        // 'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
        'vue/html-indent': ['error', 4],
        // 'camelcase': 'off',
        // 'quotes': ['error', 'single'],
        // 'semi': ['error', 'always'],
        // 'no-trailing-spaces': [process.env.NODE_ENV === 'production' ? 'error' : 'warn'],
        // 'no-multi-spaces': ['error'],
        // 'keyword-spacing': ['error'],
        // 'vue/script-indent': ['error', 4],
        // 'vue/eqeqeq': ['error'],
        // 'vue/arrow-spacing': ['error'],
        // 'vue/no-deprecated-scope-attribute': ['error'],
        // 'vue/require-prop-types': ['error'],
        // 'vue/require-default-prop': ['error'],
        // 'vue/prop-name-casing': ['error', 'snake_case'],
        'vue/component-tags-order': ['error'],
        // 'vue/component-tags-order': ['error', {
        //         'order': [ 'template', 'style', 'script' ]
        // }],
        // '@typescript-eslint/no-empty-function': ['off'],
        // 'no-else-return': ['error'],
        // 'no-eval': ['error'],
        // 'no-var': ['error'],
        // 'no-alert': ['error'],
        // '@typescript-eslint/camelcase': ['off'],
        // '@typescript-eslint/no-explicit-any': ['off'],
        // '@typescript-eslint/ban-ts-ignore': ['off'],
        // 'vue/valid-v-slot': ['error', {
        //     allowModifiers: true,
        // }],
        // 'vue/component-definition-name-casing': ['off']
    }
};
