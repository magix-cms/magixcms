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
 * Author: Gerits Aurelien <aurelien[at]magix-cms[point]com>
 * Copyright: MAGIX CMS
 * Date: 21/05/13
 * Time: 15:01
 * License: Dual licensed under the MIT or GPL Version
 */
class app_model_language{
    /**
     * @var array
     */
    public static $tabs_iso = array(
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
    /**
     * lang setting conf
     *
     * @var string 'fr', ' 'en', ...
     */
    static public $adminLanguage;
    /**
     * function construct class
     *
     */
    public function __construct(){
        if (magixcjquery_filter_request::isGet('adminLanguage')){
            self::$adminLanguage = magixcjquery_form_helpersforms::inputClean($_GET['adminLanguage']);
        }
    }

    /**
     * Retourne la langue en cours de session sinon retourne fr par défaut
     * @return string
     * @access public
     * @static
     */
    public static function current_Language(){
        if(isset(self::$adminLanguage)){
            if(!empty(self::$adminLanguage)){
                $lang = magixcjquery_filter_join::getCleanAlpha($_SESSION['adminLanguage'],3);
            }else{
                $lang = 'fr';
            }
        }else{
            if(magixcjquery_filter_request::isSession('adminLanguage')){
                $lang = magixcjquery_filter_join::getCleanAlpha($_SESSION['adminLanguage'],3);
            } else {
                $lang = 'fr';
            }
        }
        return $lang;
    }
    /**
     * @return array|int|string
     */
    private function initlang(){
        $lang_array = self::$tabs_iso;
        $langue = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $langue = strtolower(substr(chop($langue[0]),0,2));
        foreach($lang_array as $key => $value){
            if(array_key_exists($key,$lang_array)){
                switch($langue){
                    case $key:
                        $langue = $key;
                        break;
                    default:
                        $langue = 'fr';
                        break;
                }
            }else{
                $langue = 'fr';
            }
        }
        if(empty($_SESSION['adminLanguage']) || !empty(self::$adminLanguage)) {
            return $_SESSION['adminLanguage'] = empty(self::$adminLanguage) ? $langue : self::$adminLanguage;
        }else{
            if (isset(self::$adminLanguage)) {
                return self::$adminLanguage  = $langue;
            }
        }
    }
    /**
     * Retourne l'OS courant si windows
     */
    private function getOS(){
        if(stripos($_SERVER['HTTP_USER_AGENT'],'win')){
            return 'windows';
        }
    }
    /**
     * Modification du setlocale suivant la langue courante pour les dates
     */
    private function setTimeLocal(){
        if(self::current_Language() == 'nl'){
            if($this->getOS() === 'windows'){
                setlocale(LC_TIME, 'nld_nld','nl');
            }else{
                setlocale(LC_TIME, 'nl_NL.UTF8','nl');
            }
        }elseif(self::current_Language() == 'fr'){
            setlocale(LC_TIME, 'fr_FR.UTF8', 'fra');
        }elseif(self::current_Language() == 'de'){
            setlocale(LC_TIME, 'de_DE.UTF8', 'de');
        }elseif(self::current_Language() == 'es'){
            setlocale(LC_TIME, 'es_ES.UTF8', 'es');
        }elseif(self::current_Language() == 'it'){
            setlocale(LC_TIME, 'it_IT.UTF8', 'it');
        }else{
            setlocale(LC_TIME, 'en_US.UTF8', 'en');
        }
    }
    /**
     * Initialisation de la création de session de langue
     */
    public function run(){
        $this->initlang();
        self::setTimeLocal(self::current_Language());
    }
}
?>