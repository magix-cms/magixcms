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
 * @category   Model 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name system
 *
 */
class magixglobal_model_system{
	/**
	 * @access public
	 * Retourne le chemin racine de Magix CMS
	 * @param array $arraydir
	 * @param array $dirname
	 * @param string $pathdir
     * @return mixed
     */
	public static function root_path($arraydir=array(),$dirname=array(),$pathdir){
		try {
			if (is_array($arraydir) AND is_array($dirname)) {
				$search  = $arraydir;
				$replace = $dirname;
				return str_replace($search, $replace, $pathdir);
			}
		}catch(Exception $e) {
			self::magixlog("An error has occured :", $e);
		}
	}
	/**
	 * Retourne le dossier base(ROOT) de Magix CMS
	 */
	public static function base_path(){
		try{
			$search  = array('app'.DIRECTORY_SEPARATOR.'magixglobal'.DIRECTORY_SEPARATOR.'model');
			$replace = array('');
			return str_replace($search, $replace, dirname(realpath( __FILE__ )));
		}catch(Exception $e) {
			self::magixlog("An error has occured :", $e);
		}
	}
	/**
	 * Initialise le système de LOG du CMS
	 * @param string $str
	 * @param void $e (paramètre Exception)
	 */
	public static function magixlog($str,$e){
		//Systeme de log + firephp
		$log = magixcjquery_error_log::getLog();
        $log->logfile = M_TMP_DIR;
        $log->write($str. $e->getMessage(),__FILE__, $e->getLine());
        magixcjquery_debug_magixfire::magixFireError($e);
	}
	/**
	 * extract domain
	 * exemple: http//www.mydomain.com => mydomain.com
	 */
	public static function extract_domain(){
		$parse = parse_url(magixcjquery_html_helpersHtml::getUrl(), PHP_URL_HOST);
		return substr($parse,4);
	}
	/**
	 * @access public
	 * Remplace les variables par un contenu de substitution
	 * @param array $search
	 * @param array $replace
	 * @param string $str
     * @return mixed
     * @throws Exception
	 */
	public static function vars_replace(array $search,array $replace, $str){
		//Tableau des variables à rechercher
		if(!is_array($search)){
			throw new Exception('var search is not array');
		}
		//Tableau des variables à remplacer 
		if(!is_array($replace)){
			throw new Exception('var replace is not array');
		}
		//texte générique à remplacer
		return str_replace($search ,$replace,$str);
	}

    /**
     * @access public
     * @static
     * getUrlConcat Retourne la concaténation de la minification de fichiers
     * @param $options
     * @return string
     * @throws Exception
     * @author Gérits Aurelien and JB Demonte (http://jb.demonte.fr/)
     */
    public static function getUrlConcat($options){
        if(is_array($options)){
            if(array_key_exists('caches', $options)){
                $min_cachePath = $options['caches'];
            }else{
                throw new Exception("Error caches dir is not defined");
            }
            if(array_key_exists('href', $options)){
                $url = $options["href"];
                $ext = 'css';
            }elseif(array_key_exists('src', $options)){
                $url = $options["src"];
                $ext = 'js';
            }
            if(array_key_exists('filesgroups', $options)){
                $filesgroups = $options['filesgroups'];
            }else{
                $filesgroups = 'min/groupsConfig.php';
            }
            if(array_key_exists('minDir', $options)){
                $minDir = $options['minDir'];
            }else{
                $minDir = '/min/';
            }
            if(array_key_exists('callback', $options)){
                $callback = $options['callback'];
            }else{
                $callback = '';
            }
        }else{
            throw new Exception("Error options is not array");
        }

        $name = "";
        //Parse a URL and return its components
        $parseurl = parse_url($url);

        //return position
        $position = strpos($parseurl['query'], '=');

        //return first query
        $query = substr($parseurl['query'],0,$position);

        //return url after query
        $filesPath = substr(strrchr($parseurl['query'], '='), 1);
        // Group
        if($query === 'g'){
            $filesCollection = array();
            if(file_exists($filesgroups)){
                $groups = (require $filesgroups);
                foreach(explode(",", $filesPath) as $group){
                    $filesCollection = array_merge($filesCollection, isset($groups[$group]) ? $groups[$group] : array());
                }
            }else{
                throw new Exception("filesgroups is not exist");
            }
        // Files
        }elseif($query === 'f'){
            $filesCollection = explode(",", $filesPath);
        }
        foreach($filesCollection as &$file){
            $file = ltrim($file, "/");
            $name .= $file . "|" . filemtime(self::base_path().$file) . "|" . filesize(self::base_path().$file) . "/";
        };
        $sha1name = sha1($name) . "." . $ext;
        if(file_exists($min_cachePath) AND is_writable($min_cachePath)){
            $filepath = realpath(".") . "/" . $min_cachePath . "/" . $sha1name;
            if (!file_exists($filepath)){
                $content = file_get_contents(magixcjquery_html_helpersHtml::getUrl().$minDir.'?f=' . implode(",", $filesCollection));
	            file_put_contents($filepath, $content);
	        }
            return $callback."/" . $min_cachePath . "/" . $sha1name;
        }else{
            throw new Exception("Error ".$min_cachePath." is not writable");
        }
    }
    /**
     * Retourne un tableaux contenant les identifiant actif (int OR string)
     * @access public
     * @static
     * @return array
     */
    public static function setCurrentId ()
    {
        $ModelTemplate  =   new frontend_model_template();
        $FilterRequest  =   new magixcjquery_filter_request();
        $HelperClean    =   new magixcjquery_form_helpersforms();
        $current = array();

        $current['news']['record']['id'] = null;
        if ($FilterRequest->isGet('getnews'))
            $current['news']['record']['id']    =   $HelperClean->inputAlphaNumeric($_GET['getnews']);

        $current['news']['pagination']['id'] = 1;
        if ($FilterRequest->isGet('page'))
            $current['news']['pagination']['id']    =   $HelperClean->inputNumeric($_GET['page']);

        $current['news']['tag']['id'] = null;
        if ($FilterRequest->isGet('tag'))
            $current['news']['tag']['id']    =   $HelperClean->inputClean($_GET['tag']);

        $current['cms']['record']['id'] = null;
        if ($FilterRequest->isGet('getidpage'))
            $current['cms']['record']['id']    =   $HelperClean->inputNumeric($_GET['getidpage']);

        $current['cms']['parent']['id'] = null;
        if ($FilterRequest->isGet('getidpage_p'))
            $current['cms']['parent']['id']    =   $HelperClean->inputNumeric($_GET['getidpage_p']);

        $current['catalog']['category']['id'] = null;
        if ($FilterRequest->isGet('idclc'))
            $current['catalog']['category']['id']    =   $HelperClean->inputNumeric($_GET['idclc']);

        $current['catalog']['subcategory']['id'] = null;
        if ($FilterRequest->isGet('idcls'))
            $current['catalog']['subcategory']['id']    =   $HelperClean->inputNumeric($_GET['idcls']);

        $current['catalog']['product']['id'] = null;
        if ($FilterRequest->isGet('idproduct'))
            $current['catalog']['product']['id']    =   $HelperClean->inputNumeric($_GET['idproduct']);

        $current['lang']['iso']  = $ModelTemplate->current_Language();


        return $current;

    }


}
?>