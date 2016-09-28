<?php
class Home extends CI_Controller {
     
    public function __construct() {
        parent::__construct();
		$this->load->model('rewardprogram_model');
		$this->load->model('rewardrequest_model');		
    }
 
    public function index() {
		$this->load->helper('form');
		$this->load->library('form_validation');		
		$data['title'] = 'Welcome';	
		$_data['reward_program'] = $this->rewardprogram_model->get_active_rewardprograms();
		$_data['myrequests'] = $this->rewardrequest_model->get_myrequests($this->session->userdata('id'));
		$this->load->view('templates/header', $data);
		$this->load->view('home/index', $_data);
		$this->load->view('templates/footer');	
    }	
}