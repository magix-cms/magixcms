'use strict';

var gulp = require('gulp'),
	fs = require('fs'),
	runSeq = require('run-sequence'),
	$ = require('gulp-load-plugins')({
		rename: {
			'gulp-ruby-sass': 'sass',
			'gulp-clean-css': 'cleanCSS',
			'gulp-uglify'   : 'compress'
		}
	});
	$.fs = fs;
	$.path = require('path');
	$.prompt = require('prompt');
	$.inquirer = require('inquirer');

/**
 * Get configuration
 */
var env = {
	config: JSON.parse(fs.readFileSync('./config.json'))
};

var workingdir = {}; // will be completed by the setWorkingDir function

/**
 * Set paths relative to the theme directory
 */
function setWorkingDir() {
	Object.keys(env.config.paths.themePath).map(function(k, i) {
		workingdir[k] = './' + env.config.paths.themePath[k];
	});
}

gulp.task('compile:all', function () {
	var css = env.config.cssProcessor === 'less'?'less':'scss';
	runSeq('bootstrap-js','vendors','js',css);
});

/**
 * Gulp task: bootstrap-js
 *
 * Compile bootstrap js files to bootstrap.min.js
 */
gulp.task('bootstrap-js', function () {
	gulp.src([
		env.workingDir.vendor + '/bootstrap/transition.js',
		env.workingDir.vendor + '/bootstrap/alert.js',
		//env.workingDir.vendor + '/bootstrap/button.js',
		env.workingDir.vendor + '/bootstrap/carousel.js',
		env.workingDir.vendor + '/bootstrap/collapse.js',
		env.workingDir.vendor + '/bootstrap/dropdown.js',
		env.workingDir.vendor + '/bootstrap/modal.js',
		env.workingDir.vendor + '/bootstrap/tooltip.js',
		//env.workingDir.vendor + '/bootstrap/popover.js',
		//env.workingDir.vendor + '/bootstrap/scrollspy.js',
		env.workingDir.vendor + '/bootstrap/tab.js'
		//env.workingDir.vendor + '/bootstrap/affix.js'
	])
		.pipe($.concat('bootstrap.js'))
		.pipe($.compress())
		.pipe($.rename({ suffix: '.min' }))
		.pipe($.header($.fs.readFileSync('Copyright'),{theme: {name: env.config.name, version: env.config.version, magixcms: env.config.magixcms}}))
		.pipe(gulp.dest(env.workingDir.vendor))
		.pipe(gulp.dest(env.config.paths.skins + '/' + env.config.name + '/js/vendor'));

	gulp.src([
		env.workingDir.vendor + '/bootstrap/transition.js',
		env.workingDir.vendor + '/bootstrap/alert.js',
		//env.workingDir.vendor + '/bootstrap/button.js',
		//env.workingDir.vendor + '/bootstrap/carousel.js',
		env.workingDir.vendor + '/bootstrap/collapse.js',
		env.workingDir.vendor + '/bootstrap/dropdown.js',
		env.workingDir.vendor + '/bootstrap/modal.js',
		//env.workingDir.vendor + '/bootstrap/tooltip.js',
		//env.workingDir.vendor + '/bootstrap/popover.js',
		//env.workingDir.vendor + '/bootstrap/scrollspy.js',
		env.workingDir.vendor + '/bootstrap/tab.js'
		//env.workingDir.vendor + '/bootstrap/affix.js'
	])
		.pipe($.concat('bootstrap-mobile.js'))
		.pipe($.compress())
		.pipe($.rename({ suffix: '.min' }))
		.pipe($.header($.fs.readFileSync('Copyright'),{theme: {name: env.config.name, version: env.config.version, magixcms: env.config.magixcms}}))
		.pipe(gulp.dest(env.workingDir.vendor))
		.pipe(gulp.dest(env.config.paths.skins + '/' + env.config.name + '/js/vendor'));
});

/**
 * Gulp task: vendors
 *
 * Compile js vendor sources into .min
 */
gulp.task('vendors', function () {
	gulp.src(env.workingDir.vendorSrc + '/*.js')
		.pipe($.compress())
		.pipe($.rename({ suffix: '.min' }))
		.pipe($.header($.fs.readFileSync('Copyright'),{theme: {name: env.config.name, version: env.config.version, magixcms: env.config.magixcms}}))
		.pipe(gulp.dest(env.workingDir.vendor))
		.pipe(gulp.dest(env.config.paths.skins + '/' + env.config.name + '/js/vendor'));
});

/**
 * Gulp task:js
 *
 * Compile js sources into .min
 */
gulp.task('js', function () {
	gulp.src(env.workingDir.jsSrc + '/*.js')
		.pipe($.compress())
		.pipe($.rename({ suffix: '.min' }))
		.pipe($.header($.fs.readFileSync('Copyright'),{theme: {name: env.config.name, version: env.config.version, magixcms: env.config.magixcms}}))
		.pipe(gulp.dest(env.workingDir.js))
		.pipe(gulp.dest(env.config.paths.skins + '/' + env.config.name + '/js'));
});

/**
 * Gulp task: scss
 *
 * Compile scss files into .min.css
 */
gulp.task('scss', function () {
	var globs, msg;
	if (typeof $.util.env.cssFile == 'undefined') {
		msg = 'Compilation and Minification of all css files';
		globs = [env.workingDir.less + '/style.less', env.workingDir.less + '/mobile.less'];
	}
	else {
		msg = 'Compilation and Minification of ' + $.util.env.cssFile + '.css';
		globs = env.workingDir.less + '/' + $.util.env.cssFile + '.less';
	}

	return $.sass(globs, {
		style: 'compressed',
		loadPath: [
			env.workingDir.scss,
			env.workingDir.css + '/bootstrap/scss',
			env.workingDir.css + '/font-awesome/scss'
		]
	})
		.on("error", notify.onError(function (error) {
			return "Error: " + error.message;
		}))
		.pipe($.notify(msg))
		.pipe($.rename({ suffix: '.min' }))
		.pipe($.header($.fs.readFileSync('Copyright'),{theme: {name: env.config.name, version: env.config.version, magixcms: env.config.magixcms}}))
		.pipe(gulp.dest(env.workingDir.css));
});

/**
 * Gulp task: less
 *
 * Compile less files into .min.css
 */
gulp.task('less', function () {
	var globs, msg;
	if (typeof env.config.cssFile === 'undefined') {
		msg = 'Compilation and Minification of all css files';
		globs = [env.workingDir.less + '/style.less', env.workingDir.less + '/mobile.less'];
	}
	else {
		msg = 'Compilation and Minification of ' + env.config.cssFile + '.css';
		globs = env.workingDir.less + '/' + env.config.cssFile + '.less';
	}

	return gulp.src(globs)
		.pipe($.notify(msg))
		.pipe($.less({
			paths: [
				env.workingDir.less,
				env.workingDir.css + '/bootstrap/less',
				env.workingDir.css + '/font-awesome/less',
				env.workingDir.css + '/fancybox'
			],
			compress: true
		}))
		.pipe($.rename({ suffix: '.min' }))
		.pipe($.header($.fs.readFileSync('Copyright'),{theme: {name: env.config.name, version: env.config.version, magixcms: env.config.magixcms}}))
		.pipe(gulp.dest(env.workingDir.css))
		.pipe(gulp.dest(env.config.paths.skins + '/' + env.config.name + '/css'));
});

/**
 * gulp Task: watch-css
 *
 * File watcher for CSS files
 */
gulp.task('watch-css', function () {
	if(env.config.cssProcessor === 'less'
		|| env.config.cssProcessor === 'scss')
	{
		var srcPath = workingdir.cssSrc + '/' + env.config.cssProcessor;
		gulp.watch([
			srcPath + '/style.' + env.config.cssProcessor,
			srcPath + '/**/*.' + env.config.cssProcessor,
			'!' + srcPath + 'custom/critical/mobile/*.' + env.config.cssProcessor,
			'!' + srcPath + 'custom/theme/mobile/*.' + env.config.cssProcessor,
			'!' + srcPath + '/mobile.' + env.config.cssProcessor
		], [(env.config.cssProcessor)]).on('change', function() { env.config.cssFile = 'style'; });
		gulp.watch([
			srcPath + '/mobile.' + env.config.cssProcessor,
			srcPath + '/**/*.' + env.config.cssProcessor,
			'!' + srcPath + 'custom/critical/**/*.' + env.config.cssProcessor,
			'!' + srcPath + 'custom/theme/**/*.' + env.config.cssProcessor,
			srcPath + 'custom/critical/mobile/*.' + env.config.cssProcessor,
			srcPath + 'custom/theme/mobile/*.' + env.config.cssProcessor,
			'!' + srcPath + '/style.' + env.config.cssProcessor
		], [(env.config.cssProcessor)]).on('change', function() { env.config.cssFile = 'mobile'; });
	}
});

/**
 * gulp Task: watch-vendors
 *
 * File watcher for JS Vendors files
 */
gulp.task('watch-vendors', function () {
	gulp.watch(workingdir.vendors + '/bootstrap/**/*.js', ['bootstrap-js']);
	gulp.watch(workingdir.vendorsSrc + '/**/*.js', ['vendors']);
});

/**
 * gulp Task: watch-js
 *
 * File watcher for JS files
 */
gulp.task('watch-js', function () {
	gulp.watch(workingdir.jsSrc + '/**/*.js', ['js']);
});

// --- All Watchers
/**
 * Gulp Task: watch
 *
 * Start file watchers for a theme
 *
 * If the theme does not exist,
 * it propose to create it
 */
gulp.task('watch', function (cb) {
	setWorkingDir();
	runSeq(['watch-css', 'watch-vendors', 'watch-js'], cb);
});

/**
 * Default Gulp task
 *
 * Ask for user what he want to do between:
 * - Start file watchers
 * - Update version
 * - Never mind
 */
gulp.task('default', function (cb) {
	var task_choices = [
		{
			type: "list",
			name: "task",
			message: "What do you want to do ?",
			choices: [
				{
					name: "Start file watchers",
					value: "watch"
				},
				{
					name: "Compile all file types",
					value: "compile:all"
				},
				new $.inquirer.Separator(),
				{
					name: "Update version",
					value: "patch"
				},
				new $.inquirer.Separator(),
				{
					name: "Never mind",
					value: "closing"
				}
			]
		}
	];
	$.inquirer.prompt(task_choices).then(function(result) {
		// Check if bower is installed
		runSeq(result.task, cb);
	});
});