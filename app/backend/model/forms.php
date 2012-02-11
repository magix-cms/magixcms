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
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name forms
 * Model from FORMS & INPUT dynamic
 */
class backend_model_forms{
	/**
	 * Menu select pour les langues original
	 * @param string $cvalue
	 */
	public static function code_iso($name="iso",$cvalue=null){
		$tabs_iso = array('ar', 'az', 'bg', 'bs', 'ca', 'cs', 'da', 'de', 'el', 'en', 'es', 'et', 'fi', 'fr', 'he', 'hr', 'hu', 'hy', 'is', 'it', 'ja', 'ko', 'lt', 'lv', 'mk', 'mn', 'mt', 'nl', 'no', 'pl', 'pt', 'ro', 'ru', 'sk', 'sl', 'sq', 'sr', 'sv', 'sz', 'th', 'tr', 'uk', 'uz', 'vi', 'zh');
		$mselect = '<select id="'.$name.'" name="'.$name.'" class="ui-widget-content">';
		if($cvalue != null){
			$mselect .= '<option selected="selected" value="'.$cvalue.'">'.magixcjquery_string_convert::upTextCase($cvalue).'</option>';
			$mselect .= '<option value="">---------------------</option>';
		}else{
			$mselect .= '<option value="">Choisissez une langue</option>';
		}
		foreach($tabs_iso as $row){
			$mselect .= '<option value="'.$row.'">'.magixcjquery_string_convert::upTextCase($row).'</option>';
		}
		$mselect .= '</select>';
		return $mselect;
	}
}