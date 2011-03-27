<?php 
class backend_db_seo{
	/**
	 * @access protected
	 * Sélectionne toutes les réécritures de métas pour le listing dans l'admin
	 */
	protected function s_tab_rewrite(){
		$sql = 'SELECT m.*,lang.codelang
		FROM mc_metas_rewrite AS m
		JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
		ORDER BY m.idmetas ASC,m.attribute DESC';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Sélectionne la métas pour l'édition
	 * @param integer $editseo
	 */
	protected function s_uniq_rewrite($editseo){
		$sql = 'SELECT m.*,lang.codelang
		FROM mc_metas_rewrite AS m
		JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
		WHERE m.idrewrite=:editseo';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':editseo'=>$editseo
		));
	}
	/**
	 * Insertion d'une nouvelle réécriture
	 * @param string $attribute
	 * @param integer $idlang
	 * @param string $strrewrite
	 * @param integer $idmetas
	 * @param integer $level
	 */
	protected function i_new_seo($attribute,$idlang,$strrewrite,$idmetas,$level){
		$sql = 'INSERT INTO mc_metas_rewrite (attribute,idlang,strrewrite,idmetas,level) 
		VALUE(:attribute,:idlang,:strrewrite,:idmetas,:level)';
		magixglobal_model_db::layerDB()->insert($sql,array(
			':attribute'   => $attribute,
			':idlang' 	   => $idlang,
			':strrewrite'  => $strrewrite,
			':idmetas'     => $idmetas,
			':level'  	   => $level
		));
	}
	/**
	 * Mise à jour d'une métas
	 * @param integer $editseo
	 * @param string $ustrrewrite
	 */
	protected function u_seo($editseo,$ustrrewrite){
		$sql = 'UPDATE mc_metas_rewrite SET strrewrite=:ustrrewrite
		WHERE idrewrite=:editseo';
		magixglobal_model_db::layerDB()->update($sql,array(
			':editseo'=>$editseo,
			':ustrrewrite'=>$ustrrewrite
		));
	}
	/**
	 * @access protected
	 * Suppression d'une métas
	 * @param integer $del
	 */
	protected function d_seo($del){
		$sql = 'DELETE FROM mc_metas_rewrite WHERE idrewrite = :del';
		magixglobal_model_db::layerDB()->delete($sql,array(
			':del' => $del
		));
	}
}
?>