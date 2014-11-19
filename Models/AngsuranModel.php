<?php 
class AngsuranModel extends BaseModel{
	
	protected $table = 'tbl_angsuran';
	protected $pk	 = 'id_angsuran';
	
	/* function getNama($id){
		$db = new Db();
		$return = $db->query("SELECT nama_anggota  FROM  '{$this-$table}'  WHERE  '{$this->$pk}' = '{$id}'");
			
		if(!count($return)){
			return array();
		} 
		
		return $return['0']['nama_anggota'];	
	} */
	
	function alls(){
		$db = new Db();
		$return = $db->query("SELECT 
			tbl_angsuran.tgl_bayar,
			tbl_angsuran.id_angsuran,
			tbl_angsuran.id_pinjaman,
			tbl_angsuran.bayar,
			tbl_angsuran.sisa,
			tbl_angsuran.denda,
			tbl_angsuran.terlambat,
			tbl_angsuran.`status`,
			tbl_anggota.nama_anggota,
			tbl_anggota.kode_anggota,
			tbl_pinjaman.pokok,
			tbl_pinjaman.bunga,
			tbl_pinjaman.tgl_mulai,
			tbl_pinjaman.lama,
			tbl_pinjaman.total,
			tbl_pinjaman.tanggal,
			tbl_pinjaman.keterangan,
			tbl_resort.kode 
			FROM 
			tbl_angsuran 
			INNER JOIN tbl_pinjaman ON tbl_pinjaman.id_pinjaman = tbl_angsuran.id_pinjaman 
			INNER JOIN tbl_anggota ON tbl_anggota.id_anggota = tbl_pinjaman.id_anggota 
			INNER JOIN tbl_resort ON tbl_resort.id_resort = tbl_anggota.id_resort");

		if(!count($return)){
			return array();
		} 
		
		return $return;
	}
}