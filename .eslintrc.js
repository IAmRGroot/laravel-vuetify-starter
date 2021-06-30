const spaces = 4;

module.exports = {
    root: true,
    env: {
        browser: true,
        es2021: true,
        node: true,
    },
    ignorePatterns: [
        'resources/vue/dist/*',
        '*.svg',
        'node_modules'
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
        'vue/html-indent': ['error', spaces],
        'vue/block-tag-newline': ['error'],
        'vue/component-name-in-template-casing': ['error', 'kebab-case'],
        'vue/custom-event-name-casing': ['error', 'kebab-case'],
        'vue/no-deprecated-v-is': ['error'],
        'vue/no-duplicate-attr-inheritance': ['error'],
        'vue/no-empty-component-block': ['error'],
        'vue/no-multiple-objects-in-class': ['error'],
        'vue/no-reserved-component-names': ['error', { disallowVue3BuiltInComponents: true}],
        'vue/no-unregistered-components': ['error', {
            "ignorePatterns": ['v-.+']
        }],
        'vue/no-unused-properties': ['error'],
        'vue/no-unused-refs': ['error'],
        'vue/no-useless-mustaches': ['error'],
        'vue/no-useless-v-bind': ['error'],
        "vue/padding-line-between-blocks": ["error", "always"],
        "vue/require-emit-validator": ["error"],
        "vue/script-indent": ["error", spaces,],
        "vue/v-on-event-hyphenation": ['error', 'always', { autofix: true }],
        "vue/valid-next-tick": ['error', ],
        "@typescript-eslint/no-unused-vars": ['off'],
        'no-trailing-spaces': ['error'],
    },
};
