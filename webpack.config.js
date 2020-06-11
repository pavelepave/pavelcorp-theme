const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = {
  entry: {
    main: "./src/index.js",
    notFound: "./src/404.js",
  },
  output: {
    path: path.join(__dirname, "/wordpress/wp-content/themes/pavelcorp"),
    filename: "js/custom/[name].pavelcorp.js",
    chunkFilename: "js/custom/[name].pavelcorp.js",
    publicPath: "/wp-content/themes/pavelcorp/"
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: ["babel-loader"]
      },
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader'],
      },
      {
        test: /\.scss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader, 
          },
          "css-loader", 
          {
            loader: 'postcss-loader',
            options: {
              ident: 'postcss',
              plugins: [
                require('autoprefixer')({grid: true})
              ]
            }
          },
          "sass-loader"
        ]
      },
      {
        test: /\.(jpg|png|svg|gif)$/,
        use: {
          loader: 'file-loader',
          options: {
            name: '[path][name].[ext]',
            outputPath: 'img/',
            publicPath: '/wp-content/themes/pavelcorp/img/',
            context: 'src/images'
          }
        }
      },
      {
        test: /\.(woff(2)?|otf|ttf|eot)(\?v=\d+\.\d+\.\d+)?$/,
        use: {
          loader: 'file-loader',
          options: {
            name: '[name].[ext]',
            outputPath: 'fonts/',
            publicPath: '/wp-content/themes/pavelcorp/fonts/'
          }
        }
      }
    ]
  },
  optimization: {
    minimizer: [
      new UglifyJsPlugin({
        cache: true,
        parallel: true,
        sourceMap: true // set to true if you want JS source maps
      }),
      new OptimizeCSSAssetsPlugin({})
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "css/custom/[name].css"
    })
  ]
};