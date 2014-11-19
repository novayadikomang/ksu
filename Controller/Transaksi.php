<?php 
class Transaksi extends BaseController{

	public $data = array();

	function index($data=array()){
		$transaksiModel = $this->loadmodel('TransaksiModel');		
		$this->data['title'] =  lang("Management transaksi");
		$this->data['header'] =  lang('Transaksi');
		$this->data['trans'] = $transaksiModel->all();
		$this->data['userModel'] = $this->loadmodel('UserModel');	
		$this->view('transaksi/index',$this->data);
	}
	
	
	function addnew($data=array()){
		$transaksiModel = $this->loadmodel('TransaksiModel');			
		$data['title'] = lang('Tambah transaksi');	
		$data['header'] = lang('Tambah transaksi');
		$data['transaksi']=$transaksiModel->all();
		$this->view('transaksi/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		
		if(isset($request['total'])){					
				$target = $this->loadmodel('TransaksiModel');
				$target->tanggal = date('Y-m-d');
				if($request['jenis']=='debet'){
					$target->debet = 1;
					$target->kredit = 0;
				} else{
					$target->debet = 0;
					$target->kredit = 1;
				}
				$target->total = $request['total'];
				$target->user_id = $_SESSION['loggedIn']['id'];
				$target->ket = $request['ket'];
				if($target->Create()){
					$this->data['msg'] = addSuccess(lang('Data transaksi baru berhasil disimpan.'));
					$this->index();
				}						
		} else {
			redirect(site('transaksi/index'));
		}
		
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$target = $this->loadmodel('TargetModel');
		$target->id_target = $post['params'];
		if($target->Delete()){
			$this->data['msg'] = addSuccess(lang('1 data transaksi berhasil dihapus.'));
			$this->index();
		} else {
			$this->data['msg'] = addError(lang('Data yang dimaksud tidak dapat dihapus.'));
			$this->index();
		}
		
		//redirect(site('resort/index'));
			
	}
	
	function edit(){
		$params =  Core::Request();
		$pegawaiModel = $this->loadmodel('PegawaiModel');
		$data['kpl'] =   $pegawaiModel->getPegawaibyPosisi('kpl');
		$data['pegawai'] =   $pegawaiModel->all();
		$resortModel = $this->loadmodel('ResortModel');
		$TargetModel = $this->loadmodel('TargetModel');
		$data['resorts']=$resortModel->all();
		$TargetModel->id_target = $params['params'];
		$TargetModel->Find();
		$data['resorts']=$resortModel->all();
		$data['title'] = lang('Ubah data transaksi');	
		$data['header'] = lang('Ubah data transaksi');
		$data['request'] = $TargetModel->variables;
		$this->view('target/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		//pre($request);exit;
		if(!empty($request['params'])){
			//$this->__validusername($request['username']);			
			$target = $this->loadmodel('TargetModel');
			$target = $this->loadmodel('TargetModel');
			$target->id_resort = $request['id_resort'];
			$target->bulan = $request['bulan'];
			$target->tahun = $request['tahun'];
			$target->target = $request['target'];
			$target->id_target	= $request['params'];

			if($target->Save()){
				$this->data['msg'] = addSuccess(lang('Data transaksi berhasil diubah.'));
				$this->index();
			} else {
				$this->data['msg'] = addError(lang('Data transaksi tidak dapat diubah.'));
				$this->index();
			}

		}
		//pre($request);exit;
	}
	
}