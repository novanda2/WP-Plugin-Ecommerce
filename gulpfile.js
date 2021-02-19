const gulp = require('gulp');
const webpack = require('webpack-stream');
const { task, parallel } = gulp;

const webpackConfig = {
    watch: true,
    mode: 'production',
    output: { filename: 'main.js' },
    module: {
        rules: [
            {
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'] 
                    }
                }
            }
        ]
    }
}

function clientjs(cb) {
    gulp.src('src/site/js/main.js')
        .pipe(webpack(webpackConfig))
        .pipe(gulp.dest('plugins/nvn-ecommerce/scripts/site/'));
    cb()
}


function adminjs(cb) {
    gulp.src('src/admin/js/main.js')
        .pipe(webpack(webpackConfig))
        .pipe(gulp.dest('plugins/nvn-ecommerce/scripts/admin/'));
    cb()
}


task('default', parallel(clientjs, adminjs));