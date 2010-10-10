<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_db_home{
	/**
	 * singleton dbhome
	 * @access public
	 * @var void
	 */
	static public $admindbhome;
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbHome(){
        if (!isset(self::$admindbhome)){
         	self::$admindbhome = new backend_db_home();
        }
    	return self::$admindbhome;
    }
	/**
	 * selection du titre et du contenu de la page home ou index public 
	 *
	 */
	function s_home_page_plugin(){
		$sql = 'SELECT h.idhome,h.subject,h.content,h.metatitle,h.metadescription,lang.codelang,h.idlang,m.pseudo
				FROM mc_page_home AS h
				LEFT JOIN mc_lang AS lang ON(h.idlang = lang.idlang)
				LEFT JOIN mc_admin_member AS m ON(h.idadmin = m.idadmin)';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Affiche les données (dans les champs) pour une modification
	 * @param $gethome
	 */
	function s_home_page_record($gethome){
		$sql = 'SELECT h.subject,h.content,h.metatitle,h.metadescription,lang.codelang,lang.idlang
				FROM mc_page_home AS h
				LEFT JOIN mc_lang AS lang ON(h.idlang = lang.idlang) 
				WHERE idhome = :gethome';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
		':gethome'=>$gethome
		));
	}
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
	 */
	function s_home_page_b_lang($idlang){
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
	function i_new_home_page($subject,$content,$metatitle,$metadescription,$idlang,$idadmin){
		$sql = 'INSERT INTO mc_page_home (subject,content,metatitle,metadescription,idlang,idadmin) 
				VALUE(:subject,:content,:metatitle,:metadescription,:idlang,:idadmin)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':subject'			=>	$subject,
			':content'			=>	$content,
			':metatitle'		=>	$metatitle,
			':metadescription'  =>	$metadescription,
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
	function u_home_page($subject,$content,$metatitle,$metadescription,$idlang,$idadmin,$idhome){
		$sql = 'UPDATE mc_page_home 
		SET subject=:subject,content=:content,metatitle=:metatitle,metadescription=:metadescription,idlang=:idlang,idadmin=:idadmin,date_home=NOW()
		WHERE idhome = :idhome';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':subject'			=>	$subject,
			':content'			=>	$content,
			':metatitle'		=>	$metatitle,
			':metadescription'  =>	$metadescription,
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin,
			':idhome'			=>	$idhome
		));
	}
	/**
	 * Suppression d'une page d'accueil
	 * @param $delhome
	 */
	function d_home($delhome){
		$sql = 'DELETE FROM mc_page_home WHERE idhome = :delhome';
			magixglobal_model_db::layerDB()->delete($sql,
			array(
				':delhome'	=>	$delhome
			)); 
	}
}