<?php
class backend_model_modules{
	/**
	 * Tableau des modules
	 * @access public
	 * @staticvar $_array_module
	 */
	private static $_array_module;
	private static $options_default = array(
		'News'=>'news','Catalogue'=>'catalog'
	);
	/**
	 * 
	 * Constructeur
	 */
	public function __construct($arraymods = ''){
		self::$_array_module = $arraymods;
	}
	private function _tab_module(){
		if(self::$_array_module != null){
			$tabs = self::$_array_module;
		}else{
			$tabs = self::$options_default;
		}
		return $tabs;
	}
	/**
	 * @access public
	 * @static
	 * Menu select pour le choix du module
	 */
	public static function select_menu_module(){
		$arrayMod = self::_tab_module();
		$module = '<select name="attribute" id="attribute" class="ui-widget-content">';
		$module .= '<option value="">Choisir un module</option>';
		foreach($arrayMod as $md => $key){
			$module .='<option value="'.$key.'">'.$md.'</option>';
		}
		$module .= '</select>';
		return $module;
	}
}