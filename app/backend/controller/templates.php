<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name templates
 * @version 0.1alpha
 *
 */
class backend_controller_templates{
	/**
	 * Cosntante
	 * @var string
	 */
	const skin = '/skin/';
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
	private function directory_skin(){
		return $_SERVER['DOCUMENT_ROOT'].self::skin;
	}
	/**
	 * @see backend_model_template
	 * Theme selectionné dans la base de donnée
	 */
	function tpl_identifier(){
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
				$selected = ' ui-state-active';
			}else{
				$selected = ' ui-state-disabled';
			}
			$themePath = self::directory_skin().$d;
			if($makefiles->scanDir($themePath) != null){
				if(file_exists($themePath.'/screenshot.png')){
					$dossier .= '<div class="list-screen ui-widget-content ui-corner-all'.$selected.'">';
					$dossier .= '<div class="title-skin ui-widget-header ui-corner-all">'.$d.'</div>';
					$dossier .= '<div class="img-screen">'.'<a title="'.$d.'" href="#"><img src="'.magixcjquery_html_helpersHtml::getUrl().'/skin/'.$d.'/screenshot.png" alt="" /></a></div>';
					$dossier .= '</div>';
				}else{
					$dossier .= '<div class="list-screen ui-widget-content ui-corner-all'.$selected.'">';
					$dossier .= '<div class="title-skin ui-widget-header ui-corner-all">'.$d.'</div>';
					$dossier .= '<div class="img-screen">'.'<a title="'.$d.'" href="#"><img src="'.magixcjquery_html_helpersHtml::getUrl().'/skin/default/screenshot.png" alt="" /></a></div>';
					$dossier .= '</div>';
				}
			}
		}
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
	public function send_post_template(){
		self::change_tpl();
		$fetch = backend_config_smarty::getInstance()->display('templates/success.phtml');
		backend_config_smarty::getInstance()->assign('msg',$fetch);
	}
	/**
	 * Affiche la page pour la sélection ou le changement de template
	 */
	public function view_tpl_screen(){
		self::assign_screen();
		backend_config_smarty::getInstance()->display('templates/index.phtml');
	}
}