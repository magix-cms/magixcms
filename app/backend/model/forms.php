<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
		$mselect = '<select id="'.$name.'" name="'.$name.'" class="form-control">';
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
    /**
     * Construction du menu select
     * @param array $default_array
     * @param $options
     * @return string
     * @throws Exception
     */
    public static function select_static_row(array $default_array,$options){
        if(is_array($default_array)){
            if(array_key_exists('attr_name',$options)){
                $attr_name = $options['attr_name'];
            }else{
                $attr_name = 'name_field';
            }
            if(array_key_exists('empty_value',$options)){
                $empty_value = $options['empty_value'];
            }else{
                $empty_value = '';
            }
            if(array_key_exists('class',$options)){
                $class = ' class="'.$options['class'].'"';
            }else{
                $class = '';
            }
            if(array_key_exists('attr_id',$options)){
                $attr_id= ' id="'.$options['attr_id'].'"';
            }else{
                $attr_id = '';
            }
            if(array_key_exists('attr_multiple',$options)){
                if($options['attr_multiple'] === true){
                    $attr_multiple = ' multiple="multiple"';
                }else{
                    $attr_multiple = '';
                }
            }else{
                $attr_multiple = '';
            }
            if(array_key_exists('upper_case',$options)){
                if($options['upper_case'] === true){
                    $upper_case = true;
                }else{
                    $upper_case = false;
                }
            }else{
                $upper_case = false;
            }
            $mselect = '<select'.$attr_id.' name="'.$attr_name.'"'.$class.$attr_multiple.'>';
            if(array_key_exists('attr_multiple',$options)){
                if($options['attr_multiple'] === true){
                    $multiple = true;
                }else{
                    $multiple = false;
                }
            }else{
                $multiple = false;
            }
            if($multiple != false){
                if(array_key_exists('default_value',$options)){
                    if(is_array($options['default_value'])){
                        foreach($options['default_value'] as $key => $value){
                            $mselect .= '<option selected="selected" value="'.$key.'">'.$value.'</option>';
                        }

                    }
                }
                foreach($default_array as $row => $val){
                    $row_value = $row;
                    $row_name = $upper_case ? magixcjquery_string_convert::upTextCase($val) : $val;
                    $mselect .= '<option value="'.$row_value.'">'.$row_name.'</option>';
                }

            }else{
                if(array_key_exists('default_value',$options)){
                    if($options['default_value'] != null || $options['default_value'] != ''){
                        if(is_array($options['default_value'])){
                            foreach($options['default_value'] as $key => $value){
                                $mselect .= '<option selected="selected" value="'.$key.'">'.$value.'</option>';
                            }
                        }else{
                            $default_value = $upper_case ? magixcjquery_string_convert::upTextCase($options['default_value']) : $options['default_value'];
                            $mselect .= '<option selected="selected" value="'.$options['default_value'].'">'.$default_value.'</option>';
                        }
                        if($empty_value != ''){
                            $mselect .= '<option value="">---------------------</option>';
                        }
                    }else{
                        if($empty_value != ''){
                            $mselect .= '<option value="">'.$empty_value.'</option>';
                        }
                    }
                }else{
                    if($empty_value != ''){
                        $mselect .= '<option value="">'.$empty_value.'</option>';
                    }
                }
                foreach($default_array as $row => $val){
                    $row_value = $row;
                    $row_name = $upper_case ? magixcjquery_string_convert::upTextCase($val) : $val;
                    $mselect .= '<option value="'.$row_value.'">'.$row_name.'</option>';
                }
            }
            $mselect .= '</select>';
            return $mselect;
        }else{
            throw new Exception('Params default_array is not array');
        }
    }
}