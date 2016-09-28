<?php
class Course_model extends CI_Model {

        public function __construct(){
        }
			
		public function get_courses($id = FALSE){
			if ($id === FALSE){
				$query = $this->db->get('course');
				return $query->result_array();
			}

			$query = $this->db->get_where('course', array('id' => $id));
			return $query->row_array();
		}		
		
		public function set_course($id = FALSE){
			$this->load->helper('url');

			$data = array(
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'status' => $this->input->post('status')
			);

			if ($id === FALSE){
				return $this->db->insert('course', $data);
			}
			else {
				$this->db->where('id', $id);
				$this->db->update('course', $data);
			}	
		}	

		public function delete_course($id){       
			$this->db->where('id', $id);
			$this->db->delete('course');
		}	

		public function uniqueTitle($id, $title){
			$query = $this->db->get_where('course', array('id !=' => $id, 'title' => $title));
			return $query->row_array();		
		}	
		
		public function get_active_courses(){
			$query = $this->db->get_where('course', array('status' => "1"));
			return $query->result_array();
		}			
}