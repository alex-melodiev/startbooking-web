
var path = require('path');
module.exports = {
    devServer: {
        //host: '0.0.0.0',//your ip address
        port: 8000,
        //disableHostCheck: true,
        proxy: 'https://startbooking.octopus.uz',
    },
  transpileDependencies: ["vuex-persist"],
  pluginOptions: {
    i18n: {
      locale: 'ru',
      fallbackLocale: 'ru',
      localeDir: 'locales',
      enableInSFC: true
    },
    svgSprite: {
        /*
          * The directory containing your SVG files.
          */
        dir: 'src/assets/icons',
        /*
          * The reqex that will be used for the Webpack rule.
          */
        test: /\.(svg)(\?.*)?$/,
        /*
          * @see https://github.com/kisenka/svg-sprite-loader#configuration
          */
        loaderOptions: {
            extract: true,
            spriteFilename: 'img/icons.[hash:8].svg' // or 'img/icons.svg' if filenameHashing == false
        },
        /*
          * @see https://github.com/kisenka/svg-sprite-loader#configuration
          */
        pluginOptions: {
            plainSprite: true
        }
    }
  },
  chainWebpack: config => {
    config.module
      .rule('svg-sprite')
      .use('svgo-loader')
      .loader('svgo-loader')
  }
};
