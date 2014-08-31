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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name imagesize
 *
 */
class backend_controller_imagesize extends database_imagesize{
    protected $message;
    /**
     * @var bool
     */
    public $id_size_img,
        $config_size_attr,
        $width,
        $height,
        $img_resizing;

    /**
     * Constructeur
     */
    public function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
		if(magixcjquery_filter_request::isPost('width') AND magixcjquery_filter_request::isPost('height')){
			$this->width = magixcjquery_filter_isVar::isPostNumeric($_POST['width']);
			$this->height = magixcjquery_filter_isVar::isPostNumeric($_POST['height']);
		}
		if(magixcjquery_filter_request::isPost('img_resizing')){
			$this->img_resizing = magixcjquery_form_helpersforms::inputClean($_POST['img_resizing']); 
		}
		if(magixcjquery_filter_request::isPost('id_size_img')){
			$this->id_size_img = magixcjquery_filter_isVar::isPostNumeric($_POST['id_size_img']); 
		}
	}

    /**
     * @param $type
     * @return mixed
     */
    private function img_size_type($type){
		//Tableau des variables à rechercher
		$search = array('small','medium','large');
		$replace = array('Mini','Moyen','Grand');
		return str_replace($search ,$replace,$type);
	}
	/**
	 * @access private
	 * Charge le formulaire pour l'élément
	 */
	private function load_img_forms($attr_name){
		$setting = new backend_model_setting();
		$input = '';
		$thead = 0;
		$tbody = 0;
		foreach($setting->fetch_img_size($attr_name) as $row){
			$input .= '<form class="forms-config" method="post" action="" id="si_'.$row['attr_name'].'_'.$row['config_size_attr'].'_'.$row['type'].'">';
			$input .= '<table class="tb-size-config">';
			if ($thead == 0) {
				$input .= '<thead>'."\n";
				$input .= '<tr class="ui-widget ui-widget-header"><th>Cible</th><th>Format</th><th>Largeur</th><th>Hauteur</th><th>Echelle</th><th></th></tr>'."\n";
				$input .= '</thead>'."\n";
				$input .= '<tbody>'."\n";
				$thead++;
			}
			$input .= '<tr><td class="size_img_attribute">'.magixcjquery_string_convert::ucFirst($row['config_size_attr']).'</td>'."\n";
			$input .= '<td class="size_img_type">'.$this->img_size_type($row['type']).'</td>'."\n";
			$input .= '<td>
			<input type="hidden" name="id_size_img" value="'.$row['id_size_img'].'" />
			<label>Largeur :</label><input type="text" name="width" class="spincount" value="'.$row['width'].'" size="5" /></td>'."\n";
			$input .= '<td><label>Hauteur :</label><input type="text" name="height" class="spincount" value="'.$row['height'].'" size="5" /></td>'."\n";
			if($row['img_resizing'] == 'basic'){
				$input .= '<td>Basic <input type="radio" checked="checked" name="img_resizing" value="basic" /> Adaptive <input type="radio" name="img_resizing" value="adaptive" /></td>'."\n";
			}else{
				$input .= '<td>Basic <input type="radio" name="img_resizing" value="basic" /> Adaptive <input type="radio" name="img_resizing" checked="checked" value="adaptive" /></td>'."\n";
			}
			$input .= '<td><input type="submit" value="Save" /></td></tr>';
			if ($tbody == 0) {
				$input .= '</tbody>'."\n";
				$tbody++;
			}
			$input .= '</table>'."\n";
			$input .= '</form>'."\n";
		}
		return $input;
	}

	/**
	 * @access private
	 * Mise à jour des tailles images des catégories catalogue 
	 */
	private function update_img(){
		if(isset($this->id_size_img)){
			parent::u_size_img_config($this->width, $this->height,$this->img_resizing, $this->id_size_img);
            $this->message->getNotify('update');
		}
	}

	/**
	 * @access public 
	 * Execute la classe
	 */
	public function run(){
        $create = new backend_controller_template();
        $create->addConfigFile(array(
                'config'
            ),array('config_'),false
        );
		if(magixcjquery_filter_request::isPost('id_size_img')){
			$this->update_img();
		}else{
			backend_controller_template::assign('img_size_forms_catalog', $this->load_img_forms('catalog'));
			backend_controller_template::assign('img_size_forms_news', $this->load_img_forms('news'));
			backend_controller_template::assign('img_size_forms_plugins', $this->load_img_forms('plugins'));
			backend_controller_template::display('config/imagesize.tpl');
		}
	}
}
class database_imagesize{
    /**
     * @access protected
     * Mise à jour des tailles d'image
     * @param $width
     * @param $height
     * @param $img_resizing
     * @param $id_size_img
     * @internal param int $num_size
     * @internal param string $name_size
     */
	protected function u_size_img_config($width,$height,$img_resizing,$id_size_img){
		$sql = 'UPDATE mc_config_size_img 
		SET width = :width,height = :height,img_resizing = :img_resizing
		WHERE id_size_img = :id_size_img';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':width'        =>	$width,
			':height'       =>	$height,
			':img_resizing' =>	$img_resizing,
			':id_size_img'  =>	$id_size_img
		));
	}
}