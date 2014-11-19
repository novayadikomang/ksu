<?php 
class SimpananModel extends BaseModel{
	
	protected $table = 'tbl_simpanan';
	protected $pk	 = 'id_simpanan';
	
	/* function getNama($id){
		$db = new Db();
		$return = $db->query("SELECT nama_anggota  FROM  '{$this-$table}'  WHERE  '{$this->$pk}' = '{$id}'");
			
		if(!count($return)){
			return array();
		} 
		
		return $return['0']['nama_anggota'];	
	} */
	
	function getAlls(){
		$db = new Db();
		$return = $db->query("SELECT tbl_resort.kode,
		tbl_anggota.nama_anggota,
		tbl_simpanan.id_simpanan,
		tbl_simpanan.tgl_simpan,
		tbl_simpanan.jenis,
		tbl_simpanan.saldo,
		tbl_anggota.kode_anggota FROM tbl_anggota 
		INNER JOIN tbl_simpanan ON tbl_anggota.id_anggota = tbl_simpanan.id_anggota 
		INNER JOIN tbl_resort ON tbl_resort.id_resort = tbl_anggota.id_resort");
		
		if(!count($return)){
			return array();
		} 
		
		return $return;
	}
}