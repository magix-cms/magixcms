<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name LANG
 * @version 1.0
 *
 */
class backend_controller_lang{
	public $codelang;
	public $desclang;
	function __construct(){
		if(isset($_POST['codelang'])){
			$this->codelang = magixcjquery_form_helpersforms::inputCleanStrolower($_POST['codelang']);
		}
		if(isset($_POST['desclang'])){
			$this->desclang = magixcjquery_form_helpersforms::inputClean($_POST['codelang']);
		}
	}
	/**
	 * retourne les langues ajouté
	 */
	function full_language(){
		$lang = null;
		$lang .= '<table class="clear">
						<thead>
							<tr>
							<th>code Langue</th>
							<th>Langue</th>
							<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_lang::dblang()->s_full_lang_data() as $slang){
			 $lang .= '<tr class="line">';
			 $lang .=	'<td class="maximal">'.$slang['codelang'].'</td>';
			 $lang .=	'<td class="nowrap">'.$slang['desclang'].'</td>';
			 $lang .= 	'<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/lang/edit/'.$slang['idlang'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 $lang .= '</tr>';
		}
		$lang .= '</tbody></table>';
		return $lang;
	}
	/**
	 * insertion d'une nouvelle langue avec système de controle
	 */
	function insert_new_lang(){
		if(isset($this->codelang) AND isset($this->desclang)){
			if(empty($this->codelang) OR empty($this->desclang)){
				backend_config_smarty::getInstance()->assign(
				'msg',
				'<div style="margin:5px;padding:5px;" class="ui-state-error ui-corner-all">
				<span style="float:left;" class="ui-icon ui-icon-alert"></span>Les champs ne sont pas tous rempli</div>'
				);
			}elseif(backend_db_lang::dblang()->s_verif_lang($this->codelang) == null){
				backend_db_lang::dblang()->i_new_lang($this->codelang,$this->desclang);
			}else{
				backend_config_smarty::getInstance()->assign(
					'msg',
					'<div style="margin:5px;padding:5px;" class="ui-state-error ui-corner-all">
					<span style="float:left;" class="ui-icon ui-icon-alert"></span>Cette langue existe déjà</div>'
					);
			}
		}
	}
	function count_lang(){
		$lang = null;
		$lang .= '<table class="clear">
						<thead>
							<tr>
								<th>Module</th>
								<th>code Langue</th>
								<th>Langue</th>
								<th>Nbr pages</th>
							</tr>
						</thead>
						<tbody>';
		//Compte les langues dans la page home
		foreach(backend_db_lang::dblang()->count_lang_home() as $clang){
			$lang .= '<tr class="line">';
			$lang .=	'<td class="nowrap">home</td>';
			$lang .=	'<td class="nowrap">'.$clang['codelang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['desclang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['countlang'].'</td>';
			$lang .= '</tr>';
		}
		//Compte les langues dans le CMS
		foreach(backend_db_lang::dblang()->count_lang_pages() as $clang){
			$lang .= '<tr class="line">';
			$lang .=	'<td class="nowrap">CMS</td>';
			$lang .=	'<td class="nowrap">'.$clang['codelang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['desclang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['countlang'].'</td>';
			$lang .= '</tr>';
		}
		//Compte les langues dans les news
		foreach(backend_db_lang::dblang()->count_lang_news() as $clang){
			$lang .= '<tr class="line">';
			$lang .=	'<td class="nowrap">News</td>';
			$lang .=	'<td class="nowrap">'.$clang['codelang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['desclang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['countlang'].'</td>';
			$lang .= '</tr>';
		}
		$lang .= '</tbody></table>';
		return $lang;
	}
	/**
	 * Affiche la page des langues
	 */
	function display(){
		self::insert_new_lang();
		backend_config_smarty::getInstance()->assign('viewlang',self::full_language());
		backend_config_smarty::getInstance()->assign('countlang',self::count_lang());
		backend_config_smarty::getInstance()->display('lang/index.phtml');
	}
}