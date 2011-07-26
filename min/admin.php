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
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
/**
 * @see groupsConfig
 * minify dans admin
 */
return array(
	'admincss'=>array('//framework/css/ui/dark-backend-1.8.10/jquery-ui-1.8.10.custom.css',
	'//framework/css/colorbox-simple/colorbox.css','//framework/css/ui/ui.checkbox.1.4.css',
	'//framework/css/ui/ui.spinner.1-20.css','//framework/css/notification.css','//framework/css/jquery.jqplot.css','//framework/css/globalforms.css','//framework/css/globalcss.css'),
	'adminjs'=> array('//framework/js/jquery-1.5.2.min.js','//framework/js/jquery-ui-1.8.10.custom.min.js','//framework/js/ui/i18n-1.8/jquery-ui-i18n.js',
	'//framework/js/jquery.form-2.83.js','//framework/js/jquery.validate.1.8.1.min.js','//framework/js/additional-methods.1.8.1.min.js',
	'//framework/js/jquery.validate.password-1.0.js','//framework/js/jquery.cookie.js','//framework/js/tools/jquery.colorbox-1.3.17.js',
	'//framework/js/ui/ui.spinner.1-20.min.js','//framework/js/jquery.jfirebug.js','//framework/js/tools/notice-tpl.js',
	'//framework/js/backend/magixtools.0.1.js','//framework/js/ad-globalform-1.0.js','//framework/js/backend/ad-globaljs-1.0.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);
?>