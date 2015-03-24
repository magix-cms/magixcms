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
 * Smarty {widget_share_display} function plugin
 *
 * Type:     function
 * Name:     widget_share_display
 * Date:     04/01/2012
 * Update:   12/01/2013
 * Output:
 * @author   Sire Sam (http://www.sire-sam.be)
 * @author   Gerits Aurélien (http://www.magix-dev.be)
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * <ul id="share-box" class="nav navbar-nav navbar-right">
    <li>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <span class="glyphicon glyphicon-share">&nbsp;</span>
    <span class="dropdown-text">
    {#share#|ucfirst}
    </span>
    </a>
    {widget_share_display
    htmlStructure=[
    'container' => [
    'before' => '<ul id="share-nav" class="dropdown-menu">',
    'after' => '</ul>'
    ]
    ]
    }
    </li>
    </ul>
 */
function smarty_function_widget_share_display($params, $template){

    // *** Load active script var
        // ** Catch Domain var
        $url['root']        =       magixcjquery_html_helpersHtml::getUrl();
        $url['relativ']     =       $_SERVER["REQUEST_URI"];
            //strrpos récupère la dernière occurence de / et de .
            $url['share'] = $url['root'].$url['relativ'];

        // ** Catch module's page name
        $smarty = frontend_model_smarty::getInstance();

        // ** find active module
        $script['fileName'] = substr($_SERVER['SCRIPT_NAME'],1);
        $script['chartBeforeExt'] = strpos($script['fileName'], '.');
        $active_mod = substr($script['fileName'], 0, $script['chartBeforeExt']);

        // ** set active module name
        $name = null;
        switch($active_mod){
            case 'index':
                $name = $smarty->getTemplateVars('title');
                break;
            case 'catalog':
                if(isset($_GET['idproduct'])){
                    $productData = $smarty->getTemplateVars('product');
                    $name = $productData['name'];
                }elseif(isset($_GET['idcls'])){
                    $subcatData = $smarty->getTemplateVars('subcat');
                    $name = $subcatData['name'];
                }elseif(isset($_GET['idclc'])){
                    $catData = $smarty->getTemplateVars('cat');
                    $name = $catData['name'];
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
    $name = str_replace(' ','%20',$name); // W3C validation require no ' ' in url
    $data_default = array (
      'facebook' => array(
          'name' => 'facebook',
          'url' => 'http://www.facebook.com/share.php?u='.$url['share'],
          'img' => 'facebook.png'
      ),
      'twitter' =>  array(
            'name' => 'twitter',
            'url' => 'https://twitter.com/intent/tweet?text='.$name.'&amp;url='.$url['share'],
            'img' => 'twitter.png'
        ),
        'viadeo' => array(
            'name' => 'viadeo',
            'url' => 'http://www.viadeo.com/shareit/share/?url='.$url['share'].'&amp;title='.$name.'&amp;overview='.$name,
            'img' => 'viadeo.png'
        ),
        'google' => array(
            'name' => 'google',
            'url' => 'https://plus.google.com/share?url='.$url['share'],
            'onclick' => 'javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;',//TODO Prendre en charge dans le formatage
            'img' => 'google.png'
        )
    );

        // ** Select Data
        if (isset($params['dataSelect']['context'])){
            $dataSelect = explode(',',$params['dataSelect']['context']);
            foreach($dataSelect as $share){
                if(array_key_exists($share,$data_default)){
                    $data[] = $data_default[$share];
                }
            }
        }else{
            $data = $data_default;
        }

    // *** Set default html structure
    $strucHtml_default = array(
        'container'     =>  array(
            'before'    => '<ul>',
            // items injected here
            'after'     => '</ul>'
        ),
        'item'          =>  array(
            'before'    => '<li>',
            // item's elements injected here (name, img, descr)
            'after'     => '</li>'
        ),
        'img'         =>  array(
            'before'    =>  ' ',
            'after'     =>  ' '
        ),
        'name'        =>  array(
            'before'    =>  ' ',
            'after'     =>  ' '
        ),
        'current'     =>  array(
            'class'         =>  ' current'
        ),
        'last'        =>  array(
            'class'         => ' last',
            'col'           =>  1
        )
    );

        // ** Set default elem to display
        $strucHtml_default['allow']     = array('', 'name', 'img');
        $strucHtml_default['display']   = array(
            1 =>    array('','img', 'name')
        );

        // ** Update html struct & item setting with custom var (params['htmlStructure'])
        $custom = ($params['htmlStructure']) ? $params['htmlStructure'] : null;
        $default = $strucHtml_default;
        if (is_array($custom)){
            $default['display'] = array();
            foreach($custom AS $k => $v){
                foreach($v AS $sk => $sv){
                    if ($sv != null){
                        $default[$k][$sk] = $sv;
                    }
                }
                if (array_search($k,$default['allow']))
                    $default['display'][1][] = $k;
            }
        }

        // ** Update html struct with display params (params['htmlDisplay'])
        if(isset($params['htmlDisplay']))
            $default['display'] = $params['htmlDisplay'];

            // * push null value on case[0] (allow array search on format function)
            foreach($default['display'] AS $k => $v){
                array_unshift($default['display'][$k],null);
            }
            $strucHtml = $default;

        // ** in cas diplay is null, we take default value
        if ($strucHtml['display'][1] == null)
            $strucHtml['display'][1] = $strucHtml_default['display'][1];

    // *** Set translation var
    $t_share_on = frontend_model_template::getConfigVars('share_on');

    // *** format items loop (foreach item)
    $items = null;
    foreach ($data as $row){
        // ** format item loop (foreach element)
        $elem = null;
        foreach ($strucHtml['display'][1] as $elem_type ){
            if(array_search($elem_type,$strucHtml['display'][1])){
                switch($elem_type){
                    case 'name':
                        $elem .= ucfirst($row['name']);
                        break;
                    case 'img':
                        $elem .= '<img src="'.'/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/share/'.$row['img'].'" alt="'.$row['name'].'" />';
                }
            }
        }
        // ** item construct
        $items .= $strucHtml['item']['before'];
            $items .= '<a id="share-'.$row['name'].'" class="targetblank" href="'.$row['url'].'" title="'.ucfirst($t_share_on).': '.$row['name'].'">';
                $items .= $elem;
            $items .= '</a>';
        $items .= $strucHtml['item']['after'];
    }
    // *** container construct
    $output = $strucHtml['container']['before'];
        $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
            $output .=  $items;
        $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
    $output .= $strucHtml['container']['after'];

	return $output;
}
