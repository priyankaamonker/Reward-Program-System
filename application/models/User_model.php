<?php
class User_model extends CI_Model {

        public function __construct(){
        }
			
		public function get_users($id = FALSE){
			if ($id === FALSE){				
				$this->db->select('u.id, email, status, firstname, lastname, company');
				$this->db->from('user u');
				$this->db->join('user_profile up','u.id = up.uid');
				$query = $this->db->get();
				return $query->result();
			}

			$this->db->select('u.id, email, status, created, firstname, lastname, role, company, date_format, pending_requests, last_activity');
			$this->db->from('user u');
			$this->db->join('user_profile up','u.id = up.uid');
			$this->db->where('u.id',$id);
			$query = $this->db->get();
			return $query->result();
		}		
		
		public function set_user($id = FALSE){
			$this->load->helper('url');
			
			$data = array(
				'email' => $this->input->post('email'),
				'status' => $this->input->post('status')
			);
			$_data = array(
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'role' => $this->input->post('role'),
				'company'=> $this->input->post('company'),
				'date_format'=> $this->input->post('date_format'),
				'last_activity'=> date('Y-m-d H:i:s'),
			);			
			
			if ($id === FALSE){
				$data['pass'] = md5($this->input->post('password'));
				$data['created'] = date('Y-m-d H:i:s');
			    $this->db->insert('user', $data);
				$_data['uid'] = $this->db->insert_id();
				return $this->db->insert('user_profile', $_data);
			}
			else {
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('user', $data);
				
				$_data['uid'] = $this->input->post('id');
				$this->db->where('uid', $id);
				$this->db->update('user_profile', $_data);		

				if($this->input->post('id')==$this->session->userdata('id')) {
					$this->session->unset_userdata('firstname');
					$this->session->set_userdata('firstname',$this->input->post('firstname'));
					$this->session->unset_userdata('lastname');
					$this->session->set_userdata('lastname',$this->input->post('lastname'));
					$this->session->unset_userdata('company');
					$this->session->set_userdata('company',$this->input->post('company'));
					$this->session->unset_userdata('date_format');
					$this->session->set_userdata('date_format',$this->input->post('date_format'));					
				}
			}	
		}	

		public function delete_user($id){      
			$this->db->where('id', $id);
			$this->db->delete('user');
			$this->db->where('uid', $id);
			$this->db->delete('user_profile');			
		}	

		public function uniqueEmail($id, $email){
			$query = $this->db->get_where('user', array('id !=' => $id, 'email' => $email));
			return $query->row_array();		
		}
		
		public function get_active_users(){
			$query = $this->db->get_where('user', array('status' => "1"));
			return $query->result_array();
		}		

		public function set_pending_requests($uid, $op="add"){
			$this->db->select('pending_requests');
			$this->db->from('user_profile');
			$this->db->where('uid', $uid);
			$query = $this->db->get();
		    $pending_requests = $query->result();
			
			if($op == "add") {
				$pending_requests = $pending_requests[0]->pending_requests + 1;
			}
			if($op == "sub") {
				$pending_requests = $pending_requests[0]->pending_requests - 1;
			}
			$_data = array('pending_requests' => $pending_requests);
			$this->db->where('uid', $uid);
		    $this->db->update('user_profile', $_data);				
			
			$this->session->unset_userdata('pending_requests');
			$this->session->set_userdata('pending_requests',$pending_requests);
			return true;
		}

		public function set_last_activity($uid){
			$_data = array('last_activity' => date('Y-m-d H:i:s'));
			$this->db->where('uid', $uid);
		    $this->db->update('user_profile', $_data);			

			$this->session->unset_userdata('last_activity');
			$this->session->set_userdata('last_activity',date('Y-m-d H:i:s'));
			
			return true;
		}		
}