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
 * @copyright  MAGIX CMS Copyright (c) 2010 -2014 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1 2010-06-27
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name admin
 *
 */
class backend_db_employee{

    /**
     * connexion des membres ou vérification du membre
     * @param $email_admin
     * @param $passwd_admin
     * @return array
     */
    protected function s_auth_exist($email_admin, $passwd_admin){
        $sql='SELECT em.* from mc_admin_employee AS em
        LEFT JOIN mc_admin_access_rel AS acrel ON ( em.id_admin = acrel.id_admin )
        WHERE em.email_admin = :email_admin AND em.passwd_admin = :passwd_admin
        AND em.active_admin = 1 AND acrel.id_admin=em.id_admin';
		return magixglobal_model_db::layerDB()->selectOne($sql,
		array(
            ':email_admin'=> $email_admin,
            ':passwd_admin' => $passwd_admin
			)
		);
    }

    /**
     * @access public
     * Retourne un tableau des sessions
     * @param $keyuniqid_admin
     * @return mixed
     */
    public function s_data_session($keyuniqid_admin){
        $sql='SELECT em.*, pr.role_name, pr.id_role
            FROM mc_admin_employee AS em
            JOIN mc_admin_access_rel AS acrel ON ( em.id_admin = acrel.id_admin )
            JOIN mc_admin_role_user AS pr ON ( acrel.id_role = pr.id_role )
            WHERE em.keyuniqid_admin = :keyuniqid_admin';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':keyuniqid_admin'=> $keyuniqid_admin
            )
        );
    }

    /**
     * Retourne les statistiques des utilisateurs
     * @return array
     */
    protected function s_stats_user(){
        $sql ='SELECT admin.pseudo_admin,admin.email_admin,IF(rel_home.home_count>0,rel_home.home_count,0) AS HOME,
        IF(rel_news.news_count>0,rel_news.news_count,0) AS NEWS,
        IF(rel_pages.pages_count>0,rel_pages.pages_count,0) AS PAGES,
        IF(rel_product.product_count>0,rel_product.product_count,0) AS PRODUCT
        FROM mc_admin_employee AS admin
        LEFT OUTER JOIN (
            SELECT admin.id_admin, count( h.idhome ) AS home_count
            FROM mc_page_home AS h
            JOIN mc_admin_employee AS admin ON ( h.idadmin = admin.id_admin )
            GROUP BY h.idadmin
            )rel_home ON ( rel_home.id_admin = admin.id_admin )
        LEFT OUTER JOIN (
            SELECT admin.id_admin, count( n.idnews ) AS news_count
            FROM mc_news AS n
            JOIN mc_admin_employee AS admin ON ( n.idadmin = admin.id_admin )
            GROUP BY n.idadmin
            )rel_news ON ( rel_news.id_admin = admin.id_admin )
        LEFT OUTER JOIN (
            SELECT admin.id_admin,count(cms.idadmin) AS pages_count
            FROM mc_cms_pages AS cms
            JOIN mc_admin_employee AS admin ON(cms.idadmin = admin.id_admin)
            GROUP BY cms.idadmin
            )rel_pages ON ( rel_pages.id_admin = admin.id_admin )
        LEFT OUTER JOIN (
            SELECT admin.id_admin,count( catalog.idcatalog ) AS product_count
            FROM mc_catalog AS catalog
            JOIN mc_admin_employee AS admin ON ( catalog.idadmin = admin.id_admin )
            GROUP BY catalog.idadmin
            )rel_product ON ( rel_product.id_admin = admin.id_admin )
        GROUP BY admin.id_admin';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * @access protected
     * Suppression des sessions inutilisés
     * @param $limit
     */
    public function d_session_lastmodified($limit){
        $sql = 'DELETE FROM mc_admin_session
		WHERE TO_DAYS(DATE_FORMAT(NOW(), "%Y%m%d")) - TO_DAYS(DATE_FORMAT(last_modified_session, "%Y%m%d")) > :limit';
        magixglobal_model_db::layerDB()->delete($sql,
            array(
                ':limit'=>$limit
            )
        );
    }

    /**
     * @access protected
     * Suppression de la session
     * @param $id_admin
     */
    public function d_session_current($id_admin){
        $sql = 'DELETE FROM mc_admin_session
        WHERE id_admin = :id_admin';
        magixglobal_model_db::layerDB()->delete($sql,
            array(
                ':id_admin'=> $id_admin

            ));
    }

    /**
     * @access public
     * Insertion d'une nouvelle session
     * @param $id_admin
     * @param $ip_session
     * @param $browser_admin
     * @param $keyuniqid_admin
     */
    public function i_new_sessionId($id_admin,$ip_session,$browser_admin,$keyuniqid_admin){
        $sql = 'INSERT INTO mc_admin_session (id_admin_session,id_admin,ip_session,browser_admin,keyuniqid_admin)
        VALUE (:id_admin_session,:id_admin,:ip_session,:browser_admin,:keyuniqid_admin)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':id_admin_session'=> session_id(),
                ':id_admin'=> $id_admin,
                ':ip_session'=> $ip_session,
                ':browser_admin' => $browser_admin,
                ':keyuniqid_admin' => $keyuniqid_admin
            )
        );
    }

    /**
     * @access public
     * Suppression de la session courante
     * @param $id_admin_session
     */
    public function d_session_admin_session($id_admin_session){
        $sql = 'DELETE FROM mc_admin_session WHERE id_admin_session = :id_admin_session';
        magixglobal_model_db::layerDB()->delete($sql,
            array(
                ':id_admin_session'=>$id_admin_session
            )
        );
    }

    /**
     * @access public
     * Retourne un tableau des identifiants
     * récupère la session utilisateur via la session actuelle
     * @return void
     */
    public function s_id_admin_session(){
        $sql = 'SELECT id_admin_session,id_admin FROM mc_admin_session
        WHERE id_admin_session = :id_admin_session';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':id_admin_session'=>session_id()
            )
        );
    }
    // Employee
    /**
     * Retourne un tableau des employées
     * @access protected
     * @return mixed
     */
    protected function s_listing_employee(){
        $sql='SELECT em.*,pr.*
        FROM mc_admin_employee AS em
        LEFT JOIN mc_admin_access_rel AS acrel ON( em.id_admin = acrel.id_admin )
        LEFT JOIN mc_admin_role_user AS pr ON( acrel.id_role = pr.id_role )';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * @access protected
     * Retourne un tableau des informations des utilisateurs
     * @param $edit
     * @return mixed
     */
    protected function s_edit_employee($edit){
        $sql='SELECT emp.*,access_rel.id_role
        FROM mc_admin_employee emp
        JOIN mc_admin_access_rel as access_rel ON(access_rel.id_admin = emp.id_admin)
        WHERE emp.id_admin = :edit';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':edit'=>$edit
        ));
    }
    /**
     * @access protected
     * Insertion d'un nouvel employé
     *
     * @param $keyuniqid_admin
     * @param $lastname_admin
     * @param $firstname_admin
     * @param $email_admin
     * @param $passwd_admin
     */
    protected function i_new_employee($keyuniqid_admin,$lastname_admin,$firstname_admin,$pseudo_admin,$email_admin,$passwd_admin){
        $sql = 'INSERT INTO mc_admin_employee (keyuniqid_admin,lastname_admin,firstname_admin,pseudo_admin,email_admin,passwd_admin,last_change_admin)
        VALUE (:keyuniqid_admin,:lastname_admin,:firstname_admin,:pseudo_admin,:email_admin,:passwd_admin,NOW())';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':keyuniqid_admin'=> $keyuniqid_admin,
                ':lastname_admin'=> $lastname_admin,
                ':firstname_admin'=> $firstname_admin,
                ':pseudo_admin'=> $pseudo_admin,
                ':email_admin'=> $email_admin,
                ':passwd_admin'=> $passwd_admin
            )
        );
    }

    /**
     * @access protected
     * Edition des informations des utilisateurs
     * @param $edit
     * @param $lastname_admin
     * @param $firstname_admin
     * @param $email_admin
     */
    protected function u_edit_employee_infos($edit,$lastname_admin,$firstname_admin,$pseudo_admin,$email_admin){
        $sql = 'UPDATE mc_admin_employee SET lastname_admin=:lastname_admin,firstname_admin=:firstname_admin,pseudo_admin=:pseudo_admin,
        email_admin=:email_admin
		WHERE id_admin = :edit';
        magixglobal_model_db::layerDB()->update($sql,array(
            ':edit'             => $edit,
            ':lastname_admin'   => $lastname_admin,
            ':firstname_admin'  => $firstname_admin,
            ':pseudo_admin'     => $pseudo_admin,
            ':email_admin'      => $email_admin
        ));
    }

    /**
     * @access protected
     * Edition du mot de passe des utilisateurs
     * @param $edit
     * @param $passwd_admin
     */
    protected function u_edit_employee_passwd($edit,$passwd_admin){
        $sql = 'UPDATE mc_admin_employee SET passwd_admin=:passwd_admin
		WHERE id_admin = :edit';
        magixglobal_model_db::layerDB()->update($sql,array(
            ':edit'         => $edit,
            ':passwd_admin' => $passwd_admin
        ));
    }

    /**
     * @access protected
     * Edition du statut des utilisateurs
     * @param $edit
     * @param $active_admin
     */
    protected function u_statut_employee($edit,$active_admin){
        $sql = 'UPDATE mc_admin_employee SET active_admin=:active_admin
		WHERE id_admin = :edit';
        magixglobal_model_db::layerDB()->update($sql,array(
            ':edit'         => $edit,
            ':active_admin' => $active_admin
        ));
    }
    /**
     * supprime un utilisateur
     * @param $idadmin
     */
    protected function d_employee($idadmin){
        $sql = array(
            'DELETE FROM mc_admin_access_rel
             WHERE id_admin ='.$idadmin,
            'DELETE FROM mc_admin_employee
             WHERE id_admin ='.$idadmin);
        magixglobal_model_db::layerDB()->transaction($sql);
    }
    // Profile
    /**
     * @access protected
     * @param $id_admin
     * @return mixed
     */
    protected function s_employee_profile($id_admin){
        $sql='SELECT acrel.*, pr.role_name, pr.id_role
        FROM mc_admin_access_rel AS acrel
        JOIN mc_admin_role_user AS pr ON( acrel.id_role = pr.id_role )
        WHERE acrel.id_admin = :id_admin';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':id_admin'=> $id_admin
            )
        );
    }
    /**
     * @access protected
     * @param $email_admin
     * @return mixed
     */
    protected function s_last_employee(){
        $sql='SELECT em.*
        FROM mc_admin_employee AS em
        WHERE em.email_admin = :id_admin';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':id_admin'=> magixglobal_model_db::layerDB()->lastInsert()
            )
        );
    }

    /**
     * @access protected
     * Vérification de jointure profil/employee
     * @param $id_admin
     * @return mixed
     */
    protected function v_access_rel($id_admin){
        $sql='SELECT acrel.*
        FROM mc_admin_access_rel AS acrel
        WHERE acrel.id_admin = :id_admin';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':id_admin'=> $id_admin
            )
        );
    }

    /**
     * @access protected
     * Insertion d'un employee dans la table des accès
     * @param $id_admin
     * @param $id_role
     */
    protected function i_employee_profile($id_admin,$id_role){
        $sql = 'INSERT INTO mc_admin_access_rel (id_admin,id_role)
        VALUE (:id_admin,:id_role)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':id_admin'=> $id_admin,
                ':id_role'=> $id_role
            )
        );
    }

    /**
     * @access protected
     * Modification d'un employee dans la table des accès
     * @param $edit
     * @param $id_role
     */
    protected function u_employee_profile($edit,$id_role){
        $sql = 'UPDATE mc_admin_access_rel SET id_role=:id_role
		WHERE id_admin = :edit';
        magixglobal_model_db::layerDB()->update($sql,array(
            ':edit'=> $edit,
            ':id_role'=> $id_role
        ));
    }
    // Access


    /**
     * @access public
     * retourne un tableau des accès de profile suivant le nom de la classe
     * @param $id_role
     * @param $class_name
     * @return mixed
     */
    public function s_access_profile($id_role,$class_name){
        $sql='SELECT * FROM mc_admin_access
        WHERE id_role = :id_role AND class_name = :class_name';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':id_role'=> $id_role,
                ':class_name'=> $class_name
            )
        );
    }

    /**
     * @access public
     * retourne un tableau des accès de profile
     * @param $id_role
     * @return mixed
     */
    public function s_all_access_profile($id_role){
        $sql='SELECT access.* ,module.*
        FROM mc_admin_access AS access
        JOIN mc_module as module ON(access.id_module = module.id_module)
        WHERE access.id_role = :id_role';
        return magixglobal_model_db::layerDB()->select($sql,
            array(
                ':id_role'=> $id_role
            )
        );
    }
    //ROLE

    /**
     * @access public
     * retourne un tableau des rôles
     * @return mixed
     */
    public function s_all_role(){
        $sql='SELECT * FROM mc_admin_role_user';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * @access public
     * retourne un tableau des rôles
     * @param $id_admin
     * @return mixed
     */
    public function s_role_data($id_admin){
        $sql='SELECT * FROM mc_admin_role_user AS role
        JOIN mc_admin_access_rel AS rel_access ON(role.id_role = rel_access.id_role)
        WHERE id_admin = :id_admin';
        return magixglobal_model_db::layerDB()->select($sql,
            array(
                ':id_admin'=> $id_admin
            )
        );
    }
}