<?php
/**
 * Smarty {baseadmin} function plugin
 *
 * Type:     function
 * Name:     baseadmin
 * Date:     01/12/2012 19:07
 * Purpose:  Récupère L'URL de l'admin.
 * Examples: {baseadmin}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_script_name($params, $template){
    $array_files = array(
        "home"=>"home",
        "cms"=>"cms",
        "news"=>"news",
        "catalog"=>"catalog",
        "plugins"=>"plugins"
    );
    $filename = substr($_SERVER['SCRIPT_NAME'],1);
    $position = strpos($filename, '.');
    $attribute =  substr($filename, 0, $position);
    $basename = substr($attribute, strpos($filename, '/')+1);
    if(array_key_exists($basename,$array_files)){
        if($basename === 'catalog'){
            if(isset($_GET['section'])){
                if($_GET['section'] === 'category'){
                    return $basename.':category';
                }elseif($_GET['section'] === 'subcategory'){
                    return $basename.':subcategory';
                }elseif($_GET['section'] === 'product'){
                    return $basename.':product';
                }
            }
        }elseif($basename === 'plugins'){
            if(isset($_GET['name'])){
                return $basename.':'.$_GET['name'];
            }
        }else{
            return $basename;
        }
    }
}