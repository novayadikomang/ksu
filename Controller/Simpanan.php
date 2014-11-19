<?php 
class Simpanan extends BaseController{

	public $data = array();
	
	public $globals = array();
	

	function index($data=array()){
		$SimpananModel = $this->loadmodel('SimpananModel');		
		$this->data['title'] =  lang("Management Simpanan");
		$this->data['header'] =  lang('Simpanan');
		$this->data['simpanan'] = $SimpananModel->getAlls();
		$this->data['anggotaModel'] = $this->loadmodel('AnggotaModel');
		$this->data['resortModel'] = $this->loadmodel('ResortModel');
		$this->view('simpanan/index',$this->data);
	}
	
	
	function addnew($data=array()){
		$SimpananModel = $this->loadmodel('SimpananModel');	
		$data['resorts'] = $this->loadmodel('ResortModel')->all();			
		$data['title'] = lang('Tambah simpanan');	
		$data['header'] = lang('Tambah simpanan');
		$data['simpanan']=$SimpananModel->all();
		$this->view('simpanan/addnew',$data);
	}
	function loadanggota(){
		$request = Core::Request();
		$data['layout'] = 'ajax';	
		$data['html'] =  json_encode(array('html'=>'testing bro'));
		$data['template'] =  'simpanan/anggota';
		$data['anggota'] = $this->loadmodel('AnggotaModel')->getAnggotabyResort($request['resort']);
		$this->view('simpanan/anggota',$data);
	}
	
	function save(){
		$request = Core::Request();
		if(isset($request['id_resort'])){					
				$simpanan = $this->loadmodel('SimpananModel');
				$simpanan->id_anggota = $request['id_anggota'];
				$simpanan->tgl_simpan = date('Y-m-d');
				$simpanan->saldo = $request['saldo'];	
				$simpanan->jenis = $request['jenis'];	
				if($simpanan->Create()){				
					$transaksi = $this->loadmodel('TransaksiModel');
					if($request['jenis']=='DEBET'){
						$transaksi->debet = 1;
					} else {
						$transaksi->kredit = 1;
					}
					
					$transaksi->total = $request['saldo'];
					//$transaksi->user_id = $_SESSION['loggedIn']['id'];
					$transaksi->tanggal = date('Y-m-d');
					$transaksi->user_id =1;
					$transaksi->ket = 'Drop keluar ke anggota dengan ID simpanan '. $simpanan->lastInsertId();
					if($transaksi->Create()){						
						$this->data['msg'] = addSuccess(lang('Data simpanan baru berhasil disimpan.'));
						$this->index();
					}
				}						
		} else {
			redirect(site('simpanan/index'));
		}
		
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$SimpananModel = $this->loadmodel('SimpananModel');
		$SimpananModel->id_simpanan = $post['params'];
		if($SimpananModel->Delete()){
			$this->data['msg'] = addSuccess(lang('1 data simpanan berhasil dihapus.'));
			$this->index();
		} else {
			$this->data['msg'] = addError(lang('Data yang dimaksud tidak dapat dihapus.'));
			$this->index();
		}
		
		//redirect(site('resort/index'));
			
	}
	
	function edit(){
		$params =  Core::Request();		
		$simpanan = $this->loadmodel('SimpananModel');		
		$simpanan->id_simpanan = $params['params'];		
		$simpanan->Find();		
		$data['resorts'] = $this->loadmodel('ResortModel')->all();	
		$data['title'] = lang('Ubah data simpanan');	
		$data['header'] = lang('Ubah data simpanan');
		$data['anggota'] = $this->loadmodel('AnggotaModel')->getAnggotabyResort($simpanan->variables['id_resort']);
		$data['request'] = $simpanan->variables;
		$this->view('simpanan/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		//pre($request);exit;
		if(!empty($request['params'])){
			//$this->__validusername($request['username']);			
			$simpanan = $this->loadmodel('SimpananModel');
			$simpanan->id_resort = $request['id_resort'];
			$simpanan->id_anggota = $request['id_anggota'];
			$simpanan->tgl_mulai = $request['tgl_mulai'];
			$simpanan->lama = $request['lama'];
			$simpanan->pokok = $request['pokok'];
			$simpanan->bunga = 20;
			$simpanan->total = $request['pokok'] + ($request['pokok'] * 0.2);
			$simpanan->keterangan = $request['keterangan'];
			$simpanan->tanggal = date('Y-m-d');
			$simpanan->id_simpanan	= $request['params'];
			if($simpanan->Save()){
				$this->data['msg'] = addSuccess(lang('Data simpanan berhasil diubah.'));
				$this->index();
			} else {
				$this->data['msg'] = addError(lang('Data simpanan tidak dapat diubah.'));
				$this->index();
			}

		}
	}
	
}