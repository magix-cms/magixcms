<?php
/**
 * @category   DB CLass 
 * @package    Magix cms
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_db_admin{
	/**
	 * singleton dbhome
	 * @access public
	 * @var void
	 */
	static public $adminDbMember;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbMember(){
        if (!isset(self::$adminDbMember)){
         	self::$adminDbMember = new backend_db_admin();
        }
    	return self::$adminDbMember;
    }
	/**
	 * connexion des membres ou vérification du membre
	 *
	 * @return void
	 */
	function s_auth_exist($email, $cryptpass){
		$sql='SELECT idadmin from mc_admin_member where email = :email AND cryptpass = :cryptpass';
		return $this->layer->select($sql,
		array(
			':email'=> $email,
			':cryptpass' => $cryptpass
			)
		);
	}
	/**
	 * retourne l identifiant, le mail et le pseudo via l'adresse mail
	 * @param $email
	 * @return void
	 */
	function s_t_profil_url($email){
		$sql='SELECT idadmin,pseudo from mc_admin_member where email = :email';
		return $this->layer->selectOne($sql,
		array(
			':email'=> $email
			)
		);
	}
	/**
	 * Retourne les personnes connecté ou online
	 * @return void
	 */
	function s_session_membres(){
		$sql = 'SELECT pr.idadmin, pr.pseudo, p.perms,
				CASE WHEN session.userid IS NULL
				THEN 0
				ELSE 1
				END AS connex
				FROM mc_admin_member pr
				LEFT JOIN mc_admin_session AS session ON ( pr.idadmin = session.userid )
				LEFT JOIN mc_admin_perms AS p ON ( p.idadmin = pr.idadmin )';
		return $this->layer->select($sql);
	}
	/**
	 * retourne les permissions de ce membre
	 * @param $email
	 */
	function perms_session_membres($email){
		$sql='SELECT p.perms from mc_admin_member m
		LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin)
		where email = :email';
		return $this->layer->selectOne($sql,
		array(
			':email'=> $email
			)
		);
	}
	/**
	 * retourne la liste des membres avec le pseudo, l'email et les permissions
	 * @return array()
	 */
	function view_list_members(){
		$sql='SELECT m.idadmin,m.pseudo,m.email,p.perms from mc_admin_member m
		LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin)';
		return $this->layer->select($sql);
	}
	/**
	 * Retourne les informations de l'utilisateur
	 */
	function view_info_members($idadmin){
		$sql='SELECT m.idadmin,m.pseudo,m.email,p.perms from mc_admin_member m
		LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin) WHERE m.idadmin = :idadmin';
		return $this->layer->selectOne($sql,array(
			':idadmin'=> $idadmin
		));
	}
	/**
	 * retourne le nombre total de membres
	 * @return array()
	 */
	function c_max_members(){
		$sql = 'SELECT count( m.idadmin ) as countadmin
				from mc_admin_member m
				LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin)';
		return $this->layer->selectOne($sql);
	}
	/**
	 * retourne le nombre de membres par hierarchie (permissions)
	 * @return array()
	 */
	function c_members_by_perms(){
		$sql = 'SELECT count( m.idadmin ) as countadmin,p.perms
				from mc_admin_member m
				LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin)
				GROUP BY p.perms ORDER BY p.perms';
		return $this->layer->select($sql);
	}
	/**
	 * Insert un nouveau membre dans la table mc_admin_member
	 * 
	 */
	function i_n_members($pseudo,$email,$cryptpass,$perms){
		$sql = array(
		'INSERT INTO mc_admin_member (pseudo,email,cryptpass) VALUE("'.$pseudo.'","'.$email.'","'.$cryptpass.'")',
		'INSERT INTO mc_admin_perms (perms) VALUE("'.$perms.'")'
		);
		$this->layer->transaction($sql);
	}
	/**
	 * Mise à jour d'un membre
	 * @param $pseudo
	 * @param $email
	 * @param $cryptpass
	 * @param $idadmin
	 */
	function u_n_members($pseudo,$email,$cryptpass,$perms,$idadmin){
		$sql = 'UPDATE mc_admin_member as m LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin) 
		SET m.pseudo= :pseudo, m.email = :email, m.cryptpass=:cryptpass,p.perms=:perms WHERE m.idadmin = :idadmin';
		$this->layer->update($sql,array(
			':pseudo'=>$pseudo,
			':email'=>$email,
			':cryptpass'=>$cryptpass,
			':perms'=>$perms,
			':idadmin'=>$idadmin
		));
	}
	/**
	 * Selectionne les membres avec un statut plus grand que 3 (user admin et user)
	 */
	function s_members_user_states(){
		$sql='SELECT m.pseudo,m.email,p.perms from mc_admin_member m
		LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin)
		WHERE p.perms >= 3';
		return $this->layer->select($sql);
	}
	/**
	 * supprime un utilisateur
	 * @param $idadmin
	 */
	function d_members_user($idadmin){
		$sql = array(
		'DELETE FROM mc_admin_member WHERE idadmin = "'.$idadmin.'"',
		'DELETE FROM mc_admin_perms WHERE idadmin = "'.$idadmin.'"'
		);
		$this->layer->transaction($sql);
	}
}