<?php
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
                                $query = 'UPDATE mc_catalog_c SET img_c = :img WHERE idclc = :edit';
                                magixglobal_model_db::layerDB()->update($query,
                                    array(
                                        ':img'	=>	$data['img'],
                                        ':edit'		=>	$data['id']
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