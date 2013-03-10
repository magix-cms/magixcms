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
 * @package     Smarty
 * @subpackage  plugins
 * Type:        function
 * Name:        widget_catalog_display
 * Date:        27/09/2013
 * Update:      05/03/2013
 * @author      Samuel Lesire
 * @author      Gerits Aurelien
 * @link        htt://www.sire-sam.be, http://www.magix-dev.be
 * @version     1.1
 * @param       array
 * @param       Smarty
 * @return      string
 */

function smarty_function_widget_catalog_display($params, $template)
{
    $ModelSystem        =   new magixglobal_model_system();
    $ModelConstructor   =   new magixglobal_model_constructor();
    $ModelCatalog       =   new frontend_model_catalog();

    // Set and load data
    $current    =   $ModelSystem->setCurrentId();
    $conf       =   (is_array($params['conf'])) ? $params['conf'] : array();
    $data       =   $ModelCatalog->getData($conf,$current);

    // Format data
    $html = null;
    if ($data != null){
        $pattern['default']     =   patternCatalog();
        $pattern['custom']      =   null;
        if ($params['pattern']) {
            $pattern['custom']  =
                (is_array($params['pattern']))
                    ? $params['pattern']
                    : patternCatalog($params['pattern'])
            ;
        }
        $pattern['global'] = $ModelConstructor->mergeHtmlPattern($pattern['default'],$pattern['custom']);

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
            if ($pass_trough == 0) {
                // Si je n'ai plus de données à traiter je vide ma variable
                $row[$deep] = null;
            } else {
                // Sinon j'active le traitement des données
                $pass_trough = 0;
            }

            // Si je suis au premier niveaux et que je n'ai pas de donnée à traiter
            if ($deep == 1 AND $row[$deep] == null) {
                // récupération des données dans $data
                $row[$deep] = array_shift($data);
            }

            // Si ma donnée possède des sous-donnée sous-forme de tableau
            if (isset($row[$deep]['subdata'])) {
                if (is_array($row[$deep]['subdata']) AND $row[$deep]['subdata'] != null) {
                    // On monte d'une profondeur
                    $deep++;
                    $deep_minus++;
                    $deep_plus++;
                    // on récupére la  première valeur des sous-données en l'éffacant du tableau d'origine
                    $row[$deep] = array_shift($row[$deep_minus]['subdata']);
                    // Désactive le traitement des données
                    $pass_trough = 1;
                }
            } elseif($deep != 1) {
                if ($row[$deep] == null) {
                    if ($row[$deep_minus]['subdata'] == null) {
                        // Si je n'ai pas de sous-données & pas de données à traiter & pas de frères à récupérer dans mon parent
                        // ====> désactive le tableaux de sous-données du parent et retourne au niveau de mon parent
                        unset ($row[$deep_minus]['subdata']);
                        unset ($i[$deep]);
                        // @TODO test if there's no other solution too englobe items with container
                        $items[$deep] = $pattern['item']['container']['htmlBefore'].$items[$deep].$pattern['item']['container']['htmlAfter'];
                        $deep--;
                        $deep_minus = $deep  - 1;
                        $deep_plus = $deep  + 1;
                    } else {
                        // Je récupère un frère dans mon parent
                        $row[$deep] = array_shift($row[$deep_minus]['subdata']);
                    }
                    // Désactive le traitement des données
                    $pass_trough = 1;
                }
            }
            // *** loop management END

            // *** list format START
            if ($row[$deep] != null AND $pass_trough != 1) {
                $i[$deep]++;

                // Récupération de la taille de l'image
                if (isset($structHtml['img']['size_'.$deep]))
                    $row[$deep]['img_size']     =   $structHtml['img']['size_'.$deep];
                elseif (isset($structHtml['img']['size']))
                    $row[$deep]['img_size']     =   $structHtml['img']['size'];

                // Construit doonées de l'item en array avec clée nominative unifiée ('name' => 'monname,'descr' => '<p>ma descr</p>,...)
                $item_dataVal       =       $ModelCatalog->setItemData($row[$deep],$current['catalog']);

                // Configuration de la structure HTML de l'item
                $pattern['global']['is_current']    =   ($item_dataVal['current'] == 'true' OR $item_dataVal['current'] == 'parent') ? 1 : 0;
                $pattern['global']['id']            =   (isset($item_dataVal['id'])) ? $item_dataVal['id'] : 0;
                $pattern['global']['url']           =   (isset($item_dataVal['uri'])) ? $item_dataVal['uri'] : '#';
                $pattern['item']                    =   $ModelConstructor->setItemPattern($pattern['global'],$deep,$i[$deep]);

                // remise à zero du compteur si élément est le dernier de la ligne
                if ($pattern['item']['is_last'] == 1) {
                    $i[$deep] = 0;
                }

                // Récupération de l'affichage pour le niveau
                $pattern['item']['display'] = (is_array($pattern['global']['display'][$deep])) ? $pattern['global']['display'][$deep] : $pattern['global']['display'][1];
                if ($pattern['item']['display'] == null)
                    $pattern['item']['display'] = $pattern['default']['display'][1];


                // Récupération des sous-données (enfants)
                if(isset($items[$deep_plus]) != null) {
                    $subitems = $items[$deep_plus];
                    $items[$deep_plus] = null;
                }else{
                    $subitems = null;
                }

                $item = null;
                foreach ($pattern['item']['display'] as $elem_type )
                {
                    // BOUCLE de formatage des éléments contenus dans item
                    $pattern['elem'] = $pattern['item'][$elem_type ];
                    if (array_search($elem_type,$pattern['item']['display'])) {
                        // Config class link
                        $item_classLink = null;
                        if(isset($pattern['elem']['classLink'])){
                            $item_classLink = ' class="'.$pattern['elem']['classLink'].'"';
                            $item_classLink = ($pattern['elem']['classLink'] == 'none') ? 'none' : $item_classLink;
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
                                $elem = magixcjquery_form_helpersforms::inputCleanTruncate( magixcjquery_form_helpersforms::inputTagClean($item_dataVal['descr']), $pattern['item']['descr']['lenght'] , $pattern['item']['descr']['delemiter']);
                                break;
                            case 'price':
                                if (is_numeric($item_dataVal['price']))
                                    $elem = $item_dataVal['price'] . $pattern['item']['price']['currency'];
                                else
                                    $elem = null;
                                break;
                            default:
                                $elem = null;
                        }
                        if ($elem != null){
                            $item .= $pattern['elem']['htmlBefore'];
                            $item .= $elem;
                            $item .= $pattern['elem']['htmlAfter'];
                        }
                    }

                }
                $items[$deep] .= $pattern['item']['item']['htmlBefore'];
                $items[$deep] .= $item;
                $items[$deep] .= $subitems;
                $items[$deep] .= $pattern['item']['item']['htmlAfter'];
            }
            // *** list format END

            // Si $data est vide => arrête la boucle
            if (empty($data) AND $row[1] == null)
                $data_empty = true;

        }while($data_empty == false);

        // *** container construct
        if ($items[1] != null) {
            $html  = isset($params['title']) ? $params['title'] : '';
            $html .= $pattern['global']['container']['htmlBefore'];
            $html .= isset($params['prepend']) ? $params['prepend'] : null;
            $html .=  $items[1];
            $html .= isset($params['append']) ? $params['append'] : null;
            $html .= $pattern['global']['container']['htmlAfter'];
        }else{
            $html = null;
        }
    }
    return $html;
}
function patternCatalog ($name=null)
{
    $ModelTemplate  =   new frontend_model_template();
    $tr =   array(
        'show_product'  =>  $ModelTemplate->getConfigVars('show_product')
    );

    switch ($name) {
        case 'product':
            $pattern = array(
                'item'          =>  array(
                    'htmlBefore'    => '<li class="span8"><div class="thumbnail">',
                    // item's elements injected here (name, img, descr)
                    'htmlAfter'     => '</div></div></li>'
                )            );
            break;
        case 'sidebar':
            $pattern = array(
                'item'          =>  array(
                    'htmlBefore'    => '<li class="span3"><div class="thumbnail">',
                    // item's elements injected here (name, img, descr)
                    'htmlAfter'     => '</div></div></li>'
                ),
                'img'         =>  array(
                    'classLink'     =>  'img'
                ),
                'name'        =>  array(
                    'htmlBefore'    =>  '<div class="caption"> <p class="lead">',
                    'classLink'     =>  'name',
                    'htmlAfter'     =>  '</p>'
                ),
                'price'       =>  array(
                    'htmlBefore' => '<a class="btn" href="#url#">',
                    'htmlAfter' => '</a>'
                )
            );
            break;
        default:
            $pattern = array(
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
                    'htmlBefore' => '<a class="btn" href="#url#" title="'.$tr['show_product'].'">',
                    'currency'      => ' € TTC',
                    'htmlAfter' => '</a>'
                ),
                'current'     =>  array(
                    'class'         =>  ' current'
                ),
                'last'        =>  array(
                    'class'         => ' last',
                    'col'           =>  1
                ),
                'allow'      =>  array(
                    '',
                    'img',
                    'name',
                    'price',
                    'descr'
                ),
                'display'   =>  array(
                    1 =>    array('','name', 'img', 'descr', 'price'),
                    2 =>    array('','name', 'img', 'descr', 'price'),
                    3 =>    array('','name', 'img', 'descr', 'price')
                )
            );
    }
    return $pattern;
}
