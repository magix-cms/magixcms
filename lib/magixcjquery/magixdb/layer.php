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
 * @package : magixdb
 * @version 0.3
 * 
 */
require('class.DataObjects.php');
require('interface.Layer.php');
class magixcjquery_magixdb_layer implements Layer {
	/**
	 * protected instance DataObjects
	 * @var $instance
	 */
	protected static $instance;
	/**
	 * instance DataObjects
	 *
	 * @var dataObjects
	 */
	//public $dataobject;
	/**
	 * function construct class
	 *
	 */
	protected function iDataObject(){
        if (!isset(self::$instance)){
         self::$instance = new DataObjects();
      	}
    	return self::$instance;
	}

    /**
     * function select Request
     *
     * @param request $sql
     * @param array|bool $execute
     * @param int|string $mode
     * @param bool $closeCursor
     * @param bool|void $debugParams
     * @internal param \closeCursor $void
     * @return array
     */
	function select($sql,$execute=false,$mode='assoc',$closeCursor=true,$debugParams=false){
		return self::iDataObject()->getInstance()->fetchAll($sql,$execute,$mode,$closeCursor,$debugParams);
	}

    /**
     * — Fetches the next row and returns it as an object.
     *
     * @param request $sql
     * @param bool $execute
     * @param bool $closeCursor
     * @param bool|void $debugParams
     * @internal param \closeCursor $void
     * @return \object() ;
     */
	function selectObject($sql,$execute=false,$closeCursor=true,$debugParams=false){
		return self::iDataObject()->getInstance()->fetchObject($sql,$execute,$closeCursor,$debugParams);
	}

    /**
     * function selectOne Request
     *
     * @param request $sql
     * @param bool $execute
     * @param int|string $mode
     * @param bool $closeCursor
     * @param bool|void $debugParams
     * @internal param \closeCursor $void
     * @return array
     */
	function selectOne($sql,$execute=false,$mode='assoc',$closeCursor=true,$debugParams=false){
		return self::iDataObject()->getInstance()->fetch($sql,$execute,$mode,$closeCursor,$debugParams);
	}
    /**
     * @param $sql
     * @param array $execute associative array containing the values ​​to bind
     * @param bool $typeArray associative array with the desired value for its corresponding key in $execute
     * @param bool $closeCursor Closes the cursor, enabling the statement to be executed again.
     * @param bool $debugParams Dump an SQL prepared command
     */
    function bindArrayValue($sql, $execute, $typeArray = false, $closeCursor=true, $debugParams=false){
        return self::iDataObject()->getInstance()->bindArrayValue($sql,$execute,$typeArray,$closeCursor,$debugParams);
    }

    /**
     * function insert value with array()
     *
     * @param string $sql
     * @param array() $execute
     * @param bool $closeCursor
     * @param bool|void $debugParams
     * @return void
     */
	function insert($sql,$execute,$closeCursor=true,$debugParams=false){
		self::iDataObject()->getInstance()->insertValue($sql,$execute,$closeCursor,$debugParams);
	}

    /**
     * function update value with array()
     *
     * @param string $sql
     * @param array() $execute
     * @param bool $closeCursor
     * @return void
     */
	function update($sql,$execute,$closeCursor=true){
		self::iDataObject()->getInstance()->updateValue($sql,$execute,$closeCursor);
	}

    /**
     * function delete value with array()
     *
     * @param string $sql
     * @param array() $execute
     * @param bool $closeCursor
     * @return void
     */
	function delete($sql,$execute,$closeCursor=true){
		self::iDataObject()->getInstance()->delValue($sql,$execute,$closeCursor);
	}

    /**
     * function transaction
     *
     * @param array|void $sql
     * @return void
     */
	function transaction($sql=array()){
		self::iDataObject()->getInstance()->InsertTransaction($sql);
	}

    /**
     * select DB column
     *
     * @param void $sql
     * @param int|string $column
     * @param bool $debugParams
     * @return
     */
	function selectColumn($sql, $column = 0,$debugParams=false){
		return self::iDataObject()->getInstance()->selectFetchColumn($sql,$column,$debugParams);
	}

    /**
     * Count column in DB
     *
     * @param void $sql
     * @param bool $debugParams
     * @return
     */
	function columnCount($sql,$debugParams=false){
		return self::iDataObject()->getInstance()->columnCountAll($sql,$debugParams);
	}
	/**
	 * function Optimize single table
	 *
	 * @param void $table
	 */
	function singleOptimize($table){
		self::iDataObject()->getInstance()->singleOptimizeTable($table);
	}
	/**
	 * function Optimize mulitple table
	 *
	 * @param void $table
	 */
	function multipleOptimize($table){
		self::iDataObject()->getInstance()->multipleOptimizeTable($table);
	}
	/**
	 * function drivers
	 * Return an array of available PDO drivers 
	 * @return array(void)
	 */
	function drivers(){
		self::iDataObject()->getInstance()->availableDrivers();
	}

    /**
     * function columnMeta
     * Returns metadata for a column in a result set
     * @param $column
     * @return \array(void)
     */
	function columnMeta($column){
		self::iDataObject()->getInstance()->getColumnMeta($column);
	}
	/**
	 * function lastInsert
	 * Returns the ID of the last inserted row or sequence value 
	 */
	function lastInsert(){
		return self::iDataObject()->getInstance()->lastInsertId();
	}
	/**
	 * Quotes a string for use in a query. 
	 * @param $string
	 */
	function escape_string($string){
		return self::iDataObject()->getInstance()->quote($string);
	}
	/**
	 * Advances to the next rowset in a multi-rowset statement handle 
	 * @return void
	 */
	function nextRow(){
		return self::iDataObject()->getInstance()->nextRowset();
	}

    /**
     * Create table
     * @param $sql
     * @param bool $debugParams
     * @return
     * @internal param $string
     */
	function createTable($sql,$debugParams=false){
		return self::iDataObject()->getInstance()->createTable($sql,$debugParams);
	}

    /**
     * Show table
     * @param $table
     * @param bool $debugParams
     * @internal param $string
     * @return \intéger
     */
	function showTable($table,$debugParams=false){
		return self::iDataObject()->getInstance()->showTable($table,$debugParams);
	}

    /**
     * Show Database
     * @param $database
     * @param bool $debugParams
     * @return \intéger
     */
	function showDatabase($database,$debugParams=false){
		return self::iDataObject()->getInstance()->showDatabase($database,$debugParams);
	}

    /**
     * Empty table
     * @param $table
     * @param bool $debugParams
     * @internal param $string
     * @return \intéger
     */
	function truncateTable($table,$debugParams=false){
		return self::iDataObject()->getInstance()->truncateTable($table,$debugParams);
	}
	/**
     * @return void
     * Test connexion in the SGBD with PDO
     */
	function PDOConnexion(){
		return self::iDataObject()->getInstance()->PDOConnexion();
	}
}
?>