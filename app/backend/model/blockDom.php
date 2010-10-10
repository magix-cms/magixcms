<?php
/**
 * @category   Model block Dom
 * Model from DOM element dynamic
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_model_blockDom{
	/**
	 * Construction du menu select pour la langue
	 */
	public static function select_language(){
		if(backend_db_lang::dblang()->s_full_lang() != null){
			$block = '<tr>
						<td class="label"><label for="idlang" class="inlinelabel">Langue :</label></td>
					</tr>
					<tr>
						<td>';
			$block .= '<select id="idlang" name="idlang">';
			$block .= '<option value="0">Défaut</option>';
			foreach(backend_db_lang::dblang()->s_full_lang() as $slang){
				$block .= '<option value="'.$slang['idlang'].'">'.$slang['codelang'].'</option>';
			}
			$block .='</select>';
			$block .= '</td>
							<td style="width:150px;" class="errorInput"></td>
					</tr>
					<tr>
						<td class="status"></td>
					</tr>';
		}else{
			$block = '<tr>
						<td>';
			$block .= '<input type="hidden" size="5" id="idlang" name="idlang" value="0" />';
			$block .= '</td>
					</tr>';
		}
		return $block;
	}
	/**
	 * Construction du menu select des utilisateurs 
	 */
	public static function select_users(){
		if(backend_db_admin::adminDbMember()->view_list_members() != null){
			$block = '<tr>
						<td class="label"><label for="idadmin" class="inlinelabel">Utilisateurs :</label></td>
					</tr>
					<tr>
						<td>';
			$block .= '<select id="idadmin" name="idadmin">';
			$block .= '<option value="">Sélectionner un utilisateur</option>';
			foreach(backend_db_admin::adminDbMember()->view_list_members() as $m){
				$block .= '<option value="'.$m['idadmin'].'">'.$m['pseudo'].'</option>';
			}
			$block .='</select>';
			$block .= '</td>
							<td style="width:150px;" class="errorInput"></td>
					</tr>
					<tr>
						<td class="status"></td>
					</tr>';
		}else{
			$block = '<tr>
						<td>';
			$block .= '<input type="hidden" size="5" id="idlang" name="idlang" value="0" />';
			$block .= '</td>
					</tr>';
		}
		return $block;
	}
}