<?php 
class Target extends BaseController{

	public $data = array();

	function index($data=array()){
		$resorts = $this->loadmodel('TargetModel');
		$resortModel = $this->loadmodel('ResortModel');
		$pegawaiModel = $this->loadmodel('PegawaiModel');
		$this->data['title'] =  lang("Management Target");
		$this->data['header'] =  lang('Pegawai');
		$this->data['resorts'] = $resorts->all();
		$this->data['TargetModel'] =  $pegawaiModel;
		$this->data['resortModel'] =  $resortModel;
		$this->view('target/index',$this->data);
	}
	
	
	function addnew($data=array()){
		$pegawaiModel = $this->loadmodel('PegawaiModel');
		$resortModel = $this->loadmodel('ResortModel');
		$data['kpl'] =   $pegawaiModel->getPegawaibyPosisi('kpl');
		$data['pegawai'] =   $pegawaiModel->all();		
		$data['title'] = lang('Tambah target');	
		$data['header'] = lang('Tambah target');
		$data['resorts']=$resortModel->all();
		//echo '<pre>';print_r($data);exit;
		$this->view('target/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		
		if(isset($request['id_resort'])){					
				$target = $this->loadmodel('TargetModel');
				$target->id_resort = $request['id_resort'];
				$target->bulan = $request['bulan'];
				$target->tahun = $request['tahun'];
				$target->target = $request['target'];
				if($target->Create()){
					$this->data['msg'] = addSuccess(lang('Data target baru berhasil disimpan.'));
					$this->index();
				}						
		} else {
			redirect(site('target/index'));
		}
		
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$target = $this->loadmodel('TargetModel');
		$target->id_target = $post['params'];
		if($target->Delete()){
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
		$resortModel = $this->loadmodel('ResortModel');
		$TargetModel = $this->loadmodel('TargetModel');
		$data['resorts']=$resortModel->all();
		$TargetModel->id_target = $params['params'];
		$TargetModel->Find();
		$data['resorts']=$resortModel->all();
		$data['title'] = lang('Ubah data Resort');	
		$data['header'] = lang('Ubah data Resort');
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
				$this->data['msg'] = addSuccess(lang('Data target berhasil diubah.'));
				$this->index();
			} else {
				$this->data['msg'] = addError(lang('Data target tidak dapat diubah.'));
				$this->index();
			}

		}
		//pre($request);exit;
	}
	
}