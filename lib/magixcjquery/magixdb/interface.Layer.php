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
/**
 * interface Layer for magixLayer
 *
 */
interface Layer{
    /**
     * simple selection of all row
     *
     * @param void $sql
     * @param bool $execute
     * @param string|void $mode
     * @param bool $closeCursor
     * @param bool $debugParams
     * @return
     * @internal param $array ($execute)
     */
	function select($sql,$execute=false,$mode = 'assoc',$closeCursor=true,$debugParams=false);

    /**
     * — Fetches the next row and returns it as an object.
     *
     * @param request $sql
     * @param bool $execute
     * @param bool $closeCursor
     * @param bool|void $debugParams
     * @internal param \closeCursor $void
     * @return object();
     */
	function selectObject($sql,$execute=false,$closeCursor=true,$debugParams=false);

    /**
     * simple selection of one row
     *
     * @param void $sql
     * @param bool $execute
     * @param string|void $mode
     * @param bool $closeCursor
     * @param bool $debugParams
     * @return
     */
	function selectOne($sql,$execute=false,$mode = 'assoc',$closeCursor=true,$debugParams=false);
    /**
     * @param $sql
     * @param array $execute associative array containing the values ​​to bind
     * @param bool $typeArray associative array with the desired value for its corresponding key in $execute
     * @param bool $closeCursor Closes the cursor, enabling the statement to be executed again.
     * @param bool $debugParams Dump an SQL prepared command
     */
    function bindArrayValue($sql, $execute, $typeArray = false, $closeCursor=true, $debugParams=false);

    /**
     *     insertion of data in SGBD
     *
     * @param void $sql
     * @param array() $execute
     * @param bool $closeCursor
     * @param bool $debugParams
     * @return
     */
	function insert($sql,$execute,$closeCursor=true,$debugParams=false);

    /**
     * update of data in SGBD
     *
     * @param void $sql
     * @param array() $execute
     * @param bool $closeCursor
     * @return
     */
	function update($sql,$execute,$closeCursor=true);

    /**
     * delete data in SGBD
     *
     * @param void $sql
     * @param array() $execute
     * @param bool $closeCursor
     * @return
     */
	function delete($sql,$execute,$closeCursor=true);

    /**
     * insert, delete, update data in SGBD
     * ##### NO SELECT #####
     *
     * @param array|void $sql
     * @return
     */
	function transaction($sql=array());

    /**
     * select DB column
     *
     * @param void $sql
     * @param int|string $column
     * @param bool $debugParams
     * @return
     */
	function selectColumn($sql, $column = 0,$debugParams=false);

    /**
     * count column in DB
     *
     * @param void $sql
     * @param bool $debugParams
     * @return
     */
	function columnCount($sql,$debugParams=false);
	/**
	 * function drivers
	 * Return an array of available PDO drivers 
	 * @return array(void)
	 */
	function drivers();

    /**
     * function columnMeta
     * Returns metadata for a column in a result set
     * @param $column
     * @return array(void)
     */
	function columnMeta($column);
	/**
	 * function lastInsert
	 * Returns the ID of the last inserted row or sequence value 
	 */
	function lastInsert();
	/**
	 * Quotes a string for use in a query. 
	 * @param string $string
	 */
	function escape_string($string);
	/**
	 * Advances to the next rowset in a multi-rowset statement handle 
	 * @return void
	 */
	function nextRow();
	/**
	 * function Optimize single table
	 *
	 * @param void $table
	 */
	function singleOptimize($table);
	/**
	 * function Optimize mulitple table
	 *
	 * @param void $table
	 */
	function multipleOptimize($table);

    /**
     * Create table
     * @param $sql
     * @param bool $debugParams
     * @return
     * @internal param $string
     */
	function createTable($sql,$debugParams=false);
	/**
	 * return SHOW TABLE
	 * @param $table
	 * @param $debugParams
	 *  @return intéger
	 */
	function showTable($table,$debugParams=false);
	/**
	 * return SHOW DATABASE
	 * @param $database
	 * @param $debugParams
	 *  @return intéger
	 */
	function showDatabase($database,$debugParams=false);
	/**
	 * empty table
	 * @param $table
	 * @param $debugParams
	 *  @return intéger
	 */
	function truncateTable($table,$debugParams=false);
	/**
     * @return void
     * Test connexion in the SGBD with PDO
     */
	function PDOConnexion();
}
?>