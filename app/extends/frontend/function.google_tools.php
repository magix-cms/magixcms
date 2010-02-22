<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {google_tools} function plugin
 *
 * Type:     function
 * Name:     google_tools
 * Date:     Décember 18, 2009
 * Purpose:  
 * Examples: {google_tools}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_google_tools($params, &$smarty){
	$data = frontend_db_googletools::publicDbGtools()->s_google_tools_widget();
	$type = $params['tools'];
	switch ($type){
		case 'analytics':
		$tools = '<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
		</script>'.
		'<script type="text/javascript">
		try {
		var pageTracker = _gat._getTracker("'.$data['analytics'].'");
		pageTracker._trackPageview();
		} catch(err) {}</script>';
			break;
		case 'webmaster':
			$tools = $data['webmaster'];
			break;
	}
	return $tools;
}