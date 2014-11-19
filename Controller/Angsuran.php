<?php

class Angsuran extends BaseController {

    public $data = array();
    public $globals = array();

    function index($data = array()) {
        $AngsuranModel = $this->loadmodel('AngsuranModel');
        $this->data['title'] = lang("Management angsuran");
        $this->data['header'] = lang('angsuran');
        $this->data['angsuran'] = $AngsuranModel->alls();
        $this->data['anggotaModel'] = $this->loadmodel('AnggotaModel');
        $this->data['resortModel'] = $this->loadmodel('ResortModel');
        $this->view('angsuran/index', $this->data);
    }

    function addnew($data = array()) {
        $AngsuranModel = $this->loadmodel('AngsuranModel');
        $data['resorts'] = $this->loadmodel('ResortModel')->all();
        $data['pinjaman'] = $this->loadmodel('PinjamanModel')->getPinjamanbyResort();
        $data['title'] = lang('Tambah angsuran');
        $data['header'] = lang('Tambah angsuran');
        $data['angsuran'] = $AngsuranModel->all();
        $this->view('angsuran/addnew', $data);
    }

    function loadanggota() {
        $request = Core::Request();
        $data['layout'] = 'ajax';
        $data['html'] = json_encode(array('html' => 'testing bro'));
        $data['template'] = 'angsuran/anggota';
        $data['anggota'] = $this->loadmodel('AnggotaModel')->getAnggotabyResort($request['resort']);
        $this->view('angsuran/anggota', $data);
    }

    function loadpinjaman() {
        $request = Core::Request();
        $data['layout'] = 'ajax';
        $data['html'] = json_encode(array('html' => 'testing bro'));
        $data['template'] = 'angsuran/anggota';
        $data['dataPeminjam'] = $this->loadmodel('PinjamanModel')->getPinjamanbyId($request['postId']);
        $this->view('angsuran/add', $data);
    }

    function save() {
        $request = Core::Request();
		pre($request);
		exit;
        // if (isset($request['id_resort'])) {
            // $angsuran = $this->loadmodel('AngsuranModel');
            // $angsuran->id_anggota = $request['id_anggota'];
            // $angsuran->tgl_simpan = date('Y-m-d');
            // $angsuran->saldo = $request['saldo'];
            // $angsuran->jenis = $request['jenis'];
            // if ($angsuran->Create()) {
                // $transaksi = $this->loadmodel('TransaksiModel');
                // if ($request['jenis'] == 'DEBET') {
                    // $transaksi->debet = 1;
                // } else {
                    // $transaksi->kredit = 1;
                // }

                // $transaksi->total = $request['saldo'];

                // $transaksi->tanggal = date('Y-m-d');
                // $transaksi->user_id = 1;
                // $transaksi->ket = 'Drop keluar ke anggota dengan ID angsuran ' . $angsuran->lastInsertId();
                // if ($transaksi->Create()) {
                    // $this->data['msg'] = addSuccess(lang('Data angsuran baru berhasil disimpan.'));
                    // $this->index();
                // }
            // }
        // } else {
            // redirect(site('angsuran/index'));
        // }

        //pre($request);exit;
    }

    function delete($post) {
        //pre($post);exit;
        $AngsuranModel = $this->loadmodel('AngsuranModel');
        $AngsuranModel->id_angsuran = $post['params'];
        if ($AngsuranModel->Delete()) {
            $this->data['msg'] = addSuccess(lang('1 data angsuran berhasil dihapus.'));
            $this->index();
        } else {
            $this->data['msg'] = addError(lang('Data yang dimaksud tidak dapat dihapus.'));
            $this->index();
        }

        //redirect(site('resort/index'));
    }

    function edit() {
        $params = Core::Request();
        $angsuran = $this->loadmodel('AngsuranModel');
        $angsuran->id_angsuran = $params['params'];
        $angsuran->Find();
        $data['resorts'] = $this->loadmodel('ResortModel')->all();
        $data['title'] = lang('Ubah data angsuran');
        $data['header'] = lang('Ubah data angsuran');
        $data['anggota'] = $this->loadmodel('AnggotaModel')->getAnggotabyResort($angsuran->variables['id_resort']);
        $data['request'] = $angsuran->variables;
        $this->view('angsuran/edit', $data);
    }

    function update() {
        $request = Core::Request();
        //pre($request);exit;
        if (!empty($request['params'])) {
            //$this->__validusername($request['username']);			
            $angsuran = $this->loadmodel('AngsuranModel');
            $angsuran->id_resort = $request['id_resort'];
            $angsuran->id_anggota = $request['id_anggota'];
            $angsuran->tgl_mulai = $request['tgl_mulai'];
            $angsuran->lama = $request['lama'];
            $angsuran->pokok = $request['pokok'];
            $angsuran->bunga = 20;
            $angsuran->total = $request['pokok'] + ($request['pokok'] * 0.2);
            $angsuran->keterangan = $request['keterangan'];
            $angsuran->tanggal = date('Y-m-d');
            $angsuran->id_angsuran = $request['params'];
            if ($angsuran->Save()) {
                $this->data['msg'] = addSuccess(lang('Data angsuran berhasil diubah.'));
                $this->index();
            } else {
                $this->data['msg'] = addError(lang('Data angsuran tidak dapat diubah.'));
                $this->index();
            }
        }
    }

}
