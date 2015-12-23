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
/**
 * 
 * Magix cjQuery
 * 
 * @author Gérits Aurélien
 * @access public
 * @copyright magix cjquery
 * @version 0.1
 * @package View Helper
 * @name headLink
 *
 */
class magixcjquery_view_helper_headLink extends link_rel{
	/**
	 * Instance
	 * @var void
	 * @access private
	 */
	private static $instance = null;
	/**
	 * Constante application
	 * @var string
	 * @return application/
	 */
	const application = 'application/';
	/**
	 * Constante rss
	 * @var string
	 * @return rss+xml
	 */
	const rss = "rss+xml";
	/**
     * instance singleton
     * @access public
     */
    private static function getInstance(){
    	if (!isset(self::$instance)){
    		if(is_null(self::$instance)){
				self::$instance = new magixcjquery_view_helper_headLink();
			}
      	}
		return self::$instance;
    }
	/**
	 * 
	 * start Ini link meta
	 * 
	 * @access private
	 */
	private function startLink(){
		if(self::getInstance()){
			return '<link ';
		}
	}
	/**
	 * end link meta
	 * 
	 * @access private
	 */
	private function endLink(){
		if(self::getInstance()){
			return ' />'.PHP_EOL;
		}
	}
	/**
	 * 
	 * magixcjquery_view_helper_headLink::linkStyleSheet()
	 * <link rel="stylesheet" type="text/css" href="http://mydomaine.com/styles.css" media="screen" />
	 * 
	 * @param string $href
	 * @param string media
	 */
	public static function linkStyleSheet($href,$media='screen'){
		if(self::getInstance()){
			return self::getInstance()->startLink().link_rel::stylesheet($href,$media).self::getInstance()->endLink();
		}
	}
	/**
	 * 
	 * magixcjquery_view_helper_headLink::linkRss()
	 * <link rel="alternate" type="application/rss+xml" href="http://mydomaine.com/rss.xml" />
	 * 
	 * @param string $href
	 */
	public static function linkRss($href){
		if(self::getInstance()){
			return self::getInstance()->startLink().link_rel::alternate(self::application.self::rss,$href).' title="RSS"'.self::getInstance()->endLink();
		}
	}
}
abstract class link_rel{
	/**
	 * Protected define alternate params
	 * @param string $type
	 * @param string $href
	 */
	protected function alternate($type,$href){
		return 'rel="alternate" type="'.$type.'" href="'.$href.'"';
	}
	/**
	 * Protected define alternate params
	 * @param string $type
	 * @param string $media
	 */
	protected function stylesheet($href,$media){
		return 'rel="stylesheet" type="text/css" href="'.$href.'" media="'.$media.'"';
	}
}