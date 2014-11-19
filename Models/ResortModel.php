<?php 
class ResortModel extends BaseModel{
	protected $table = 'tbl_resort';
	protected $pk	 = 'id_resort';
	
	function withPegawai($id_resort=null){
		$db = new Db();
		$sql = "SELECT tbl_pegawai.nama, tbl_resort.id_resort,tbl_resort.kode,tbl_resort.id_pegawai,tbl_resort.ketua
			FROM tbl_pegawai INNER JOIN tbl_resort ON tbl_pegawai.id_pegawai = tbl_resort.id_pegawai";
			
		if(!is_null($id_resort)	){
			$sql .= "WHERE tbl_resort.id_resort ='{$id_resort}'";
		}
		
		$return = $db->query($sql);
		
		if(!count($return)){
			return array();
		} 
		return $return;
		
	}
	
	function getKode($id){
		$db = new Db();
		$return = $db->query("SELECT tbl_resort.kode 
			FROM 
			tbl_resort 
			WHERE 
			tbl_resort.id_resort = '{$id}'");
			
		if(!count($return)){
			return array();
		} 
		
		return $return['0']['kode'];	
	}
	
}