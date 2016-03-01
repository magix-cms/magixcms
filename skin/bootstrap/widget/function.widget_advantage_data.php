<?php
function smarty_function_widget_advantage_data($params, $template){
    plugins_Autoloader::register();
    $collection = new plugins_advantage_public();

    $template->assign('advantages',$collection->getAdvs());;
}
?>