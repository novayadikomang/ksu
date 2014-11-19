<?php 
class AnggotaModel extends BaseModel{
	
	protected $table = 'tbl_anggota';
	protected $pk	 = 'id_anggota';
	
	function getNama($id){
		$db = new Db();
		$return = $db->query("SELECT nama_anggota  FROM  tbl_anggota  WHERE  id_anggota  = '$id'");
			
		if(!count($return)){
			return array();
		} 
		
		return $return['0']['nama_anggota'];	
	} 
	
	function getAnggotabyResort($id){
		$db = new Db();
		$return = $db->query("SELECT *  FROM  tbl_anggota  WHERE  id_resort = '$id'");
			
		if(!count($return)){
			return array();
		} 
		
		return $return;	
	} 
}