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
 * Date: 12/02/13
 * Time: 01:13
 * License: Dual licensed under the MIT or GPL Version
 */
$baseadmin = '../../../../../baseadmin.php';
if(file_exists($baseadmin)){
    require_once $baseadmin;
    if(!defined('PATHADMIN')){
        throw new Exception('PATHADMIN is not defined');
    }elseif(!defined('VERSION_EDITOR')){
        throw new Exception('VERSION_EDITOR is not defined');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{#mc_catalog_dlg.title}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="/framework/library/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/framework/plugins/jquery.form.3.20.js"></script>
    <script type="text/javascript" src="../../tiny_mce_popup.js"></script>
    <script type="text/javascript">
        var baseadmin = <?php print '"'.PATHADMIN.'"'; ?>
    </script>
    <script type="text/javascript" src="js/dialog.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="css/product_search.css" />-->
</head>
<body class="forceColors">
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <p>
                <img src="img/cart_search.gif" width="24" height="24" />
                {#mc_catalog_dlg.description}
            </p>
            <form id="forms-product-search" class="form-search" method="post" action="">
                <p>
                    <input type="text" class="input-large" name="product_search" id="product_search" value="" size="30" />
                    <input type="submit" class="btn btn-small btn-primary" value="{#mc_catalog_dlg.search}" />
                </p>
            </form>
            <div id="list_product_search"></div>
        </div>
    </div>
</div>
</body>
</html>
