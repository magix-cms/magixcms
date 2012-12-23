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
 * @package    minify
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @version    plugin version
 *
 */
/**
 * @see groupsConfig
 * minify dans public
 */
return array(
	'publiccss' => array('//framework/css/notification.css'),
	'publicjs'=> array('//framework/js/jquery-1.7.2.min.js','//framework/js/jquery-ui-1.8.23.custom.min.js',
	'//framework/js/ui/i18n-1.8.15/jquery-ui-i18n.js','//framework/js/jquery.form.3.03.js',
        '//framework/js/jquery.validate.2.0.0.pre.js','//framework/js/additional-methods.2.0.0.pre.js','//framework/js/tools/jquery.colorbox-1.3.18.js',
	'//framework/js/jquery.cookie.js'),
	'jimagine' => array('//framework/js/jimagine/plugins/jquery.nicenotify.js','//framework/js/jimagine/plugins/jquery.fbwidget.js',
	'//framework/js/jimagine/config.js','//framework/js/jimagine/constant.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);
?>