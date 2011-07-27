<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1 2010-06-27
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name admin
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
		return magixglobal_model_db::layerDB()->select($sql,
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
		$sql='SELECT * FROM 
		mc_admin_member 
		WHERE email = :email';
		return magixglobal_model_db::layerDB()->selectOne($sql,
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
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * retourne les permissions de ce membre
	 * @param $email
	 */
	function perms_session_membres($email){
		$sql='SELECT p.perms from mc_admin_member m
		LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin)
		where email = :email';
		return magixglobal_model_db::layerDB()->selectOne($sql,
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
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Retourne les informations de l'utilisateur
	 */
	function view_info_members($idadmin){
		$sql='SELECT m.idadmin,m.pseudo,m.email,m.keyuniqid,p.perms from mc_admin_member m
		LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin) WHERE m.idadmin = :idadmin';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
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
		return magixglobal_model_db::layerDB()->selectOne($sql);
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
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Insert un nouveau membre dans la table mc_admin_member
	 * 
	 */
	function i_n_members($pseudo,$email,$cryptpass,$keyuniqid,$perms){
		$sql = array(
		'INSERT INTO mc_admin_member (pseudo,email,cryptpass) VALUE("'.$pseudo.'","'.$email.'","'.$cryptpass.'","'.$keyuniqid.'")',
		'INSERT INTO mc_admin_perms (perms) VALUE("'.$perms.'")'
		);
		magixglobal_model_db::layerDB()->transaction($sql);
	}
	/**
	 * Mise à jour d'un membre
	 * @param $pseudo
	 * @param $email
	 * @param $cryptpass
	 * @param $idadmin
	 */
	function u_n_members($pseudo,$email,$cryptpass,$keyuniqid,$perms,$idadmin){
		if($keyuniqid == null){
			$sql = 'UPDATE mc_admin_member as m LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin) 
			SET m.pseudo= :pseudo, m.email = :email, m.cryptpass=:cryptpass,p.perms=:perms WHERE m.idadmin = :idadmin';
			magixglobal_model_db::layerDB()->update($sql,array(
				':pseudo'=>$pseudo,
				':email'=>$email,
				':cryptpass'=>$cryptpass,
				':perms'=>$perms,
				':idadmin'=>$idadmin
			));
		}else{
			$sql = 'UPDATE mc_admin_member as m LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin) 
			SET m.pseudo= :pseudo, m.email = :email, m.cryptpass=:cryptpass,m.keyuniqid=:keyuniqid,p.perms=:perms WHERE m.idadmin = :idadmin';
			magixglobal_model_db::layerDB()->update($sql,array(
				':pseudo'=>$pseudo,
				':email'=>$email,
				':cryptpass'=>$cryptpass,
				':keyuniqid'=>$keyuniqid,
				':perms'=>$perms,
				':idadmin'=>$idadmin
			));
		}
	}
	/**
	 * Selectionne les membres avec un statut plus grand que 3 (user admin et user)
	 */
	function s_members_user_states(){
		$sql='SELECT m.pseudo,m.email,p.perms from mc_admin_member m
		LEFT JOIN mc_admin_perms p ON(m.idadmin = p.idadmin)
		WHERE p.perms >= 3';
		return magixglobal_model_db::layerDB()->select($sql);
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
		magixglobal_model_db::layerDB()->transaction($sql);
	}
}