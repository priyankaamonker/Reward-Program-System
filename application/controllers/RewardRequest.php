<?php
class RewardRequest extends CI_Controller {
     
    public function __construct() {
        parent::__construct();
		if($this->session->userdata('logged_in') == false){
            redirect(base_url().'login/li');
            exit;
        }		
        $this->load->model(array('rewardrequest_model', 'rewardprogram_model'));
		//$this->load->model('rewardprogram_model');
		$this->load->model('user_model');		
		$this->load->model('product_model');
	    $this->load->model('course_model');		
    }
 
    public function index() {
        $data['rewardrequest'] = $this->rewardrequest_model->get_rewardrequests();
		$data['title'] = 'Reward Requests';		
		
		$msg =  $this->uri->segment(3);
		if($msg=="updated")
			$data['msg'] = "Reward Request updated successfully.";
		if($msg=="deleted")
			$data['msg'] = "Reward Request deleted successfully.";
		
		foreach($data['rewardrequest'] as $key => $val) {
			$program = $this->rewardprogram_model->get_rewardprograms($data['rewardrequest'][$key]->rp_id);
			$data['rewardrequest'][$key]->program = $program[0];
			$user = $this->user_model->get_users($data['rewardrequest'][$key]->uid);
			$data['rewardrequest'][$key]->user = $user[0];
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('rewardrequest/index', $data);
		$this->load->view('templates/footer');		
    }
	
	public function view($id = NULL){
		$data['rewardrequest_item'] = $this->rewardrequest_model->get_rewardrequests($id);
		
		if (empty($data['rewardrequest_item'][0])){
			show_404();
		}

		$data['rewardrequest_item'] = $data['rewardrequest_item'][0];
		$data['title'] = "Reward Request";		
		
		$program = $this->rewardprogram_model->get_rewardprograms($data['rewardrequest_item']->rp_id);
		$data['rewardrequest_item']->program = $program[0];
		$user = $this->user_model->get_users($data['rewardrequest_item']->uid);
		$data['rewardrequest_item']->user = $user[0];
		
		if($data['rewardrequest_item']->program->type==1) {
			foreach($data['rewardrequest_item']->qitems as $ky => $vl) {
				$data['rewardrequest_item']->qitems[$ky]->item_details[] = $this->product_model->get_products($data['rewardrequest_item']->qitems[$ky]->item_id);	 
			}
		}
		else {
			foreach($data['rewardrequest_item']->qitems as $ky => $vl) {
				$data['rewardrequest_item']->qitems[$ky]->item_details[] = $this->course_model->get_courses($data['rewardrequest_item']->qitems[$ky]->item_id);	
			}
		}		

		$this->load->view('templates/header', $data);
		$this->load->view('rewardrequest/view', $data);
		$this->load->view('templates/footer');
	}	
 
	public function create(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = "Reward Requests";
		
		$this->form_validation->set_rules('rp_id', 'Reward Program', 'required');
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('rewardrequest/create');	
			$this->load->view('templates/footer');			
		}else{
			$this->rewardrequest_model->set_rewardrequest();
			$this->user_model->set_pending_requests($this->input->post('uid'), "add");
			redirect(base_url().'#my-requests?msg=success');
		}		
	}
         
    public function edit($id){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['rewardrequest_item'] = $this->rewardrequest_model->get_rewardrequests($id);
		$data['rewardrequest_item'] = $data['rewardrequest_item'][0];
		
		if (empty($data['rewardrequest_item'])){
			show_404();
		}

		$data['title'] = 'Reward Requests';
		$data['reward_program'] = $this->reward_program_model->get_active_rewardprograms();
			
		$this->form_validation->set_rules('reward_program', 'Reward Program', 'required');			
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('rewardrequest/edit', $data);
			$this->load->view('templates/footer');			
		}else{
			$this->rewardrequest_model->set_rewardrequest($id);
			redirect('/rewardrequest/index/updated');
		}	
    }
	
    public function approve(){	
		$uid =  $this->uri->segment(3);
		$id =  $this->uri->segment(4);
		$this->rewardrequest_model->approve_rewardrequest($uid, $id);
		redirect('/rewardrequest/index/updated');
    }

    public function deny(){	
		$uid =  $this->uri->segment(3);
		$id =  $this->uri->segment(4);
		$this->rewardrequest_model->deny_rewardrequest($uid, $id);
		redirect('/rewardrequest/index/updated');
    }
	
    public function reset(){	
		$uid =  $this->uri->segment(3);
		$id =  $this->uri->segment(4);
		$this->rewardrequest_model->reset_rewardrequest($uid, $id);
		redirect('/rewardrequest/index/updated');
    }
	
    public function delete(){	
		$uid =  $this->uri->segment(3);
		$id =  $this->uri->segment(4);
		$this->rewardrequest_model->delete_rewardrequest($uid, $id);
		redirect(base_url().'#my-requests?msg=deleted');
    }
   
    public function destroy(){	
		$uid =  $this->uri->segment(3);
		$id =  $this->uri->segment(4);
		$this->rewardrequest_model->destroy_rewardrequest($uid, $id);
		redirect('/rewardrequest/index/deleted');
    }   
}