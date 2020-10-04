const gulp = require('gulp');
const sass = require('gulp-sass');
const rename = require('gulp-rename');

sass.compiler = require('node-sass');

function style() {
  return gulp
    .src('./src/sass/*.scss')
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(rename('style.css'))
    .pipe(gulp.dest('./public/css/'));
}

function watch() {
  style();

  gulp.watch('./src/sass/*.scss', style);
}

exports.watch = watch;
