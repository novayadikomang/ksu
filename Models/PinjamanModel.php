<?php

class PinjamanModel extends BaseModel {

    protected $table = 'tbl_pinjaman';
    protected $pk = 'id_pinjaman';

    /* function getNama($id){
      $db = new Db();
      $return = $db->query("SELECT nama_anggota  FROM  '{$this-$table}'  WHERE  '{$this->$pk}' = '{$id}'");

      if(!count($return)){
      return array();
      }

      return $return['0']['nama_anggota'];
      } */
    function getPinjamanbyId($id) {
        $db = new Db();
        $return = $db->query("SELECT 
			tbl_pinjaman.id_anggota,
			tbl_pinjaman.id_resort,
			tbl_pinjaman.pokok,
			tbl_pinjaman.bunga,
			tbl_pinjaman.tgl_mulai,
			tbl_pinjaman.tgl_lunas,
			tbl_pinjaman.keterangan,
			tbl_pinjaman.lama,
			tbl_pinjaman.total,
			tbl_pinjaman.tanggal,
			tbl_anggota.kode_anggota,
			tbl_anggota.nama_anggota,
			tbl_anggota.alamat,
			tbl_anggota.no_tlp,
			tbl_anggota.tgl_daftar,
			tbl_anggota.status,
			tbl_resort.kode,
			tbl_resort.ketua,
			tbl_resort.id_pegawai,
			tbl_pegawai.nama,
			tbl_pinjaman.id_pinjaman
			FROM 
			tbl_resort 
			INNER JOIN tbl_pinjaman ON tbl_resort.id_resort = tbl_pinjaman.id_resort 
			INNER JOIN tbl_anggota ON tbl_anggota.id_anggota = tbl_pinjaman.id_anggota 
			INNER JOIN tbl_pegawai ON tbl_pegawai.id_pegawai = tbl_resort.id_pegawai 
			WHERE 
			tbl_pinjaman.status = 0  AND tbl_pinjaman.id_pinjaman = '$id' 
			GROUP BY 
			tbl_pinjaman.id_pinjaman ");

        if (!count($return)) {
            return array();
        }

        return $return;
    }
    
    function getPinjamanbyResort() {
        $db = new Db();
        $return = $db->query("SELECT 
			tbl_pinjaman.id_anggota,
			tbl_pinjaman.id_resort,
			tbl_pinjaman.pokok,
			tbl_pinjaman.bunga,
			tbl_pinjaman.tgl_mulai,
			tbl_pinjaman.tgl_lunas,
			tbl_pinjaman.keterangan,
			tbl_pinjaman.lama,
			tbl_pinjaman.total,
			tbl_pinjaman.tanggal,
			tbl_anggota.kode_anggota,
			tbl_anggota.nama_anggota,
			tbl_resort.kode,
			tbl_resort.ketua,
			tbl_resort.id_pegawai,
			tbl_pegawai.nama,
			tbl_pinjaman.id_pinjaman
			FROM 
			tbl_resort 
			INNER JOIN tbl_pinjaman ON tbl_resort.id_resort = tbl_pinjaman.id_resort 
			INNER JOIN tbl_anggota ON tbl_anggota.id_anggota = tbl_pinjaman.id_anggota 
			INNER JOIN tbl_pegawai ON tbl_pegawai.id_pegawai = tbl_resort.id_pegawai 
			WHERE 
			tbl_pinjaman.status = 0 
			GROUP BY 
			tbl_pinjaman.id_pinjaman ");

        if (!count($return)) {
            return array();
        }

        return $return;
    }

    function getPinjamanbyAnggota($id) {
        $db = new Db();
        $return = $db->query("SELECT 
			tbl_pinjaman.id_anggota,
			tbl_pinjaman.id_resort,
			tbl_pinjaman.pokok,
			tbl_pinjaman.bunga,
			tbl_pinjaman.tgl_mulai,
			tbl_pinjaman.tgl_lunas,
			tbl_pinjaman.keterangan,
			tbl_pinjaman.lama,
			tbl_pinjaman.total,
			tbl_pinjaman.tanggal,
			tbl_anggota.kode_anggota,
			tbl_anggota.nama_anggota,
			tbl_resort.kode,
			tbl_resort.ketua,
			tbl_resort.id_pegawai,
			tbl_pegawai.nama,
			tbl_pinjaman.id_pinjaman,
			tbl_anggota.alamat,
			tbl_anggota.no_tlp,
			tbl_anggota.`status`,
			tbl_anggota.tgl_daftar
			FROM 
			tbl_resort 
			INNER JOIN tbl_pinjaman ON tbl_resort.id_resort = tbl_pinjaman.id_resort 
			INNER JOIN tbl_anggota ON tbl_anggota.id_anggota = tbl_pinjaman.id_anggota AND tbl_resort.id_resort = tbl_anggota.id_resort 
			INNER JOIN tbl_pegawai ON tbl_pegawai.id_pegawai = tbl_resort.id_pegawai 
			WHERE 
			tbl_pinjaman.status = 0 AND tbl_anggota.id_anggota = '$id' 
			GROUP BY 
			tbl_pinjaman.id_pinjaman");
        if (!count($return)) {
            return array();
        }

        return $return;
    }

}
