<?php 
class PegawaiModel extends BaseModel{
	protected $table = 'tbl_pegawai';
	protected $pk	 = 'id_pegawai';
	
	function getPegawaibyPosisi($pos='res'){
		$db = new Db();
		$return = $db->query("SELECT id_pegawai,nama FROM tbl_pegawai WHERE posisi = '{$pos}'");
		if(!count($return)){
			return array();
		} 
		return $return;
	}
	
	function getNama($id){
		$db = new Db();
		$return = $db->query("SELECT tbl_pegawai.nama 
			FROM 
			tbl_pegawai 
			WHERE 
			tbl_pegawai.id_pegawai = '{$id}'");
			
		if(!count($return)){
			return array();
		} 
		
		return $return['0']['nama'];	
	}
}