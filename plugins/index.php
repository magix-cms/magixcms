<?php 
$magixjquery = $_SERVER['DOCUMENT_ROOT'].'/lib/magixcjquery/_common.php';
if (file_exists($magixjquery)) {
	require $magixjquery;
}else{
	print 'Error lib';
	exit;
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Location:".magixcjquery_html_helpersHtml::getUrl());
// Access forbidden:
//header('HTTP/1.1 403 Forbidden');
exit;
?>