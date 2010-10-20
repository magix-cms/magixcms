<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
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
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name formsconstruct
 *
 */
class frontend_controller_formsconstruct{
	public $getlang;
	/**
	 * variable de sessions deslangues
	 * @var string
	 */
	public $slang;
	public $urlforms;
	public $getforms;
	function __construct(){
		if(isset($_GET['strLangue'])){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
		if(isset($_GET['urlforms'])){
			$this->urlforms = magixcjquery_form_helpersforms::inputClean($_GET['urlforms']);
		}
		if(isset($_GET['getforms'])){
			$this->getforms = magixcjquery_form_helpersforms::inputClean($_GET['getforms']);
		}
	}
	private function forms_url(){
		$forms = frontend_db_formsconstruct::publicDbForms()->s_public_getforms($this->getforms);
		frontend_config_smarty::getInstance()->assign('titleforms',$forms['titleforms']);
		frontend_config_smarty::getInstance()->assign('urlforms',$forms['urlforms']);
	}
	private function forms_construct(){
		if(isset($this->getforms)){
		$forms = '';
			if(frontend_db_formsconstruct::publicDbForms()->s_public_input_in_forms($this->getforms) !=null){
			$forms = '<table>';
			foreach(frontend_db_formsconstruct::publicDbForms()->s_public_input_in_forms($this->getforms) as $input){
				switch($input['required']){
					case 0:
						$required = '';
					break;
					case 1:
						$required = 'Obligatoire';
					break;
				}
				switch($input['type']){
					case 1:
						$forms .= '<tr><td class="label"><label for="'.$input['nameinput'].'" class="inlinelabel">'.$input['label'].' :</label></td></tr>';
						$forms .= '<tr><td>'.frontend_model_forms::field($input['nameinput'],$input['size'],$input['maxlength']).' '.$required.'</td>';
						$forms .= '</tr>';
					break;
					case 2:
						$forms .= '<tr><td class="label"><label for="'.$input['nameinput'].'" class="inlinelabel">'.$input['label'].' :</label></td></tr>';
						$forms .= '<tr><td>'.frontend_model_forms::textarea($input['nameinput'],$input['size'],$input['maxlength']).' '.$required.'</td>';
						$forms .= '</tr>';
					break;
				}
			}
			$forms .= '</table>';
			}
			return $forms;
		}
	}
	function jquery_validate_forms(){
		$input = '';
		$forms = frontend_db_formsconstruct::publicDbForms()->s_public_getforms($this->getforms);
		$jquery = 'var formdata = $("#'.$forms['urlforms'].'").validate({rules: {';
		foreach(frontend_db_formsconstruct::publicDbForms()->s_public_required_input_in_forms($this->getforms) as $row){
			$jquery .= $row['nameinput'].': {required: true,minlength: 2}';
			if($row['nameinput'] != $input){
				$jquery .= ',';
			}
		}
		$jquery .= '},';
		$jquery .= 'messages: {';
		foreach(frontend_db_formsconstruct::publicDbForms()->s_public_required_input_in_forms($this->getforms) as $row){
			$jquery .=$row['nameinput'].': {required: "Le champ est vide"}';
			if($row['nameinput'] != $input){
				$jquery .= ',';
			}
		}
		$jquery .= '}});';
		$jquery .= '$("#'.$forms['urlforms'].'").formdata;';
		return $jquery;
	}
	function assign_name_input(){
		$input = '';
		foreach(frontend_db_formsconstruct::publicDbForms()->s_public_required_input_in_forms($this->getforms) as $row){
			if(isset($_POST[$row['nameinput']])){
				$input .= $_POST[$row['nameinput']];
			}
		}
		return $input;
	}
	function mail_admin(){
		
	}
	function send_forms_mail(){
		$forms = frontend_db_formsconstruct::publicDbForms()->s_public_getforms($this->getforms);
		frontend_model_mail::simple_mail_head();
		frontend_model_mail::mail_subject($forms['titleforms']);
		frontend_model_mail::mail_body(self::assign_name_input());
		frontend_model_mail::mail_add_Address();
		frontend_model_mail::mail_submit();
		frontend_model_mail::clean_Submit();
	}
	/**
	 * 
	 */
	function display(){
		self::forms_url();
		frontend_config_smarty::getInstance()->assign('j_validate',self::jquery_validate_forms());
		frontend_config_smarty::getInstance()->assign('inputforms',self::forms_construct());
		frontend_config_smarty::getInstance()->display('forms/index.phtml');
	}
	
}