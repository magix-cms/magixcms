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
class frontend_db_lang{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 */
	protected $layer;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
	/**
	 * selectionne l'identifiant correspondant au code de la langue
	 * @param $codelang
	 */
	function s_lang($codelang){
		$sql = 'SELECT idlang FROM mc_lang WHERE codelang = :codelang';
		return $this->layer->selectOne($sql,
			array(':codelang' => $codelang)
		);
	}
}