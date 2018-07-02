var webpack = require('webpack'),
path = require('path');

 var srcPath  = path.join(__dirname, '/src/js'),
  distPath = path.join(__dirname, '/assets/js');


  module.exports = {

  // cache: true,
    // devtool: '#cheap-module-eval-source-map',
    context: srcPath,
    module: {

      rules: [
      {
        test: /\.js$/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['es2015']
          }
        }
      }
      ]
    },
    entry: {
      wp_voting: ['./wp_voting.js'],
      wp_voting_frontend: ['./wp_voting_frontend.js'],
      wp_voting_tinymce_btn: ['./wp_voting_tinymce_btn.js'],
      wp_voting_vote: ['./wp_voting_vote.js']
    },
    output: {
      path: distPath,
      filename: '[name].min.js',
    },
  //   // plugins: [
  //   // new webpack.ProvidePlugin({
  //   //   $: "jquery",
  //   //   jQuery: "jquery",
  //   //   "window.jQuery": "jquery"
  //   // })
  //   // ]
    externals: {
      jquery: 'jQuery'
    }
  //   // resolve: {
  //   //     modules: ["node_modules"],
  //   // },

 };
