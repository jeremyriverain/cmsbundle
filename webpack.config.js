var webpack = require('webpack');

var glob = require('glob');
var path = require('path');
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var CleanWebpackPlugin = require('clean-webpack-plugin');
var ManifestPlugin = require('webpack-manifest-plugin');
var BabelWebpackPlugin = require('babel-minify-webpack-plugin');

var inProduction = (process.env.NODE_ENV === 'production');

module.exports = {
  target: 'web',
  entry: {
    'app' : [
      './src/assets/js/app.js',
      './src/assets/css/app.scss'
    ],
  },
  resolve: {
    alias: {
      Web: path.resolve(__dirname, 'src/Resources/public'),
    }

  },
  output: {
    path: path.resolve(__dirname, './src/Resources/public/build'),
    filename: '[name].[chunkhash].js'
  },
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/,
        use: ExtractTextPlugin.extract({
          use: [{
            loader: "css-loader"
          }, {
            loader: "postcss-loader"
          }, {
            loader: "resolve-url-loader"
          },
            {
              loader: "sass-loader", options: {
                sourceMap: true,
              }
            }],

          fallback: 'style-loader'
        })
      },
      {
        test: /\.(svg|eot|ttf|woff|woff2)$/,
        loader: 'file-loader',
        options: {
          name: 'fonts/[name].[hash].[ext]'
        }
      },

      {
        test: /\.(png|je?pg|gif)$/,
        loader: 'file-loader',
        options: {
          name: 'images/[name].[hash].[ext]'
        }
      },
      { 
        test: /\.js$/, 
        exclude: /node_modules/, 
        use: {
          loader: 'babel-loader',
          options: {
            presets: ["env"]
          }
        }
      }

    ]
  },
  plugins: [

    new ExtractTextPlugin('[name].[chunkhash].css'),
    new webpack.LoaderOptionsPlugin({
      minimize: inProduction
    }),
    new CleanWebpackPlugin(['public/build'], {
      root: __dirname,
      verbose: true,
      dry: false
    }),
    new ManifestPlugin({
      basePath: 'build/'
    }),
    new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
      "window.jQuery": "jquery",
    }),
    new webpack.DefinePlugin({
      'process.env': {
        NODE_ENV: '"production"'
      }
    })

  ],
};

if (inProduction) {
  module.exports.plugins.push( 
    new BabelWebpackPlugin()
  );
}
