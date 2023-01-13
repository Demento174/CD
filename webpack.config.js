const  path = require('path');
const webpack = require('webpack');
// const MiniCssExtractPlugin = require("mini-css-extract-plugin");
module.exports =
    {
        mode: 'development',
        entry:'./public/js/src/index.js',
        devtool: 'inline-source-map',
        output:
            {
                path:path.resolve('public/js'),
                filename:'index.js',
            },
        module: {
            rules: [
                {
                    test: /\.less$/,
                    use:
                            [
                                {
                                    loader: 'style-loader'
                                },
                                {
                                    loader: 'css-loader'
                                },
                                {
                                    loader: 'less-loader'
                                }
                            ]
                },
                {
                    test: /\.css$/i,
                    // use: [MiniCssExtractPlugin.loader,'style-loader', 'css-loader'],
                    use: ['style-loader', 'css-loader'],
                },
                {
                    test: /\.svg$/,
                    use: ['svg-loader']
                },
                {
                    test: /\.(eot|woff|woff2|svg|ttf)([\?]?.*)$/,
                    use: ['file-loader']
                },
                {
                    test: /\.(png|woff|woff2|eot|ttf|svg)$/,
                    use: ['url-loader?limit=100000']
                },
                {
                    test: /\.(png|jpe?g|gif|svg|eot|ttf|woff|woff2)$/i,
                    loader: 'url-loader',
                    options: {
                        limit: 8192,
                    },
                }

            ],
        },
        plugins: [
            new webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery'
            }),
        ],

    };