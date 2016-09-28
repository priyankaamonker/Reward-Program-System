<?php
class RewardProgram extends CI_Controller {
     
    public function __construct() {
        parent::__construct();
		if($this->session->userdata('logged_in') == false){
            redirect(base_url().'login/li');
            exit;
        }		
        $this->load->model('rewardprogram_model');
		$this->load->model('product_model');
	    $this->load->model('course_model');
    }
 
    public function index() {
        $data['rewardprogram'] = $this->rewardprogram_model->get_rewardprograms();	
		$data['title'] = 'Reward Programs';
		
		$msg = $this->uri->segment(3);
		if($msg=="success")
			$data['msg'] = "Reward Program added successfully.";
		if($msg=="updated")
			$data['msg'] = "Reward Program updated successfully.";
		if($msg=="deleted")
			$data['msg'] = "Reward Program deleted successfully.";
		
		$this->load->view('templates/header', $data);
		$this->load->view('rewardprogram/index', $data);
		$this->load->view('templates/footer');		
    }
	
	public function view($id = NULL){
		$data['rewardprogram_item'] = $this->rewardprogram_model->get_rewardprograms($id);

		if (empty($data['rewardprogram_item'][0])){
			show_404();
		}

		$data['rewardprogram_item'] = $data['rewardprogram_item'][0];
		$data['title'] = $data['rewardprogram_item']->title;
		
		if($data['rewardprogram_item']->type==1) {
			foreach($data['rewardprogram_item']->qitems as $ky => $vl) {
				$data['rewardprogram_item']->qitems[$ky]->item_details[] = $this->product_model->get_products($data['rewardprogram_item']->qitems[$ky]->item_id);	 
			}
		}
		else {
			foreach($data['rewardprogram_item']->qitems as $ky => $vl) {
				$data['rewardprogram_item']->qitems[$ky]->item_details[] = $this->course_model->get_courses($data['rewardprogram_item']->qitems[$ky]->item_id);	
			}
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('rewardprogram/view', $data);
		$this->load->view('templates/footer');
	}	
 
	public function create(){
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Reward Programs';
		$_data['qproducts'] = $this->product_model->get_active_products();
		$_data['qcourses'] = $this->course_model->get_active_courses();

		$this->form_validation->set_rules('title', 'Title', 'required|is_unique[reward_program.title]');
		$this->form_validation->set_rules('type', 'Type', 'required');			
		$this->form_validation->set_rules('validity', 'Validity', 'callback_validateDate'); 
		
		if($this->input->post('type') == 1) {
			$this->form_validation->set_rules('qproduct[]', 'Qualified Product', 'required');	
			$this->form_validation->set_rules('product_reward_amount[]', 'Qualified Product amount', 'required|numeric');	
		}
		if($this->input->post('type') == 2) {
			$this->form_validation->set_rules('qcourse[]', 'Qualified Course', 'required');	
			$this->form_validation->set_rules('course_reward_amount[]', 'Qualified Course amount', 'required|numeric');				
		}		
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('rewardprogram/create', $_data);	
			$this->load->view('templates/footer');			
		}else{
			$this->rewardprogram_model->set_rewardprogram();
			redirect('/rewardprogram/index/success');
		}		
	}
         
    public function edit($id){
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['rewardprogram_item'] = $this->rewardprogram_model->get_rewardprograms($id);
		$data['rewardprogram_item'] = $data['rewardprogram_item'][0];
		
		if (empty($data['rewardprogram_item'])){
			show_404();
		}

		$data['title'] = 'Reward Programs';
		
		if($data['rewardprogram_item']->type==1) {
			foreach($data['rewardprogram_item']->qitems as $ky => $vl) {
				$data['rewardprogram_item']->qitems[$ky]->item_details[] = $this->product_model->get_products($data['rewardprogram_item']->qitems[$ky]->item_id);	 
			}
		}
		else {
			foreach($data['rewardprogram_item']->qitems as $ky => $vl) {
				$data['rewardprogram_item']->qitems[$ky]->item_details[] = $this->course_model->get_courses($data['rewardprogram_item']->qitems[$ky]->item_id);	
			}
		}
		
		$this->form_validation->set_rules('title', 'Title', 'required|callback_uniqueTitle');		
		$this->form_validation->set_rules('validity', 'Validity', 'callback_validateDate');
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('rewardprogram/edit', $data);
			$this->load->view('templates/footer');			
		}else{
			$this->rewardprogram_model->set_rewardprogram($id);
			redirect('/rewardprogram/index/updated');
		}	
    }
	
	public function uniqueTitle($title){
		$id =  $this->uri->segment(3);
		$return = $this->rewardprogram_model->uniqueTitle($id, $title);
		
		if (count($return) > 0){
            $this->form_validation->set_message('uniqueTitle', 'The {field} field must contain a unique value.');
            return FALSE;
        }
        else {
            return TRUE;
        }
	}

	public function validateDate($validity){
		$flag = 0;
		if (DateTime::createFromFormat('m/d/Y', $validity))
			$flag = 1;

		if(strtotime($validity) > strtotime(date('Y-m-d H:i:s'))) 
			$flag = 2;

		if ($flag < 2){
            $this->form_validation->set_message('validateDate', 'The {field} field must contain a valid date.');
            return FALSE;
        }
        else {
            return TRUE;
        }
	}
	
    public function delete(){	
		$id =  $this->uri->segment(3);
		$this->rewardprogram_model->delete_rewardprogram($id);
		redirect('/rewardprogram/index/deleted');		
    }

	//required by a ajax call
	public function programtype(){
		$id =  $this->uri->segment(3);
		$return = $this->rewardprogram_model->programtype($id);
		echo $return[0]->type;
	}
	
	//required by a ajax call
	public function programdesc(){
		$id =  $this->uri->segment(3);
		$return = $this->rewardprogram_model->programdesc($id);
		echo $return[0]->description;
	}
 
	//required by a ajax call
	public function programitem(){
		$id =  $this->uri->segment(3);
		$data = $this->rewardprogram_model->get_rewardprograms($id);
		$data = $data[0];
		if($data->type==1) {
			foreach($data->qitems as $ky => $vl) {
				$data->qitems[$ky]->item_details[] = $this->product_model->get_products($data->qitems[$ky]->item_id);	 
			}	
			$this->load->view('rewardrequest/_qproduct', $data);			
		} else {
			foreach($data->qitems as $ky => $vl) {
				$data->qitems[$ky]->item_details[] = $this->course_model->get_courses($data->qitems[$ky]->item_id);	
			}
			$this->load->view('rewardrequest/_qcourse', $data);			
		}
	}

	//required by a ajax call
	public function programItemamount(){
		$id =  $this->uri->segment(3);
		$item_id =  $this->uri->segment(4);
		$qty =  $this->uri->segment(5);		
		$return = $this->rewardprogram_model->programItemamount($id, $item_id);
		$amount = $return[0]->amount * $qty;
		echo "$" . $amount;
	}	
	
	//required by a ajax call
	public function programTotal(){
		$id =  $this->uri->segment(3);
	    $item_id =  $this->uri->segment(4);
	    $qty =  $this->uri->segment(5);
		
		$return = $this->rewardprogram_model->programtype($id);
		$item_id = explode("-",$item_id);
		$count = count($item_id);
		$total = 0;
		if($return[0]->type == 1) {			
			$qty = explode("-",$qty);					
			for($i=0;$i<$count; $i++) {
				if($item_id[$i]!="" && $qty[$i]!="") {
					$return = $this->rewardprogram_model->programItemamount($id, $item_id[$i]);
					$total = $total + $return[0]->amount * $qty[$i];
				}		
			}	
		} else {
			for($i=0;$i<$count; $i++) {
				if($item_id[$i]!="") {
					$return = $this->rewardprogram_model->programItemamount($id, $item_id[$i]);
					$total = $total + $return[0]->amount;
				}		
			}				
		}
		echo $total;
	}	
}