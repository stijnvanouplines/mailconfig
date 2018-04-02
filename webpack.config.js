
let webpack = require('webpack')
let path = require('path')
let glob = require('glob')
let ExtractTextPlugin = require('extract-text-webpack-plugin')
let UglifyJsPlugin = require('uglifyjs-webpack-plugin')
var inProduction = (process.env.NODE_ENV === 'production')

module.exports = {
    entry: {
        app: [
            path.resolve(__dirname, 'src/js') + '/main.js',
            path.resolve(__dirname, 'src/scss') + '/main.scss',
        ]
    },
    output: {
        filename: 'js/[name].js',
        path: path.resolve(__dirname, 'dist/public/assets')
    },
    module: {
        rules: [
            {
                test: /\.(scss)$/,
                use: ExtractTextPlugin.extract({
                    use: ['css-loader', 'sass-loader'],
                    fallback: 'style-loader'
                })
            },
            {
                test: /\.(js)$/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                        plugins: ['@babel/plugin-proposal-object-rest-spread']
                    }
                }
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin('css/[name].css'),
        new webpack.ProvidePlugin({
            $: 'jquery',
            Popper: 'popper.js'
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: inProduction
        })
    ]
}

if (inProduction) {
    module.exports.optimization = {
        minimizer: [
            new UglifyJsPlugin({
                uglifyOptions: {
                    output: {
                        comments: false
                    }
                }
            })
        ]
    }
}
