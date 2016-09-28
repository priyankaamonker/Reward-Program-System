<?php
class RewardRequest_model extends CI_Model {
		//public $variable;
		public function __construct() {
			//$this->variable = 1;
		}
			
		public function get_rewardrequests($id = FALSE){
			//echo $this->variable;exit;
			if ($id === FALSE){				
				$this->db->select('rr.id, uid, rp_id, status, amount, created, last_activity');
				$this->db->from('reward_request rr');
				$this->db->join('reward_request_item rri','rr.id = rri.rr_id');
				$this->db->group_by('rr.id');
				$this->db->order_by('rr.id', 'DESC');
				$query = $this->db->get();
				return $query->result();
			}
			
			$query = $this->db->get_where('reward_request', array('id =' => $id));
			$result = $query->result();
			$query = $this->db->get_where('reward_request_item', array('rr_id' => $id));
			$result_item = $query->result();				
			$result[0]->qitems = $result_item;
			return $result;			
		}		
		
		public function set_rewardrequest($id = FALSE){
			$this->load->helper('url');
			
			$data = array(
				'uid' => $this->input->post('uid'),
				'rp_id' => $this->input->post('rp_id'),
				'comments' => $this->input->post('comments'),
			);
			
			if ($id === FALSE){
				$data['created'] = date('Y-m-d H:i:s');
				$data['status'] = "1";
				$data['last_activity'] = date('Y-m-d H:i:s');
			    $this->db->insert('reward_request', $data);
				
				$_data = $this->prepareItems($this->db->insert_id());
				foreach($_data as $key => $val) {
					$this->db->insert('reward_request_item', $val);
				}	
				return true;
			}
			else {
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('reward_request', $data);
				
				$_data['rr_id'] = $this->input->post('id');
				$this->db->where('rr_id', $id);
				return $this->db->update('reward_request_item', $_data);			
			}	
		}	
		
		public function prepareItems($reward_request_id) {
			$products = is_array($this->input->post('qproduct')) ? array_filter($this->input->post('qproduct')) : "";
			$quantity = $this->input->post('qpquantity');
				
			if(!empty($products)) {
				$item = $this->input->post('qproduct');
				$completed_on = $this->input->post('qpcompleted_date');
			} else {
				$item = $this->input->post('qcourse');
				$completed_on = $this->input->post('qccompleted_date');
			}
					
			$count = count($item);
			if(!empty($products)) {
				for($i = 0; $i < $count; $i++) {
					if(!empty($item[$i]) && !empty($quantity[$i]) && !empty($completed_on[$i])) {
						$amount = $this->rewardprogram_model->programItemamount($this->input->post('rp_id'), $item[$i]);
						$finalamount = $amount[0]->amount * $quantity[$i];
						$items[$i] = array(
							"rr_id"		   => $reward_request_id,
							"item_id" 	   => $item[$i],
							"quantity" 	   => $quantity[$i],
							"amount" 	   => $finalamount,
							"completed_on" => date('Y-m-d H:i:s', strtotime($completed_on[$i])),
						);
					}
				}
			} else {
				for($i = 0; $i < $count; $i++) {
					if(!empty($item[$i]) && !empty($completed_on[$i])) {
						$amount = $this->rewardprogram_model->programItemamount($this->input->post('rp_id'), $item[$i]);
						$items[$i] = array(
							"rr_id"		   => $reward_request_id,
							"item_id" 	   => $item[$i],
							"quantity" 	   => 0,
							"amount" 	   => $amount[0]->amount,
							"completed_on" => date('Y-m-d H:i:s', strtotime($completed_on[$i])),
						);
					}
				}			
			}		
			return $items;
		}		

		public function approve_rewardrequest($uid, $id){ 
			$request = $this->get_rewardrequests($id);
			if($request[0]->status==1) {
				$this->user_model->set_pending_requests($uid, "sub");
			}
				
			$_data['status'] = 2;
			$_data['last_activity'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			return $this->db->update('reward_request', $_data);	
		}
		
		public function deny_rewardrequest($uid, $id){
			$request = $this->get_rewardrequests($id);
			if($request[0]->status==1) {
				$this->user_model->set_pending_requests($uid, "sub");
			}
				
			$_data['status'] = 3;
			$_data['last_activity'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			return $this->db->update('reward_request', $_data);	
		}		
		
		public function reset_rewardrequest($uid, $id){
			$this->user_model->set_pending_requests($uid, "add");			
			$_data['status'] = 1;
			$this->db->where('id', $id);
			return $this->db->update('reward_request', $_data);	
		}
		
		public function delete_rewardrequest($uid, $id){
			$request = $this->get_rewardrequests($id);
			if($request[0]->status==1) {
				$this->user_model->set_pending_requests($uid, "sub");
			}
				
			$_data['status'] = 4;
			$_data['last_activity'] = date('Y-m-d H:i:s');
			$this->db->where('id', $id);
			return $this->db->update('reward_request', $_data);	
		}		
		
		public function get_myrequests($uid) {		
			$this->db->select('rr.id, uid, rp_id, status, created, last_activity, rr_id, item_id, quantity, amount');
			$this->db->from('reward_request rr');
			$this->db->join('reward_request_item rri','rr.id = rri.rr_id');
			$this->db->where(array('uid' => $uid, 'status!=' => 4));
			$this->db->group_by('rr.id');
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get();			
			$result = $query->result();
			foreach($result as $key => $val){
				$query1 = $this->rewardprogram_model->get_rewardprograms($val->rp_id);					
				$result[$key]->program = $query1[0];
			}	
			return $result;
		} 
		
		public function destroy_rewardrequest($uid, $id){
			$request = $this->get_rewardrequests($id);
			if($request[0]->status==1) {
				$this->user_model->set_pending_requests($uid, "sub");
			}
			$this->db->where('id', $id);
			$this->db->delete('reward_request');
			
			$this->db->where('rr_id', $id);
			$this->db->delete('reward_request_item');			
		}			
}