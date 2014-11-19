<?php 
class GlobalModel extends BaseModel{
	protected $table = 'tbl_globals';
	protected $pk	 = 'id';
	
	function getConfig($key){
		$db = new Db();
		$return = $db->query("SELECT `value` FROM `tbl_globals` WHERE `option` = '$key'");
			
		if(!count($return)){
			return array();
		} 
		
		return $return['0']['value'];	
	}
}