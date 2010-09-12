<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.1 alpha
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name formsconstruct
 *
 */
class backend_controller_formsconstruct{
	/**
	 * @access public
	 * @var idlang
	 */
	public $idlang;
	/**
	 * 
	 * @var urlforms
	 */
	public $urlforms;
	/**
	 * 
	 * @var titleforms
	 */
	public $titleforms;
	/**
	 * @access public
	 * @var idforms
	 */
	public $idforms;
	/**
	 * @access public
	 * @var label
	 */
	public $label;
	/**
	 * @access public
	 * @var type
	 */
	public $type;
	/**
	 * @access public
	 * @var nameinput
	 */
	public $nameinput;
	/**
	 * @access public
	 * @var required
	 */
	public $required;
	/**
	 * @access public
	 * @var size
	 */
	public $size;
	/**
	 * @access public
	 * @var maxlength
	 */
	public $maxlength;
	/**
	 * @access public
	 * @var value
	 */
	public $value;
	/**
	 * @access public
	 * @var getforms
	 */
	public $getforms;
	/**
	 * @access public
	 * @var delinput
	 */
	public $delinput;
	/**
	 * function construct class
	 */
	function __construct(){
		if(isset($_POST['idlang'])){
			$this->idlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(isset($_POST['titleforms'])){
			$this->titleforms = magixcjquery_form_helpersforms::inputClean($_POST['titleforms']);
			$this->urlforms = magixcjquery_url_clean::rplMagixString($_POST['titleforms']);
		}
		if(isset($_POST['idforms'])){
			$this->idforms = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idforms']);
		}
		if(isset($_POST['label'])){
			$this->label = magixcjquery_form_helpersforms::inputClean($_POST['label']);
		}
		if(isset($_POST['type'])){
			$this->type = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['type']);
		}
		if(isset($_POST['nameinput'])){
			$this->nameinput = magixcjquery_url_clean::rplMagixString($_POST['nameinput']);
		}
		if(isset($_POST['required'])){
			$this->required = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['required']);
		}
		if(isset($_POST['size'])){
			$this->size = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['size']);
		}
		if(isset($_POST['maxlength'])){
			$this->maxlength = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['maxlength']);
		}
		if(isset($_POST['value'])){
			$this->value = magixcjquery_form_helpersforms::inputClean($_POST['value']);
		}
		if(isset($_GET['getforms'])){
			$this->getforms = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getforms']);
		}
		if(isset($_GET['delinput'])){
			$this->delinput = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delinput']);
		}
	}
	private function select_identify_forms(){
		$dbforms = backend_db_formsconstruct::adminDbForms()->s_selected_forms();
		$countforms = backend_db_formsconstruct::adminDbForms()->c_forms_size();
		$tforms = $countforms['countforms'] +2;
		$lang = '';
		$select='<select name="idforms" id="idforms" style="width:150px;" size="'.$tforms.'">';
		foreach ($dbforms as $row){
			if ($row['codelang'] != $lang) {
			       if ($lang != '') { $select .= "</optgroup>\n"; }
			       $select .= '<optgroup label="'.$row['codelang'].'">';
			}
			$select .= '<option value="'.$row['idforms'].'">'.$row['titleforms'].'</option>';
			$lang = $row['codelang'];
		}
		if ($lang != '') { $select .= "</optgroup>\n"; }
		$select .='</select>';
		return $select;
	}
	private function insert_new_forms(){
		if(isset($this->titleforms)){
			backend_db_formsconstruct::adminDbForms()->i_forms($this->idlang,$this->titleforms,$this->urlforms);
		}
	}
	private function insert_new_input(){
		if(isset($this->idforms)){
			backend_db_formsconstruct::adminDbForms()->i_forms_input($this->idforms,$this->label,$this->type,$this->nameinput,$this->required,$this->size,$this->maxlength,$this->value);
		}
	}
	private function input(){
		if(isset($this->getforms)){
			$forms = '';
			if(backend_db_formsconstruct::adminDbForms()->s_input_in_forms($this->getforms) !=null){
			$forms = '<table>';
			foreach(backend_db_formsconstruct::adminDbForms()->s_input_in_forms($this->getforms) as $input){
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
						$forms .= '<tr><td>'.backend_model_forms::field($input['nameinput'],$input['size'],$input['maxlength']).' '.$required.'</td>';
						$forms .= '<td><div class="ui-state-error" style="border:none;"><a class="deleteinput" title="'.$input['idinput'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></div></td>';
						$forms .= '</tr>';
					break;
					case 2:
						$forms .= '<tr><td class="label"><label for="'.$input['nameinput'].'" class="inlinelabel">'.$input['label'].' :</label></td></tr>';
						$forms .= '<tr><td>'.backend_model_forms::textarea($input['nameinput'],$input['size'],$input['maxlength']).' '.$required.'</td>';
						$forms .= '<td><div class="ui-state-error" style="border:none;"><a class="deleteinput" title="'.$input['idinput'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></div></td>';
						$forms .= '</tr>';
					break;
				}
			}
			$forms .= '</table>';
			}
			return $forms;
		}
	}
	function delete_input(){
		if(isset($this->delinput)){
			backend_db_formsconstruct::adminDbForms()->d_input($this->delinput);
		}
	}
	function display_forms_input(){
		if(isset($this->getforms)){
			$f = backend_db_formsconstruct::adminDbForms()->s_getforms_unique($this->getforms);
			backend_config_smarty::getInstance()->assign('titleforms',$f['titleforms']);
			backend_config_smarty::getInstance()->assign('urlforms',$f['urlforms']);
			backend_config_smarty::getInstance()->assign('input',self::input());
			backend_config_smarty::getInstance()->display('forms/input.phtml');
		}
	}
	/**
	 * Affiche la page principal des formulaires
	 */
	function display_index(){
		self::insert_new_forms();
		self::insert_new_input();
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->assign('selectforms',self::select_identify_forms());
		backend_config_smarty::getInstance()->display('forms/index.phtml');
	}
}