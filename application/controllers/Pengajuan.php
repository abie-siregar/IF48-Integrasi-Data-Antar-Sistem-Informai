<?php 

header("Access-Control-Allow-Headers: Access-Control-Allow-Origin, Accept");
header("Access-Control-Allow-Origin: *");
defined('BASEPATH') OR exit('No direct script access allowed');

	require APPPATH. '/libraries/REST_Controller.php'; 
	use Restserver\Libraries\REST_Controller;

	class Pengajuan extends REST_Controller {
		function __construct($config = 'rest') {
			parent::__construct($config); 
			$this->load->database(); 
		}
		function index_get() {
			// $id = $this->get('ID');
            $type = $this->get('Type');
			if ($type == '') { 
                $sql = 'SELECT * FROM tblpengajuan';
                $query = $this->db->query($sql);
                $data = $query->result_array();
				//$kontak = $this->db->get('tblpengajuan')->result(); 
			} else {
                $sql = 'SELECT * FROM tblpengajuan WHERE TipePengajuan = ?';
                $query = $this->db->query($sql, array($type));
                $data = $query->result_array();
			} 
			$this->response($data, 200);
		}

        // function approvepengajuan_get(){
        //     $id = $this->put('ID');
        //     $sqlUpd = `UPDATE tblpengajuan SET Status = 'Approve' WHERE ID = ?`;
        //     $this->db->query($sqlUpd, array($id));
        // }
	
    function index_post() {
        $data = array(
            'tipePengajuan' => $this->post('tipePengajuan'),
            'deskripsi' => $this->post('deskripsi'),
            'tglPengajuan' => $this->post('tglPengajuan'),
            'Status' => 'Uploaded');
        $insert = $this->db->insert('tblpengajuan', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    function index_put() {
        $id = $this->put('id');
        $data = array(
            'deskripsi' => $this->put('deskripsi'),
            'tglPengajuan' => $this->put('tglPengajuan'));
        $this->db->where('id', $id);
        $update = $this->db->update('tblpengajuan', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    function index_delete() {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('tblpengajuan');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>