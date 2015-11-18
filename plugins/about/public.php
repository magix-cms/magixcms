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
 * @category   about
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2015 Gerits Aurelien,
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * Author: Salvatore Di Salvo
 * Date: 09-11-15
 * Time: 15:31
 * @name about
 * Le plugin about
 */
class plugins_about_public extends database_plugins_about{
    /**
     * @var frontend_controller_plugins
     */
    protected $template;

    /**
     * @var array, type of website allowed
     */
    public $type = array(
        'org' 		=> array(
            'schema' => 'Organization',
            'label' => 'Organisation'
        ),
        'corp' 		=> array(
            'schema' => 'LocalBusiness',
            'label' => 'Entreprise locale'
        ),
        'store' 	=> array(
            'schema' => 'Store',
            'label' => 'Magasin'
        ),
        'food' 		=> array(
            'schema' => 'FoodEstablishment',
            'label' => 'Restaurant'
        ),
        'place' 	=> array(
            'schema' => 'Place',
            'label' => 'Lieu'
        ),
        'person' 	=> array(
            'schema' => 'Person',
            'label' => 'Personne physique'
        )
    );

    /**
     * @var array, Company informations
     */
    public $company = array(
        'name' 		=> NULL,
        'type' 		=> 'org',
        'eshop' 	=> '0',
        'tva' 		=> NULL,
        'contact' 	=> array(
            'mail' 			=> NULL,
            'click_to_mail' => '0',
            'crypt_mail'    => '1',
            'phone' 		=> NULL,
            'mobile' 		=> NULL,
            'fax' 			=> NULL,
            'adress' 		=> array(
                'adress' 		=> NULL,
                'street' 		=> NULL,
                'postcode' 		=> NULL,
                'city' 			=> NULL
            ),
            'languages' => 'French'
        ),
        'socials' => array(
            'facebook' 	=> NULL,
            'twitter' 	=> NULL,
            'google' 	=> NULL,
            'linkedin' 	=> NULL,
            'viadeo' 	=> NULL
        ),
        'openinghours' => '0',
        'specifications' => array(
            'Mo' => array(
                'open_day' 		=> '0',
                'open_time' 	=> NULL,
                'close_time' 	=> NULL,
                'noon_time' 	=> '0',
                'noon_start' 	=> NULL,
                'noon_end' 		=> NULL
            ),
            'Tu' => array(
                'open_day' 		=> '0',
                'open_time' 	=> NULL,
                'close_time'	=> NULL,
                'noon_time' 	=> '0',
                'noon_start'	=> NULL,
                'noon_end'		=> NULL
            ),
            'We' => array(
                'open_day' 		=> '0',
                'open_time' 	=> NULL,
                'close_time' 	=> NULL,
                'noon_time' 	=> '0',
                'noon_start' 	=> NULL,
                'noon_end' 		=> NULL
            ),
            'Th' => array(
                'open_day' 		=> '0',
                'open_time' 	=> NULL,
                'close_time' 	=> NULL,
                'noon_time' 	=> '0',
                'noon_start' 	=> NULL,
                'noon_end' 		=> NULL
            ),
            'Fr' => array(
                'open_day' 		=> '0',
                'open_time' 	=> NULL,
                'close_time' 	=> NULL,
                'noon_time' 	=> '0',
                'noon_start' 	=> NULL,
                'noon_end'		=> NULL
            ),
            'Sa' => array(
                'open_day' 		=> '0',
                'open_time' 	=> NULL,
                'close_time' 	=> NULL,
                'noon_time' 	=> '0',
                'noon_start' 	=> NULL,
                'noon_end' 		=> NULL
            ),
            'Su' => array(
                'open_day' 		=> '0',
                'open_time' 	=> NULL,
                'close_time' 	=> NULL,
                'noon_time' 	=> '0',
                'noon_start' 	=> NULL,
                'noon_end' 		=> NULL
            )
        )
    );

    /**
     * Class constructor
     */
    public function __construct(){
        $this->template = new frontend_controller_plugins();
    }

    /**
     * @param $about
     * @param $op
     * @return array
     */
    public function setData($about, $schedule)
    {
        foreach ($this->company as $info => $value) {
            if($info == 'contact') {
                foreach ($value as $contact_info => $val) {
                    if($contact_info == 'adress') {
                        $this->company['contact'][$contact_info]['adress'] = $about['adress'];
                        $this->company['contact'][$contact_info]['street'] = $about['street'];
                        $this->company['contact'][$contact_info]['postcode'] = $about['postcode'];
                        $this->company['contact'][$contact_info]['city'] = $about['city'];
                    } else {
                        $this->company['contact'][$contact_info] = $about[$contact_info];
                    }
                }
            }
            elseif($info == 'socials') {
                foreach ($value as $social_name => $link) {
                    $this->company['socials'][$social_name] = $about[$social_name];
                }
            }
            elseif($info == 'specifications') {
                foreach ($value as $day => $op_info) {
                    foreach ($op_info as $t => $v) {
                        $this->company['specifications'][$day][$t] = $schedule[$day][$t];
                    }
                }
            }
            elseif($info == 'type') {
                $this->company['type'] = $this->type[$about['type']]['schema'];
            }
            else {
                $this->company[$info] = $about[$info];
            }
        }

        return $this->company;
    }

    /**
     * @access private
     * Installation des tables mysql du plugin
     */
    private function verify_table(){
        if(parent::c_show_table() == 0){
            //$this->template->db_install_table('db.sql', 'request/install.tpl');
            return false;
        }else{
            //$magixfire = new magixcjquery_debug_magixfire();
            //$magixfire->magixFireInfo('Les tables mysql sont installés', 'Statut des tables mysql du plugin');
            return true;
        }
    }

    /**
     * @throws Exception
     */
    public function getData()
    {
        if( self::verify_table() ) {
            $about = parent::getAbout();
            $global = array();
            foreach ($about as $info) {
                $global[$info['info_name']] = $info['value'];
            }
            $op = parent::getOp();
            $schedules = array();
            foreach ($op as $d) {
                $schedules[$d['day_abbr']] = $d;
                array_shift($schedules[$d['day_abbr']]);
            }

            return $this->setData($global, $schedules);
        } else {
			$this->company['type'] = $this->type[$this->company['type']]['schema'];
            return $this->company;
        }
    }
}
class database_plugins_about{
    /**
     * Vérifie si les tables du plugin sont installé
     * @access protected
     * return integer
     */
    protected function c_show_table(){
        $table = 'mc_plugins_about';
        return frontend_db_plugins::layerPlugins()->showTable($table);
    }

    /* GET */
    /**
     * @return array
     */
    protected function getAbout()
    {
        $query = "SELECT `info_name`,`value` FROM `mc_plugins_about`";

        return magixglobal_model_db::layerDB()->select($query);
    }

    /**
     * @return array
     */
    protected function getOp()
    {
        $query = "SELECT `day_abbr`,`open_day`,`noon_time`,`open_time`,`close_time`,`noon_start`,`noon_end` FROM `mc_plugins_about_op`";

        return magixglobal_model_db::layerDB()->select($query);
    }
}
?>