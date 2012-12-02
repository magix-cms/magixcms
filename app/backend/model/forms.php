<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
     * @param string $name
     * @param string $cvalue
     * @return string
     */
	public static function code_iso($name="iso",$cvalue=null){
		$tabs_iso = array(
            "ar"=>"Arabic",
            "az"=>"Azerbaijani",
            "bg"=>"Bulgarian",
            "bs"=>"Bosnian",
            "ca"=>"Catalan",
            "cs"=>"Czech",
            "da"=>"Danish",
            "de"=>"German",
            "el"=>"Greek",
            "en"=>"English",
            "es"=>"Spanish",
            "et"=>"Estonian",
            "fi"=>"Finnish",
            "fr"=>"French",
            "he"=>"Hebrew",
            "hr"=>"Croatian",
            "hu"=>"Hungarian",
            "hy"=>"Armenian",
            "is"=>"Icelandic",
            "it"=>"Italian",
            "ja"=>"Japanese",
            "ko"=>"Korean",
            "lt"=>"Lithuanian",
            "lv"=>"Latvian",
            "mk"=>"Macedonian",
            "mn"=>"Mongolian",
            "mt"=>"Maltese",
            "nl"=>"Dutch",
            "no"=>"Norwegian",
            "pl"=>"Polish",
            "pt"=>"Portuguese",
            "ro"=>"Romanian",
            "ru"=>"Russian",
            "sk"=>"Slovak",
            "sl"=>"Slovenian",
            "sq"=>"Albanian",
            "sr"=>"Serbian",
            "sv"=>"Swedish",
            "sz"=>"Montenegrin",
            "th"=>"Thai",
            "tr"=>"Turkish",
            "uk"=>"Ukrainian",
            "uz"=>"Uzbek",
            "vi"=>"Vietnamese",
            "zh"=>"Chinese"
        );
		$mselect = '<select id="'.$name.'" name="'.$name.'" class="ui-widget-content">';
		if($cvalue != null){
			$mselect .= '<option selected="selected" value="'.$cvalue.'">'.magixcjquery_string_convert::upTextCase($cvalue).'</option>';
			$mselect .= '<option value="">---------------------</option>';
		}else{
			$mselect .= '<option value="">Choisissez une langue</option>';
		}
		foreach($tabs_iso as $key => $value){
			$mselect .= '<option value="'.$key.'">'.magixcjquery_string_convert::upTextCase($key).' ('.$value.')'.'</option>';
		}
		$mselect .= '</select>';
		return $mselect;
	}
}