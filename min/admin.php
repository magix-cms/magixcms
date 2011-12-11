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
 * minify dans admin
 */
return array(
	'admincss'=>array('//framework/css/ui/dark-backend-1.8.15/jquery-ui-1.8.15.custom.css',
	'//framework/css/colorbox-simple/colorbox.css',
	'//framework/css/ui/ui.spinner.1-20.css','//framework/css/notification.css','//framework/css/jquery.jqplot.css','//framework/css/globalforms.css','//framework/css/globalcss.css'),
	'globaljs'=> array('//framework/js/jquery-1.7.1.min.js','//framework/js/jquery-ui-1.8.15.custom.min.js','//framework/js/ui/i18n-1.8.15/jquery-ui-i18n.js',
	'//framework/js/jquery.form.2.93.js','//framework/js/jquery.validate.1.9.min.js','//framework/js/additional-methods.1.9.min.js',
	'//framework/js/jquery.validate.password-1.0.js','//framework/js/jquery.cookie.js','//framework/js/tools/jquery.colorbox-1.3.18.js',
	'//framework/js/ui/ui.spinner.1-20.min.js','//framework/js/jquery.jfirebug.js','//framework/js/tools/notice-tpl.js',
	'//framework/js/backend/magixtools.0.1.js','//framework/js/jimagine/plugins/jquery.nicenotify.js','//framework/js/jimagine/config.js','//framework/js/jimagine/constant.js'),
	'adminjs'=> array('//framework/js/ad-globalform-1.0.js','//framework/js/backend/ad-globaljs-1.0.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);
?>