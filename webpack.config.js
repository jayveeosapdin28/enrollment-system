const path = require('path');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')
const CaseSensitivePath = require('case-sensitive-paths-webpack-plugin')

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    plugins: [
        new VuetifyLoaderPlugin(),
        new CaseSensitivePath()
    ],
};
