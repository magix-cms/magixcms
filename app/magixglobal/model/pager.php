<?php
/*
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of MAGIX CMS.
# MAGIX CMS, The content management system optimized for users
# Copyright (C) 2008 - 2013 sc-box.com <support@magix-cms.com>
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
 * Author: Gerits Aurelien <aurelien[at]magix-cms[point]com>
 * Copyright: MAGIX CMS
 * Date: 1/02/13
 * Time: 22:57
 * License: Dual licensed under the MIT or GPL Version
 */
class magixglobal_model_pager{
    /**
     * Retourne les données sql sur base des paramètres passés en paramète
     * @param numeric $limit
     * @param numeric $current
     * @return numerice
     */
    public function setPaginationOffset($limit,$current){
        $pagination = new magixcjquery_pager_pagination();
        return $pagination->pageOffset($limit,$current);
    }
    /**
     * Retourne la liste des liens pour la pagination
     * @param int $totalItems
     * @param int $perPage
     * @param string $basePath
     * @param int $currentPage
     * @param string $separator
     * @return array|null
     */
    public function setPaginationData($totalItems,$perPage,$basePath,$currentPage=1,$separator='/',$debug=false)
    {
        $output = array();
        $total['items']     = $totalItems;
        $total['perPage']   = $perPage;

        if ($total['items'] >= $total['perPage']) {
            $total['page'] = ceil($total['items']/$total['perPage']);

            // Si je ne suis pas sur la première page, je retourne les liens first et previous
            if ($currentPage > 1) {
                $output[] = array(
                    'name' => 'first',
                    'url'  => $basePath
                );
                $output[] = array(
                    'name' => 'previous',
                    'url'  => $basePath.'page'.$separator.($currentPage-1)
                );
            }

            // Construction de chaque numéro de page
            for ($i = 1; $i <= $total['page']; $i++)
            {
                $output[] = array(
                    'name' => $i,
                    'url'  => $basePath.'page'.$separator.$i
                );
            }

            // Si je ne suis pas sur la dernière page, je retourne les liens next et last
            if ($currentPage < $total['page']) {
                $output[] = array(
                    'name' => 'next',
                    'url'  => $basePath.'page'.$separator.($currentPage+1)
                );
                $output[] = array(
                    'name' => 'last',
                    'url'  => $basePath.'page'.$separator.$total['page']
                );
            }
        }
        return $output;
    }
}