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
 * @category   informations
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2015 Gerits Aurelien,
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * Author: Salvatore Di Salvo
 * Date: 04-11-15
 * Time: 16:56
 * @name informations
 * Le plugin informations
 */
class plugins_about_admin extends DBabout{
    /**
	 * 
	 * @var idadmin
	 */
	public $idadmin;
	/**
	 * 
	 * @var idlang
	 */
	public $idlang;
	/**
	 * Les variables globales
	 */
	public $action,$message;
	public static $notify = array('plugin'=>'true','template'=>'message-about.tpl','method'=>'display','assignFetch'=>'notifier');
	/**
	 * @var bool, Sections edited
	 */
	public $edit_about = false, $edit_contact = false, $edit_socials = false, $edit_op = false, $add_page = false, $refesh_lang, $switch_op, $send = array('openinghours' => ''), $page, $parent;

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
		'desc'	=> NULL,
		'slogan'	=> NULL,
		'type' 		=> NULL,
		'eshop' 	=> '0',
		'tva' 		=> NULL,
		'contact' 	=> array(
			'mail' 			=> NULL,
			'click_to_mail' => '0',
			'crypt_mail' 	=> '1',
			'phone' 		=> NULL,
			'mobile' 		=> NULL,
			'click_to_call' => '1',
			'fax' 			=> NULL,
			'adress' 		=> array(
				'adress' 		=> NULL,
				'street' 		=> NULL,
				'postcode' 		=> NULL,
				'city' 			=> NULL
			),
			'languages' => 'Français'
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

	public $languages = array(
			'ar' => 'Arabic',
			'az' => 'Azerbaijani',
			'bg' => 'Bulgarian',
			'bs' => 'Bosnian',
			'ca' => 'Catalan',
			'cs' => 'Czech',
			'da' => 'Danish',
			'de' => 'German',
			'el' => 'Greek',
			'en' => 'English',
			'es' => 'Spanish',
			'et' => 'Estonian',
			'fi' => 'Finnish',
			'fr' => 'French',
			'he' => 'Hebrew',
			'hr' => 'Croatian',
			'hu' => 'Hungarian',
			'hy' => 'Armenian',
			'is' => 'Icelandic',
			'it' => 'Italian',
			'ja' => 'Japanese',
			'ko' => 'Korean',
			'lt' => 'Lithuanian',
			'lv' => 'Latvian',
			'mk' => 'Macedonian',
			'mn' => 'Mongolian',
			'mt' => 'Maltese',
			'nl' => 'Dutch',
			'no' => 'Norwegian',
			'pl' => 'Polish',
			'pt' => 'Portuguese',
			'ro' => 'Romanian',
			'ru' => 'Russian',
			'sk' => 'Slovak',
			'sl' => 'Slovenian',
			'sq' => 'Albanian',
			'sr' => 'Serbian',
			'sv' => 'Swedish',
			'sz' => 'Montenegrin',
			'th' => 'Thai',
			'tr' => 'Turkish',
			'uk' => 'Ukrainian',
			'uz' => 'Uzbek',
			'vi' => 'Vietnamese',
			'zh' => 'Chinese'
	);

    /**
	 * Construct class
	 */
	public function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
        
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('edit')){
            $this->edit = magixcjquery_form_helpersforms::inputNumeric($_GET['edit']);
        }
        if(magixcjquery_filter_request::isGet('getlang')){
            $this->getlang = magixcjquery_form_helpersforms::inputNumeric($_GET['getlang']);
        }
		if(magixcjquery_filter_request::isGet('tab')){
			$this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
		}

		/* Global about edition */
		if(magixcjquery_filter_request::isPost('company_name')){
			$this->company['name'] = magixcjquery_form_helpersforms::inputClean($_POST['company_name']);
			$this->edit_about = true;
		}
		if(magixcjquery_filter_request::isPost('company_desc')){
			$this->company['desc'] = magixcjquery_form_helpersforms::inputClean($_POST['company_desc']);
			$this->edit_about = true;
		}
		if(magixcjquery_filter_request::isPost('company_slogan')){
			$this->company['slogan'] = magixcjquery_form_helpersforms::inputClean($_POST['company_slogan']);
			$this->edit_about = true;
		}
		if(magixcjquery_filter_request::isPost('company_type')){
			$this->company['type'] = magixcjquery_form_helpersforms::inputClean($_POST['company_type']);
			$this->edit_about = true;
		}
		if(magixcjquery_filter_request::isPost('company_tva')){
			$this->company['tva'] = magixcjquery_form_helpersforms::inputClean($_POST['company_tva']);
			$this->edit_about = true;
		}
		if(magixcjquery_filter_request::isPost('eshop')){
			$this->company['eshop'] = '1';
			$this->edit_about = true;
		}elseif($this->edit_contact){
			$this->company['eshop'] = '0';
		}

		/* Contact about edition */
		if(magixcjquery_filter_request::isPost('company_mail')){
			$this->company['contact']['mail'] = magixcjquery_form_helpersforms::inputClean($_POST['company_mail']);
			$this->edit_contact = true;
		}
		if(magixcjquery_filter_request::isPost('company_phone')){
			$this->company['contact']['phone'] = magixcjquery_form_helpersforms::inputClean($_POST['company_phone']);
			$this->edit_contact = true;
		}
		if(magixcjquery_filter_request::isPost('company_mobile')){
			$this->company['contact']['mobile'] = magixcjquery_form_helpersforms::inputClean($_POST['company_mobile']);
			$this->edit_contact = true;
		}
		if(magixcjquery_filter_request::isPost('company_mail')){
			$this->company['contact']['fax'] = magixcjquery_form_helpersforms::inputClean($_POST['company_fax']);
			$this->edit_contact = true;
		}
		if(magixcjquery_filter_request::isPost('company_adress')){
			$this->company['contact']['adress'] = magixcjquery_form_helpersforms::arrayClean($_POST['company_adress']);
			$this->edit_contact = true;
		}
		if(magixcjquery_filter_request::isPost('click_to_mail')){
			$this->company['contact']['click_to_mail'] = '1';
			$this->edit_contact = true;
		}elseif($this->edit_contact){
			$this->company['contact']['click_to_mail'] = '0';
		}
		if(magixcjquery_filter_request::isPost('click_to_call')){
			$this->company['contact']['click_to_call'] = '1';
			$this->edit_contact = true;
		}elseif($this->edit_contact){
			$this->company['contact']['click_to_call'] = '0';
		}
		if(magixcjquery_filter_request::isPost('crypt_mail')){
			$this->company['contact']['crypt_mail'] = '1';
			$this->edit_contact = true;
		}elseif($this->edit_contact){
			$this->company['contact']['crypt_mail'] = '0';
		}

		/* Languages about refreshing */
		if(magixcjquery_filter_request::isPost('refesh_lang')){
			$this->refesh_lang = true;
		}

		/* Socials links edition */
		if(magixcjquery_filter_request::isPost('company_socials')){
			$this->edit_socials = true;
			$this->company['socials'] = magixcjquery_form_helpersforms::arrayClean($_POST['company_socials']);
		}

		/* Opening Hours links edition */
		if(magixcjquery_filter_request::isPost('switch_op')){
			$this->enable_op = magixcjquery_form_helpersforms::inputClean($_POST['enable_op']);
			$this->switch_op = true;
		}
		if(magixcjquery_filter_request::isPost('openinghours')){
			$this->edit_op = true;
			$this->send['openinghours'] = magixcjquery_form_helpersforms::arrayClean($_POST['openinghours']);
		}

		/* Add about page */
		if(magixcjquery_filter_request::isPost('subject')){
			$this->page['title'] = magixcjquery_form_helpersforms::inputClean($_POST['subject']);
			$this->add_page = true;
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->page['idlang'] = magixcjquery_form_helpersforms::inputNumeric($_POST['idlang']);
			$this->add_page = true;
		}

		/* Edit about Page */
		if(magixcjquery_filter_request::isPost('idpage')){
			$this->page['id'] = magixcjquery_form_helpersforms::inputNumeric($_POST['idpage']);
		}
		if(magixcjquery_filter_request::isPost('page_title')){
			$this->page['title'] = magixcjquery_form_helpersforms::inputClean($_POST['page_title']);
		}
		if(magixcjquery_filter_request::isPost('page_content')){
			$this->page['content'] = magixcjquery_form_helpersforms::inputCleanQuote($_POST['page_content']);
		}
		if(magixcjquery_filter_request::isPost('seo_title_page')){
			$this->page['seo_title'] = magixcjquery_form_helpersforms::inputCleanQuote($_POST['seo_title_page']);
		}
		if(magixcjquery_filter_request::isPost('seo_desc_page')){
			$this->page['seo_desc'] = magixcjquery_form_helpersforms::inputCleanQuote($_POST['seo_desc_page']);
		}
		if(magixcjquery_filter_request::isPost('parent')){
			$this->page['parent'] = magixcjquery_form_helpersforms::inputCleanQuote($_POST['parent']);
		}

		# DELETE PAGE
		if(magixcjquery_filter_request::isPost('delete')){
			$this->delete = magixcjquery_form_helpersforms::inputNumeric($_POST['delete']);
		}

		/* Child page */
		if(magixcjquery_filter_request::isGet('parent')){
			$this->parent = magixcjquery_form_helpersforms::inputNumeric($_GET['parent']);
		}

		$this->template = new backend_controller_plugins();
	}

	/**
	 * Retourne le message de notification
	 * @param $type
	 */
	private function notify($type){
		$this->message->getNotify($type,self::$notify);
	}

	/**
	 * @param $about
	 * @param $op
	 * @return array
	 */
	private function setData($about)
	{
		$schedule = array();

		foreach ($this->company as $info => $value) {
			if($info == 'contact') {
				foreach ($value as $contact_info => $val) {
					if($contact_info == 'adress') {
						$this->company['contact'][$contact_info]['adress'] = $about['adress'];
						$this->company['contact'][$contact_info]['street'] = $about['street'];
						$this->company['contact'][$contact_info]['postcode'] = $about['postcode'];
						$this->company['contact'][$contact_info]['city'] = $about['city'];
					} elseif ($contact_info == 'languages') {
						$this->company['contact'][$contact_info] = $this->getActiveLang();
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
			elseif($info == 'openinghours') {
				$this->company[$info] = $about['openinghours'];

				$op = parent::getOp();
				foreach ($op as $d) {
					$schedule[$d['day_abbr']] = $d;
					array_shift($schedule[$d['day_abbr']]);

					$schedule[$d['day_abbr']]['open_time'] = explode(':',$d['open_time']);
					$schedule[$d['day_abbr']]['close_time'] = explode(':',$d['close_time']);
					$schedule[$d['day_abbr']]['noon_start'] = explode(':',$d['noon_start']);
					$schedule[$d['day_abbr']]['noon_end'] = explode(':',$d['noon_end']);
				}
			}
			else {
				$this->company[$info] = $about[$info];
			}
		}

		return $this->company;
	}

	/**
	 * @throws Exception
	 */
	private function getData()
	{
		$about = parent::getAbout();
		$global = array();
		foreach ($about as $info) {
			$global[$info['info_name']] = $info['value'];
		}

		$this->template->assign('companyData', $this->setData($global));
	}

	/**
	 * @throws Exception
	 */
	private function getTypes()
	{
		$this->template->assign('schemaTypes', $this->type);
	}

	/**
	 *
	 */
	private function display_op()
	{
		parent::enable_op($this->enable_op);
	}

	/**
	 * 
	 */
	private function addPage()
	{
		if (isset($this->page)) {

			if( parent::getPageLang($this->page['idlang']) == null ) {
				$this->page['uri_title'] = magixcjquery_url_clean::rplMagixString($this->page['title'],array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
				parent::i_page($this->page);
				$this->notify('save');
			} else {
				$this->notify('already_exist');
			}
		}
	}

	/**
	 *
	 */
	private function addChild()
	{
		if (isset($this->page)) {

			if( $this->page['parent'] != null ) {
				$parent = parent::getPage($this->page['parent']);
				if ( $parent != null ){
					$this->page['idlang'] = $parent['idlang'];
					$this->page['uri_title'] = magixcjquery_url_clean::rplMagixString($this->page['title'],array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
					parent::i_child($this->page);
					$this->notify('save');
				}
			}
		}
	}

	/**
	 *
	 */
	private function editPage()
	{
		if (isset($this->page)) {
			$this->page['uri_title'] = magixcjquery_url_clean::rplMagixString($this->page['title'],array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
			parent::u_page($this->page);

			$this->notify('save');
		}
	}

	/**
	 *
	 */
	public function del()
	{
		parent::d_page($this->delete);
		$this->notify('delete');
	}

	/**
	 * @param $section
	 */
	private function save($section)
	{
		if ($section == 'about') {
			parent::up_about($this->company);

		} elseif ($section == 'contact') {
			$this->company['contact']['adress']['adress'] = $this->company['contact']['adress']['street'].', '.$this->company['contact']['adress']['postcode'].' '.$this->company['contact']['adress']['city'];
			parent::up_contact($this->company);

		} elseif ($section == 'socials') {
			parent::up_socials($this->company);

		} elseif ($section == 'openinghours') {
			foreach ($this->company['specifications'] as $day => $opt) {
				if(isset($this->send['openinghours'][$day])) {
					$this->company['specifications'][$day]['open_day'] = '1';

					if(isset($this->send['openinghours'][$day]['noon_time'])) {
						$this->company['specifications'][$day]['noon_time'] = '1';

						$this->company['specifications'][$day]['noon_start'] 	= ($this->send['openinghours'][$day]['noon_start']['hh'] ? ($this->send['openinghours'][$day]['noon_start']['hh'].':'.$this->send['openinghours'][$day]['noon_start']['mm']) : null);
						$this->company['specifications'][$day]['noon_end'] 	= ($this->send['openinghours'][$day]['noon_end']['hh'] ? ($this->send['openinghours'][$day]['noon_end']['hh'].':'.$this->send['openinghours'][$day]['noon_end']['mm']) : null);
					} else {
						$this->company['specifications'][$day]['noon_time'] = '0';
					}

					$this->company['specifications'][$day]['open_time'] 	= ($this->send['openinghours'][$day]['open']['hh'] ? ($this->send['openinghours'][$day]['open']['hh'].':'.$this->send['openinghours'][$day]['open']['mm']) : null);
					$this->company['specifications'][$day]['close_time'] 	= ($this->send['openinghours'][$day]['close']['hh'] ? ($this->send['openinghours'][$day]['close']['hh'].':'.$this->send['openinghours'][$day]['close']['mm']) : null);
				} else {
					$this->company['specifications'][$day]['open_day'] = '0';
				}
			}

			parent::up_openinghours($this->company);
		}
		$this->notify('save');
	}

	/**
	 *
	 */
	private function updateLanguages()
	{
		$langs = parent::getIso();

		$iso = array();
		foreach ($langs as $lang) {
			$iso[] = ucfirst($this->languages[$lang['iso']]);
		}

		if(count($iso) > 1) {
			$langs = implode(',',$iso);
		} else {
			$langs = $iso[0];
		}

		parent::up_languages($langs);

		$this->notify('refresh_lang');
	}

	/**
	 * @return array|string
	 */
	private function getActiveLang()
	{
		$langs = parent::getLanguages();

		$list = array();
		foreach ($langs as $lang) {
			$list[] = ucfirst($lang['language']);
		}

		$langs = implode(', ',$list);

		return $langs;
	}

	/**
	 * @access private
	 * Installation des tables mysql du plugin
	 */
	private function install_table(){
		if(parent::c_show_table() == 0){
			$this->template->db_install_table('db.sql', 'request/install.tpl');
		}else{
			//$magixfire = new magixcjquery_debug_magixfire();
			//$magixfire->magixFireInfo('Les tables mysql sont installés', 'Statut des tables mysql du plugin');
			return true;
		}
	}

	/**
	 * Affiche les pages de l'administration du plugin
	 * @access public
	 */
	public function run(){
		if(self::install_table() == true){
			if (isset($this->tab) && $this->tab == 'about')
			{
				$this->template->display('about.tpl');
			}
			elseif (isset($this->tab) && $this->tab == 'page')
			{
				if($this->add_page) {
					$this->addPage();
				} elseif($this->action == 'edit' && $this->page['id']) {
					$this->editPage();
				} elseif($this->action == 'edit' && $this->edit) {
					$this->template->assign('page',parent::getPage($this->edit));
					$this->template->display('page/editpage.tpl');
				} elseif($this->action == 'addchild' && $this->parent) {
					$this->template->assign('parent',parent::getPage($this->parent));
					$this->template->display('page/addpage.tpl');
				} elseif($this->action == 'savechild' && $this->page['parent']) {
					$this->addChild();
				} elseif ($this->action == 'delete') {
					if ( isset($this->delete) && is_numeric($this->delete) ) {
						$this->del();
					}
				} elseif ($this->action == 'getlist') {
					$this->template->assign('pages',parent::getLastPage());
					$this->template->display('page/loop/list.tpl');
				} elseif($this->action == 'getchild' && $this->parent) {
					$this->template->assign('pages',parent::getChildPages($this->parent));
					$this->template->display('page/parent.tpl');
				} else {
					$this->template->assign('languages',$this->getLang());
					$this->template->assign('pages',parent::getPages());
					$this->template->display('page/index.tpl');
				}
			}
			elseif (!isset($this->tab) || (isset($this->tab) && $this->tab == 'index'))
			{
				if ($this->edit_about) {
					$this->save('about');
				} elseif ($this->edit_contact) {
					$this->save('contact');
				} elseif ($this->edit_socials) {
					$this->save('socials');
				} elseif ($this->edit_op) {
					$this->save('openinghours');
				} elseif ($this->switch_op) {
					$this->display_op();
				} elseif ($this->refesh_lang) {
					$this->updateLanguages();
				} else {
					$this->getData();
					$this->getTypes();
					$this->template->display('index.tpl');
				}
			}
		}
	}

	/**
	 * @access public
	 * Options de reecriture des métas
	 */
	public function seo_options(){
		return $options_string = array(
				'plugins'=>true
		);
	}

    /**
     * Set Configuration pour le menu
     * @return array
     */
    public function setConfig(){
        return array(
            'url' => array(
				'lang' => 'none',
				'action' => '',
				'name' => 'À propos'
			),
			'icon' => array(
				'type' => 'font',
				'name' => 'fa fa-info-circle'
			)
        );
    }

	//SITEMAP
	/*private function lastmod_dateFormat(){
		$dateformat = new magixglobal_model_dateformat();
		return $dateformat->sitemap_lastmod_dateFormat();
	}*/
	/**
	 * @access public
	 * Options de reecriture des sitemaps NEWS
	 */
	/*public function sitemap_rewrite_options(){
		return $options_string = array(
				'index'=>true,
				'level1'=>false,
				'level2'=>false,
				'records'=>false
		);
	}*/

	/**
	 * URL index du module suivant la langue
	 * @param $idlang
	 */
	/*public function sitemap_uri_index($idlang){
		$sitemap = new magixcjquery_xml_sitemap();
		// Table des langues
		$lang = new backend_db_block_lang();
		// Retourne le code ISO
		$db = $lang->s_data_iso($idlang);
		if($db != null){
			$sitemap->writeMakeNode(
					magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_plugins_root_url(
							$db['iso'],
							'about',
							true)
					,
					$this->lastmod_dateFormat(),
					'always',
					0.7
			);
		}
	}*/
}
class DBabout{
    /**
	 * Vérifie si les tables du plugin sont installées
	 * @access protected
	 * return integer
	 */
	protected function c_show_table(){
		return magixglobal_model_db::layerDB()->showTable('mc_plugins_about');
	}

	/* GET */
	/**
	 * @return array
	 */
	protected function getLanguages()
	{
		$query = "SELECT `language` FROM `mc_lang`";

		return magixglobal_model_db::layerDB()->select($query);
	}

	/**
	 * @return array
	 */
	protected function getIso()
	{
		$query = "SELECT `iso` FROM `mc_lang`";

		return magixglobal_model_db::layerDB()->select($query);
	}

	/**
	 * @return array
	 */
	protected function getLang()
	{
		$query = "SELECT `idlang`,`iso`,`language` FROM `mc_lang`";

		return magixglobal_model_db::layerDB()->select($query);
	}

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

	/**
	 * @return array
	 */
	protected function getPages()
	{
		$query = "SELECT lang.iso, ab.idpage as id, ab.title_page as title, ab.content_page as content, ab.seo_title_page, ab.seo_desc_page FROM `mc_plugins_about_page` as ab
				 JOIN mc_lang as lang ON ab.idlang = lang.idlang
				 WHERE ab.idpage_p = 0";

		return magixglobal_model_db::layerDB()->select($query);
	}

	/**
	 * @return array
	 */
	protected function getChildPages($id)
	{
		$query = "SELECT lang.iso, ab.idpage as id, ab.title_page as title, ab.content_page as content, ab.seo_title_page, ab.seo_desc_page FROM `mc_plugins_about_page` as ab
				 JOIN mc_lang as lang ON ab.idlang = lang.idlang
				 WHERE ab.idpage_p = :id";

		return magixglobal_model_db::layerDB()->select($query, array(':id' => $id));
	}

	/**
	 * @return array
	 */
	protected function getLastPage()
	{
		$query = "SELECT lang.iso, ab.idpage as id, ab.title_page as title, ab.content_page as content, ab.seo_title_page, ab.seo_desc_page FROM `mc_plugins_about_page` as ab
				 JOIN mc_lang as lang ON ab.idlang = lang.idlang ORDER BY ab.idpage DESC LIMIT 1";

		return magixglobal_model_db::layerDB()->select($query);
	}

	/**
	 * @param $id
	 * @return array
	 */
	protected function getPage($id)
	{
		$query = "SELECT lang.iso, ab.idlang, ab.idpage as id, ab.idpage_p, ab.title_page as title, ab.content_page as content, ab.seo_title_page, ab.seo_desc_page FROM `mc_plugins_about_page` as ab
				 JOIN mc_lang as lang ON ab.idlang = lang.idlang
				 WHERE ab.idpage = :id";

		return magixglobal_model_db::layerDB()->selectOne($query,array(
			':id' => $id
		));
	}

	/**
	 * Get about page from idlang
	 *
	 * @param $idlang
	 * @return array
	 */
	protected function getPageLang($idlang)
	{
		$query = "SELECT * FROM `mc_plugins_about_page`
				 WHERE idlang = :id";

		return magixglobal_model_db::layerDB()->selectOne($query,array(
				':id' => $idlang
		));
	}

	/* EDITION */
	/**
	 * @param $languages
	 */
	protected function up_languages($languages)
	{
		$query = "UPDATE `mc_plugins_about` SET `value` = :languages WHERE `info_name` = 'languages'";
		magixglobal_model_db::layerDB()->update($query,array(':languages' => $languages));
	}
	/**
	 * @param $company
	 */
	protected function up_about($company)
	{
		$query = "UPDATE `mc_plugins_about`
					SET `value` = CASE `info_name`
						WHEN 'name' THEN :nme
						WHEN 'desc' THEN :dsc
						WHEN 'slogan' THEN :slogan
						WHEN 'type' THEN :tpe
						WHEN 'eshop' THEN :eshop
						WHEN 'tva' THEN :tva
					END
					WHERE `info_name` IN ('name','desc','slogan','type','eshop','tva')";

		magixglobal_model_db::layerDB()->update($query,array(
				':nme' 		=> $company['name'],
				':dsc' 		=> $company['desc'],
				':slogan' 	=> $company['slogan'],
				':tpe' 		=> $company['type'],
				':eshop' 	=> $company['eshop'],
				':tva' 		=> $company['tva']
		));
	}

	/**
	 * @param $company
	 */
	protected function up_contact($company)
	{
		$query = "UPDATE `mc_plugins_about`
					SET `value` = CASE `info_name`
						WHEN 'mail' THEN :mail
						WHEN 'click_to_mail' THEN :click_to_mail
						WHEN 'crypt_mail' THEN :crypt_mail
						WHEN 'phone' THEN :phone
						WHEN 'mobile' THEN :mobile
						WHEN 'click_to_call' THEN :click_to_call
						WHEN 'fax' THEN :fax
						WHEN 'adress' THEN :adress
						WHEN 'street' THEN :street
						WHEN 'postcode' THEN :postcode
						WHEN 'city' THEN :city
					END
					WHERE `info_name` IN ('mail','click_to_mail','crypt_mail','phone','mobile','click_to_call','fax','adress','street','postcode','city')";

		magixglobal_model_db::layerDB()->update($query,array(
				':mail' 			=> $company['contact']['mail'],
				':click_to_mail'	=> $company['contact']['click_to_mail'],
				':crypt_mail'		=> $company['contact']['crypt_mail'],
				':phone' 			=> $company['contact']['phone'],
				':mobile' 			=> $company['contact']['mobile'],
				':click_to_call'	=> $company['contact']['click_to_call'],
				':fax' 				=> $company['contact']['fax'],
				':adress' 			=> $company['contact']['adress']['adress'],
				':street' 			=> $company['contact']['adress']['street'],
				':postcode' 		=> $company['contact']['adress']['postcode'],
				':city' 			=> $company['contact']['adress']['city'],
		));
	}

	/**
	 * @param $company
	 */
	protected function up_socials($company)
	{
		$query = "UPDATE `mc_plugins_about`
					SET `value` = CASE `info_name`
						WHEN 'facebook' THEN :facebook
						WHEN 'twitter' THEN :twitter
						WHEN 'google' THEN :google
						WHEN 'linkedin' THEN :linkedin
						WHEN 'viadeo' THEN :viadeo
					END
					WHERE `info_name` IN ('facebook','twitter','google','linkedin','viadeo')";

		magixglobal_model_db::layerDB()->update($query,array(
				':facebook' => $company['socials']['facebook'],
				':twitter'	=> $company['socials']['twitter'],
				':google' 	=> $company['socials']['google'],
				':linkedin' => $company['socials']['linkedin'],
				':viadeo' 	=> $company['socials']['viadeo']
		));
	}

	/**
	 * @param $company
	 */
	protected function up_openinghours($company)
	{
		foreach ($company['specifications'] as $day => $opt) {
			$query = "UPDATE `mc_plugins_about_op`
					SET `open_day` = :open_day,
					`noon_time` = CASE `open_day`
									WHEN '1' THEN :noon_time
									ELSE `noon_time`
									END,
					`open_time` = CASE `open_day`
									WHEN '1' THEN :open_time
									ELSE `open_time`
									END,
					`close_time` = CASE `open_day`
									WHEN '1' THEN :close_time
									ELSE `close_time`
									END,
					`noon_start` = CASE `open_day`
									WHEN '1' THEN
									 	CASE `noon_time`
									 	WHEN '1' THEN :noon_start
										ELSE `noon_start`
										END
									ELSE `noon_start`
									END,
					`noon_end` = CASE `open_day`
									WHEN '1' THEN
									 	CASE `noon_time`
									 	WHEN '1' THEN :noon_end
										ELSE `noon_end`
										END
									ELSE `noon_end`
									END
					WHERE `day_abbr` = :cday";

			magixglobal_model_db::layerDB()->update($query,array(
					':cday'			=> $day,
					':open_day' 	=> $opt['open_day'],
					':noon_time' 	=> $opt['noon_time'],
					':open_time' 	=> $opt['open_time'],
					':close_time' 	=> $opt['close_time'],
					':noon_start' 	=> $opt['noon_start'],
					':noon_end' 	=> $opt['noon_end'],
			));
		}
	}

	/**
	 * @param $page
	 */
	protected function u_page($page)
	{
		$query = "UPDATE `mc_plugins_about_page` SET
					title_page = :title,
					uri_title = :uri,
					content_page = :content,
					seo_title_page = :seo_title,
					seo_desc_page = :seo_desc
					WHERE `idpage` = :id";

		magixglobal_model_db::layerDB()->update($query,array(
			':title' => $page['title'],
			':uri' => $page['uri_title'],
			':content' => $page['content'],
			':seo_title' => $page['seo_title'],
			':seo_desc' => $page['seo_desc'],
			':id' => $page['id']
		));
	}

	/**
	 * @param $enable_op
	 */
	protected function enable_op($enable_op)
	{
		if($enable_op) {
			$enable_op = '1';
		} else {
			$enable_op = '0';
		}
		$query = "UPDATE `mc_plugins_about` SET `value` = :enable WHERE `info_name` = 'openinghours'";

		magixglobal_model_db::layerDB()->update($query,array(':enable'=>$enable_op));
	}

	/**
	 * @param $page
	 */
	protected function i_page($page)
	{
		$query = "INSERT INTO `mc_plugins_about_page` (`idlang`,`title_page`,`uri_title`) VALUES (:lang,:title,:uri)";
		
		magixglobal_model_db::layerDB()->insert($query, array(
			':lang' => $page['idlang'],
			':title' => $page['title'],
			':uri' => $page['uri_title']
		));
	}

	/**
	 * @param $page
	 */
	protected function i_child($page)
	{
		$query = "INSERT INTO `mc_plugins_about_page` (`idlang`,`idpage_p`,`title_page`,`uri_title`,`content_page`,`seo_title_page`,`seo_desc_page`) VALUES (:lang,:parent,:title,:uri,:content,:seo_title,:seo_desc)";

		magixglobal_model_db::layerDB()->insert($query, array(
			':lang' => $page['idlang'],
			':parent' => $page['parent'],
			':title' => $page['title'],
			':uri' => $page['uri_title'],
			':content' => $page['content'],
			':seo_title' => $page['seo_title'],
			':seo_desc' => $page['seo_desc']
		));
	}

	// DELETE
	/**
	 * @param $id
	 */
	protected function d_page($id)
	{
		$query = "DELETE FROM mc_plugins_about_page WHERE idpage = :id";

		magixglobal_model_db::layerDB()->delete($query,array(':id'=>$id));
	}
}
?>