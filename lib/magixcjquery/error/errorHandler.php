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
 * @package ErrorHandler
 *
 */
class magixcjquery_error_errorHandler implements SplSubject{
	private $_errno;
	private $_errstr;
	private $_errline;
	private $_errfile;
	private $_observers = array();

	public function error($errno, $errstr, $errfile, $errline)
	{
		if(error_reporting() == 0) {
			return;
		}
		$this->_errno   = $errno;
		$this->_errstr  = $errstr;
		$this->_errfile = $errfile;
		$this->_errline = $errline;
		$this->notify();
		return false;
	}

	public function getError()
	{
		return $this->_errstr . ', ' . $this->_errfile . ', ' . $this->_errline;
	}

	public function attach(SplObserver $obs)
	{
		$this->_observers[] = $obs;
		return $this;
	}

	public function detach(SplObserver $obs)
	{
		if (is_int($key = array_search($obs, $this->_observers, true))) {
			unset($this->_observers[$key]);
		}
		return $this;
	}

	public function notify()
	{
		foreach ($this->_observers as $observer)
		{
			try{
				$observer->update($this); // délégation
			}catch(Exception $e){
				die($e->getMessage());
			}
		}
	}
}
class FileWriter implements SplObserver
{
	private $_fp;
	
	public function __construct($filepath)
	{
		if (false === $this->_fp = @fopen($filepath,'a+'))
		{
			throw new Exception('is not a valid file path');
		}
	}

	public function update(SplSubject $errorHandler)
	{
		@fputs($this->_fp,$errorHandler->getError() . PHP_EOL);
	}
}
class mockWriter implements SplObserver{
	
	private $_messages = array();

	public function update(SplSubject $errorHandler)
	{
		$this->_messages[] = $errorHandler->getError();
	}

	public function show()
	{
		return print_r($this->_messages, true);
	}
}
/*
class ErrorHandler
{
	
	public function error($errno, $errstr, $errfile, $errline)
	{
		
		if(error_reporting() == 0)
		{
			return;
		}
		if (!$fp = @fopen($_SERVER['DOCUMENT_ROOT'].M_TMP_DIR,'a+'))
		{
			throw new Exception('is not writable');
		}
		$message = $errstr . ', ' . $errfile . ', ' . $errline;
		@fputs($fp,$message . PHP_EOL);
		return false; // PHP 5.2 : false doit être retourné pour peupler $php_errormsg
	}
}*/
?>