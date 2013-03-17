<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1 2010-06-27
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
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
     * @param $email
     * @param $cryptpass
     * @return void
     */
	protected function s_auth_exist($email, $cryptpass){
		$sql='SELECT m.idadmin
        FROM mc_admin_member AS m
		WHERE m.email = :email AND m.cryptpass = :cryptpass';
		return magixglobal_model_db::layerDB()->select($sql,
		array(
			':email'=> $email,
			':cryptpass' => $cryptpass
			)
		);
    }
    /**
     * Retourne les données du profil suivant son adresse mail
     * @param $email
     * @return array
     */
    protected function s_member_data_by_mail($email){
        $sql='SELECT m.*,r.role_name
        FROM mc_admin_member AS m
		JOIN mc_admin_role_user AS r ON(r.id_role=m.id_role)
		WHERE m.email = :email';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':email'=> $email
            )
        );
    }

    /**
     * Retourne les données du profil suivant son identifiant
     * @param $idadmin
     * @return array
     */
    public function s_member_data($idadmin){
        $sql='SELECT m.*,r.role_name
        FROM mc_admin_member AS m
		JOIN mc_admin_role_user AS r ON(r.id_role=m.id_role)
		WHERE m.idadmin = :idadmin';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':idadmin'=> $idadmin
            )
        );
    }

    /**
     * Retourne les statistiques des utilisateurs
     * @return array
     */
    protected function s_stats_user(){
        $sql ='SELECT admin.pseudo,admin.email,IF(rel_home.home_count>0,rel_home.home_count,0) AS HOME,
        IF(rel_news.news_count>0,rel_news.news_count,0) AS NEWS,
        IF(rel_pages.pages_count>0,rel_pages.pages_count,0) AS PAGES,
        IF(rel_product.product_count>0,rel_product.product_count,0) AS PRODUCT
        FROM mc_admin_member AS admin
        LEFT OUTER JOIN (
            SELECT admin.idadmin, count( h.idhome ) AS home_count
            FROM mc_page_home AS h
            JOIN mc_admin_member AS admin ON ( h.idadmin = admin.idadmin )
            GROUP BY h.idadmin
            )rel_home ON ( rel_home.idadmin = admin.idadmin )
        LEFT OUTER JOIN (
            SELECT admin.idadmin, count( n.idnews ) AS news_count
            FROM mc_news AS n
            JOIN mc_admin_member AS admin ON ( n.idadmin = admin.idadmin )
            GROUP BY n.idadmin
            )rel_news ON ( rel_news.idadmin = admin.idadmin )
        LEFT OUTER JOIN (
            SELECT admin.idadmin,count(cms.idadmin) AS pages_count
            FROM mc_cms_pages AS cms
            JOIN mc_admin_member AS admin ON(cms.idadmin = admin.idadmin)
            GROUP BY cms.idadmin
            )rel_pages ON ( rel_pages.idadmin = admin.idadmin )
        LEFT OUTER JOIN (
            SELECT admin.idadmin,count( catalog.idcatalog ) AS product_count
            FROM mc_catalog AS catalog
            JOIN mc_admin_member AS admin ON ( catalog.idadmin = admin.idadmin )
            GROUP BY catalog.idadmin
            )rel_product ON ( rel_product.idadmin = admin.idadmin )
        GROUP BY admin.idadmin';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * Retourne la liste des rôles
     * @param $select_role
     * @return array
     */
    protected function s_role($select_role){
        $sql='SELECT r.id_role,r.role_name
        FROM mc_admin_role_user AS r
        WHERE r.id_role IN('.$select_role.')';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * Retourne la liste des utilisateurs
     * @param $select_role
     * @return array
     */
    protected function s_users($select_role){
        $sql='SELECT m.*,r.role_name
        FROM mc_admin_member AS m
        JOIN mc_admin_role_user as r USING(id_role)
        WHERE m.id_role IN('.$select_role.')';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * Retourne le rôle de l'utilisateur (pour edition)
     * @param $idadmin
     * @return array
     */
    protected function s_user_role($idadmin){
        $sql='SELECT r.id_role,r.role_name
        FROM mc_admin_member AS m
		JOIN mc_admin_role_user AS r ON(r.id_role=m.id_role)
		WHERE m.idadmin = :idadmin';
        return magixglobal_model_db::layerDB()->select($sql,
            array(
                ':idadmin'=> $idadmin
            )
        );
    }

    /**
     * Insert un nouvel utilisateur
     * @param $id_role
     * @param $pseudo
     * @param $email
     * @param $cryptpass
     * @param $keyuniqid
     */
    protected function i_new_user($id_role,$pseudo,$email,$cryptpass,$keyuniqid){
		$sql = 'INSERT INTO mc_admin_member(id_role,pseudo,email,cryptpass,keyuniqid)
		VALUE(:id_role,:pseudo,:email,:cryptpass,:keyuniqid)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':id_role'		=>	$id_role,
                ':pseudo'		=>	$pseudo,
                ':email'		=>	$email,
                ':cryptpass'	=>	$cryptpass,
                ':keyuniqid'	=>	$keyuniqid
            ));
	}

    /**
     * @param $idadmin
     * @param $pseudo
     * @param $email
     * @param $id_role
     */
    protected function u_user_data($idadmin,$pseudo,$email,$id_role){
        $sql = 'UPDATE mc_admin_member as m
		SET m.pseudo= :pseudo, m.email = :email, m.id_role=:id_role
		WHERE m.idadmin = :idadmin';
        magixglobal_model_db::layerDB()->update($sql,array(
            ':pseudo'=>$pseudo,
            ':email'=>$email,
            ':id_role'=>$id_role,
            ':idadmin'=>$idadmin
        ));
    }

    /**
     * @param $idadmin
     * @param $cryptpass
     */
    protected function u_user_password($idadmin,$cryptpass){
        $sql = 'UPDATE mc_admin_member as m
		SET m.cryptpass=:cryptpass
		WHERE m.idadmin = :idadmin';
        magixglobal_model_db::layerDB()->update($sql,array(
            ':cryptpass'=>$cryptpass,
            ':idadmin'=>$idadmin
        ));
    }
	/**
	 * supprime un utilisateur
	 * @param $idadmin
	 */
	protected function d_user($idadmin){
        $sql = 'DELETE FROM mc_admin_member
        WHERE idadmin =:idadmin';
        magixglobal_model_db::layerDB()->delete($sql,array(
            ':idadmin'=>$idadmin
        ));
	}
}