<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 *
 */
class frontend_db_lang{
	/**
	 * selectionne l'identifiant correspondant au code de la langue
	 * @param $codelang
	 */
	function s_lang($codelang){
		$sql = 'SELECT idlang FROM mc_lang WHERE codelang = :codelang';
		return magixglobal_model_db::layerDB()->selectOne($sql,
			array(':codelang' => $codelang)
		);
	}
}