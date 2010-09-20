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
class frontend_db_member{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $dbmember;
	/**
	 * instance frontend_db_news with singleton
	 */
	public static function dbMember(){
        if (!isset(self::$dbmember)){
         	self::$dbmember = new frontend_db_member();
        }
    	return self::$dbmember;
    }
	/**
	 * Selectionne les membres avec un statut plus grand que 3 (user admin et user)
	 */
	function s_members_user_states(){
		$sql = 'SELECT m.pseudo,m.email,p.perms from mc_admin_member m
			LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin)
			WHERE p.perms >= 3';
		return magixglobal_model_db::layerDB()->select($sql);
	}
}