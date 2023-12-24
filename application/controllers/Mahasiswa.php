<?php 

header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Accept");
header("Access-Control-Allow-Origin: *");
defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH. '/libraries/REST_Controller.php'; 
	use Restserver\Libraries\REST_Controller;

	class Mahasiswa extends REST_Controller {
		function __construct($config = 'rest') {
			parent::__construct($config); 
			$this->load->database(); 
		}
		function index_get() {
			$id = $this->get('nim');
			if ($id == '') { 
				$kontak = $this->db->get('tblmahasiswa')->result(); 
			} else { 
				$this->db->where('nim', $id);
				$kontak = $this->db->get('tblmahasiswa')->result(); 
			} 
			$this->response($kontak, 200);
		} 
	
    function index_post() {
        $data = array(
            'nim' => $this->post('nim'),
            'nama' => $this->post('nama'),
            'jurusan' => $this->post('jurusan'),
            'email' => $this->post('email'));
        $insert = $this->db->insert('tblmahasiswa', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    function index_put() {
        $id = $this->put('nim');
        $data = array(
            'nama' => $this->put('nama'),
            'jurusan' => $this->put('jurusan'),
            'email' => $this->put('email'));
        $this->db->where('nim', $id);
        $update = $this->db->update('tblmahasiswa', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id = $this->delete('nim');
        $this->db->where('nim', $id);
        $delete = $this->db->delete('tblmahasiswa');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>