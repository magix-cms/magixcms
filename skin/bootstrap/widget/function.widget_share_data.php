<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2015 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_share_data} function plugin
 *
 * Type:     function
 * Name:     widget_share_data
 * Date:     24/03/2015
 * Update:
 * Output:
 * @author   Gerits Aurélien (http://www.magix-cms.com)
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * @example
 *
    {widget_share_data
        assign="shareData"
    }
 OR
    {widget_share_data
        exclude=["viadeo","linkedin"]
        assign="shareData"
    }
    <ul id="share-box" class="nav navbar-nav navbar-right">
        <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-share">&nbsp;</span>
                <span class="dropdown-text">
                {#share#|ucfirst}
                </span>
            </a>
            <ul id="share-nav" class="dropdown-menu">
                {include file="section/loop/share.tpl" data=$shareData}
            </ul>
        </li>
    </ul>
 * LOOP
{if is_array($data) && !empty($data)}
    {foreach $shareData as $item}
        <li>
            <a class="targetblank" href="{$item.url}" title="{#share_on#|ucfirst} {$item.name|ucfirst}">
                <img src="/skin/{template}/img/share/{$item.img}" alt="{$item.name|ucfirst}" /> {$item.name|ucfirst}
            </a>
        </li>
    {/foreach}
    {/if}
 * OR
{if is_array($data) && !empty($data)}
    {foreach $shareData as $item}
        <li>
        <a class="targetblank" href="{$item.url}" title="{#share_on#|ucfirst} {$item.name|ucfirst}">
            <span class="fa fa-{$item.font}-square"></span>
        </a>
        </li>
    {/foreach}
{/if}
 */
function smarty_function_widget_share_data($params, $template)
{
    // *** Load active script var
    // ** Catch Domain var
    $url['root'] = magixcjquery_html_helpersHtml::getUrl();
    $url['relativ'] = $_SERVER["REQUEST_URI"];
    //strrpos récupère la dernière occurence de / et de .
    $url['share'] = $url['root'] . $url['relativ'];

    // ** Catch module's page name
    $smarty = frontend_model_smarty::getInstance();

    // ** find active module
    $script['fileName'] = substr($_SERVER['SCRIPT_NAME'], 1);
    $script['chartBeforeExt'] = strpos($script['fileName'], '.');
    $active_mod = substr($script['fileName'], 0, $script['chartBeforeExt']);
    // ** set active module name
    $name = null;
    switch ($active_mod) {
        case 'index':
            $name = $smarty->getTemplateVars('title');
            break;
        case 'catalog':
            if (isset($_GET['idproduct'])) {
                $productData = $smarty->getTemplateVars('product');
                $name = $productData['name'];
            } elseif (isset($_GET['idcls'])) {
                $subcatData = $smarty->getTemplateVars('subcat');
                $name = $subcatData['name'];
            } elseif (isset($_GET['idclc'])) {
                $catData = $smarty->getTemplateVars('cat');
                $name = $catData['name'];
            } else {
                $name = $smarty->getConfigVars('catalog_root_h1');
            }
            break;
        case 'cms':
            $name = $smarty->getTemplateVars('name_page');
            break;
        case 'news':
            if (isset($_GET['getnews'])) {
                $name = $smarty->getTemplateVars('name_news');
            } elseif (isset($_GET['tag'])) {
                $name = $smarty->getConfigVars('news_root_h1') . ': ' . $_GET['tag'];
            } else {
                $name = $smarty->getConfigVars('news_root_h1');
            }
            break;
        case 'plugin':
            $active_plugin = $_GET['magixmod'];
            switch ($active_plugin) {
                case 'contact':
                    $name = $smarty->getConfigVars('contact_root_h1');
                    break;
                default:
                    if (isset($_GET['pstring3']))
                        $name = ucfirst(str_replace('-', ' ', 'pstring3'));
                    elseif (isset($_GET['pstring2']))
                        $name = ucfirst(str_replace('-', ' ', 'pstring2'));
                    elseif (isset($_GET['pstring1']))
                        $name = ucfirst(str_replace('-', ' ', 'pstring1'));
                    else
                        $name = $smarty->getConfigVars($active_mod . '_root_h1');
            }
    }

    // *** Set share data
    $name = str_replace(' ', '%20', $name); // W3C validation require no ' ' in url
    $data_default = array(
        'facebook' => array(
            'name' => 'facebook',
            'url' => 'http://www.facebook.com/share.php?u='.$url['share'],
            'img' => 'facebook.png',
            'font'=> 'facebook'
        ),
        'twitter' =>  array(
            'name' => 'twitter',
            'url' => 'https://twitter.com/intent/tweet?text='.$name.'&amp;url='.$url['share'],
            'img' => 'twitter.png',
            'font'=> 'twitter'
        ),
        'viadeo' => array(
            'name' => 'viadeo',
            'url' => 'http://www.viadeo.com/shareit/share/?url='.$url['share'].'&amp;title='.$name.'&amp;overview='.$name,
            'img' => 'viadeo.png',
            'font'=> ''
        ),
        'google' => array(
            'name' => 'google',
            'url' => 'https://plus.google.com/share?url='.$url['share'],
            'img' => 'google.png',
            'font'=> 'google-plus'
        ),
        'linkedin' => array(
            'name' => 'linkedin',
            'url' => 'http://www.linkedin.com/shareArticle?mini=true&url='.$url['share'],
            'img' => 'linkedin.png',
            'font'=> 'linkedin'
        )
    );
    $exclude = isset($params['exclude']) ? $params['exclude'] : false;
    if($exclude){
        if(is_array($exclude)){
            foreach($exclude as $item){
                unset($data_default[$item]);
            }
        }
    }
    $assign = isset($params['assign']) ? $params['assign'] : 'data';
    $template->assign($assign,$data_default);
}
?>