const path = require('path')

const pathBase = path.join(__dirname, 'resources', 'adminfx');
const pathPublic = path.join(pathBase, 'public');

module.exports = {
  outputDir: "./public/adminfx",
  publicPath: "/adminfx",
  chainWebpack: config => {
    config.plugin('copy').tap(args => {
      let [options] = args;
      options[0].from = pathPublic;
      return args;
    });
    config.plugin('html').tap(args => {
      args[0].template = path.join(pathPublic, 'index.html');
      return args;
    });
  },
  configureWebpack: {
    devtool: 'inline-source-map',
    performance: {
      hints: false,
      maxEntrypointSize: 512000,
      maxAssetSize: 512000
    },
    resolve: {
      alias: {
        '@': pathBase
      }
    },
    entry: {
      app: path.join(pathBase, 'main.js')
    }
  }
}
