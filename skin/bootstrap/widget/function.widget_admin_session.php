<?php
function smarty_function_widget_admin_session($params, $template){
	plugins_Autoloader::register();
	$collection = new plugins_adminpanel_public();

	$template->assign('displayAdminPanel',$collection->checkAdminSession());
}
?>