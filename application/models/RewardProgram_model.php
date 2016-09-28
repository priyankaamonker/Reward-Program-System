<?php
class RewardProgram_model extends CI_Model {

        public function __construct() {
        }
			
		public function get_rewardprograms($id = FALSE){
			if ($id === FALSE){				
				$this->db->select('rp.id, title, description, type, validity, status, item_id, amount');
				$this->db->from('reward_program rp');
				$this->db->join('reward_program_item rpi','rp.id = rpi.reward_program_id');
				$this->db->group_by('rp.id');
				$query = $this->db->get();
				return $query->result();
			}
			
			$query = $this->db->get_where('reward_program', array('id =' => $id));
			$result = $query->result();
			$query = $this->db->get_where('reward_program_item', array('reward_program_id' => $id));
			$result_item = $query->result();				
			$result[0]->qitems = $result_item;
			return $result;
		}		
		
		public function set_rewardprogram($id = FALSE){
			$this->load->helper('url');
			
			$data = array(
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'type' => $this->input->post('type'),
				'validity' => date('Y-m-d H:i:s', strtotime($this->input->post('validity'))),
				'status' => $this->input->post('status')
			);
			
			if ($id === FALSE){
				$data['added_on'] = date('Y-m-d H:i:s');
			    $this->db->insert('reward_program', $data);
				
				$_data = $this->prepareItems($this->db->insert_id());
				foreach($_data as $key => $val) {
					$this->db->insert('reward_program_item', $val);
				}					
			}
			else {
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('reward_program', $data);	
			}			
		}	

		public function delete_rewardprogram($id){       
			$this->db->where('id', $id);
			$this->db->delete('reward_program');
			$this->db->where('reward_program_id', $id);
			$this->db->delete('reward_program_item');			
		}	

		public function uniqueTitle($id, $title){
			$query = $this->db->get_where('reward_program', array('id !=' => $id, 'title' => $title));
			return $query->row_array();		
		}	
		
		public function get_active_rewardprograms(){
			$query = $this->db->get_where('reward_program', array('status' => "1"));
			return $query->result_array();			
		}
		
		public function prepareItems($reward_program_id) {
			$products = array_filter($this->input->post('qproduct'));
			
			if(!empty($products)) {
				$item = $this->input->post('qproduct');
				$amount = $this->input->post('product_reward_amount');
			} else {
				$item = $this->input->post('qcourse');
				$amount = $this->input->post('course_reward_amount');				
			}
					
			$count = count($item);
			for($i = 0; $i < $count; $i++) {
				if(isset($item[$i]) && isset($amount[$i])) {
					$items[$i] = array(
						"reward_program_id" => $reward_program_id,
						"item_id" => $item[$i],
						"amount"  => $amount[$i]
					);
				}
			}	
			return $items;
		}
		
		//required by a ajax call
		public function programtype($id){
			$this->db->select('type');
			$this->db->from('reward_program');
			$this->db->where(array('id' => $id));
			$query = $this->db->get();
			return $query->result();	
		}
		
		//required by a ajax call
		public function programdesc($id){
			$this->db->select('description');
			$this->db->from('reward_program');
			$this->db->where(array('id' => $id));
			$query = $this->db->get();
			return $query->result();	
		}

		//required by a ajax call
		public function programItemamount($id, $item_id){
			$this->db->select('amount');
			$this->db->from('reward_program_item');
			$this->db->where(array('reward_program_id' => $id, 'item_id' => $item_id));
			$query = $this->db->get();
			return $query->result();	
		}		
}