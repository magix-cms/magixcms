var gulp = require("gulp"),
    clean = require("gulp-clean"),
    concat = require("gulp-concat"),
    rename = require("gulp-rename"),
    replace = require("gulp-replace"),
    uglify = require("gulp-uglify"),
    minifyCss = require("gulp-minify-css"),
    zip = require("gulp-zip");

/**
 * Remove dist directory
 */
gulp.task("clean", function () {
    return gulp.src("dist", {read: false}).pipe(clean());
});

/**
 * generate plugin.min.js
 */
gulp.task("plugin", function () {
    return gulp
        .src("plugin.js")
        .pipe(uglify({preserveComments: "some"}))
        .pipe(rename("plugin.min.js"))
        .pipe(gulp.dest("tmp/"));
});

/**
 * Concat and minify CSS
 */
gulp.task("css", function () {
    return gulp
        .src(["styles.min.css"])
        .pipe(concat("styles.css"))
        .pipe(minifyCss())
        .pipe(gulp.dest("tmp/css/"));
});

/**
 * Build distribuable package
 **/
gulp.task("dist", ["clean", "css", "plugin"], function () {
    return gulp
        .src([
            "img/**/*",
            "langs/**/*",
            "tmp/**/*",
			"css/**/*",
            "LICENCE",
            "plugin.js",
            "README.md"
        ], {base: "."})
        .pipe(rename(function (path) {
            path.dirname = "fontawesome/" + path.dirname.replace(/^tmp\/*/, "");
        }))
        .pipe(zip("fontawesome.zip"))
        .pipe(gulp.dest("dist/"))
});

/**
 * Build and remove temps
 */
gulp.task("default", ["dist"],  function () {
    return gulp.src("tmp", {read: false}).pipe(clean());
});