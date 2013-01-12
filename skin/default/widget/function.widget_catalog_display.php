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
 * @copyright  MAGIX CMS Copyright (c) 2012 Gerits Aurelien,
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
 * Smarty {widget_catalog_display} function plugin
 * Type:     function
 * Name:     widget_catalog_display
 * Date:     September 27, 2012
 * Update:   December  29, 2012
 * Purpose:
 * Output:  string
 * @link    htt://www.sire-sam.be, http://www.magix-dev.be
 * @author   Samuel Lesire
 * @author   Gerits Aurelien
 * @version  1.1
 * @param array
 * @param Smarty
 * @return string
 * @example & @doc : report to: https://github.com/sire-sam/Magix-CMS_Widget-Frontend/blob/master/function.widget_catalog_display.txt
 */

function smarty_function_widget_catalog_display($params, $template) {

    // *** Catch location var
    $id_current['category']     =       magixcjquery_filter_isVar::isPostNumeric($_GET['idclc'])        ;
    $id_current['subcategory']  =       magixcjquery_filter_isVar::isPostNumeric($_GET['idcls'])        ;
    $id_current['product']      =       magixcjquery_filter_isVar::isPostNumeric($_GET['idproduct'])    ;

    // *** Load SQL data
    $sort_config = (is_array($params['dataSelect'])) ? $params['dataSelect'] : array();
    $data = frontend_model_catalog::set_sql_data($sort_config,$id_current);

    $output = null;
    if ($data != null){
        // *** set default html structure
        $strucHtml_default = array(
            'container'     =>  array(
                'htmlBefore'    => '<ul class="thumbnails">',
                    // items injected here
                'htmlAfter'     => '</ul>'
                ),
            'item'          =>  array(
                'htmlBefore'    => '<li class="span4"><div class="thumbnail">',
                    // item's elements injected here (name, img, descr)
                'htmlAfter'     => '</div></div></li>'
            ),
            'img'         =>  array(
                'classLink'     =>  'img'
                ),
            'name'        =>  array(
                'htmlBefore'    =>  '<div class="caption"> <h3>',
                'classLink'     =>  'name',
                'htmlAfter'     =>  '</h3>'
                ),
            'descr'       =>  array(
                'htmlBefore'    => '<p>',
                'lenght'        => 250,
                'delemiter'     => '...',
                'htmlAfter'     => '</p>'
                ),
            'price'       =>  array(
                'htmlBefore'    => '<p class="price">',
                'currency'      => ' € TTC',
                'htmlAfter'     => '</p>'
                ),
            'current'     =>  array(
                'class'         =>  ' current'
                ),
            'last'        =>  array(
                'class'         => ' last',
                'col'           =>  1
                )
        );

        // *** Set default elem to display
        $strucHtml_default['allow']     = array('', 'img', 'name', 'price', 'descr');
        $strucHtml_default['display']   = array(
            1 =>    array('','name', 'img', 'descr', 'price'),
            2 =>    array('','name', 'img', 'descr', 'price'),
            3 =>    array('','name', 'img', 'descr', 'price')
        );

        // *** Update html struct & item setting with custom var (params['structureHTML'])
        $structHtml_custom = ($params['htmlStructure']) ? $params['htmlStructure'] : null;
        $strucHtml = frontend_model_catalog::set_html_struct($strucHtml_default,$structHtml_custom);

        // *** format items loop (foreach item)
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

        // *** boucle / loop
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
                        // @TODO test if there's no other solution too englobe items with container
                        $items[$deep] = $strucHtml_item['container']['htmlBefore'].$items[$deep].$strucHtml_item['container']['htmlAfter'];
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

                // Récupération de la taille de l'image
                if (isset($structHtml['img']['size_'.$deep]))
                    $row[$deep]['img_size'] = $structHtml['img']['size_'.$deep];
                elseif (isset($structHtml['img']['size']))
                    $row[$deep]['img_size'] = $structHtml['img']['size'];

                // Construit doonées de l'item en array avec clée nominative unifiée ('name' => 'monname,'descr' => '<p>ma descr</p>,...)
                $item_dataVal  = frontend_model_catalog::set_data_item($row[$deep],$id_current);

                // Configuration de la structure HTML de l'item
                $strucHtml['is_current'] = ($item_dataVal['current'] == 'true' OR $item_dataVal['current'] == 'parent') ? 1 : 0;
                $strucHtml['id'] = (isset($item_dataVal['id'])) ? $item_dataVal['id'] : 0;
                $strucHtml['url'] = (isset($item_dataVal['uri'])) ? $item_dataVal['uri'] : '#';
                $strucHtml_item = frontend_model_catalog::set_html_struct_item($strucHtml,$deep,$i[$deep]);

                // remise à zero du compteur si élément est le dernier de la ligne
                if ($strucHtml_item['is_last'] == 1){
                    $i[$deep] = 0;
                }

                // Récupération de l'affichage pour le niveau
                $strucHtml_item['display'] = (is_array($strucHtml['display'][$deep])) ? $strucHtml['display'][$deep] : $strucHtml['display'][1];
                if ($strucHtml_item['display'] == null)
                    $strucHtml_item['display'] = $strucHtml_default['display'][1];


                // Récupération des sous-données (enfants)
                if(isset($items[$deep_plus]) != null) {
                    $subitems = $items[$deep_plus];
                    $items[$deep_plus] = null;
                }else{
                    $subitems = null;
                }

                $item = null;
                foreach ($strucHtml_item['display'] as $elem_type ){
                    // BOUCLE de formatage des éléments contenus dans item
                    $strucHtml_elem = $strucHtml_item[$elem_type ];
                    if(array_search($elem_type,$strucHtml_item['display'])){
                        // Config class link
                        $item_classLink = null;
                        if(isset($strucHtml_elem['classLink'])){
                            $item_classLink = ' class="'.$strucHtml_elem['classLink'].'"';
                            $item_classLink = ($strucHtml_elem['classLink'] == 'none') ? 'none' : $item_classLink;
                        }
                        // Format element on switch
                        switch($elem_type){
                            case 'name':
                                $elem = ($item_classLink != 'none') ? '<a'.$item_classLink.' href="'.$item_dataVal['uri'].'" title="'. $item_dataVal['name'].'">' : '';
                                $elem .= $item_dataVal['name'];
                                $elem .= ($item_classLink != 'none') ? '</a>'  : '';
                                break;
                            case 'img':
                                $elem = ($item_classLink != 'none') ? '<a'.$item_classLink.' href="'.$item_dataVal['uri'].'" title="'. $item_dataVal['name'].'">' : '';
                                $elem .= '<img src="'.$item_dataVal['img_src'].'" alt="'.$item_dataVal['name'].'"/>';
                                $elem .= ($item_classLink != 'none') ? '</a>' : '';
                                break;
                            case 'descr':
                                $elem = magixcjquery_form_helpersforms::inputCleanTruncate( magixcjquery_form_helpersforms::inputTagClean($item_dataVal['descr']), $strucHtml_item['descr']['lenght'] , $strucHtml_item['descr']['delemiter']);
                                break;
                            case 'price':
                                if (is_numeric($item_dataVal['price']))
                                    $elem = $item_dataVal['price'] . $strucHtml_item['price']['currency'];
                                else
                                    $elem = null;
                                break;
                            default:
                                $elem = null;
                        }
                        if ($elem != null){
                            $item .= $strucHtml_elem['htmlBefore'];
                            $item .= $elem;
                            $item .= $strucHtml_elem['htmlAfter'];
                        }
                    }

                }
                $items[$deep] .= $strucHtml_item['item']['htmlBefore'];
                $items[$deep] .= $item;
                $items[$deep] .= $subitems;
                $items[$deep] .= $strucHtml_item['item']['htmlAfter'];
            }
            // *** list format END

            // Si $data est vide => arrête la boucle
            if (empty($data) AND $row[1] == null)
                $data_empty = true;

        }while($data_empty == false);

        // *** container construct
        if ($items[1] != null) {
            $output .= $strucHtml['container']['htmlBefore'];
            $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
            $output .=  $items[1];
            $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
            $output .= $strucHtml['container']['htmlAfter'];
        }else{
            $output = null;
        }
    }
    return $output;
}