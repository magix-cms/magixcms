<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
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
/**
 * MAGIX CMS
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {ariane} function plugin
 *
 * Type:     function
 * Name:     ariane
 * Date:    December, 3 2009
 * Purpose:  
 * Examples: {ariane title=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_ariane($params, $template){
	$title = $params['title'];
	$lang = $_GET['strLangue'] ? $_GET['strLangue']:'';
	$url = $_SERVER['REQUEST_URI'];
	$segment = str_replace('.html', "", explode('/', $url));
	$root = magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator();
	$fil = null;
	$fil .= '<li><span style="float:left;" class="ui-icon ui-icon-home"></span><a href="'.$root.$segment[0].'">'.$title.'</a></li>';
	if(!isset($_GET['strLangue'])){
		if(isset($_GET['catalog'])){
			$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
			if(isset($_GET['c'])){
				$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
			}elseif(isset($_GET['s'])){
				$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
				$fil .= empty($segment[4])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
			}elseif(isset($_GET['idproduct'])){
				if(isset($_GET['idcls'])){
					$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
					$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().'s'.magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
					$fil .= empty($segment[4])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
				}else{
					$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
					$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
					$fil .= empty($segment[4])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().'s'.magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
					$fil .= empty($segment[5])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
				}
			}
		}elseif(isset($_GET['getnews'])){
			$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
			$fil .= empty($segment[5])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
		}elseif(isset($_GET['static'])){
			$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
			$fil .= empty($segment[5])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
		}elseif(isset($_GET['magixmod'])){
			$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '),magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
			//$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
		}elseif(isset($_GET['mix'])){
			$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
		}else{
			if(isset($_GET['getidcategory']) AND isset($_GET['getidpage'])){
				$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span>'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '),magixcjquery_string_convert::ucfirst($segment[1])).'</li>';
				$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '),magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
				$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
				//$fil .= empty($segment[4])? null: '<li><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
			}else{
				$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '),magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
				$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '),magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
				$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
			}
		}
	}else{
		if(isset($_GET['catalog'])){
			$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
			if(isset($_GET['c'])){
				$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
			}elseif(isset($_GET['s'])){
				$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
				$fil .= empty($segment[4])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
			}elseif(isset($_GET['idcatalog'])){
				if(isset($_GET['idcls'])){
					$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
					$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
					$fil .= empty($segment[4])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().'s'.magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
					$fil .= empty($segment[5])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
				}
			}
		}else{
			$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span>'.magixcjquery_string_convert::ucfirst($segment[1]).'</li>';
			if(isset($_GET['magixmod'])){
				$fil .= empty($segment[4])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
			}else{
				if(isset($_GET['getidcategory']) AND isset($_GET['getidpage'])){
					$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
					//
				}else{
					$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '),magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
					//$fil .= empty($segment[4])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
					//$fil .= empty($segment[5])? null: '<li><span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
				}
			}
		}
	}
	return $fil;
}
?>