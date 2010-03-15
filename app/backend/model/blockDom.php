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
			$lang = '<tr>
						<td class="label"><label for="idlang" class="inlinelabel">Langue :</label></td>
					</tr>
					<tr>
						<td>';
			$lang .= '<select id="idlang" name="idlang" class="select">';
			$lang .= '<option value="0">Aucune langue</option>';
			foreach(backend_db_lang::dblang()->s_full_lang() as $slang){
				$lang .= '<option value="'.$slang['idlang'].'">'.$slang['codelang'].'</option>';
			}
			$lang .='</select>';
			$lang .= '</td>
							<td style="width:150px;" class="errorInput"></td>
					</tr>
					<tr>
						<td class="status"></td>
					</tr>';
		}else{
			$lang = '<tr>
						<td>';
			$lang .= '<input type="hidden" size="5" id="idlang" name="idlang" value="0" />';
			$lang .= '</td>
					</tr>';
		}
		return $lang;
	}
}