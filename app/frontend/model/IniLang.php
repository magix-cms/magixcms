<?php
/**
 * MAGIX CMS
 * @category   MODEL 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name IniLang
 *
 */
class frontend_model_IniLang{
	/**
	 * lang setting conf
	 *
	 * @var string 'fr', ' 'en', ...
	 */
	public $loadlang;
	/**
	 * function construct class
	 *
	 */
	function __construct(){
		if (isset($_GET['strLangue'])) {
			$this->loadlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
		}
	}
	/**
	 * function display home backend
	 *
	 */
	protected function loadGlobalLang(){
		$langue = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$langue = strtolower(substr(chop($langue[0]),0,2));
		switch ($langue){
			case 'en':
				$langue = 'en';
				break;
			case 'fr':
				$langue = 'fr';
				break;
			case 'de':
				$langue = 'de';
				break;
			case 'nl':
				$langue = 'nl';
				break;
			case 'es':
				$langue = 'es';
				break;
			case 'it':
				$langue = 'it';
				break;
			default:
				$langue = 'fr';
		}
		if (empty($_SESSION['strLangue']) || !empty($this->loadlang)) {
			
	 		 return $_SESSION['strLangue'] = empty($this->loadlang) ? $langue : $this->loadlang;
	 		 
		}else{
			if (isset($this->loadlang)) {
	 		 	return $this->loadlang  = $langue;
	 		 }
		}
	}
	function autoLangSession(){
		self::loadGlobalLang();
	}
}
?>