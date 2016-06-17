<?php
class backend_db_webservice{
    /**
     * @return array
     */
    protected function fetch(){
        $sql = 'SELECT ws.*
					FROM mc_webservice AS ws';
        return magixglobal_model_db::layerDB()->selectOne($sql);
    }
    /**
     * @param $data
     */
    protected function insert($data)
    {
        if (is_array($data)) {
            $sql = 'INSERT INTO mc_webservice (ws_key,status_key)
		        VALUE(:key,:status)';
            magixglobal_model_db::layerDB()->insert($sql,
                array(
                    ':key' 		=> $data['key'],
                    ':status' 	=> $data['status']
                ));
        }
    }

    /**
     * @param $data
     */
    protected function update($data){
        if (is_array($data)) {
            $query = 'UPDATE mc_webservice 
            SET ws_key = :key, status_key = :status 
            WHERE idwskey = :id';
            magixglobal_model_db::layerDB()->update($query,
                array(
                    ':id' => $data['id'],
                    ':key' 		=> $data['key'],
                    ':status' 	=> $data['status']
                )
            );
        }
    }
}
?>