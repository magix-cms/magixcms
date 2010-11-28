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
 * @subpackage prefilter
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
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
function smarty_prefilter_magixmin($source, $smarty){
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