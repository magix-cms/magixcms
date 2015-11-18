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
 * @copyright clashdesign
 * @version 0.1
 * @package View Helper
 * @name headMeta
 *
 */
class magixcjquery_view_helper_headMeta{
	/**
	 * Instance
	 * @var void
	 * @access private
	 */
	private static $instance = null;
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const html = 'html';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const xhtml = 'xhtml';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const rdf = 'rdf';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const xbl = 'xbl';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const xml = 'xml';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const rtf = 'rtf';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const css = 'css';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const txt = 'txt';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const xul = 'xul';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const rss = 'rss';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const smil = 'smil';
	/**
	 * Constante type Content-Type
	 * @var void
	 */
	const svg = 'svg';
	/**
	 * Constante Charset for Constante-type
	 * @var void
	 */
	const utf8 = 'utf8';
	/**
     * instance singleton
     * @access public
     */
    private static function getInstance(){
    	if (!isset(self::$instance)){
    		if(is_null(self::$instance)){
				self::$instance = new magixcjquery_view_helper_headMeta();
			}
      	}
		return self::$instance;
    }
	/**
	 * 
	 * Ini meta http-equiv
	 * 
	 * @param string $httpequiv
	 * @param string $content
	 * @access protected
	 */
	protected function http_equiv($httpequiv,$content){
		if(self::getInstance()){
			return '<meta http-equiv="'.$httpequiv.'" content="'.$content.'" />';//.PHP_EOL;
		}
	}
	/**
	 * 
	 * Ini meta name
	 * 
	 * @param string $name
	 * @param string $content
	 * @access protected
	 * 
	 */
	protected function name($name,$content){
		if(self::getInstance()){
			return '<meta name="'.$name.'" content="'.$content.'" />';//.PHP_EOL;
		}
	}
	/**
	 * Config charset string
	 * @param void $charset
	 * 
	 * @return (string)
	 * 
	 */
	private function charset($charset){
		if(self::getInstance()){
			switch($charset){
				case self::utf8:
					$chrs = 'charset=utf-8';
					break;
				default:
					$chrs = 'charset=iso-8859-1';
			}
			return $chrs;
		}
	}
	/**
	 * Add content for css function
	 * @param string $css
	 * 
	 * @access protected
	 * @return (string)
	 * 
	 */
	private function css($css){
		if(self::getInstance()){
			if($css == self::css)
				return 'text/css';
		}
	}
	/**
	 * Define delay for revisit-after
	 * @param string $delay
	 * 
	 * @return (string)
	 * 
	 */
	private function delayRevisit($delay){
		if(self::getInstance()){
			switch($delay){
				case 'days':
					return 'days';
					break;
				case 'weeks':
					return 'weeks';
					break;
				case 'month':
					return 'month';
					break;
			}
		}
	}
	/**
	 * Function control intéger params
	 * @param intéger $int
	 */
	private function numRevisit($int){
		if(self::getInstance()){
			if(is_numeric($int)){
				return $int;
			}
			throw new Exception('Error argument "int" is not numeric');
		}
	}
	/**
	 * Add meta http-equiv Content-Type
	 * @param string $content
	 * @param string $charset
	 * 
	 * @access public
	 * @example 
	 * magixcjquery_view_helper_headMeta::contentType('html','utf8');
	 * <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	 * @return string
	 */
	public static function contentType($content=null,$charset){
		if(!null == $content){
			switch($content){
				case self::html:
					$type = 'text/html; '.self::getInstance()->charset($charset);
					break;
			}
			return self::getInstance()->http_equiv('Content-Type',$type);
		}
		throw new Exception('Missing argument content in Content-Type!!');
	}
	/**
	 * Add meta http-equiv Content-Type-Style
	 * @param string $style
	 * 
	 * @access public
	 * @example 
	 * magixcjquery_view_helper_headMeta::contentStyleType('css');
	 * <meta http-equiv="Content-Style-Type" content="text/css" />
	 * @return string
	 */
	public static function contentStyleType($style=null){
		if(!null == $style){
			switch($style){
				case self::css:
					$content = self::getInstance()->css(self::css);
					break;
			}
			return self::getInstance()->http_equiv('Content-Style-Type',$content);
		}
		throw new Exception('Missing argument style in Content-Style-Type!!');
	}
	/**
	 * Add meta http-equiv Content-Language
	 * @param string $content
	 * 
	 * @access public
	 * @example 
	 * magixcjquery_view_helper_headMeta::contentLanguage('fr,en,nl');
	 * <meta http-equiv="Content-Language" content="fr,en,nl" />
	 * @return string
	 */
	public static function contentLanguage($content){
		return self::getInstance()->http_equiv('Content-Language',$content);
	}
	/**
	 * Add meta name revisit-after
	 * @param intéger $int
	 * @param string $delay
	 * 
	 * @access public
	 * @example 
	 * magixcjquery_view_helper_headMeta::revisitAfter(3,'days');
	 * <meta name="revisit-after" content="3 days" />

	 * @return string
	 */
	public static function revisitAfter($int,$delay){
		return self::getInstance()->name('revisit-after',self::getInstance()->numRevisit($int).' '.self::getInstance()->delayRevisit($delay));
	}
	/**
	 * Add meta name robots
	 * @param string $content
	 * 
	 * @access public
	 * @example 
	 * magixcjquery_view_helper_headMeta::robots('index, follow, all');
	 * <meta name="robots" content="index, follow, all" />
	 * @return string
	 */
	public static function robots($content){
		return self::getInstance()->name('robots',$content);
	}
	/**
	 * Add meta name googleSiteVerification
	 * @param string $content
	 * 
	 * @access public
	 * @example 
	 * magixcjquery_view_helper_headMeta::googleSiteVerification('+nxGUDJ4QpAZ5l9Bsjdi102tLVC21AIh5d1Nl23908vVuFHs34=');
	 * <meta name="google-site-verification" content="+nxGUDJ4QpAZ5l9Bsjdi102tLVC21AIh5d1Nl23908vVuFHs34=" />
	 * @return string
	 */
	public static function googleSiteVerification($content){
		return self::getInstance()->name('google-site-verification',$content);
	}
	/**
	 * Add meta name keywords
	 * @param string $content
	 * 
	 * @access public
	 * @example 
	 * magixcjquery_view_helper_headMeta::keywords('magixcjquery,jquery,ajax');
	 * <meta name="keywords" content="magixcjquery,jquery,ajax" />
	 * @return string
	 */
	public static function keywords($content){
		return self::getInstance()->name('keywords',$content);
	}
	/**
	 * Add meta name description
	 * @param string $content
	 * 
	 * @access public
	 * @example 
	 * magixcjquery_view_helper_headMeta::description('my website');
	 * <meta name="description" content="my website" />
	 * @return string
	 */
	public static function description($content){
		return self::getInstance()->name('description',$content);
	}
}