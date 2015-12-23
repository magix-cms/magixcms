<?php 
class magixcjquery_magixdb_dbConstruct extends DataObjects{
	const AUTO_INCREMENT = 'AUTO_INCREMENT';
    public function __construct () 
    {
    	parent::__construct();
    }
	/**
	 * ini create table
	 *
	 * @param string $name
	 * @return string
	 */
	public function table($name){
		return 'CREATE TABLE IF NOT EXISTS ‘'.$name.'‘ (';
	}
	public function tinyint($name,$integer,$null='NOT NULL',$options=false){
		return '‘'.$name.'‘ tinyint('.$integer.')'.PHP_EOL.$null.PHP_EOL.$options.',';
	}
	public function mediumint($name,$integer,$null='NOT NULL',$options){
		return '‘'.$name.'‘ mediumint('.$integer.')'.PHP_EOL.$null.PHP_EOL.$options.',';
	}
	public function int($name,$integer,$null='NOT NULL',$options){
		return '‘'.$name.'‘ int('.$integer.')'.PHP_EOL.$null.PHP_EOL.$options.',';
	}
	public function varchar($name,$integer,$null='NOT NULL'){
		return '"'.$name.'" mediumint('.$integer.')'.' '.$null.' ,';
	}
	public function endtable($engine,$charset='latin1',$autoincrement=false){
		switch($autoincrement){
			case true:
				$increment = ' '.AUTO_INCREMENT.'='.$autoincrement;
				break;
			case false:
				$increment = '';
				break;
		}
		return ') ENGINE='.$engine.' DEFAULT CHARSET='.$charset.''.$increment.' ;';
	}
}