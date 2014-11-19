<?php 
class Anggota extends BaseController{

	public $data = array();

	function index($data=array()){
		$AnggotaModel = $this->loadmodel('AnggotaModel');		
		$this->data['title'] =  lang("Management anggota");
		$this->data['header'] =  lang('anggota');
		$this->data['anggota'] = $AnggotaModel->all();
		$this->data['userModel'] = $this->loadmodel('UserModel');	
		$this->view('anggota/index',$this->data);
	}
	
	
	function addnew($data=array()){
		$AnggotaModel = $this->loadmodel('AnggotaModel');			
		$data['title'] = lang('Tambah anggota');	
		$data['header'] = lang('Tambah anggota');
		$data['anggota']=$AnggotaModel->all();
		$this->view('anggota/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		
		if(isset($request['nama_anggota'])){					
				$anggota = $this->loadmodel('AnggotaModel');
				$anggota->tgl_daftar = date('Y-m-d');
				$anggota->nama_anggota = $request['nama_anggota'];
				$anggota->no_tlp = $request['no_tlp'];
				$anggota->alamat = $request['alamat'];
				if($anggota->Create()){
					$this->data['msg'] = addSuccess(lang('Data anggota baru berhasil disimpan.'));
					$this->index();
				}						
		} else {
			redirect(site('anggota/index'));
		}
		
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$AnggotaModel = $this->loadmodel('AnggotaModel');
		$AnggotaModel->id_anggota = $post['params'];
		if($AnggotaModel->Delete()){
			$this->data['msg'] = addSuccess(lang('1 data anggota berhasil dihapus.'));
			$this->index();
		} else {
			$this->data['msg'] = addError(lang('Data yang dimaksud tidak dapat dihapus.'));
			$this->index();
		}
		
		//redirect(site('resort/index'));
			
	}
	
	function edit(){
		$params =  Core::Request();		
		$anggota = $this->loadmodel('AnggotaModel');		
		$anggota->id_anggota = $params['params'];
		$anggota->Find();		
		$data['title'] = lang('Ubah data anggota');	
		$data['header'] = lang('Ubah data anggota');
		$data['request'] = $anggota->variables;
		$this->view('anggota/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		//pre($request);exit;
		if(!empty($request['params'])){
			//$this->__validusername($request['username']);			
			$anggota = $this->loadmodel('AnggotaModel');
			$anggota->tgl_daftar = date('Y-m-d');
			$anggota->nama_anggota = $request['nama_anggota'];
			$anggota->no_tlp = $request['no_tlp'];
			$anggota->alamat = $request['alamat'];
			$anggota->status	= $request['status'];
			$anggota->id_anggota	= $request['params'];

			if($anggota->Save()){
				$this->data['msg'] = addSuccess(lang('Data anggota berhasil diubah.'));
				$this->index();
			} else {
				$this->data['msg'] = addError(lang('Data anggota tidak dapat diubah.'));
				$this->index();
			}

		}
		//pre($request);exit;
	}
	
}