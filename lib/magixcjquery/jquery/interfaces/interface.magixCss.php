<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of magix cjQuery.
# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.
# Magix cjQuery is a library written in PHP 5.
# It can work with a layer of abstraction, to validate data, handle jQuery code in PHP.
# Copyright (C)Magix cjQuery 2009 Gerits Aurelien
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or (at your option) any later version.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
interface ImagixCss{
	/**
	 * jquery attr function
	 * style property on the first matched element or all matched element
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $name
	 * @param array $properties
	 * @return string
	 */
	public static function jCss($nid=false,$seq='name',$params=true, $end=true);
	/**
	 * jQuery height function
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $value
	 * @return string
	 */
	public static function jHeight($nid=false, $value=false, $end=true);
	/**
	 * jQuery width function
	 *
	 * @param string $var
	 * @param string $nid
	 * @param string $value
	 * @return string
	 */
	public static function jWidth($nid=false, $value=false, $end=true);
}