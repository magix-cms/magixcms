<?php
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
function smarty_function_ariane($params, &$smarty){
	$title = $params['title'];
	$lang = $_GET['strLangue'] ? $_GET['strLangue']:'';
	$url = $_SERVER['REQUEST_URI'];
	$segment = str_replace('.html', "", explode('/', $url));
	$root = magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator();
	$fil = null;
	$fil .= '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-home"></span><a href="'.$root.$segment[0].'">'.$title.'</a></li>';
	if(!isset($_GET['strLangue'])){
		if(isset($_GET['catalog'])){
			$fil .= empty($segment[1])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
			if(isset($_GET['c'])){
				$fil .= empty($segment[3])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
			}elseif(isset($_GET['s'])){
				$fil .= empty($segment[2])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
				$fil .= empty($segment[4])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
			}elseif(isset($_GET['idcatalog'])){
				if(isset($_GET['idcls'])){
					$fil .= empty($segment[2])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
					$fil .= empty($segment[3])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().'s'.magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
					$fil .= empty($segment[4])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
				}else{
					$fil .= empty($segment[2])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
					$fil .= empty($segment[3])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
					$fil .= empty($segment[4])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().'s'.magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
					$fil .= empty($segment[5])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
				}
			}
		}elseif(isset($_GET['getnews'])){
			$fil .= empty($segment[1])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
			$fil .= empty($segment[5])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
		}elseif(isset($_GET['static'])){
			$fil .= empty($segment[1])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
			$fil .= empty($segment[5])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
		}elseif(isset($_GET['contact'])){
			$fil .= empty($segment[3])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
		}elseif(isset($_GET['mix'])){
			$fil .= empty($segment[3])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
		}else{
			if(isset($_GET['getcat']) && isset($_GET['getpurl'])){
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
			$fil .= empty($segment[1])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
			if(isset($_GET['c'])){
				$fil .= empty($segment[3])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
			}elseif(isset($_GET['s'])){
				$fil .= empty($segment[2])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
				$fil .= empty($segment[4])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
			}elseif(isset($_GET['idcatalog'])){
				if(isset($_GET['idcls'])){
					$fil .= empty($segment[1])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().'">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[1])).'</a></li>';
					$fil .= empty($segment[3])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace('/[0-9\-]/i', '', magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
					$fil .= empty($segment[4])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().'s'.magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
					$fil .= empty($segment[5])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
				}
			}
		}else{
			$fil .= empty($segment[1])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span>'.magixcjquery_string_convert::ucfirst($segment[1]).'</li>';
			if(isset($_GET['contact'])){
				$fil .= empty($segment[4])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
			}else{
				if(isset($_GET['getcat']) && isset($_GET['getpurl'])){
					$fil .= empty($segment[3])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[3])).'</a></li>';
					//
				}else{
					$fil .= empty($segment[2])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '),magixcjquery_string_convert::ucfirst($segment[2])).'</a></li>';
					//$fil .= empty($segment[4])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[4])).'</a></li>';
					//$fil .= empty($segment[5])? null: '<li><span style="float:left;margin-top:2px;" class="ui-icon ui-icon-triangle-1-e"></span><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].magixcjquery_html_helpersHtml::unixSeparator().$segment[3].magixcjquery_html_helpersHtml::unixSeparator().$segment[4].magixcjquery_html_helpersHtml::unixSeparator().$segment[5].'.html">'.preg_replace(array('/[0-9]/i','/[-]/i'), array('', ' '), magixcjquery_string_convert::ucfirst($segment[5])).'</a></li>';
				}
			}
		}
	}
	return $fil;
}
?>