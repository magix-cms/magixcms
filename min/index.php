<?php
/**
 * Front controller for default Minify implementation
 *
 * DO NOT EDIT! Configure this utility via config.php and groupsConfig.php
 *
 * @package Minify
 */

define('MINIFY_MIN_DIR', dirname(__FILE__));

// load config
require MINIFY_MIN_DIR . '/config.php';

// setup include path
set_include_path($min_libPath . PATH_SEPARATOR . get_include_path());

require 'Minify.php';

Minify::$uploaderHoursBehind = $min_uploaderHoursBehind;
Minify::setCache(
isset($min_cachePath) ? $min_cachePath : ''
,$min_cacheFileLocking
);

if ($min_documentRoot) {
	$_SERVER['DOCUMENT_ROOT'] = $min_documentRoot;
} elseif (0 === stripos(PHP_OS, 'win')) {
	Minify::setDocRoot(); // IIS may need help
}

$min_serveOptions['minifierOptions']['text/css']['symlinks'] = $min_symlinks;

if ($min_allowDebugFlag && isset($_GET['debug'])) {
	$min_serveOptions['debug'] = true;
}

if ($min_errorLogger) {
	require_once 'Minify/Logger.php';
	if (true === $min_errorLogger) {
		require_once 'FirePHP.php';
		Minify_Logger::setLogger(FirePHP::getInstance(true));
	} else {
		Minify_Logger::setLogger($min_errorLogger);
	}
}

// check for URI versioning
if (preg_match('/&\\d/', $_SERVER['QUERY_STRING'])) {
	$min_serveOptions['maxAge'] = 86400 * 7;
}
if (isset($_GET['g'])) {
	// well need groups config
	$min_serveOptions['minApp']['groups'] = (require MINIFY_MIN_DIR . '/groupsConfig.php');
}
if (isset($_GET['f']) || isset($_GET['g'])) {
	// serve!
	Minify::serve('MinApp', $min_serveOptions);
	if (isset($_GET['g'])) {
	    switch ($_GET['g']) {
	    case 'js' : $min_serveOptions['maxAge'] = 86400 * 7;
	                break;
	    case 'css': $min_serveOptions['contentTypeCharset'] = 'UTF-8';
	                break;
	    }
	}
}elseif ($min_enableBuilder) {
	header('Location: builder/');
	exit();
} 
