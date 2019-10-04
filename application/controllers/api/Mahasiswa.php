<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * 
 */
class Mahasiswa extends CI_Controller
{

	use REST_Controller { REST_Controller::__construct as private __resTraitConstruct;}

	public function __construct(){
		parent::__construct();
		$this->__resTraitConstruct();
		$this->load->model('Mahasiswa_model','mahasiswa');

	}
	
	public function index_get()
	{
		$id = $this->get('id');
		
		if ($id === null){
			$mahasiswa = $this->mahasiswa->getMahasiswa();

		}else{
			$mahasiswa = $this->mahasiswa->getMahasiswa($id);
		}
		
		

        if($mahasiswa){
 				 $this->response([
                    'status' => true,
                    'data' => $mahasiswa
                ], 200); 
        } else {
 				 $this->response([
                    'status' => false,
                    'message' => 'id tidak ada'
                ], 404);         	
        }
              
	}

	public function index_delete(){

		$id = $this->delete('id');

		if ($id == null){
			$this->response([
                    'status' => false,
                    'message' => 'beri id'
                ], 400);  
		}else{
			if( $this->mahasiswa->deleteMahasiswa($id) > 0 ){
 				 $this->response([
                    'status' => true,
                    'id' => $id,
                    'message'=> 'Deleted'
                ], 204); 				
			}else{
				
			$this->response([
                    'status' => false,
                    'message' => 'id ga ketemu'
                ], 400);  

			}
		}

	}


	public function index_post(){
		$data = [
			'nrp' => $this->post('nrp'),
			'nama' => $this->post('nama'),
			'email' => $this->post('email'),
			'jurusan' => $this->post('jurusan')
		];

		if($this->mahasiswa->createMahasiswa($data)>0){
 				 $this->response([
                    'status' => true,
                    'message'=> 'Data mahasiswa berhasil disimpan'
                ], 201); 			
		}else{

			$this->response([
                    'status' => false,
                    'message' => 'gagal tambah data'
                ], 400);  

		}

	}

	public function index_put(){
		
		$id = $this->put('id');
		$data = [
			'nrp' => $this->put('nrp'),
			'nama' => $this->put('nama'),
			'email' => $this->put('email'),
			'jurusan' => $this->put('jurusan')
		];		

		if($this->mahasiswa->updateMahasiswa($data,$id)>0){
 				 $this->response([
                    'status' => true,
                    'message'=> 'Data mahasiswa berhasil update'
                ], 204); 			
		}else{

			$this->response([
                    'status' => false,
                    'message' => 'gagal update data'
                ], 400);  

		}

	}


}