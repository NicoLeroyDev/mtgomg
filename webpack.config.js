const webpack = require('webpack');
const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false,
        }),
    ],
    stats: {
        children: true,
    },
    module: {
        rules: [
            {
                test: /\\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\\.(json5?|ya?ml)$/, // target json, json5, yaml and yml files
                type: 'javascript/auto',
                loader: '@intlify/vue-i18n-loader',
                include: [
                    // Use `Rule.include` to specify the files of locale messages to be pre-compiled
                    path.resolve(__dirname, 'src/locales'),
                ],
            },
            {
                resourceQuery: /blockType=i18n/,
                type: 'javascript/auto',
                loader: '@intlify/vue-i18n-loader',
            },
        ],
    },
};
