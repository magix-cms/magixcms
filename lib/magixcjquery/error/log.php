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
 * @link http://www.clashdesign.be
 * @copyright clashdesign.be 2009
 * @author : Gérits Aurélien
 * @package : log
 * @version 0.1
 * 
 * $log = log::getInstance();
 * $log->logfile = '/tmp/errors.log';
 * $log->write('An error has occured', __FILE__, __LINE__);
 *
 */
class magixcjquery_error_log
{
  /**
  * Instance DataObjects class
  *
  * @var DataObjects
  * @access private
  * @static
  */
    private static $instancelog = null;
     /**
     *
     * @Constructor is set to private to stop instantion
     *
     */
    private function __construct()
    {
    }
    /**
     *
     * @settor
     *
     * @access public
     *
     * @param string $name
     *
     * @param mixed $value
     *
     */
    public function __set($name, $value)
    {
        switch($name)
        {
            case 'logfile':
            if (!file_exists($value)) {
            	if(!@fopen($value, "a+")){
            		throw new Exception("$value is not writable");
            	}
            }
            elseif(!is_writeable($value))
            {
                throw new Exception("$value is not a valid file path");
            }
            $this->logfile = $value;
            break;
            default:
            throw new Exception("$name cannot be set");
        }
    }
	
    /**
     *
     * @write to the logfile
     *
     * @access public
     *
     * @param string $message
     *
     * @param string $file The filename that caused the error
     *
     * @param int $line The line that the error occurred on
     *
     * @return number of bytes written, false other wise
     *
     */
    public function write($message, $file=null, $line=null)
    {
    	date_default_timezone_set('Europe/Brussels');
        $message = iconv('ISO-8859-1', 'UTF-8', strftime('%d/%m/%Y, %H:%M:%S')) .' - '.$message;
        $message .= is_null($file) ? '' : " in $file";
        $message .= is_null($line) ? '' : " on line $line";
        $message .= "\n";
        return file_put_contents( $this->logfile, $message, FILE_APPEND );
    }

    /**
    *
    * Return logger instance or create new instance
    *
    * @return object (PDO)
    *
    * @access public
    *
    */
     public static function getLog(){
    	
    	if(is_null(self::$instancelog)){
    		
            self::$instancelog = new magixcjquery_error_log;
        }
        return self::$instancelog;
    }

}
?>