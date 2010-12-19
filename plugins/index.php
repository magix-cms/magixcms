<?php
header('HTTP/1.1 403 Forbidden');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// last modified (good for caching)
$time = time() - 60; // or filemtime($fn), etc
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $time).' GMT');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
die("You don't have permission to access plugins on this server.");
?>