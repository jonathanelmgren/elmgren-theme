const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const dotenv = require('dotenv');
dotenv.config();

const plugins = [
    new MiniCssExtractPlugin({
        filename: 'css/[name].css'
    })
]

if (typeof process.env.WORDPRESS_SITE_URL === 'string') {
    plugins.push(
        new BrowserSyncPlugin({
            https: {
                key: 'docker/ssl/server.key',
                cert: 'docker/ssl/server.crt',
            },
            host: process.env.WORDPRESS_SITE_URL.replace('https://', ''),
            open: "external",
            port: 3000,
            proxy: process.env.WORDPRESS_SITE_URL + '/',
            files: [
                './header.php',
                './footer.php',
                './templates/*.php',
            ],
            reloadDelay: 0,
            injectChanges: true,
            notify: false
        })
    )
}

module.exports = {
    entry: {
        main: ['./assets/ts/plugins.ts', './assets/scss/main.scss']
    },
    output: {
        filename: 'js/[name].js',
        path: path.resolve(__dirname, 'dist')
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                use: 'ts-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: {
                                plugins: [
                                    require('tailwindcss'),
                                    require('autoprefixer')
                                ],
                            },
                        },
                    },
                    'sass-loader'
                ]
            }
        ]
    },
    plugins,
    resolve: {
        extensions: ['.tsx', '.ts', '.js', '.scss'],
    },
};
