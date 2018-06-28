let gulp = require('gulp');
let sass = require('gulp-sass');
let concat = require('gulp-concat');
let minify = require('gulp-minify');
let cleanCSS = require('gulp-clean-css');
let uglifycss = require('gulp-uglifycss');
let plumber = require('gulp-plumber');

gulp.task('sass', function () {
    return gulp.src('./assets/css/app.scss')
        .pipe(sass().on('error', sass.logError))
        // .pipe(cleanCSS({compatibility: 'edge'}))
        // .pipe(uglifycss({
        //     "maxLineLen": 80,
        //     "uglyComments": true
        // }))
        .pipe(gulp.dest('./public/build/css'));
});

gulp.task('sassAdmin', function () {
    return gulp.src('./assets/adminCss/app.scss')
        .pipe(sass().on('error', sass.logError))
        // .pipe(cleanCSS({compatibility: 'edge'}))
        // .pipe(uglifycss({
        //     "maxLineLen": 80,
        //     "uglyComments": true
        // }))
        .pipe(gulp.dest('./public/build/adminCss'));
});

gulp.task('scriptsCompact', function() {
    return gulp.src('./assets/js/compact/**/*')
        .pipe(plumber())
        .pipe(concat('compact.js'))
        .pipe(minify())
        .pipe(gulp.dest('./public/build/js/compact'));
});

gulp.task('scriptsScattered', function() {
    return gulp.src('./assets/js/scattered/**/*')
        .pipe(plumber())
        .pipe(minify())
        .pipe(gulp.dest('./public/build/js/scattered'));
});

gulp.task('watch', function () {
    gulp.watch('./assets/**/*', ['sass', 'sassAdmin'
        // ,'scriptsCompact','scriptsScattered'
    ]);
});