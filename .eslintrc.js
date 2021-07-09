const spaces = 4;

const eslint_rules = {
    'array-bracket-newline': ['error', 'consistent'],
    'arrow-spacing': ['error', {
        before: true,
        after: true,
    }],
    'block-spacing': ['error', 'always'],
    'brace-style': ['error', '1tbs'],
    'comma-dangle': ['error', 'always-multiline'],
    'comma-spacing': ['error'],
    'comma-style': ['error'],
    'dot-location': ['error', 'property'],
    'dot-notation': ['error'],
    'eqeqeq': ['error'],
    'func-call-spacing': ['error'],
    'key-spacing': ['error'],
    'keyword-spacing': ['error'],
    'no-constant-condition': ['error'],
    'no-empty-pattern': ['error'],
    'no-extra-parens': ['error'],
    'no-irregular-whitespace': ['error'],
    'no-sparse-arrays': ['error'],
    'no-useless-concat': ['error'],
    'object-curly-spacing': ['error', 'always'],
    'object-property-newline': ['error', { allowAllPropertiesOnSameLine: false }],
    'object-curly-newline': ['error', {
        'ObjectExpression': {
            multiline: true,
            minProperties: 3,
        },
        'ObjectPattern': {
            multiline: true,
            minProperties: 3,
        },
        'ImportDeclaration': 'never',
        'ExportDeclaration': {
            multiline: true,
            minProperties: 3,
        },
    }],
    'prefer-template': ['error'],
    'space-in-parens': ['error'],
    'space-infix-ops': ['error'],
    'space-unary-ops': ['error'],
    'template-curly-spacing': ['error'],
};

const vue_rules = {};
for (const rule in eslint_rules) {
    vue_rules[`vue/${rule}`] = eslint_rules[rule];
}

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
        'node_modules',
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
        'semi': ['error', 'always'],
        'no-trailing-spaces': ['error'],
        'no-console': process.env.NODE_ENV === 'production' ? 2 : 1,
        'no-debugger': process.env.NODE_ENV === 'production' ? 2 : 1,
        'quotes': ['error', 'single'],
        'no-else-return': ['error'],
        'no-eval': ['error'],
        'no-var': ['error'],
        'no-alert': ['error'],
        'indent': ['error', spaces, { SwitchCase: 1 }],

        ...eslint_rules,
        ...vue_rules,

        'vue/block-tag-newline': ['error'],
        'vue/component-name-in-template-casing': ['error', 'kebab-case'],
        'vue/custom-event-name-casing': ['error', 'kebab-case'],
        'vue/no-deprecated-v-is': ['error'],
        'vue/no-duplicate-attr-inheritance': ['error'],
        'vue/no-empty-component-block': ['error'],
        'vue/no-multiple-objects-in-class': ['error'],
        'vue/no-reserved-component-names': ['error', { disallowVue3BuiltInComponents: true }],
        'vue/no-unused-properties': ['error'],
        'vue/no-unused-refs': ['error'],
        'vue/no-useless-mustaches': ['error'],
        'vue/no-useless-v-bind': ['error'],
        'vue/padding-line-between-blocks': ['error', 'always'],
        'vue/require-emit-validator': ['error'],
        'vue/script-indent': ['error', spaces, { switchCase: 1 }],
        'vue/html-indent': ['error', spaces],
        'vue/v-on-event-hyphenation': ['error', 'always', { autofix: true }],
        'vue/valid-next-tick': ['error' ],
        'vue/no-export-in-script-setup': ['error'],
        'vue/valid-define-props': ['error'],
        'vue/valid-define-emits': ['error'],
        'vue/valid-v-slot': ['error', { allowModifiers: true }],
        'vue/component-tags-order': ['error', { 'order': [ 'template', 'style', 'script' ] }],
        'vue/no-deprecated-scope-attribute': ['error'],
    },
};
