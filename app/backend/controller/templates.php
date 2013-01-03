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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
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
        if(magixcjquery_filter_request::isPost('theme')){
            $this->ptheme = magixcjquery_form_helpersforms::inputClean($_POST['theme']);
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
	}
	/**
	 * @access private
	 * return void
	 */
	protected function directory_skin(){
		try{
			return magixglobal_model_system::base_path().self::skin.DIRECTORY_SEPARATOR;
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Scanne le dossier skin (public) et retourne les images ou capture des thèmes
	 */
	private function scanTemplateDir(){
		$skin = self::directory_skin();
		if(!is_readable($skin)){
			throw new exception('skin is not minimal permission');
		}
		$makefiles = new magixcjquery_files_makefiles();
		$dir = $makefiles->scanRecursiveDir($skin,'.svn');
		$count = count($dir);
		if($count == 0){
			throw new exception('skin is not found');
		}
		if(!is_array($dir)){
			throw new exception('skin is not array');
		}
        $template = null;
		foreach($dir as $d){
			if($d == backend_model_template::backendTheme()->themeSelected()){
				$btn_class = ' btn-primary';
                $btn_title = 'Sélectionner';
			}else{
				$ctpl = '';
                $btn_class = '';
                $btn_title = 'Choisir';
			}
			$themePath = self::directory_skin().$d;
			if($makefiles->scanDir($themePath) != null){
				/*if(file_exists($themePath.'/screenshot.png')){
					$dossier .= '<div class="list-screen ui-widget-content ui-corner-all'.$selected.'">';
					$dossier .= '<div class="title-skin ui-widget-header ui-corner-all"><div class="skin-name">'.$d.'</div>'.'</div>';
					$dossier .= '<div class="img-screen">'.'<a title="'.$d.'" href="#"><img width="150" height="125" src="'.magixcjquery_html_helpersHtml::getUrl().'/skin/'.$d.'/screenshot.png" alt="" /></a></div>';
					$dossier .= '</div>';
				}else{
					$dossier .= '<div class="list-screen ui-widget-content ui-corner-all'.$selected.'">';
					$dossier .= '<div class="title-skin ui-widget-header ui-corner-all"><div class="skin-name">'.$d.'</div>'.'</div>';
					$dossier .= '<div class="img-screen">'.'<a title="'.$d.'" href="#"><img width="150" height="130" src="'.magixcjquery_html_helpersHtml::getUrl().'/skin/default/screenshot.png" alt="" /></a></div>';
					$dossier .= '</div>';
				}*/
                if(file_exists($themePath.'/screenshot.png')){
                    $img = magixcjquery_html_helpersHtml::getUrl().'/skin/'.$d.'/screenshot.png';
                }else{
                    $img = magixcjquery_html_helpersHtml::getUrl().'/skin/default/screenshot.png';
                }
                $template .= '<li class="span3">';
                    $template .= '<div class="thumbnail">';
                        $template .= '<img src="'.$img.'" data-src="holder.js/260x180" alt="'.$btn_title.'">';
                        $template .= '<div class="caption">';
                        $template .= '<h3>'.$d.'</h3>';
                        $template .= '<p><a data-skin="'.$d.'" class="skin-tpl btn btn-large btn-block'.$btn_class.'" href="#">'.$btn_title.'</a></p>';
                        $template .= '</div>';
                    $template .= '</div>';
                $template .= '</li>';
			}
		}
		return $template;
	}
	/**
	 * @access private
	 * Met à jour le template dans la configuration
	 */
	private function change_tpl(){
		backend_model_template::backendTheme()->u_change_theme($this->ptheme);
	}
	/**
	 * @access private
	 * Post les données concernant le template
	 */
	private function send_post_template(){
		self::change_tpl();
		backend_controller_template::display('request/success-templates.phtml');
	}

	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
        $create = new backend_controller_template();
		if(magixcjquery_filter_request::isGet('post')){
			self::send_post_template();
		}else{
            $create->assign('themes',self::scanTemplateDir());
            $create->display('tpl/index.phtml');
		}
	}
}