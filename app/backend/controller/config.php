<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name config
 *
 */
class backend_controller_config{
	/**
	 * @access public
	 * @var string
	 */
	public $configlang;
	/**
	 * @access public
	 * @var string
	 */
	public $configcms;
	/**
	 * @access public
	 * @var string
	 */
	public $confignews;
	/**
	 * @access public
	 * @var string
	 */
	public $configcatalog;
	/**
	 * @access public
	 * @var string
	 */
	public $configforms;
	/**
	 * @access public
	 * @var string
	 */
	public $configmicrogalery;
	/**
	 * @access public
	 * @var string
	 */
	public $rewritenews;
	/**
	 * @access public
	 * @var string
	 */
	public $rewritecms;
	/**
	 * @access public
	 * @var string
	 */
	public $rewritecatalog;
	/**
	 * 
	 * @var intéger
	 */
	public $idmetas;
	/**
	 * 
	 * @var intéger
	 */
	public $idlang;
	/**
	 * Identifiant de la configuration
	 * @var integer
	 */
	public $idconfig;
	/**
	 * Phrase pour la réécriture des métas
	 * @var string
	 */
	public $strrewrite;
	/**
	 * Niveau de la réécriture des métas
	 * @var integer
	 */
	public $level;
	/**
	 * intéger number for limited configuration
	 * @var number
	 */
	public $number;
	/**
	 * Edition d'une réécriture des métas
	 * @var integer
	 */
	public $edit;
	/**
	 * Supprime une réécriture via l'identifiant
	 * @var drmetas
	 */
	public $drmetas;
	/**
	 * function construct
	 */
	function __construct(){
		if(isset($_POST['configlang'])){
			$this->configlang = magixcjquery_filter_isVar::isPostNumeric($_POST['configlang']);
		}
		if(isset($_POST['configcms'])){
			$this->configcms = magixcjquery_filter_isVar::isPostNumeric($_POST['configcms']);
		}
		if(isset($_POST['confignews'])){
			$this->confignews = magixcjquery_filter_isVar::isPostNumeric($_POST['confignews']);
		}
		if(isset($_POST['configcatalog'])){
			$this->configcatalog = magixcjquery_filter_isVar::isPostNumeric($_POST['configcatalog']);
		}
		if(isset($_POST['configforms'])){
			$this->configforms = magixcjquery_filter_isVar::isPostNumeric($_POST['configforms']);
		}
		if(isset($_POST['configmicrogalery'])){
			$this->configmicrogalery = magixcjquery_filter_isVar::isPostNumeric($_POST['configmicrogalery']);
		}
		if(isset($_POST['rewritenews'])){
			$this->rewritenews = magixcjquery_filter_isVar::isPostNumeric($_POST['rewritenews']);
		}
		if(isset($_POST['rewritecms'])){
			$this->rewritecms = magixcjquery_filter_isVar::isPostNumeric($_POST['rewritecms']);
		}
		if(isset($_POST['rewritecatalog'])){
			$this->rewritecatalog = magixcjquery_filter_isVar::isPostNumeric($_POST['rewritecatalog']);
		}
		if(isset($_POST['idlang'])){
			$this->idlang = magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(isset($_POST['idconfig'])){
			$this->idconfig = magixcjquery_filter_isVar::isPostNumeric($_POST['idconfig']);
		}
		if(isset($_POST['idmetas'])){
			$this->idmetas = magixcjquery_filter_isVar::isPostNumeric($_POST['idmetas']);
		}
		if(isset($_POST['strrewrite'])){
			$this->strrewrite = magixcjquery_form_helpersforms::inputClean($_POST['strrewrite']);
		}
		if(isset($_POST['level'])){
			$this->level = magixcjquery_filter_isVar::isPostNumeric($_POST['level']);
		}
		if(isset($_POST['number'])){
			$this->number = magixcjquery_filter_isVar::isPostNumeric($_POST['number']);
		}
		if(isset($_GET['edit'])){
			$this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(isset($_GET['drmetas'])){
			$this->drmetas = magixcjquery_filter_isVar::isPostNumeric($_GET['drmetas']);
		}
	}
	/**
	 * @access private
	 * function load configuration lang
	 * @string
	 */
	private function load_config_lang(){
		$config = backend_db_config::adminDbConfig()->s_config_named('lang');
		backend_config_smarty::getInstance()->assign('configlang',$config['status']);
	}
	/**
	 * @access private
	 * function load configuration cms
	 * @string
	 */
	private function load_config_cms(){
		$config = backend_db_config::adminDbConfig()->s_config_named('cms');
		backend_config_smarty::getInstance()->assign('configcms',$config['status']);
	}
	/**
	 * @access private
	 * function load configuration news
	 * @string
	 */
	private function load_config_news(){
		$config = backend_db_config::adminDbConfig()->s_config_named('news');
		backend_config_smarty::getInstance()->assign('confignews',$config['status']);
	}
	/**
	 * @access private
	 * function load configuration catalog
	 * @string
	 */
	private function load_config_catalog(){
		$config = backend_db_config::adminDbConfig()->s_config_named('catalog');
		backend_config_smarty::getInstance()->assign('configcatalog',$config['status']);
	}
	/**
	 * @access private
	 * function load configuration forms
	 * @string
	 */
	private function load_config_forms(){
		$config = backend_db_config::adminDbConfig()->s_config_named('forms');
		backend_config_smarty::getInstance()->assign('configforms',$config['status']);
	}
	/**
	 * @access protected
	 * function load configuration microgalery
	 * @string
	 */
	private function load_config_microgalery(){
		$config = backend_db_config::adminDbConfig()->s_config_named('microgalery');
		backend_config_smarty::getInstance()->assign('configmicrogalery',$config['status']);
	}
	/**
	 * @access private
	 * function load rewrite news
	 * @string
	 */
	private function load_rewrite_news(){
		$config = backend_db_config::adminDbConfig()->s_config_named('rewritenews');
		backend_config_smarty::getInstance()->assign('rewritenews',$config['status']);
	}
	/**
	 * @access private
	 * function load rewrite cms
	 * @string
	 */
	private function load_rewrite_cms(){
		$config = backend_db_config::adminDbConfig()->s_config_named('rewritecms');
		backend_config_smarty::getInstance()->assign('rewritecms',$config['status']);
	}
	/**
	 * @access private
	 * function load rewrite catalog
	 * @string
	 */
	private function load_rewrite_catalog(){
		$config = backend_db_config::adminDbConfig()->s_config_named('rewritecatalog');
		backend_config_smarty::getInstance()->assign('rewritecatalog',$config['status']);
	}
	/**
	 * @access private
	 * function admin configuration
	 * @string
	 */
	private function admin_config(){
		$perms = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
		backend_config_smarty::getInstance()->assign('perms',$perms['perms']);
	}
	/**
	 * @access private
	 * function load limited_cms_number
	 * @intégrer
	 */
	private function load_limited_cms_number(){
		$config = backend_db_config::adminDbConfig()->s_config_number_module();
		backend_config_smarty::getInstance()->assign('idconfig',$config['idconfig']);
		backend_config_smarty::getInstance()->assign('numbcmspage',$config['number']);
	}
	/**
	 * @access public
	 * @static
	 * load global attribute configuration
	 */
	public static function load_attribute_config(){
		self::load_config_lang();
		self::load_config_cms();
		self::load_config_news();
		self::load_config_catalog();
		self::load_config_forms();
		self::load_config_microgalery();
		self::load_rewrite_news();
		self::load_rewrite_cms();
		self::load_rewrite_catalog();
		self::load_limited_cms_number();
		self::admin_config();
	}
	/**
	 * update states for configuration
	 * @access private
	 */
	private function update_states(){
		if(isset($this->configlang)){
			backend_db_config::adminDbConfig()->u_config_states($this->configlang,'lang');
		}
		if(isset($this->configcms)){
			backend_db_config::adminDbConfig()->u_config_states($this->configcms,'cms');
		}
		if(isset($this->confignews)){
			backend_db_config::adminDbConfig()->u_config_states($this->confignews,'news');
		}
		if(isset($this->configcatalog)){
			backend_db_config::adminDbConfig()->u_config_states($this->configcatalog,'catalog');
		}
		if(isset($this->configforms)){
			backend_db_config::adminDbConfig()->u_config_states($this->configforms,'forms');
		}
		if(isset($this->configmicrogalery)){
			backend_db_config::adminDbConfig()->u_config_states($this->configmicrogalery,'microgalery');
		}
		if(isset($this->rewritenews)){
			backend_db_config::adminDbConfig()->u_config_states($this->rewritenews,'rewritenews');
		}
		if(isset($this->rewritecms)){
			backend_db_config::adminDbConfig()->u_config_states($this->rewritecms,'rewritecms');
		}
		if(isset($this->rewritecatalog)){
			backend_db_config::adminDbConfig()->u_config_states($this->rewritecatalog,'rewritecatalog');
		}
		if(isset($this->number)){
			backend_db_config::adminDbConfig()->u_limited_module($this->idconfig,$this->number);
		}
	}
	/**
	 * Affiche la page de configuration
	 * function display configuration
	 */
	private function display(){
		self::update_states();
		backend_config_smarty::getInstance()->display('config/index.phtml');
	}
	/**
	 * Menu de sélection pour la réécriture des métas
	 * @access private
	 */
	private function select_construct_config(){
		$config = '<select id="idconfig" name="idconfig" class="select">';
		$config .= '<option value="">Aucune sélection</option>';
		/*foreach(backend_db_config::adminDbConfig()->s_config_named_all() as $c){
			$config .= '<option value="'.$c['idconfig'].'">'.$c['named'].'</option>';
		}*/
		$config .= '<option value="5">News</option>';
		$config .= '<option value="7">Catalogue</option>';
		$config .='</select>';
		return $config;
	}
	/**
	 * Affiche la réécriture des métas trié par langue
	 * @access private
	 */
	private function view_metas(){
		$title = '<table class="clear">
						<thead>
							<tr>
							<th>Métas</th>
							<th>Module</th>
							<th>Phrase</th>
							<th>Level</th>
							<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
							</tr>
						</thead>
						<tbody>';
		if(backend_db_config::adminDbConfig()->s_rewrite_meta() != null){
			foreach(backend_db_config::adminDbConfig()->s_rewrite_meta() as $seo){
				switch($seo['idmetas']){
					case 1:
						$type = 'TITLE';
						break;
					case 2:
						$type = 'DESCRIPTION';
						break;
				}
			 	$title .= '<tr class="line">';
			 	$title .= '<td class="maximal">'.$type.'</td>';
			 	$title .= '<td class="nowrap">'.$seo['named'].'</td>';
			 	$title .= '<td class="nowrap">'.$seo['strrewrite'].'</td>';
			 	$title .= '<td class="nowrap">'.$seo['level'].'</td>';
			 	$title .= '<td class="nowrap">'.$seo['codelang'].'</td>';
			 	$title .= '<td class="nowrap">'.'<a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/config.php?metasrewrite&amp;edit='.$seo['idrewrite'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 	$title .= '<td class="nowrap">'.'<a class="d-config-rmetas" title="'.$seo['idrewrite'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 	$title .= '</tr>';
			}
		}else{
			$title .= '<tr class="line">';
			$title .= '<td class="maximal"></td>';
			$title .= '<td class="nowrap"></td>';
			$title .= '<td class="nowrap"></td>';
			$title .= '<td class="nowrap"></td>';
			$title .= '<td class="nowrap"></td>';
			$title .= '<td class="nowrap"></td>';
			$title .= '<td class="nowrap"></td>';
			$title .= '<td class="nowrap"></td>';
			$title .= '</tr>';
		}
		$title .= '</tbody></table>';
		return $title;
	}
	/**
	 * insertion de la réécriture des métas
	 * @access private
	 */
	private function insertion_rewrite(){
		if(isset($this->strrewrite)){
			if(empty($this->idconfig) OR empty($this->idmetas)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}elseif(backend_db_config::adminDbConfig()->s_rewrite_v_lang($this->idconfig,$this->idlang,$this->idmetas,$this->level) == null){
				backend_db_config::adminDbConfig()->i_rewrite_metas($this->idconfig,$this->idlang,$this->strrewrite,$this->idmetas,$this->level);
				backend_config_smarty::getInstance()->display('request/success.phtml');
			}else{
				backend_config_smarty::getInstance()->display('request/element-exist.phtml');
			}
		}
	}
	/**
	 * Mise à jour de la réécriture suivant l'identifiant
	 * @access private
	 */
	private function update_rewrite(){
		if(isset($this->edit)){
			if(isset($this->strrewrite)){
				if(empty($this->idconfig) OR empty($this->idmetas)){
					backend_config_smarty::getInstance()->display('request/empty.phtml');
				}else{
					backend_db_config::adminDbConfig()->u_rewrite_metas($this->idconfig,$this->idlang,$this->strrewrite,$this->idmetas,$this->level,$this->edit);
					backend_config_smarty::getInstance()->display('request/success.phtml');
				}
			}
		}
	}
	/**
	 * Supprime la réécriture suivant l'identifiant
	 * @access public
	 */
	private function d_rewrite(){
		if(isset($this->drmetas)){
			backend_db_config::adminDbConfig()->d_rewrite_metas($this->drmetas);
		}
	}
	/**
	 * Charge les données dans le formulaire d'édition
	 * @access private
	 */
	private function load_rewrite_for_edit(){
		if(isset($this->edit)){
			$load = backend_db_config::adminDbConfig()->s_rewrite_for_edit($this->edit);
			backend_config_smarty::getInstance()->assign('strrewrite',$load['strrewrite']);
			backend_config_smarty::getInstance()->assign('idlang',$load['idlang']);
			backend_config_smarty::getInstance()->assign('codelang',$load['codelang']);
			backend_config_smarty::getInstance()->assign('idconfig',$load['idconfig']);
			backend_config_smarty::getInstance()->assign('module',$load['named']);
			backend_config_smarty::getInstance()->assign('level',$load['level']);
			backend_config_smarty::getInstance()->assign('idmetas',$load['idmetas']);
		}
	}
	/**
	 * Affiche le formulaire et une liste des réécritures disponible
	 * @access public
	 */
	private function display_seo(){
		self::insertion_rewrite();
		backend_config_smarty::getInstance()->assign('viewmetas',self::view_metas());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->assign('selectseoconfig',self::select_construct_config());
		backend_config_smarty::getInstance()->display('config/seo.phtml');
	}
	/**
	 * Affiche le fomulaire de modification ainsi que la liste des réécritures disponible
	 * @access public
	 */
	public function display_seo_edit(){
		self::load_rewrite_for_edit();
		backend_config_smarty::getInstance()->assign('viewmetas',self::view_metas());
		backend_config_smarty::getInstance()->display('config/editseo.phtml');
	}
	public function run(){
		if(magixcjquery_filter_request::isGet('metasrewrite')){
			if(magixcjquery_filter_request::isGet('add')){
				self::insertion_rewrite();
			}elseif(magixcjquery_filter_request::isGet('edit')){
				if(magixcjquery_filter_request::isGet('post')){
					self::update_rewrite();
				}else{
					self::display_seo_edit();
				}
			}elseif(magixcjquery_filter_request::isGet('drmetas')){
				self::d_rewrite();
			}else{
				self::display_seo();
			}
		}else{
			self::display();
		}
	}
}