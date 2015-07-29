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
 * Author: Gerits Aurelien <aurelien[at]magix-cms[point]com>
 * Copyright: MAGIX CMS
 * Date: 12/02/13
 * Update: 07/10/2013
 * Time: 19:13
 * License: Dual licensed under the MIT or GPL Version
 */
$baseadmin = '../../../../../../baseadmin.php';
if(file_exists($baseadmin)){
    require_once $baseadmin;
    if(!defined('PATHADMIN')){
        throw new Exception('PATHADMIN is not defined');
    }elseif(!defined('VERSION_EDITOR')){
        throw new Exception('VERSION_EDITOR is not defined');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>
    search News
  </title>
  <link href="/<?php print PATHADMIN; ?>/template/css/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="css/mc_catalog.css" rel="stylesheet">
      <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="/libjs/html5shiv.js" type="text/javascript"></script>
      <script src="/libjs/respond.min.js" type="text/javascript"></script>
      <![endif]-->
  </head>
  <body>
   <div class="container">
        <div id="template-container" class="row"></div>
        <div id="list-catalog-search" class="row"></div>
    </div>
  <script type="text/javascript" src="/<?php print PATHADMIN; ?>/min/?g=adminjs"></script>
  <script src="js/vendor/mustache.js"></script>
  <script type="text/javascript">
    var baseAdmin = <?php print '"'.PATHADMIN.'"'; ?>
    // Get someArg value inside iframe dialog
    //var someArg = top.tinymce.activeEditor.windowManager.getParams().someArg;
  </script>
  <script src="js/mc_catalog.js"></script>
  </body>
</html>