'use strict';

import gulp from 'gulp';
import sass from 'gulp-sass';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import sourcemaps from 'gulp-sourcemaps';
import livereload from 'gulp-livereload';
import babel from 'gulp-babel';
import concat from 'gulp-concat';

const dirs = {
    sassSrc: 'sass',
    sassDest: './css',
    jsSrc: 'js',
    jsDest: 'js/min'
};

const sassPaths = {
    src: `${dirs.sassSrc}/**/*.scss`,
    dest: `${dirs.sassDest}/`
};

const jsPaths = {
    src: `${dirs.jsSrc}/*.js`,
    dest: `${dirs.jsDest}/`
};

gulp.task('css', () => {
  return gulp.src(sassPaths.src)
    .pipe(sass().on('error', sass.logError))
    .pipe(sourcemaps.init())
    .pipe(postcss([ autoprefixer({ browsers: ['last 2 versions'] }) ]))
    .pipe(sourcemaps.write(`./${sassPaths.dest}`))
    .pipe(gulp.dest(sassPaths.dest))
    .pipe(livereload());
});

gulp.task('js', () => {
   return gulp.src(jsPaths.src)
       .pipe(sourcemaps.init())
       .pipe(babel())
       .pipe(concat("all.js"))
       .pipe(sourcemaps.write('.'))
       .pipe(gulp.dest(jsPaths.dest))
       .pipe(livereload());
});

gulp.task('default', () => {
    livereload.listen();
    gulp.watch(sassPaths.src, ['css']);
    gulp.watch(jsPaths.src, ['js']);
});
