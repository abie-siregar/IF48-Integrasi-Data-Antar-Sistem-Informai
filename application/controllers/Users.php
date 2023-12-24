<?php 

header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Accept");
header("Access-Control-Allow-Origin: *");
defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH. '/libraries/REST_Controller.php'; 
	use Restserver\Libraries\REST_Controller;

	class Users extends REST_Controller {
		function __construct($config = 'rest') {
			parent::__construct($config); 
			$this->load->database(); 
		}
		function index_get() {
			$id = $this->get('nim');
			if ($id == '') { 
				$kontak = $this->db->get('tbluser')->result(); 
			} else { 
				$this->db->where('nim', $id);
				$kontak = $this->db->get('tbluser')->result(); 
			} 
			$this->response($kontak, 200);
		} 
		
		function login_post() {
			// $id = $this->get('ID');
            $username = $this->post('username');
            $password = $this->post('Password');
			$sql = 'SELECT * FROM tbluser WHERE username = ? AND password = ?';
            $query = $this->db->query($sql, array($username, $password));
            $data = $query->result_array();
			$this->response($data, 200);
		}
	
    function index_post() {
        $data = array(
            'username' => $this->post('username'),
            'password' => $this->post('password'));
        $insert = $this->db->insert('tbluser', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>