const webpack = require('webpack');
const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

module.exports = {
    entry: {
        app: './assets/src/javascripts/app.js',
    },
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, 'assets/dist'),
        publicPath: '/assets/dist/',
        chunkFilename: '[name].bundle.js',
    },
    devtool: 'source-map',
    mode: process.env.WEBPACK_MODE || 'development',
    optimization: {
        minimizer: [
            new UglifyJsPlugin({
                sourceMap: true
            }),
            new OptimizeCSSAssetsPlugin({})
        ],
        splitChunks: {
            chunks: 'all'
        }
    },
    watchOptions: {
        aggregateTimeout: 300,
        poll: 1000,
        ignored: /node_modules/
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "[name].css",
        }),
        new CopyWebpackPlugin([
            {from: './assets/src/images/', to: 'img/', toType: 'dir'}
        ], {debug: 'info'}),
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': JSON.stringify('production')
        }),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            tether: 'tether',
            Tether: 'tether',
            'window.Tether': 'tether',
            Popper: ['popper.js', 'default'],
            Alert: 'exports-loader?Alert!bootstrap/js/dist/alert',
            Button: 'exports-loader?Button!bootstrap/js/dist/button',
            Carousel: 'exports-loader?Carousel!bootstrap/js/dist/carousel',
            Collapse: 'exports-loader?Collapse!bootstrap/js/dist/collapse',
            Dropdown: 'exports-loader?Dropdown!bootstrap/js/dist/dropdown',
            Modal: 'exports-loader?Modal!bootstrap/js/dist/modal',
            Popover: 'exports-loader?Popover!bootstrap/js/dist/popover',
            Scrollspy: 'exports-loader?Scrollspy!bootstrap/js/dist/scrollspy',
            Tab: 'exports-loader?Tab!bootstrap/js/dist/tab',
            Tooltip: "exports-loader?Tooltip!bootstrap/js/dist/tooltip",
            Util: 'exports-loader?Util!bootstrap/js/dist/util'
        }),
    ],
    module: {
        rules: [
            {
                test: /\.(css|scss)$/,
                use: [
                    // Adds CSS to the DOM by injecting a `<style>` tag
                    {loader: 'style-loader'},

                    // Extract CSS from javascript loader
                    MiniCssExtractPlugin.loader,

                    // Interprets `@import` and `url()` like `import/require()` and will resolve them
                    {loader: 'css-loader', options: {minimize: true}},

                    // Loader for webpack to process CSS with PostCSS
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: function () {
                                return [
                                    require('autoprefixer')
                                ];
                            }
                        }
                    },

                    // Loads a SASS/SCSS file and compiles it to CSS
                    {
                        loader: 'sass-loader',
                        options: {
                            includePaths: [path.resolve(__dirname, 'node_modules')],
                        }
                    }
                ]
            },
            {
                test: /\.(png|svg|jpg|gif)$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'img/'
                    }
                }]
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'fonts/'
                    }
                }]
            }
        ]
    },
    externals: {
        jquery: 'jQuery'
    }
};