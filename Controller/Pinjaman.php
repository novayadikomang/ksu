<?php 
class Pinjaman extends BaseController{

	public $data = array();
	
	public $globals = array();
	

	function index($data=array()){
		$PinjamanModel = $this->loadmodel('PinjamanModel');		
		$this->data['title'] =  lang("Management pinjaman");
		$this->data['header'] =  lang('pinjaman');
		$this->data['pinjaman'] = $PinjamanModel->all();
		$this->data['anggotaModel'] = $this->loadmodel('AnggotaModel');
		$this->data['resortModel'] = $this->loadmodel('ResortModel');
		$this->view('pinjaman/index',$this->data);
	}
	
	
	function addnew($data=array()){
		$PinjamanModel = $this->loadmodel('PinjamanModel');	
		$data['resorts'] = $this->loadmodel('ResortModel')->all();			
		$data['title'] = lang('Tambah pinjaman');	
		$data['header'] = lang('Tambah pinjaman');
		$data['pinjaman']=$PinjamanModel->all();
		$this->view('pinjaman/addnew',$data);
	}
	function loadanggota(){
		$request = Core::Request();
		$data['layout'] = 'ajax';	
		$data['html'] =  json_encode(array('html'=>'testing bro'));
		$data['template'] =  'pinjaman/anggota';
		$data['anggota'] = $this->loadmodel('AnggotaModel')->getAnggotabyResort($request['resort']);
		$this->view('pinjaman/anggota',$data);
	}
	
	function save(){
		$request = Core::Request();
		$GlobalModel = $this->loadmodel('GlobalModel');	
		// $t = ($request['pokok'] - ($GlobalModel->getConfig('potongan') * ($request['pokok'])/100)) + ($GlobalModel->getConfig('tabungan') * ($request['pokok']/100));
		// echo ($GlobalModel->getConfig('tabungan') * ($request['pokok']/100));
		//echo $t; exit;
		if(isset($request['pokok'])){					
				$pinjaman = $this->loadmodel('PinjamanModel');
				$pinjaman->id_resort = $request['id_resort'];
				$pinjaman->id_anggota = $request['id_anggota'];
				$pinjaman->tgl_mulai = $request['tgl_mulai'];
				$pinjaman->lama = $request['lama'];
				$pinjaman->pokok = $request['pokok'];
				$pinjaman->bunga = 20;
				$pinjaman->total = $request['pokok'] + ($request['pokok'] * 0.2);
				$pinjaman->keterangan = $request['keterangan'];
				$pinjaman->tanggal = date('Y-m-d');
	
				if($pinjaman->Create()){				
					$transaksi = $this->loadmodel('TransaksiModel');
					$transaksi->kredit = 1;
					$transaksi->total = ($request['pokok'] - (($GlobalModel->getConfig('potongan') /100) * ($request['pokok']))) - (($GlobalModel->getConfig('tabungan')/100) * ($request['pokok']));
					//$transaksi->user_id = $_SESSION['loggedIn']['id'];
					$transaksi->tanggal = date('Y-m-d');
					$transaksi->user_id =1;
					$transaksi->ket = 'Drop keluar ke anggota dengan ID Pinjaman '. $pinjaman->lastInsertId();
					if($transaksi->Create()){						
						$this->data['msg'] = addSuccess(lang('Data pinjaman baru berhasil disimpan.'));
						$this->index();
					}
				}						
		} else {
			redirect(site('pinjaman/index'));
		}
		
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$PinjamanModel = $this->loadmodel('PinjamanModel');
		$PinjamanModel->id_pinjaman = $post['params'];
		if($PinjamanModel->Delete()){
			$this->data['msg'] = addSuccess(lang('1 data pinjaman berhasil dihapus.'));
			$this->index();
		} else {
			$this->data['msg'] = addError(lang('Data yang dimaksud tidak dapat dihapus.'));
			$this->index();
		}
		
		//redirect(site('resort/index'));
			
	}
	
	function edit(){
		$params =  Core::Request();		
		$pinjaman = $this->loadmodel('PinjamanModel');		
		$pinjaman->id_pinjaman = $params['params'];		
		$pinjaman->Find();		
		$data['resorts'] = $this->loadmodel('ResortModel')->all();	
		$data['title'] = lang('Ubah data pinjaman');	
		$data['header'] = lang('Ubah data pinjaman');
		$data['anggota'] = $this->loadmodel('AnggotaModel')->getAnggotabyResort($pinjaman->variables['id_resort']);
		$data['request'] = $pinjaman->variables;
		$this->view('pinjaman/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		//pre($request);exit;
		if(!empty($request['params'])){
			//$this->__validusername($request['username']);			
			$pinjaman = $this->loadmodel('PinjamanModel');
			$pinjaman->id_resort = $request['id_resort'];
			$pinjaman->id_anggota = $request['id_anggota'];
			$pinjaman->tgl_mulai = $request['tgl_mulai'];
			$pinjaman->lama = $request['lama'];
			$pinjaman->pokok = $request['pokok'];
			$pinjaman->bunga = 20;
			$pinjaman->total = $request['pokok'] + ($request['pokok'] * 0.2);
			$pinjaman->keterangan = $request['keterangan'];
			$pinjaman->tanggal = date('Y-m-d');
			$pinjaman->id_pinjaman	= $request['params'];

			if($pinjaman->Save()){
				$this->data['msg'] = addSuccess(lang('Data pinjaman berhasil diubah.'));
				$this->index();
			} else {
				$this->data['msg'] = addError(lang('Data pinjaman tidak dapat diubah.'));
				$this->index();
			}

		}
		//pre($request);exit;
	}
	
}