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
 * @name makefilefactory
 *
 */
class magixglobal_model_makefilefactory{
	/**
	 * 
	 * Lecture d'un fichier
	 * @param string $filepath
	 */
	public function readFile($filepath){
		if(file_exists($filepath)){
			if (is_file($filepath) && is_writable($filepath)) {
				return file_get_contents($filepath);
			}
		}else{
			throw new Exception("Error readfile");
		}
		//file_put_contents($path);
	}
	public function fileTree($dirPath){   
		try {      
		    $filtre = new RecursiveDirectoryIterator($dirPath);      
		    try { 
		        // ne filtre que les fichiers         
		        $filtres = new FiltreRecursif($filtre,array('phtml','css'),array(),false); 
		        // filtre les fichiers et les dossiers, içi thumbs sera ignoré ainsi que les fichiers 
		        //et dossiers qu'il contient 
		        //$filtres = new FiltreRecursif($filtre,array('jp*g','gif','png'),array('thumbs'));          
		        /*  
		         * RecursiveIteratorIterator::SELF_FIRST pour que les dossiers soit pris en compte 
		         * retirer cette constante ne retourne que les fichiers. 
		         */    
		        foreach (new RecursiveIteratorIterator($filtres,RecursiveIteratorIterator::SELF_FIRST) as $v) { 
		            /* 
		             * // pour tester la sortie 
		             * echo '<pre>'; 
		             * print_r($v); 
		             * echo '</pre>'; 
		             */ 
		            if ($v->isDir())       
		                echo 'Dossier : '.strtr($v,'\\','/').'<br />';  
		            else echo 'Fichier : '.strtr($v,'\\','/').'<br />';  
		        }      
		    } catch (InvalidArgumentException $spl) { echo $spl->__toString(); }  
		} catch (Exception $e) { echo $e->__toString(); }  
	}
	private function FileIterator(){}
	public function saveFile($filepath,$current){
		file_put_contents($filepath, $current);
	}
}
class FiltreRecursif extends RecursiveFilterIterator { 
    /** 
     * Attend un objet implémentant l'interface RecursiveIterator, un tableau 
     * d'extensions sans le point et un tableau de dossiers à filtrer. 
     *  
     * @param $iterateur 
     * @param $tab_extensions 
     * @param $tab_dossier 
     */ 
    function  __construct(RecursiveIterator $iterateur, array $tab_extensions, array $tab_dossier, $bool_dossier = true) { 
        if ($iterateur instanceof RecursiveIterator) 
            $this->_Iterateur = $iterateur; 
        else throw new InvalidArgumentException('Cet objet n\'est pas une instance de RecursiveIterator'); 
        if (is_array($tab_extensions)) 
            $this->_TabExtensions = $tab_extensions; 
        else throw new InvalidArgumentException('Le paramètre 2 n\'est pas un tableau'); 
        if (is_array($tab_dossier)) 
            $this->_TabDossierAFiltrer = $tab_dossier; 
        else throw new InvalidArgumentException('Le paramètre 3 n\'est pas un tableau'); 
        if (is_bool($bool_dossier)) 
            $this->_BoolFiltreDossier = $bool_dossier; 
        else $this->_BoolFiltreDossier = true; 
        parent::__construct($this->_Iterateur); 
    } 
     
    /** 
     * Filtre qui n'accepte que les extensions du tableau et les dossiers. 
     * Les dossiers à exclure sont compris dans un tableau.
     */ 
    function  accept() { 
        if ($this->_BoolFiltreDossier === true) { 
            if ($this->hasChildren() && !in_array(pathinfo($this->current(),PATHINFO_BASENAME),$this->_TabDossierAFiltrer)) 
                return true; 
            else return in_array(pathinfo($this->current(), PATHINFO_EXTENSION), $this->_TabExtensions); 
        } else return ($this->hasChildren() || in_array(pathinfo($this->current(), PATHINFO_EXTENSION), $this->_TabExtensions)); 
    } 
     
    /** 
     * Si l'élément courant contient des enfants sur lesquels itérer, appel récursif 
     * de la classe avec ses paramètres. 
     */ 
    function  getChildren() { 
        return new self($this->getInnerIterator()->getChildren(), $this->_TabExtensions, $this->_TabDossierAFiltrer,$this->_BoolFiltreDossier); 
    } 
} 