<?php 
class Resort extends BaseController{

	public $data = array();

	function index($data=array()){
		$resorts = $this->loadmodel('ResortModel');
		$pegawaiModel = $this->loadmodel('PegawaiModel');
		$this->data['title'] =  lang("Management Resort");
		$this->data['header'] =  lang('Pegawai');
		$this->data['resorts'] = $resorts->withPegawai();
		//echo '<pre>';print_r($this->data['resorts']);exit;
		$this->data['resortModel'] =  $pegawaiModel;
		$this->view('resort/index',$this->data);
	}
	
	
	function addnew($data=array()){
		$pegawaiModel = $this->loadmodel('PegawaiModel');
		$data['kpl'] =   $pegawaiModel->getPegawaibyPosisi('kpl');
		$data['pegawai'] =   $pegawaiModel->all();
			
		
		$data['title'] = lang('Tambah Resort');	
		$data['header'] = lang('Tambah Resort');
		//echo '<pre>';print_r($data);exit;
		$this->view('resort/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		
		if(isset($request['kode'])){					
				$resort = $this->loadmodel('ResortModel');
				$resort->kode = $request['kode'];
				$resort->ketua = $request['ketua'];
				$resort->id_pegawai = $request['id_pegawai'];
				if($resort->Create()){
					$this->data['msg'] = addSuccess(lang('Data Resort baru berhasil disimpan.'));
					$this->index();
				}						
		} else {
			redirect(site('resort/index'));
		}
		
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$user = $this->loadmodel('ResortModel');
		$user->id_resort = $post['params'];
		if($user->Delete()){
			$this->data['msg'] = addSuccess(lang('1 data Resort berhasil dihapus.'));
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
		$ResortModel = $this->loadmodel('ResortModel');
		$ResortModel->id_resort = $params['params'];
		$ResortModel->Find();
		$data['title'] = lang('Ubah data Resort');	
		$data['header'] = lang('Ubah data Resort');
		$data['request'] = $ResortModel->variables;
		$this->view('resort/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		//pre($request);exit;
		if(!empty($request['params'])){
			//$this->__validusername($request['username']);			
			$resort = $this->loadmodel('ResortModel');
			$resort->kode = $request['kode'];
			$resort->ketua = $request['ketua'];
			$resort->id_pegawai = $request['id_pegawai'];
			$resort->id_resort	= $request['params'];

			if($resort->Save()){
				$this->data['msg'] = addSuccess(lang('Data Resort berhasil diubah.'));
				$this->index();
			} else {
				$this->data['msg'] = addError(lang('Data Resort tidak dapat diubah.'));
				$this->index();
			}

		}
		//pre($request);exit;
	}
	
}