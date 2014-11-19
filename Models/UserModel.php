<?php 
class UserModel extends BaseModel{
	
	protected $table = 'tbl_user';
	protected $pk	 = 'id_user';
	
	function getNama($id){
		$db = new Db();
		$return = $db->query("SELECT tbl_user.username 
			FROM 
			tbl_user 
			WHERE 
			tbl_user.id_user = '{$id}'");
			
		if(!count($return)){
			return array();
		} 
		
		return $return['0']['username'];	
	}
}