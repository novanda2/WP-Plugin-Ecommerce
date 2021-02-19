const gulp = require('gulp');
const webpack = require('webpack-stream');
const { task, parallel } = gulp;

function clientjs(cb) {
    gulp.src('src/site/js/main.js')
        .pipe(webpack({
            watch: true,
            mode: 'production',
            output: { filename: 'main.js' }
        }))
        .pipe(gulp.dest('plugins/nvn-ecommerce/scripts/site/'));
    cb()
}


function adminjs(cb) {
    gulp.src('src/admin/js/main.js')
        .pipe(webpack({
            watch: true,
            mode: 'production',
            output: { filename: 'main.js' }
        }))
        .pipe(gulp.dest('plugins/nvn-ecommerce/scripts/admin/'));
    cb()
}


task('default', parallel(clientjs, adminjs));