<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * MAGIX CMS
 * @category   extends
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_social_network} function plugin
 *
 * Type:     function
 * Name:     widget_get_social
 * Date:     18-07-2011
 * Update:   01-08-2011
 * Purpose:  Display social bookmark
 * Examples:
     {widget_social_network 
  		config_param=[
  		'news'=>[{#topmenu_news_t#},$n_title],
  		'cms'=>[$title_page],
  		'catalog'=>[{#topmenu_catalog_t#},$clibelle,$slibelle,$titlecatalog],
  		'plugins'=>['contact'=>{#pn_contact_forms#}]
  		] size="medium" default=$subject}
 * Output:   
 * @link 	http://www.magix-dev.be
 * @author   Gerits Aurélien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_share_display($params, $template){

    // *** Load active script var
    // **************************

        // ***Catch Domain var
        $url['root']        =       magixcjquery_html_helpersHtml::getUrl();
        $url['relativ']     =       $_SERVER["REQUEST_URI"];
            //strrpos récupère la dernière occurence de / et de .
            $url['share'] = $url['root'].$url['relativ'];

        // *** Catch module's page name
        $smarty = frontend_config_smarty::getInstance();

            ///  identify active module
        $script['fileName'] = substr($_SERVER['SCRIPT_NAME'],1);
        $script['chartBeforeExt'] = strpos($script['fileName'], '.');
        $active_mod = substr($script['fileName'], 0, $script['chartBeforeExt']);

            /// Found good name for active module
            $name = null;
        switch($active_mod){
            case 'index':
                $name = $smarty->getTemplateVars('title'); // Catch meta Title content
            case 'catalog':
                if(isset($_GET['idproduct'])){
                    $name = $smarty->getTemplateVars('name_product'); // Catch meta Title content
                }elseif(isset($_GET['idcls'])){
                    $name = $smarty->getTemplateVars('name_subcat'); // Catch meta Title content
                }elseif(isset($_GET['idclc'])){
                    $name = $smarty->getTemplateVars('name_cat'); // Catch meta Title content
                }else{
                    $name = $smarty->getConfigVars('catalog_root_h1');
                }
                break;
            case 'cms':
                $name = $smarty->getTemplateVars('name_page');
                break;
            case 'news':
                if(isset($_GET['getnews'])){
                    $name = $smarty->getTemplateVars('name_news');
                }elseif(isset($_GET['tag'])){
                    $name = $smarty->getConfigVars('news_root_h1').': '.$_GET['tag'];
                }else{
                    $name = $smarty->getConfigVars('news_root_h1');
                }
                break;
            case 'plugin':
                $active_plugin = $_GET['magixmod'];
                switch($active_plugin){
                    case 'contact':
                        $name = $smarty->getConfigVars('contact_root_h1');
                    break;
                    default:
                        if(isset($_GET['pstring3']))
                            $name = ucfirst(str_replace('-',' ','pstring3'));
                        elseif(isset($_GET['pstring2']))
                            $name = ucfirst(str_replace('-',' ','pstring2'));
                        elseif(isset($_GET['pstring1']))
                            $name = ucfirst(str_replace('-',' ','pstring1'));
                        else
                            $name = $smarty->getConfigVars($active_mod.'_root_h1');
                }
        }

    // *** Set share data
    // ******************
    $name = str_replace(' ','%20',$name); // W3C validation require no ' ' in url
    $data = array (
      array(
          'name' => 'facebook',
          'url' => 'http://www.facebook.com/share.php?u='.$url['share'],
          'img' => 'facebook.png'
      ),
        array(
            'name' => 'twitter',
            'url' => 'https://twitter.com/intent/tweet?text='.$name.'&amp;url='.$url['share'],
            'img' => 'twitter.png'
        ),
        array(
            'name' => 'viadeo',
            'url' => 'http://www.viadeo.com/shareit/share/?url='.$url['share'].'&amp;title='.$name.'&amp;overview='.$name,
            'img' => 'viadeo.png'
        )
    );

    // *** Set htmlStruc
    // *****************
    $strucHtml = array(
        'container'     =>  array(
            'htmlBefore'    => '<ul class="nav">',
            // items injected here
            'htmlAfter'     => '</ul>'
        ),
        'item'          =>  array(
            'htmlBefore'    => '<li>',
            // item's elements injected here (name, img, descr)
            'htmlAfter'     => '</li>'
        ),
        'icon'         =>  array(
            'htmlBefore'    =>  ' ',
            'htmlAfter'     =>  ' '
        ),
        'name'        =>  array(
            'htmlBefore'    =>  ' ',
            'htmlAfter'     =>  ' '
        ),
        'iso'       =>  array(
            'htmlBefore'    => '(',
            'htmlAfter'     => ')'
        ),
        'current'     =>  array(
            'class'         =>  ' current'
        ),
        'last'        =>  array(
            'class'         => ' last',
            'col'           =>  1
        )
    );


    // *** Format share list
    // *********************
    $items = null;
    foreach ($data as $row){
        $icon = '<a id="share-'.$row['name'].'" class="targetblank shareLink" href="'.$row['url'].'">';
            $icon .= '<img src="'.'/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/share/'.$row['img'].'" alt="'.$row['name'].'" />';
        $icon .= '</a>';

        $items .= $strucHtml['item']['htmlBefore'];
        $items .= $icon;
        $items .= $strucHtml['item']['htmlAfter'];
    }

    $output = $strucHtml['container']['htmlBefore'];
    $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
    $output .=  $items;
    $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
    $output .= $strucHtml['container']['htmlAfter'];

	return $output;
}