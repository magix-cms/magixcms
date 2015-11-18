<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of magix cjQuery.
# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.
# Magix cjQuery is a library written in PHP 5.
# It can work with a layer of abstraction, to validate data, handle jQuery code in PHP.
# Copyright (C)Magix cjQuery 2009 Gerits Aurelien
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or (at your option) any later version.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * 
 * Magix cjQuery
 * 
 * @author Gérits Aurélien
 * @access public
 * @copyright clashdesign - MagixcjQuery
 * @version 0.1
 * @package Video thumbnail
 *
 */
class magixcjquery_files_videoThumb{
	/**
	 * Copy distant file in local dir
	 * @param $source
	 * @param $dest
	 * @return void
	 */
	public static function copy_files($source,$dest){
		$file_ext = '.jpg';
		$opts = array (
        	'http' => array (
	            'method' => 'GET',
	            'header'=> "Content-type: image/jpeg"
            )
        );
        //Create a streams context
        $context = stream_context_create($opts);
		if(file_get_contents($source,false,$context)){
			if(!file_exists($dest)){
				//Copy file in server
				copy($source,$dest.$file_ext);
			}else{
				// return false
				return false;
			}
		}else{
			throw new Exception('is not file exists');
		}
	}
	/**
	 * moves the file
	 * @param $files
	 * @param $dest
	 * @return void
	 */
	public static function move_files($file,$source,$dest){
		//if file exist with magixcjquery function
		if(!magixcjquery_files_makefiles::recursiveFileExists($file,$source)){
			//Checks if a stream is a local stream
			if(stream_is_local($dest)){
				if(copy($source.$file,$dest.$file)){
					unlink($source.$file);
				}else{
					throw new Exception('Error copy file');
				}
			}
		}else{
			throw new Exception('is not file exists');
		}
	}
	public static function dimension_thumbnail(){}
}