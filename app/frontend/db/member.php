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
class frontend_db_member{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $dbmember;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
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
		return $this->layer->select($sql);
	}
}