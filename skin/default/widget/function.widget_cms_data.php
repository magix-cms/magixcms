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
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_cms_display} function plugin
 *
 * Type:     function
 * Name:     widget_cms_display
 * Date:     29/12/2012
 * Update:   10/03/2013
 * @author   Sire Sam (http://www.sire-sam.be)
 * @author   Gerits Aurélien (http://www.magix-dev.be)
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_cms_data ($params, $template)
{
    $ModelSystem        =   new magixglobal_model_system();
    $ModelConstructor   =   new magixglobal_model_constructor();
    $ModelCms           =   new frontend_model_cms();

    // Set and load data
    $current    =   $ModelSystem->setCurrentId();
    $conf       =   (is_array($params['conf'])) ? $params['conf'] : array();
    $data       =   $ModelCms->getData($conf,$current);
    $current    =   $current['cms'];

    $htm = null;
    if($data != null){
        // ** Loop management var
        $deep = 1;
        $deep_minus = $deep  - 1;
        $deep_plus = $deep  + 1;
        $pass_trough = 0;
        $data_empty = false;

        // ** Loop format & output var
        $row = array();
        $items = array();
        $i[$deep] = 0;

        do{
            // *** loop management START
            if ($pass_trough == 0){
                // Si je n'ai plus de données à traiter je vide ma variable
                $row[$deep] = null;
            }else{
                // Sinon j'active le traitement des données
                $pass_trough = 0;
            }

            // Si je suis au premier niveaux et que je n'ai pas de donnée à traiter
            if ($deep == 1 AND $row[$deep] == null) {
                // récupération des données dans $data
                $row[$deep] = array_shift($data);
            }

            // Si ma donnée possède des sous-donnée sous-forme de tableau
            if (isset($row[$deep]['subdata']) ){
                if (is_array($row[$deep]['subdata']) AND $row[$deep]['subdata'] != null){
                    // On monte d'une profondeur
                    $deep++;
                    $deep_minus++;
                    $deep_plus++;
                    // on récupére la  première valeur des sous-données en l'éffacant du tableau d'origine
                    $row[$deep] = array_shift($row[$deep_minus]['subdata']);
                    // Désactive le traitement des données
                    $pass_trough = 1;
                }
            }elseif($deep != 1){
                if ( $row[$deep] == null) {
                    if ($row[$deep_minus]['subdata'] == null){
                        // Si je n'ai pas de sous-données & pas de données à traiter & pas de frères à récupérer dans mon parent
                        // ====> désactive le tableaux de sous-données du parent et retourne au niveau de mon parent
                        unset ($row[$deep_minus]['subdata']);
                        unset ($i[$deep]);
                        $deep--;
                        $deep_minus = $deep  - 1;
                        $deep_plus = $deep  + 1;
                    }else{
                        // Je récupère un frère dans mon parent
                        $row[$deep] = array_shift($row[$deep_minus]['subdata']);
                    }
                    // Désactive le traitement des données
                    $pass_trough = 1;
                }
            }
            // *** loop management END

            // *** list format START
            if ($row[$deep] != null AND $pass_trough != 1){
                $i[$deep]++;

                // Construit doonées de l'item en array avec clée nominative unifiée ('name' => 'monname,'descr' => '<p>ma descr</p>,...)
                $itemData  = $ModelCms->setItemData($row[$deep],$current);

                // Récupération des sous-données (enfants)
                if(isset($items[$deep_plus]) != null) {
                    $itemData['subdata'] = $items[$deep_plus];
                    $items[$deep_plus] = null;
                }else{
                    $subitems = null;
                }

                $items[$deep][] = $itemData;
            }
            // *** list format END

            // Si $data est vide ET que je n'ai plus de données en traitement => arrête la boucle
            if (empty($data) AND $row[1] == null){
                $data_empty = true;
            }

        }while($data_empty == false);
    }
    $assign = isset($params['assign']) ? $params['assign'] : 'data';
    $template->assign($assign,$items[$deep]);
}