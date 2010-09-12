<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    3.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name home
 *
 */
class backend_controller_home{
	/**
	 * gethome
	 * @var getedit (get edit)
	 */
	public $gethome;
	/**
	 * string
	 * @var subject
	 */
	public $subject;
	/**
	 * string
	 * @var content
	 */
	public $content;
	/**
	 * string
	 * @var metatitle
	 */
	public $metatitle;
	/**
	 * string
	 * @var metadescription
	 */
	public $metadescription;
	/**
	 * integer
	 * @var delhome
	 */
	public $delhome;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(isset($_GET['edit'])){
			$this->gethome = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(isset($_POST['subject'])){
			$this->subject = magixcjquery_form_helpersforms::inputClean($_POST['subject']);
		}
		if(isset($_POST['content'])){
			$this->content = ($_POST['content']);
		}
		if(isset($_POST['idlang'])){
			$this->idlang = magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(isset($_POST['metatitle'])){
			$this->metatitle = magixcjquery_form_helpersforms::inputTagClean($_POST['metatitle']);
		}
		if(isset($_POST['metadescription'])){
			$this->metadescription = magixcjquery_form_helpersforms::inputTagClean($_POST['metadescription']);
		}
		if(isset($_GET['delhome'])){
			$this->delhome = magixcjquery_filter_isVar::isPostNumeric($_GET['delhome']);
		}
	}
	private function load_data_forms(){
		$data = backend_db_home::adminDbHome()->s_home_page_record($this->gethome);
		backend_config_smarty::getInstance()->assign('subject',$data['subject']);
		backend_config_smarty::getInstance()->assign('content',$data['content']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
		backend_config_smarty::getInstance()->assign('metatitle',$data['metatitle']);
		backend_config_smarty::getInstance()->assign('metadescription',$data['metadescription']);
	}
	private function insert_data_forms(){
		if(isset($this->subject) AND isset($this->content)){
			if(empty($this->subject) OR empty($this->content)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}else{
				if(backend_db_home::adminDbHome()->s_home_page_b_lang($this->idlang) == null){
					backend_db_home::adminDbHome()->i_new_home_page(
						$this->subject,
						$this->content,
						$this->metatitle,
						$this->metadescription,
						$this->idlang,
						backend_model_member::s_idadmin()
					);
					backend_config_smarty::getInstance()->display('request/success.phtml');
				}else{
					backend_config_smarty::getInstance()->display('request/element-exist.phtml');
				}
			}
		}
	}
	private function update_data_forms(){
		if(isset($this->subject) AND isset($this->content)){
			if(empty($this->subject) OR empty($this->content)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}else{
					backend_db_home::adminDbHome()->u_home_page(
						$this->subject,
						$this->content,
						$this->metatitle,
						$this->metadescription,
						$this->idlang,
						backend_model_member::s_idadmin(),
						$this->gethome
					);
					backend_config_smarty::getInstance()->display('request/success.phtml');
			}
		}
	}
	/**
	 * Supprime une page home
	 * @access private
	 */
	private function del_home(){
		if(isset($this->delhome)){
			backend_db_home::adminDbHome()->d_home($this->delhome);
		}
	}
	/**
	 * Edite une page home
	 * @access private
	 */
	private function edit(){
		self::load_data_forms();
		backend_config_smarty::getInstance()->display('home/edit.phtml');
	}
	/**
	 * Affiche la page principale du module
	 * @access private
	 */
	private function display(){
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('home/index.phtml');
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		if(magixcjquery_filter_request::isGet('edit')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_data_forms();
			}else{
				self::edit();
			}
		}elseif(magixcjquery_filter_request::isGet('add')){
			self::insert_data_forms();
		}elseif(magixcjquery_filter_request::isGet('delhome')){
			self::del_home();
		}else{
			self::display();
		}
	}
}
?>