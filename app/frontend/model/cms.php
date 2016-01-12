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
 * Author: Sire Sam (www.sire-sam.be)
 * Copyright: MAGIX CMS
 * Date: 29/12/12
 * License: Dual licensed under the MIT or GPL Version
 */
class frontend_model_cms extends frontend_db_cms
{
    /**
     * Formate les valeurs principales d'un élément suivant la ligne passées en paramètre
     * @param $row
     * @param $current
     * @return array|null
     */
    public function setItemData($row,$current)
    {
        $ModelRewrite   =   new magixglobal_model_rewrite();

        $data = null;

        if ($row != null) {
            $data['id']     =   $row['idpage'];
            $data['name']   =   $row['title_page'];
            $data['url']    =
                ($row['idcat_p'] != 0)
                ? $ModelRewrite->filter_cms_url(
                    $row['iso'],
                    $row['idcat_p'],
                    $row['uri_page_p'],
                    $row['idpage'],
                    $row['uri_page'],
                    true
                )
                : $ModelRewrite->filter_cms_url(
                    $row['iso'],
                    null,
                    null,
                    $row['idpage'],
                    $row['uri_page'],
                    true
                );
            $data['active']   = false;
            if ($row['idpage'] == $current['record']['id'] OR $row['idpage'] == $current['parent']['id']) {
                $data['active']   = true;
            }
            $data['content']     = $row['content_page'];
            $data['date']['update']     = $row['last_update'];
            $data['date']['register']   = $row['date_register'];
            return $data;
        }
    }

    /**
     * Retourne les données sql sur base des paramètres passés en paramète
     * @param $custom
     * @param array $current
     * @return array|null
     */
    public static function getData($custom,$current)
    {
        if (!(is_array($custom))) {
            return null;
        }

        if (!(array_key_exists('cms',$current))) {
            return null;
        }

        $conf   =   array(
            'id'        =>  null,
            'type'      =>  null,
            'limit'     =>  null,
            'lang'      =>  $current['lang']['iso'],
            'context'     =>  array(1 => 'parent')
        );
        $current    =   $current['cms'];

        // custom values: data_sort
        if (isset($custom['select']) ) {
            if ($custom['select'] == 'current') {
                $conf['id'] = isset($current['parent']['id']) ? $current['parent']['id'] : $current['record']['id'];
            } elseif (is_array($custom['select']) ) {
                if (array_key_exists($conf['lang'],$custom['select'])) {
                    $conf['id'] = $custom['select'][$conf['lang']];
                }
            }
        } elseif (isset($custom['exclude'])) {
            if (is_array($custom['exclude'])) {
                if (array_key_exists($conf['lang'],$custom['exclude'])) {
                    $conf['id'] = $custom['exclude'][$conf['lang']];
                    $conf['type'] = 'exclude';
                }
            }
        }

        // custom values: display
        if (isset($custom['context'])) {
            if (is_array($custom['context'])) {
                foreach ($custom['context'] as $k => $v)
                {
                    $conf['context'][1] = $k;
                        $conf['context'][2] = $v;
                }
            } else {
                $allowed = array(
                    '',
                    'all',
                    'parent',
                    'child',
                    'mix'
                );

                if (in_array($custom['context'],$allowed)) {
                    $conf['context'][1] = $custom['context'];
                }
            }
        }

        // *** Load SQL data
        if ($conf['context'][1] == 'parent' OR $conf['context'][1] == 'all') {
            $data = parent::s_page($conf['lang'],$conf['id'],$conf['type'],$conf['limit']);
            if($data != null AND ($conf['context'][2] == 'child' OR $conf['context'][1] == 'all'))
            {
                foreach ($data as $k1 => $v1)
                {
                     $data_2 =
                         parent::s_page_child(
                             $conf['lang'],
                             $v1['idpage']
                         );
                     if ($data_2 != null)
                         $data[$k1]['subdata'] = $data_2;
                 }
                $data_2 = null;
            }
        } elseif ($conf['context'][1] == 'child') {
            $data = parent::s_page_child(
                $conf['lang'],
                $conf['id'],
                $conf['type'],
                $conf['limit']
            );
        } elseif ($conf['context'][1] == 'mix') {
			$data = parent::s_page_all($conf['lang'],$conf['id'],$conf['type'],$conf['limit']);
			if($data != null AND ($conf['context'][2] == 'child' OR $conf['context'][1] == 'all'))
			{
				foreach ($data as $k1 => $v1)
				{
					$data_2 =
						parent::s_page_child(
							$conf['lang'],
							$v1['idpage']
						);
					if ($data_2 != null)
						$data[$k1]['subdata'] = $data_2;
				}
				$data_2 = null;
			}
		}
        return $data;
    }


}
?>