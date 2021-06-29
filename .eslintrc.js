module.exports = {
    root: true,
    env: {
        browser: true,
        es2021: true,
        node: true,
    },
    ignorePatterns: [
        'resources/ts/dist/*',
        '*.svg'
    ],
    extends: [
        'plugin:vue/vue3-recommended',
        'eslint:recommended',
        '@vue/typescript/recommended',
    ],
    parserOptions: {
        parser: '@typescript-eslint/parser',
        ecmaVersion: 2021,
    },
    rules: {
        'vue/html-indent': ['error', 4],
        "@typescript-eslint/no-unused-vars": ['off'],
    },
};
