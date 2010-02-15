<?php
/**
 * @category   Smarty Plugin
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com - http://www.magix-cms.be)
 * @license    Proprietary software
 * @version    1.0 2009-10-29
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {magixmin} {literal} {/literal}{/magixmin}function plugin
 *
 * Type:     prefilter
 * Name:     magixmin
 * Date:     Octobre 29, 2009
 * Purpose:  Compresse le javascript avec jshrink
 * Examples: {magixmin}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_prefilter_magixmin($source, &$smarty){
    $source = preg_replace_callback(
        '|\{magixmin\}(.*?)\{\/magixmin\}|s',
        'smarty_prefilter_magixmin_callback',
        $source
    );
    return $source;
}
function smarty_prefilter_magixmin_callback($matches){
    $comp = new magixcjquery_compjs_minify();
    $comp->_optionsJShrink();
    return $comp->jscompressor('jshrink',$matches[1]);
    //return magixcjquery_compjs_minify::iniJShrink($matches[1],true);
}
?>