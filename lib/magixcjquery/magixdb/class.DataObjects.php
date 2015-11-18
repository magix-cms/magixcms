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
 * @link http://www.magix-cjquery.com
 * @copyright magix-cjquery.com 2010 - 2011
 * @author : Gérits Aurélien
 * @abstract DbData
 * @package : magixdb
 * @version 0.3
 * 
 */
 abstract class DbData{
 	/**
 	 * DRIVER SGBD
 	 *
 	 * @var STRING
 	 */
 	protected static $driver = M_DBDRIVER;
	/**
	 * SGBD host
	 *
	 * @var string
	 */
	private static $host = M_DBHOST;
	/**
	 * SGBD Name
	 *
	 * @var string
	 */
	protected static $connStr = M_DBNAME;
	/**
	 * SGBD User
	 *
	 * @var string
	 */
	protected static $user = M_DBUSER;
	/**
	 * SFBD Pass
	 *
	 * @var string
	 */
	protected static $pass = M_DBPASSWORD;
	/**
	 * Load DB INFO HOST AND NAME
	 *
	 * @return string
	 */
	function getDnsData(){
		/*mysql*/
		return self::$driver.':dbname='.self::$connStr.';host='.self::$host;
	}
	/**
	 * @return database
	 */
	function getDBData(){
		return self::$connStr;
	}
	/**
	 * Load DbUser
	 *
	 * @return string
	 */
	function getuserData(){
 		
		return self::$user;
		
	}
	/**
	 * Load DbPassword
	 *
	 * @return string
	 */
	function getpassData(){
		
		return self::$pass;
	}
}
/**
 * class extends abstract DbData
 *
 */
class CallDbData extends DbData {
	/**
	 * call data DbName
	 *
	 * @return string
	 */
	function getconnStr(){
		return parent::getDnsData();
	}
	/**
	 * Load DbUser
	 *
	 * @return string
	 */
	function getuser(){
		return parent::getuserData();
	}
	/**
	 * Load DbPassword
	 *
	 * @return string
	 */
	function getpass(){
		return parent::getpassData();
	}
	/**
	 * return name database
	 * @return string
	 */
	function getDB(){
		return parent::getDBData();
	}
}
class DataObjects extends PDO {	
/**
  * Instance de la classe PDO
  *
  * @var PDO
  * @access private
  */
	private static $PDOInstance = null;
	 /**
  * Instance DataObjects class
  *
  * @var DataObjects
  * @access private
  * @static
  */
	private static $instance = null;
	/**
	 * instance CallDbData
	 * @var getinfo
	 * @access protected
	 */
	protected static $getinfo;
	/**
	 * Executes a prepared statement  
	 * @var execute
	 */
	private $execute; 
	/**
	 * constructor implemente CallData 
	 */
    function __construct () 
    {
    	if (!(self::getInfo() instanceof CallDbData)) {
    		throw new Exception('Invalid instanceof CallDbData');
    	}
    	if (!(self::PDOInstance() instanceof PDO)) {
    		throw new Exception('Invalid instanceof PDO');
    	}
        try{
			self::PDOInstance()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//self::PDOInstance()->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
        }catch(PDOException $e){
        	trigger_error($e->getMessage(), E_USER_ERROR);
		}
    }
    /**
     * instance singleton self (DataObjects)
     * @access public
     */
    public static function getInstance(){
    	if (!isset(self::$instance)){
    		if(is_null(self::$instance)){
				self::$instance = new DataObjects();
			}
      	}
		return self::$instance;
    }
	/**
     * instance singleton self (CallDbData)
     * @access protected
     */
    private static function getInfo(){
    	if (!isset(self::$getinfo)){
    		if(is_null(self::$getinfo)){
				self::$getinfo = new CallDbData();
			}
      	}
		return self::$getinfo;
    }
	/**
     * instance singleton self (PDO)
     * @access protected
     */
    private static function PDOInstance(){
    	if (!isset(self::$PDOInstance)){
    		if(is_null(self::$PDOInstance)){
				try {
					self::$PDOInstance = new PDO(self::getInfo()->getconnStr(),self::getInfo()->getuser(),self::getInfo()->getpass()/*,
						array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
					*/);
					self::$PDOInstance->exec("SET CHARACTER SET utf8");
				} catch (PDOException $e) {
					self::$PDOInstance = false;
				    die($e->getMessage());
				}
			}
      	}
      	return self::$PDOInstance;
    }
    /**
     * @return void
     * Test connexion in the SGBD with PDO
     */
    public function PDOConnexion(){
    	return self::PDOInstance();
    }
	/**
	 * Set the default mode for setFetchMode
	 *  Set an attribute 
	 * @return void
	 */
	private function setMode($mode){
		/*$fetch = array(
			'assoc' => PDO::FETCH_ASSOC,
			'class' => PDO::FETCH_CLASS,
			'column'=> PDO::FETCH_NUM
		);
		foreach ($fetch as $key){
			$fetchmode = $key[$mode];
		}*/
		switch($mode){
			case 'assoc':
				$fetchmode = PDO::FETCH_ASSOC;
			break;
			case 'class':
				$fetchmode = PDO::FETCH_CLASS;
			break;
			case 'column':
				$fetchmode = PDO::FETCH_NUM;
			break;
            case 'lazy':
                $fetchmode = PDO::FETCH_LAZY;
                break;
			default:
				$fetchmode = PDO::FETCH_ASSOC;
			break;
		}
		return $fetchmode;
	}
	/**
	 * Sets an attribute on the database handle. 
	 * @param array $attributes
	 */
	public function settingOptions($attributes=array()){
		if(is_array($attributes) && $attributes != null){
			return self::PDOInstance()->setAttribute($attributes);
		}
	}
	/**
	 * Retrieve a database connection attribute 
	 * @param array $attributes
	 * @param void $dump
	 */
	public function getOptions($attributes=array(),$dump=false){
		if(is_array($attributes) && $attributes != null){
			return self::PDOInstance()->getAttribute($attributes);
			if($dump == true){
				foreach ($attributes as $val) {
				    print self::PDOInstance()->getAttribute(constant("PDO::ATTR_$val")). "\n";
				}
			}
		}
	}
	/**
      *  Executes an SQL statement, returning a result set as a PDOStatement object
      *
      * @param request $query
      * @return void
      */
	public function query($query)
	{
		return self::PDOInstance()->query($query);
	}
	/**
	 *  Prepares a statement for execution and returns a statement object 
	 *
	 * @param request containt $sql
	 * @return void
	 */
	public function prepare($sql){
		if (self::PDOInstance()){
			return self::PDOInstance()->prepare($sql);
		}
	}
	/**
	 *  Initiates a beginTransaction 
	 *
	 * @param void $sql
	 * @return void
	 */
	public function beginTransaction(){
		return self::PDOInstance()->beginTransaction();
	}
	/**
	 * instance exec
	 *
	 * @param void $sql
	 */
	public function exec($sql){
		self::PDOInstance()->exec($sql);
	}
	/**
	 * instance commit
	 *
	 */
	public function commit(){
		self::PDOInstance()->commit();
	}
	/**
	 * instance rollback
	 *
	 */
	public function rollback(){
		self::PDOInstance()->rollBack();
	}
	/**
	 * instance fetchColumn
	 *
	 */
	public function columnCount(){
		return self::PDOInstance()->columnCount();
	}
	/**
	 * instance fetchColumn
	 *
	 */
	public function fetchColumn($column){
		return self::PDOInstance()->fetchColumn($column);
	}
	/**
	 * Instance getColumnMeta
	 * @param integer $column
	 */
	public function getColumnMeta($column){
		return self::PDOInstance()->getColumnMeta($column);
	}
	/**
	 * Return an array of available PDO drivers 
	 * @return array(void)
	 */
	public function availableDrivers(){
		return self::PDOInstance()->getAvailableDrivers();
	}
	/**
	* Returns the ID of the last inserted row or sequence value 
	*/
	public function lastInsertId(){
		return self::PDOInstance()->lastInsertId();
	}
	/**
	 * Quotes a string for use in a query. 
	 * @param string $string
	 */
	public function quote($string){
		return self::PDOInstance()->quote($string);
	}
	/**
	 * Advances to the next rowset in a multi-rowset statement handle 
	 * @return void
	 */
	public function nextRowset(){
		return self::PDOInstance()->nextRowset();
	}
	/**
	 * returns an array containing one of the remaining rows in the result set
	 *
	 * @param request $sql
	 * @param int $mode
	 * @param void closeCursor
	 * @param void $debugParams
	 * @return array();
	 */
	public function fetch($sql,$execute=false,$mode,$closeCursor=true,$debugParams=false){
		try{
			$prepare = $this->prepare($sql);
			$prepare->setFetchMode($this->setMode($mode));
			$execute ? $prepare->execute($execute) : $prepare->execute();
			$debugParams?$prepare->debugDumpParams():'';
		    $result = $prepare->fetch();
		    $closeCursor?$prepare->closeCursor():'';
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
		return $result;
	}
	/**
	 * — Fetches the next row and returns it as an object.
	 *
	 * @param request $sql
	 * @param void closeCursor
	 * @param void $debugParams
	 * @return object();
	 */
	public function fetchObject($sql,$execute=false,$closeCursor=true,$debugParams=false){
		try{
			$prepare = $this->prepare($sql);
			//$prepare->setFetchMode($this->setMode($mode));
			$execute ? $prepare->execute($execute) : $prepare->execute();
			$debugParams?$prepare->debugDumpParams():'';
		    $result = $prepare->fetchObject();
		    $closeCursor?$prepare->closeCursor():'';
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
		return $result;
	}
	/**
	 * returns an array containing all of the remaining rows in the result set
	 *
	 * @param request $sql
	 * @param array $execute
	 * @param int $mode
	 * @param void closeCursor
	 * @param void $debugParams
	 * @return array();
	 */
	public function fetchAll($sql,$execute=false,$mode,$closeCursor=true,$debugParams=true){
		try{
			$prepare = $this->prepare($sql);
			$prepare->setFetchMode($this->setMode($mode));
			$execute ? $prepare->execute($execute) : $prepare->execute();
			$debugParams?$prepare->debugDumpParams():'';
		    $result = $prepare->fetchAll();
		    $closeCursor?$prepare->closeCursor():'';
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
		return $result;
	}

    /**
     * @param $sql
     * @param $execute
     * @param bool $typeArray associative array with the desired value for its corresponding key in $execute
     * @param bool $closeCursor Closes the cursor, enabling the statement to be executed again.
     * @param bool $debugParams Dump an SQL prepared command
     * @throws Exception
     * @return mixed
     * @example
     * $execute = array('language' => 'php','lines' => 254, 'publish' => true);
     * $typeArray = array('language' => PDO::PARAM_STR,'lines' => PDO::PARAM_INT,'publish' => PDO::PARAM_BOOL);
     * $sql = 'SELECT * FROM code WHERE language = :language AND lines = :lines AND publish = :publish';
     * You can bind $arraybind like that :
     * bindArrayValue($execute,$sql,$typeArray);
     */
    public function bindArrayValue($sql, $execute, $typeArray = false, $closeCursor=true, $debugParams=true){
        try{
            $prepare = $this->prepare($sql);
            if(is_object($prepare) && ($prepare instanceof PDOStatement)){
                if(is_array($execute)){
                    foreach($execute as $key => $value){
                        if($typeArray){
                            $prepare->bindValue("$key",$value,$typeArray[$key]);
                        }else{
                            if(is_int($value)){
                                $param = PDO::PARAM_INT;
                            }elseif(is_bool($value)){
                                $param = PDO::PARAM_BOOL;
                            }elseif(is_null($value)){
                                $param = PDO::PARAM_NULL;
                            }elseif(is_string($value)){
                                $param = PDO::PARAM_STR;
                            }else{
                                $param = FALSE;
                            }
                            if($param){
                                $prepare->bindValue("$key",$value,$param);
                            }
                        }
                    }
                    $debugParams ? $prepare->debugDumpParams():'';
                    $prepare->execute();
                    $result = $prepare->fetchAll();
                    $closeCursor ? $prepare->closeCursor():'';
                    return $result;
                }else{
                    throw new Exception('bindArrayValue : execute is not array');
                }
            }
        }catch(Exception $e){
            if (M_LOG == 'log') {
                if (M_TMP_DIR != null) {
                    $log = magixcjquery_error_log::getLog();
                    $log->logfile = M_TMP_DIR;
                    $log->write('An error has occured', $e->getMessage(), $e->getLine());
                    die("Error has database, debug with log");
                }else{
                    die('error path tmp dir');
                }
            }elseif(M_LOG == 'debug'){
                die($e->getMessage(). $e->getLine());
            }else{
                die("Error has database, debug with log");
            }
        }
    }

    /**
     * Execute a prepared statement with an array of insert values
     *
     * @param request $sql
     * @param array $execute
     * @param bool $closeCursor
     * @param bool $debugParams
     * @return void
     */
	public function InsertValue($sql,$execute,$closeCursor=true,$debugParams=false){
		try{
		$prepare = $this->prepare($sql);
		$prepare->execute($execute);
		$debugParams?$prepare->debugDumpParams():'';
		$closeCursor?$prepare->closeCursor():'';
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
	}

    /**
     * Execute a prepared statement with an array of update values
     *
     * @param request $sql
     * @param array $execute
     * @param bool $closeCursor
     * @return void
     */
	public function UpdateValue($sql,$execute,$closeCursor=true){
		try{
		$prepare = $this->prepare($sql);
		$prepare->execute($execute);
		$closeCursor?$prepare->closeCursor():'';
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
	}

    /**
     * Execute a prepared statement with an array of delete values
     *
     * @param request $sql
     * @param array $execute
     * @param bool $closeCursor
     * @return void
     */
	public function DelValue($sql,$execute,$closeCursor=true){
		try{
		$prepare = $this->prepare($sql);
		$prepare->execute($execute);
		$closeCursor?$prepare->closeCursor():'';
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
	}

    /**
     * function insert transaction exec
     *
     * @param void $sql
     * @throws Exception
     * @return void
     */
	public function InsertTransaction($sql){
		try{
			$this->beginTransaction();
			if(is_array($sql)){
				foreach ($sql as $key){
					$this->exec($key);
				}
				self::commit();
			}else{
				throw new Exception("Exec transaction is not array");
			}
		}catch(Exception $e){
			self::rollback();
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
	}

    /**
     * select DB column
     *
     * @param void $sql
     * @param string $column
     * @param $debugParams
     * @return
     */
	public function selectFetchColumn($sql,$column,$debugParams){
		try{
			$prepare = $this->prepare($sql);
			$prepare->execute();
			$debugParams?$prepare->debugDumpParams():'';
		    $result = $prepare->fetchColumn($column);
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
		return $result;
	}

    /**
     * select DB column
     *
     * @param void $sql
     * @param $debugParams
     * @return
     * @internal param string $column
     */
	public function columnCountAll($sql,$debugParams){
		try{
			$prepare = $this->prepare($sql);
			$prepare->execute();
			$debugParams?$prepare->debugDumpParams():'';
			$result = $prepare->columnCount();
			 
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
		return $result;
	}
	/**
	 * function Optimize single table
	 *
	 * @param void $table
	 */
	public function singleOptimizeTable($table){
		try{
			$prepare = $this->prepare('OPTIMIZE TABLE '.$table);
			$result = $prepare->execute();
			$prepare->closeCursor();
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
		return $result;
	}
	/**
	 * function Optimize single table
	 *
	 * @param void $table
     * @return null|string
     */
	public function multipleOptimizeTable($table){
		try{
			$result = null;
			foreach ($table as $tKey){
				$prepare = $this->prepare('OPTIMIZE TABLE '.$tKey);
				$result .= $prepare->execute();
				$prepare->closeCursor();
			}
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
        return $result;
	}
	/**
	 * Create simple table
	 *
	 * @param request $sql
	 * @param void $debugParams
	 * 
	 */
	public function createTable($sql,$debugParams){
		try{
			$prepare = $this->prepare($sql);
			//$prepare->setFetchMode($this->setMode($mode));
			$prepare->execute();
			$debugParams?$prepare->debugDumpParams():'';
		    $prepare->closeCursor();
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
	}
	/**
	 * SHOW TABLE WITH PDO
	 * @access public
	 * @param string $table
	 * @param void $debugParams
	 * @return intéger
	 */
	public function showTable($table,$debugParams){
		try{
			$sql = 'SHOW TABLES FROM '.self::getInfo()->getDB().' LIKE  \''. $table. '\''; 
			$prepare = $this->query($sql);
			$result = $prepare->rowCount();
			$debugParams?$prepare->debugDumpParams():'';
		    $prepare->closeCursor();
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
        return $result;
	}
	/**
	 * SHOW DATABASE WITH PDO
	 * @access public
	 * @param string $database
	 * @param void $debugParams
	 * @return intéger
	 */
	public function showDatabase($database,$debugParams){
		try{
			$sql = 'SHOW DATABASES LIKE  \''. $database. '\''; 
			$query = $this->query($sql);
			$result = $query->rowCount();
			$debugParams?$query->debugDumpParams():'';
		    $query->closeCursor();
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
        return $result;
	}
	/**
	 * function truncate table
	 *
	 * @param void $table
	 */
	public function truncateTable($table,$debugParams){
		try{
			$prepare = $this->prepare('TRUNCATE TABLE '. $table);
			$result = $prepare->execute();
			$debugParams?$prepare->debugDumpParams():'';
		    $prepare->closeCursor();
		}catch(Exception $e){
	        if (M_LOG == 'log') {
		       if (M_TMP_DIR != null) {
		          $log = magixcjquery_error_log::getLog();
		          $log->logfile = M_TMP_DIR;
		          $log->write('An error has occured', $e->getMessage(), $e->getLine());
		          die("Error has database, debug with log");	
		       }else{
		          die('error path tmp dir');
		       }
	        }elseif(M_LOG == 'debug'){
	              die($e->getMessage(). $e->getLine());
	        }else{
	             die("Error has database, debug with log");
	        }
        }
	}
	/**
	 * delete statique methode clone
	 */
	private function __clone() {
	    throw new Exception('cloning is not allowed');
	}
}
    ?>