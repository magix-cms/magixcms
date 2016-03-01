<?php
function smarty_function_widget_about_data($params, $template){
    plugins_Autoloader::register();
    $collection = new plugins_about_public();

    $template->assign('about',$collection->getAbout());
    $template->assign('companyData',$collection->getData());
}
?>