<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class frontend_db_home{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * include dblang 
	 * @var dblang
	 */
	private $dblang;
	/**
	 * singleton dbhome
	 * @access public
	 * @var void
	 */
	static public $dbhome;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
		$this->dblang = new frontend_db_lang();
	}
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function getHome(){
        if (!isset(self::$dbhome)){
         	self::$dbhome = new frontend_db_home();
        }
    	return self::$dbhome;
    }
	/**
	 * selection du titre et du contenu de la page home ou index
	 * @param $codelang
	 */
	function s_home_page_construct($codelang){
		$idlang = $this->dblang->s_lang($codelang);
		if($codelang == null){
			$sql = 'SELECT subject,content,metatitle,metadescription FROM mc_page_home WHERE idlang = :idlang';
			return $this->layer->selectOne($sql,
				array(
					':idlang' => 0
				)
			);
		}else{
			$sql = 'SELECT subject,content,metatitle,metadescription FROM mc_page_home WHERE idlang = :idlang';
			return $this->layer->selectOne($sql,
				array(
					':idlang' => $idlang['idlang']
				)
			);
		}
	}
}