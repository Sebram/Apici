<?php
namespace Api;

use Api\Config;
use Api\Model;

class Validator {

	public static function setConfig() {
		$C = new Config();
		$cnx = new Model( $C );
		$cnx->set();
		return $cnx;
	}

	public static function BddFieldsInformations ($table, $columname) {	
		$query = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
		WHERE TABLE_NAME = '".$table."' AND COLUMN_NAME ='".$columname."'";
		$cnx = SELF::setConfig();
		$fields = $cnx->doQuery($query);
		return $fields;
	} 

	

	public static function validate($table, $columname) {

		$fields = Validator::BddFieldsInformations("habitation", $columname);
		
		foreach( $fields as $infocol ) {
			
				$columntype = $infocol['DATA_TYPE'];
				
				if ($columntype == 'int') {
					return true;
				}
				elseif ($columntype == 'varchar') {
					return true;
				}
				else return $infocol;
			
		}
	}
}