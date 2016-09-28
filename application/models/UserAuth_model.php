<?php
class UserAuth_model extends CI_Model {

        public function __construct(){
        }	
	
		public function verifyLogin(){	
			$data = array(
				'email' => $this->input->post('email'),
				'pass' => md5($this->input->post('password')),
				'status' => 1
			);
			$query = $this->db->get_where('user', $data);
			return $query->row_array();
		}	
		
		public function load_user(){
			$data = array(
				'email' => $this->input->post('email'),
				'pass' => md5($this->input->post('password')),
				'status' => 1
			);
			
			$this->db->select('u.id, email, created, firstname, lastname, role, company, date_format, pending_requests, last_activity');
			$this->db->from('user u');
			$this->db->join('user_profile up','u.id = up.uid');
			$this->db->where($data);
			$query = $this->db->get();
			return $query->result();			
		}
}