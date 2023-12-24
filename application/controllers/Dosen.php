<?php 

header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Accept");
header("Access-Control-Allow-Origin: *");
defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH. '/libraries/REST_Controller.php'; 
	use Restserver\Libraries\REST_Controller;

	class Dosen extends REST_Controller {
		function __construct($config = 'rest') {
			parent::__construct($config); 
			$this->load->database(); 
		}
		function index_get() {
			$id = $this->get('NIDN');
			if ($id == '') { 
				$kontak = $this->db->get('tbldosen')->result(); 
			} else { 
				$this->db->where('NIDN', $id);
				$kontak = $this->db->get('tbldosen')->result(); 
			} 
			$this->response($kontak, 200);
		} 
	
    function index_post() {
        $data = array(
            'NIDN' => $this->post('NIDN'),
            'Nama' => $this->post('Nama'),
            'Jurusan' => $this->post('Jurusan'),
            'Email' => $this->post('Email'));
        $insert = $this->db->insert('tbldosen', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    function index_put() {
        $id = $this->put('NIDN');
        $data = array(
            'Nama' => $this->put('Nama'),
            'Jurusan' => $this->put('Jurusan'),
            'Email' => $this->put('Email'));
        $this->db->where('NIDN', $id);
        $update = $this->db->update('tbldosen', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id = $this->delete('NIDN');
        $this->db->where('NIDN', $id);
        $delete = $this->db->delete('tbldosen');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>