<?php 
class frontend_db_seo{
	/**
	 * 
	 * Sélectionne la métas suivant l'attribut et le niveau
	 * @param string $attribute
	 * @param integer $level
	 * @param integer $idmetas
	 * @param string $codelang
	 */
	protected function s_public_rewrite($attribute,$level,$idmetas,$codelang){
		$sql = 'SELECT m.*,lang.codelang
		FROM dc_metas_rewrite AS m
		mc_lang AS lang ON(r.idlang = lang.idlang)
		WHERE m.attribute = :attribute AND m.level = :level
		AND m.idmetas = :idmetas AND lang.codelang = :codelang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':attribute'=>$attribute,
			':level'	=>$level,
			':idmetas'	=>$idmetas,
			':codelang' =>$codelang
		));
	}
}
?>