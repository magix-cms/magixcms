<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name templates
 *
 */
class backend_controller_templates{
	/**
	 * Cosntante
	 * @var string
	 */
	const skin = 'skin';
	/**
	 * ptheme
	 * @var string
	 */
	public $ptheme;
	/**
	 * function construct
	 */
	function __construct(){
		if(isset($_POST['theme'])){
			$this->ptheme = magixcjquery_filter_isVar::isPostAlphaNumeric($_POST['theme']);
		}
	}
	/**
	 * @access private
	 * return void
	 */
	private function directory_skin(){
		try{
			$pathdir = dirname(realpath( __FILE__ ));
			$arraydir = array('app'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'controller');
			return magixglobal_model_system::root_path($arraydir,array(self::skin) , $pathdir).DIRECTORY_SEPARATOR;
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @see backend_model_template
	 * Theme selectionné dans la base de donnée
	 */
	private function tpl_identifier(){
		return backend_model_template::backendTheme()->themeSelected();
	}
	/**
	 * Scanne le dossier skin (public) et retourne les images ou capture des thèmes
	 */
	private function scanTemplateDir(){
		$skin = self::directory_skin();
		if(!is_readable($skin)){
			throw new exception('skin is not minimal permission');
		}
		$makefiles = new magixcjquery_files_makefiles();
		//print_r($t->sizeDirectory($_SERVER['DOCUMENT_ROOT']));
		//print_r($t->scanDir($skin.'default/'));
		//print_r($t->recursiveDirectoryFile($skin));
		$dir = $makefiles->scanRecursiveDir($skin,'.svn');
		$count = count($dir);
		if($count == 0){
			throw new exception('skin is not found');
		}
		if(!is_array($dir)){
			throw new exception('skin is not array');
		}
		$dossier = null;
		foreach($dir as $d){
			if($d == self::tpl_identifier()){
				$selected = ' ui-state-highlight';
			}else{
				$selected = ' ui-state-disabled';
				$ctpl = '';
			}
			$themePath = self::directory_skin().$d;
			if($makefiles->scanDir($themePath) != null){
				if(file_exists($themePath.'/screenshot.png')){
					$dossier .= '<div class="list-screen ui-widget-content ui-corner-all'.$selected.'">';
					$dossier .= '<div class="title-skin ui-widget-header ui-corner-all"><div class="skin-name">'.$d.'</div>'.'<a href="#" class="template-edit">Edit template</a><a href="#" class="template-delete">Delete template</a></div>';
					$dossier .= '<div class="img-screen">'.'<a title="'.$d.'" href="#"><img width="150" height="125" src="'.magixcjquery_html_helpersHtml::getUrl().'/skin/'.$d.'/screenshot.png" alt="" /></a></div>';
					$dossier .= '</div>';
				}else{
					$dossier .= '<div class="list-screen ui-widget-content ui-corner-all'.$selected.'">';
					$dossier .= '<div class="title-skin ui-widget-header ui-corner-all"><div class="skin-name">'.$d.'</div><div class="rfloat">'.$ctpl.'<a href="#" class="template-edit">Edit template</a><a href="#" class="template-delete">Delete template</a></div></div>';
					$dossier .= '<div class="img-screen">'.'<a title="'.$d.'" href="#"><img width="150" height="130" src="'.magixcjquery_html_helpersHtml::getUrl().'/skin/default/screenshot.png" alt="" /></a></div>';
					$dossier .= '</div>';
				}
			}
		}
		$dossier .= '<div class="clearleft"></div>';
		return $dossier;
	}
	/**
	 * Assigne une variable pour les themes
	 */
	private function assign_screen(){
		return backend_config_smarty::getInstance()->assign('themes',self::scanTemplateDir());
	}
	/*
	 * 
	 * Met à jour le template dans la configuration
	 */
	private function change_tpl(){
		backend_model_template::backendTheme()->u_change_theme($this->ptheme);
	}
	/**
	 * Post les données concernant le template
	 */
	private function send_post_template(){
		self::change_tpl();
		backend_config_smarty::getInstance()->display('request/success-templates.phtml');
	}
	/**
	 * Affiche la page pour la sélection ou le changement de template
	 */
	private function view_tpl_screen(){
		self::assign_screen();
		backend_config_smarty::getInstance()->display('templates/index.phtml');
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		if(magixcjquery_filter_request::isGet('post')){
			self::send_post_template();
		}else{
			self::view_tpl_screen();
		}
	}
}