<?php
class frontend_seo_public extends frontend_db_seo{
	public $attribute,
	$level,
	$idmetas,
	$codelang;
	public function __construct($attribute,$level,$idmetas,$codelang){
		$this->attribute = $attribute;
		$this->level =$level;
		$this->idmetas =$idmetas;
		$this->codelang =$codelang;
	}
	private function load_current_seo(){
		return parent::s_public_rewrite(
			$this->attribute, 
			$this->level, 
			$this->idmetas, 
			$this->codelang
		);
	}
	public function replace_var_rewrite($record='',$category='',$subcategory=''){
		$db = self::load_current_seo();
		if($db != null){
			//Tableau des variables à rechercher
			$search = array('[[record]]','[[category]]','[[subcategory]]');
			//Tableau des variables à remplacer 
			$replace = array($record,$category,$subcategory);
			//texte générique à remplacer
			$content = str_replace($search ,$replace,$db['strrewrite']);
			return $content;
		}
	}
}
?>