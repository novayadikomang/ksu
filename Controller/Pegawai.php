<?php 
class Pegawai extends BaseController{

	public $data = array();

	function index(){
		$pegawai = $this->loadmodel('PegawaiModel');
		$this->data['title'] =  lang("Management Pegawai");
		$this->data['header'] =  lang('Pegawai');
		$this->data['pegawai'] = $pegawai->all();
		$this->view('pegawai/index',$this->data);
	}
	
	
	function addnew($data=array()){
		$data['title'] = lang('Tambah pegawai');	
		$data['header'] = lang('Tambah pegawai');
		$this->view('pegawai/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		
		if(isset($request['nama'])){					
				$user = $this->loadmodel('PegawaiModel');
				$user->nama = $request['nama'];
				$user->posisi = $request['posisi'];
				$user->alamat = $request['alamat'];
				$user->tgl_masuk = $request['tgl_masuk'];
				$user->gaji_pokok = $request['gaji_pokok'];
				if($user->Create()){
					$this->data['msg'] = addSuccess(lang('Data pegawai baru berhasil disimpan.'));
					$this->index();
				}						
		} else {
			redirect(site('pegawai/index'));
		}
		
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$user = $this->loadmodel('PegawaiModel');
		$user->id_pegawai = $post['params'];
		if($user->Delete()){
			$data['msg'] = addSuccess(lang('1 data pergawai berhasil dihapus.'));
		} else {
			$data['msg'] = addError(lang('Data yang dimaksud tidak dapat dihapus.'));
		}
		
		// $data['title'] = lang('Management user');	
		// $data['header'] = lang('Management user');
		// $this->data = $data;
		// $this->index();
		// $user->Find();
		// $data['user'] = $user->variables;
		redirect(site('pegawai/index'));
			
	}
	
	function edit(){
		$params =  Core::Request();
		$user = $this->loadmodel('PegawaiModel');
		$user->id_pegawai = $params['params'];
		$user->Find();
		$data['title'] = lang('Ubah data pegawai');	
		$data['header'] = lang('Ubah data pegawai');
		$data['request'] = $user->variables;
		$this->view('pegawai/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		
		if(!empty($request['params'])){
			//$this->__validusername($request['username']);			
			$user = $this->loadmodel('PegawaiModel');
			$user->id_pegawai = $request['params'];
			$user->posisi = $request['posisi'];
			$user->alamat = $request['alamat'];
			$user->tgl_masuk = $request['tgl_masuk'];
			$user->gaji_pokok = $request['gaji_pokok'];
			$user->nama = $request['nama'];
			if($user->Save()){
				$this->data['msg'] = addSuccess(lang('Data pegawai berhasil diubah.'));
				$this->index();
			} else {
				$this->data['msg'] = addError(lang('Data pegawai tidak dapat diubah.'));
				$this->index();
			}

		}
		//pre($request);exit;
	}
	
	private function __validusername($username){
		$user = $this->loadmodel('UserModel');
		$user->username = $username;
		$user->Find();
		
		if($user->variables){
			return false;
		} 
		
		return true;
	}
}