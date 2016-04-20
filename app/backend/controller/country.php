<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2016 magix-cms.com <support@magix-cms.com>
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
 * @category   Controller
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2016 Gerits Aurelien,
 * http://www.magix-cms.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name country
 *
 */
class backend_controller_country extends backend_db_country{
    /**
     * @var
     */
    protected $header, $template, $message;
    /**
     * @var array
     */
    private static $defaultCountry = array(
        "AF"=>"Afghanistan",
        "AL"=>"Albania",
        "DZ"=>"Algeria",
        "AD"=>"Andorra",
        "AO"=>"Angola",
        "AG"=>"Antigua and Barbuda",
        "AR"=>"Argentina",
        "AM"=>"Armenia",
        "AW"=>"Aruba",
        "AU"=>"Australia",
        "AT"=>"Austria",
        "AZ"=>"Azerbaijan",
        "BS"=>"Bahamas",
        "BH"=>"Bahrain",
        "BD"=>"Bangladesh",
        "BB"=>"Barbados",
        "BY"=>"Belarus",
        "BE"=>"Belgium",
        "BZ"=>"Belize",
        "BJ"=>"Benin",
        "BM"=>"Bermuda",
        "BT"=>"Bhutan",
        "BO"=>"Bolivia",
        "BA"=>"Bosnia-Herzegovina",
        "BW"=>"Botswana",
        "BR"=>"Brazil",
        "VG"=>"British Virgin Islands",
        "BN"=>"Brunei",
        "BG"=>"Bulgaria",
        "BF"=>"Burkina Faso",
        "BI"=>"Burundi",
        "KH"=>"Cambodia",
        "CM"=>"Cameroon",
        "CA"=>"Canada",
        "CV"=>"Cape Verde",
        "KY"=>"Cayman Islands",
        "CF"=>"Central African Republic",
        "TD"=>"Chad",
        "CL"=>"Chile",
        "CN"=>"China",
        "CO"=>"Colombia",
        "KM"=>"Comoros",
        "CG"=>"Congo (Brazzaville)",
        "CD"=>"Congo (Democratic Rep.)",
        "CR"=>"Costa Rica",
        "CI"=>"Cote d'Ivoire",
        "HR"=>"Croatia",
        "CU"=>"Cuba",
        "CY"=>"Cyprus",
        "CZ"=>"Czech Republic",
        "DK"=>"Denmark",
        "DJ"=>"Djibouti",
        "DM"=>"Dominica",
        "DO"=>"Dominican Republic",
        "EC"=>"Ecuador",
        "EG"=>"Egypt",
        "SV"=>"El Salvador",
        "GQ"=>"Equatorial Guinea",
        "ER"=>"Eritrea",
        "EE"=>"Estonia",
        "ET"=>"Ethiopia",
        "FK"=>"Falkland Islands",
        "FO"=>"Faroe Islands",
        "FJ"=>"Fiji",
        "FI"=>"Finland",
        "FR"=>"France",
        "GF"=>"French Guiana",
        "PF"=>"French Polynesia",
        "GA"=>"Gabon",
        "GM"=>"Gambia",
        "GE"=>"Georgia",
        "DE"=>"Germany",
        "GH"=>"Ghana",
        "GI"=>"Gibraltar",
        "GR"=>"Greece",
        "GL"=>"Greenland",
        "GD"=>"Grenada",
        "GP"=>"Guadeloupe",
        "GT"=>"Guatemala",
        "GG"=>"Guernsey",
        "GN"=>"Guinea",
        "GW"=>"Guinea-Bissau",
        "GY"=>"Guyana",
        "HT"=>"Haiti",
        "HN"=>"Honduras",
        "HK"=>"Hong Kong",
        "HU"=>"Hungary",
        "IS"=>"Iceland",
        "IN"=>"India",
        "ID"=>"Indonesia",
        "IR"=>"Iran",
        "IQ"=>"Iraq",
        "IE"=>"Ireland",
        "IM"=>"Isle of Man",
        "IL"=>"Israel",
        "IT"=>"Italy",
        "JM"=>"Jamaica",
        "JP"=>"Japan",
        "JE"=>"Jersey",
        "JO"=>"Jordan",
        "KZ"=>"Kazakhstan",
        "KE"=>"Kenya",
        "KI"=>"Kiribati",
        "KV"=>"Kosovo",
        "KW"=>"Kuwait",
        "KG"=>"Kyrgyzstan",
        "LA"=>"Laos",
        "LV"=>"Latvia",
        "LB"=>"Lebanon",
        "LS"=>"Lesotho",
        "LR"=>"Liberia",
        "LY"=>"Libya",
        "LI"=>"Liechtenstein",
        "LT"=>"Lithuania",
        "LU"=>"Luxembourg",
        "MO"=>"Macau",
        "MK"=>"Macedonia",
        "MG"=>"Madagascar",
        "MW"=>"Malawi",
        "MY"=>"Malaysia",
        "MV"=>"Maldives",
        "ML"=>"Mali",
        "MT"=>"Malta",
        "MH"=>"Marshall Islands",
        "MQ"=>"Martinique",
        "MR"=>"Mauritania",
        "MU"=>"Mauritius",
        "YT"=>"Mayotte",
        "MX"=>"Mexico",
        "FM"=>"Micronesia",
        "MD"=>"Moldova",
        "MC"=>"Monaco",
        "MN"=>"Mongolia",
        "ME"=>"Montenegro",
        "MA"=>"Morocco",
        "MZ"=>"Mozambique",
        "MM"=>"Myanmar",
        "NA"=>"Namibia",
        "NR"=>"Nauru",
        "NP"=>"Nepal",
        "NL"=>"Netherlands",
        "NC"=>"New Caledonia",
        "NZ"=>"New Zealand",
        "NI"=>"Nicaragua",
        "NE"=>"Niger",
        "NG"=>"Nigeria",
        "KP"=>"North Korea",
        "NO"=>"Norway",
        "OM"=>"Oman",
        "PK"=>"Pakistan",
        "PW"=>"Palau",
        "PA"=>"Panama",
        "PG"=>"Papua New Guinea",
        "PY"=>"Paraguay",
        "PE"=>"Peru",
        "PH"=>"Philippines",
        "PL"=>"Poland",
        "PT"=>"Portugal",
        "PR"=>"Puerto Rico",
        "QA"=>"Qatar",
        "RE"=>"Reunion",
        "RO"=>"Romania",
        "RU"=>"Russia",
        "RW"=>"Rwanda",
        "BL"=>"Saint Barthelemy",
        "KN"=>"Saint Kitts and Nevis",
        "LC"=>"Saint Lucia",
        "MF"=>"Saint Martin",
        "PM"=>"Saint Pierre and Miquelon",
        "VC"=>"Saint Vincent and the Grenadines",
        "WS"=>"Samoa",
        "SM"=>"San Marino",
        "ST"=>"Sao Tome and Principe",
        "SA"=>"Saudi Arabia",
        "SN"=>"Senegal",
        "RS"=>"Serbia",
        "SC"=>"Seychelles",
        "SL"=>"Sierra Leone",
        "SG"=>"Singapore",
        "SK"=>"Slovakia",
        "SI"=>"Slovenia",
        "SB"=>"Solomon Islands",
        "SO"=>"Somalia",
        "ZA"=>"South Africa",
        "KR"=>"South Korea",
        "SS"=>"South Sudan",
        "ES"=>"Spain",
        "LK"=>"Sri Lanka",
        "SD"=>"Sudan",
        "SR"=>"Suriname",
        "SJ"=>"Svalbard",
        "SZ"=>"Swaziland",
        "SE"=>"Sweden",
        "CH"=>"Switzerland",
        "SY"=>"Syria",
        "TW"=>"Taiwan",
        "TJ"=>"Tajikistan",
        "TZ"=>"Tanzania",
        "TH"=>"Thailand",
        "TL"=>"Timor-Leste",
        "TG"=>"Togo",
        "TO"=>"Tonga",
        "TT"=>"Trinidad and Tobago",
        "TN"=>"Tunisia",
        "TR"=>"Turkey",
        "TM"=>"Turkmenistan",
        "TC"=>"Turks and Caicos",
        "TV"=>"Tuvalu",
        "UG"=>"Uganda",
        "UA"=>"Ukraine",
        "AE"=>"United Arab Emirates",
        "GB"=>"United Kingdom",
        "US"=>"United States",
        "UY"=>"Uruguay",
        "UZ"=>"Uzbekistan",
        "VU"=>"Vanuatu",
        "VA"=>"Vatican City",
        "VE"=>"Venezuela",
        "VN"=>"Vietnam",
        "WF"=>"Wallis et Futuna",
        "EH"=>"Western Sahara",
        "YE"=>"Yemen",
        "ZM"=>"Zambia",
        "ZW"=>"Zimbabwe"
    );
    public $edit, $action;
    public $iso,$country,$order_c;
    public static $notify = array('plugin' => 'false');
    /**
     * backend_controller_country constructor.
     */
    public function __construct()
    {
        if (class_exists('backend_model_message')) {
            $this->message = new backend_model_message();
        }
        // Global
        if (magixcjquery_filter_request::isGet('edit')) {
            $this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
        }
        if (magixcjquery_filter_request::isGet('action')) {
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        //POST
        if(magixcjquery_filter_request::isPost('iso')){
            $this->iso = magixcjquery_form_helpersforms::inputCleanStrolower($_POST['iso']);
        }
        if(magixcjquery_filter_request::isPost('country')){
            $this->country = magixcjquery_form_helpersforms::inputClean($_POST['country']);
        }
        if(magixcjquery_filter_request::isPost('order_c')){
            $this->order_c = magixcjquery_form_helpersforms::arrayClean($_POST['order_c']);
        }
        $this->header = new magixglobal_model_header();
        $this->template = new backend_controller_template();
    }
    // UTILITY
    /**
     * @access public
     * @static
     * Retourne le tableau des pays par défaut
     */
    public static function defaultCountry(){
        $country = self::$defaultCountry;
        asort($country,SORT_STRING);
        return $country;
    }

    /**
     *
     */
    public function add(){
        $dataCount = parent::select(array('context'=>'one','type'=>'count'));
        if($dataCount){
            parent::insert(array(
                'iso'       =>  $this->iso,
                'country'   =>  $this->country,
                'order_c'   =>  $dataCount['order_c']+1
            ));
            $this->message->getNotify('add',self::$notify);
        }
    }

    /**
     * @return array
     */
    public function setItemsData(){
        return parent::select(array(
            'context'=>'all',
            'type'=>'count'
        ));
    }

    /**
     * 
     */
    public function getItemsData(){}

    /**
     * @throws Exception
     */
    public function run(){
        // load translation
        $this->template->addConfigFile(array(
            'country'
        ),array('country_'),false
        );
        if(isset($this->action)){
            if($this->action === 'add'){
                if(isset($this->country)){
                    $this->add();
                }
            }elseif($this->action === 'html'){

            }
        }else{
            $this->template->display('country/index.tpl');
        }
    }
}