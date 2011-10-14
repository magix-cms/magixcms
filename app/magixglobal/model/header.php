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
 * @category   Model 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.1
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name header
 *
 */
class magixglobal_model_header{
	protected
    $statusCode  = 200,
    $statusText  = 'OK',
    $headerOnly  = false,
    $headers     = array();
    
	static protected $statusTexts = array(
	    '100' => 'Continue',
	    '101' => 'Switching Protocols',
	    '200' => 'OK',
	    '201' => 'Created',
	    '202' => 'Accepted',
	    '203' => 'Non-Authoritative Information',
	    '204' => 'No Content',
	    '205' => 'Reset Content',
	    '206' => 'Partial Content',
	    '300' => 'Multiple Choices',
	    '301' => 'Moved Permanently',
	    '302' => 'Found',
	    '303' => 'See Other',
	    '304' => 'Not Modified',
	    '305' => 'Use Proxy',
	    '306' => '(Unused)',
	    '307' => 'Temporary Redirect',
	    '400' => 'Bad Request',
	    '401' => 'Unauthorized',
	    '402' => 'Payment Required',
	    '403' => 'Forbidden',
	    '404' => 'Not Found',
	    '405' => 'Method Not Allowed',
	    '406' => 'Not Acceptable',
	    '407' => 'Proxy Authentication Required',
	    '408' => 'Request Timeout',
	    '409' => 'Conflict',
	    '410' => 'Gone',
	    '411' => 'Length Required',
	    '412' => 'Precondition Failed',
	    '413' => 'Request Entity Too Large',
	    '414' => 'Request-URI Too Long',
	    '415' => 'Unsupported Media Type',
	    '416' => 'Requested Range Not Satisfiable',
	    '417' => 'Expectation Failed',
	    '500' => 'Internal Server Error',
	    '501' => 'Not Implemented',
	    '502' => 'Bad Gateway',
	    '503' => 'Service Unavailable',
	    '504' => 'Gateway Timeout',
	    '505' => 'HTTP Version Not Supported',
  	);
  	/**
  	 * 
  	 * Configuration du status
  	 * @param integer $code
  	 * @param string $name
  	 */
	public function setStatusCode($code, $name = null){
	    $this->statusCode = $code;
	    return $this->statusText = null !== $name ? $name : self::$statusTexts[$code];
	  }
   /**
   * retourne l'entete http
   * @param integer $code
   * @param string $name
   */
	public function getStatus($code, $name = null){
	  	return header('HTTP/1.1 '.$code.' '.$name);
	}
	  /**
   * Retrieves a formated date.
   *
   * @param  string $timestamp  Timestamp
   * @param  string $type       Format type
   *
   * @return string Formatted date
   */
  static public function getDate($timestamp, $type = 'rfc1123')
  {
    $type = strtolower($type);

    if ($type == 'rfc1123')
    {
      return substr(gmdate('r', $timestamp), 0, -5).'GMT';
    }
    else if ($type == 'rfc1036')
    {
      return gmdate('l, d-M-y H:i:s ', $timestamp).'GMT';
    }
    else if ($type == 'asctime')
    {
      return gmdate('D M j H:i:s', $timestamp);
    }
    else
    {
      throw new InvalidArgumentException('The second getDate() method parameter must be one of: rfc1123, rfc1036 or asctime.');
    }
  }
/**
   * Retrieves status text for the current web response.
   *
   * @return string Status text
   */
  public function getStatusText()
  {
    return $this->statusText;
  }

  /**
   * Retrieves status code for the current web response.
   *
   * @return integer Status code
   */
  public function getStatusCode()
  {
    return $this->statusCode;
  }
  
	/**
	 * @param $expire
	 * Expiration de l'entête
	 */
	public function head_expires($expire){
		return header("Expires:".$expire); 
	}
	/**
	 * 
	 * Dernière modification
	 * @param date $date
	 */
	public function head_last_modified($date){
		return header("Last-Modified: ".$date );
	}
	/**
	 * @return 
	 * retourne pragma
	 */
	public function pragma(){
		return header("Pragma: no-cache" ); 
	}
	/**
	 * retourne le cache control
	 * @return string
	 * retourne cache control
	 * @param string $cache
	 */
	public function cache_control($cache){
		switch($cache){
			case "nocache":
				$controle = array("no-store", "no-cache", "max-age=0", "must-revalidate");
			break;
			case "public":
				$controle = array("public", "must-revalidate");
			break;
			case "private":
				$controle = array("public", "must-revalidate");
			break;
		}
		return implode(',',$controle);
	}
	/**
	 * retourne l'entete json
	 * @param string $charset
	 * @param bool $debug
	 */
	public function json_header($charset,$debug=false){
		header('Content-type: application/json; charset='.$charset);
		if($debug == true){
			magixcjquery_debug_magixfire::magixFireLog("Headers:", headers_list());
		}
	}
	/**
	 * retourne l'entete html
	 * @param string $charset
	 * @param bool $debug
	 */
	public function html_header($charset,$debug=false){
		header('Content-Type: text/html; charset='.$charset);
		if($debug == true){
			magixcjquery_debug_magixfire::magixFireLog("Headers:", headers_list());
		}
	}
	/**
	 * retourne l'entete html
	 * @param string $charset
	 * @param bool $debug
	 */
	public function txt_header($charset,$debug=false){
		header('Content-Type: text/plain; charset='.$charset);
		if($debug == true){
			magixcjquery_debug_magixfire::magixFireLog("Headers:", headers_list());
		}
	}
	/**
	 * 
	 * Retourne
	 * @param unknown_type $debug
	 */
	public function insight_header($debug=false){
		header('x-insight: inspect');
		if($debug == true){
			magixcjquery_debug_magixfire::magixFireLog("Headers:", headers_list());
		}
	}
	/**
	 * @param string $method
	 * @param  $arguments
	 * @throws Exception
	 */
	public function __call($method, $arguments){
		throw new Exception(sprintf('Call to undefined method %s::%s.', get_class($this), $method));
	}
}