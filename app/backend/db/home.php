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
 * @copyright  MAGIX CMS Copyright (C) 2008 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 * @name home
 *
 */
class backend_db_home{
    protected function s_count_home(){
        $sql = 'SELECT count(h.idhome) AS counthome,lang.iso
        FROM mc_page_home AS h
        JOIN mc_lang AS lang ON(h.idlang = lang.idlang)
        GROUP BY h.idlang';
        return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Retourne la liste des pages
     * @return array
     */
    protected function s_list_home(){
		$sql = 'SELECT h.idhome,h.subject,h.content,h.metatitle,h.metadescription,lang.iso,h.idlang,m.pseudo
        FROM mc_page_home AS h
        JOIN mc_lang AS lang ON(h.idlang = lang.idlang)
        JOIN mc_admin_member AS m ON(h.idadmin = m.idadmin)';
		return magixglobal_model_db::layerDB()->select($sql);
	}

    /**
     * Affiche les données (dans les champs) pour une modification
     * @param $idhome
     * @return array
     */
	protected function s_edit_home($idhome){
		$sql = 'SELECT h.subject,h.content,h.metatitle,h.metadescription,lang.iso,h.idlang
        FROM mc_page_home AS h
        JOIN mc_lang AS lang ON(h.idlang = lang.idlang)
        WHERE idhome = :idhome';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
		    ':idhome'=>$idhome
		));
	}
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
     * @return array
     */
	protected function s_lang_home($idlang){
		$sql ='SELECT h.idhome,h.idlang
        FROM mc_page_home AS h
        WHERE h.idlang =:idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
		    ':idlang'=>$idlang
		));
	}
	/**
	 * insertion d'un nouvel enregistrement pour une page d'accueil
	 * @param $subject
	 * @param $content
	 * @param $metatitle
	 * @param $metadescription
	 * @param $idlang
	 * @param $idadmin
	 */
	protected function i_new_home($subject,$idlang,$idadmin){
		$sql = 'INSERT INTO mc_page_home (subject,idlang,idadmin)
        VALUE(:subject,:idlang,:idadmin)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':subject'			=>	$subject,
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin
		));
	}
	/**
	 * Mise à jour d'un enregistrement d'une page d'accueil
	 * @param $subject
	 * @param $content
	 * @param $metatitle
	 * @param $metadescription
	 * @param $idlang
	 * @param $idadmin
	 * @param $idhome
	 */
	protected function u_home($subject,$content,$metatitle,$metadescription,$idadmin,$idhome){
		$sql = 'UPDATE mc_page_home 
		SET subject=:subject,content=:content,metatitle=:metatitle,metadescription=:metadescription,idadmin=:idadmin,date_home=NOW()
		WHERE idhome = :idhome';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':subject'			=>	$subject,
			':content'			=>	$content,
			':metatitle'		=>	$metatitle,
			':metadescription'  =>	$metadescription,
			':idadmin'			=>	$idadmin,
			':idhome'			=>	$idhome
		));
	}
	/**
	 * Suppression d'une page d'accueil
	 * @param $delete_home
	 */
	protected function d_home($delete_home){
		$sql = 'DELETE FROM mc_page_home WHERE idhome = :delete_home';
        magixglobal_model_db::layerDB()->delete($sql,
        array(
            ':delete_home'	=>	$delete_home
        ));
	}
}