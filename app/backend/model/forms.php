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
 * @category   Model 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name forms
 * Model from FORMS & INPUT dynamic
 */
class backend_model_forms{
	private static function getNameAndId($nid,&$name,&$id)
	{
		if (is_array($nid)) {
			$name = $nid[0];
			$id = !empty($nid[1]) ? $nid[1] : null;
		} else {
			$name = $id = $nid;
		}
	}
	/**
	* Input field
	*
	* Returns HTML code for an input field. $nid could be a string or an array of
	* name and ID.
	*
	* @param string|array	$nid			Element ID and name
	* @param integer		$size		Element size
	* @param integer		$max			Element maxlength
	* @param string		$default		Element value
	* @param string		$class		Element class name
	* @param string		$tabindex		Element tabindex
	* @param boolean		$disabled		True if disabled
	*
	* @return string
	*/
	public static function field($nid, $size, $max, $default='',$class=true, $tabindex='',$disabled=false,$readonly=false)
	{
		self::getNameAndId($nid,$name,$id);
		
		$res = '<input type="text" size="'.$size.'" name="'.$name.'" ';
		
		$res .= $id ? 'id="'.$id.'" ' : '';
		$res .= $max ? 'maxlength="'.$max.'" ' : '';
		$res .= $default || $default === '0' ? 'value="'.$default.'" ' : '';
		$res .= $class ? 'class="inputtext ui-corner-all" ' : '';
		$res .= $tabindex ? 'tabindex="'.$tabindex.'" ' : '';
		$res .= $disabled ? 'disabled="disabled" ' : '';
		$res .= $readonly ? 'readonly="readonly" ' : '';
		$res .= ' />';
		return $res;
	}
	/**
	* Textarea
	*
	* Returns HTML code for a textarea. $nid could be a string or an array of
	* name and ID.
	*
	* @param string|array	$nid			Element ID and name
	* @param integer		$cols		Number of columns
	* @param integer		$rows		Number of rows
	* @param string		$default		Element value
	* @param string		$class		Element class name
	* @param string		$tabindex		Element tabindex
	* @param boolean		$disabled		True if disabled
	* @param string		$extra_html	Extra HTML attributes
	*
	* @return string
	*/
	public static function textArea($nid, $cols=20, $rows=30, $default='',$class=true,$tabindex='', $disabled=false)
	{
		self::getNameAndId($nid,$name,$id);
		
		$res = '<textarea cols="'.$cols.'" rows="'.$rows.'" ';
		$res .= 'name="'.$name.'" ';
		$res .= $id ? 'id="'.$id.'" ' : '';
		$res .= ($tabindex != '') ? 'tabindex="'.$tabindex.'" ' : '';
		$res .= $class ? 'class="inputtext ui-corner-all" ' : '';
		$res .= $disabled ? 'disabled="disabled" ' : '';
		$res .= '>';
		$res .= $default;
		$res .= '</textarea>';
		
		return $res;
	}
}