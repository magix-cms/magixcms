<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2016 magix-cms.com support[at]magix-cms[point]com
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com>
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
class frontend_db_webservice
{
    /**
     * @param $data
     */
    protected function insertNewData($data){
        if(is_array($data)) {
            if (array_key_exists('type', $data)) {
                $type = $data['type'];
            }
            if (array_key_exists('context', $data)) {
                $context = $data['context'];
                if($type === 'catalog'){
                    if($context === 'category'){
                        /**
                         * Insert new category catalog
                         */
                        $sql = 'INSERT INTO mc_catalog_c (clibelle,pathclibelle,c_content,idlang,corder)
		                VALUE(:name,:url,:content,:idlang,(SELECT COUNT(c.corder) FROM mc_catalog_c as c WHERE c.idlang = :idlang))';
                        magixglobal_model_db::layerDB()->insert($sql,
                            array(
                                ':name'		=>	$data['name'],
                                ':url'		=>	$data['url'],
                                ':content'  =>	$data['content'],
                                ':idlang'	=>	$data['idlang']
                            )
                        );
                    }elseif($context === 'subcategory'){
                        $query = 'INSERT INTO mc_catalog_s (idclc,slibelle,pathslibelle,s_content,sorder)
		                VALUE(:idparent,:name,:url,:content,(SELECT COUNT(s.sorder) 
		                FROM mc_catalog_s AS s WHERE s.idclc = :idparent))';
                        magixglobal_model_db::layerDB()->insert($query,
                            array(
                                ':name'		=>	$data['name'],
                                ':url'		=>	$data['url'],
                                ':content'  =>	$data['content'],
                                ':idparent' =>  $data['idparent']
                            )
                        );
                    }elseif($context === 'product'){
                        $query = 'INSERT INTO mc_catalog_product (idcatalog,idclc,idcls,orderproduct)
                        VALUE(:product,:category,:subcategory,(SELECT COUNT(p.orderproduct) FROM mc_catalog_product AS p 
                        WHERE p.idclc = :category AND p.idcls = :subcategory))';
                        magixglobal_model_db::layerDB()->insert($query,
                            array(
                                ':category'     =>  $data['category'],
                                ':subcategory'  =>  $data['subcategory'],
                                ':product'      =>  $data['product']
                            )
                        );
                    }
                }
            }
        }
    }
    protected function updateData($data){
        if(is_array($data)) {
            if (array_key_exists('type', $data)) {
                $type = $data['type'];
            }
            if (array_key_exists('id', $data)) {
                if (array_key_exists('context', $data)) {
                    $context = $data['context'];
                    if ($type === 'catalog') {
                        if ($context === 'category') {
                            if(isset($data['name'])) {
                                $query = 'UPDATE mc_catalog_c 
                            SET clibelle = :name, pathclibelle = :url,c_content = :content WHERE idclc = :id';
                                magixglobal_model_db::layerDB()->update($query,
                                    array(
                                        ':id'       => $data['id'],
                                        ':name'     => $data['name'],
                                        ':url'      => $data['url'],
                                        ':content'  => $data['content']
                                    )
                                );
                            }elseif(isset($data['img'])){
                                $query = 'UPDATE mc_catalog_c SET img_c = :img WHERE idclc = :id';
                                magixglobal_model_db::layerDB()->update($query,
                                    array(
                                        ':img'	=>	$data['img'],
                                        ':id'		=>	$data['id']
                                    )
                                );
                            }
                        }elseif ($context === 'subcategory') {
                            if(isset($data['name'])) {
                                $query = 'UPDATE mc_catalog_s 
                            SET slibelle = :name, pathslibelle = :url,s_content = :content WHERE idcls = :id';
                                magixglobal_model_db::layerDB()->update($query,
                                    array(
                                        ':id'       => $data['id'],
                                        ':name'     => $data['name'],
                                        ':url'      => $data['url'],
                                        ':content'  => $data['content']
                                    )
                                );
                            }elseif(isset($data['img'])){
                                $query = 'UPDATE mc_catalog_s SET img_s = :img WHERE idcls = :id';
                                magixglobal_model_db::layerDB()->update($query,
                                    array(
                                        ':img'	=>	$data['img'],
                                        ':id'		=>	$data['id']
                                    )
                                );
                            }
                        }
                    }
                }
            }
        }
    }
    /**
     * @param $data
     * @return array
     */
    protected function fetchConfig($data){
        if(is_array($data)) {
            if (array_key_exists('type', $data)) {
                $type = $data['type'];
            }
            if (array_key_exists('context', $data)) {
                $context = $data['context'];
            }
            switch($type){
                case 'config':
                    if($context === 'imgSize'){
                        $sql = 'SELECT cs.*,c.attr_name
                        FROM mc_config_size_img AS cs
                        JOIN mc_config AS c USING(idconfig)
                        WHERE c.attr_name = :attr_name AND cs.config_size_attr = :attr_size
                        ORDER BY cs.width DESC';
                        return magixglobal_model_db::layerDB()->select($sql,array(
                            ':attr_name' => $data['attr_name'],
                            ':attr_size' => $data['attr_size']
                        ));
                    }
                    break;
            }
        }

    }
    protected function fetchLanguage($data){
        if(is_array($data)) {
            if (array_key_exists('fetch', $data)) {
                $fetch = $data['fetch'];
            } else {
                $fetch = 'all';
            }
            if($fetch === 'one'){
                $query = 'SELECT idlang,iso FROM mc_lang 
		    WHERE iso = :iso';
                return magixglobal_model_db::layerDB()->selectOne($query,
                    array(':iso' => $data['iso'])
                );
            }
        }
    }
}
?>