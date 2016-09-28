<?php
class UserAuth extends CI_Controller {
     
    public function __construct() {
        parent::__construct();
        $this->load->model('userauth_model');
		$this->load->model('user_model');		
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
    }
 
    public function index() {
		if($this->session->userdata('logged_in') == true){
			redirect(base_url().'home');		
			exit;
		}
	
		$data['title'] = 'Login';
		
		$flag =  $this->uri->segment(2);
		if($flag=="lo")
			$data['msg'] = "You have successfully Logged out.";
		if($flag=="li")
			$data['msg'] = "You have to login to view this page.";
		
		$this->load->view('templates/header', $data);
		$this->load->view('userauth/index', $data);
		$this->load->view('templates/footer');	
    }
	
	public function login() {
		$data['title'] = 'Login';

		$this->form_validation->set_rules('email', 'Email', 'required');	
		$this->form_validation->set_rules('password', 'Password', 'required|callback_verifyLogin');	
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('userauth/index');	
			$this->load->view('templates/footer');			
		}else{
			$session_array = $this->userauth_model->load_user();
			$session_array = (array)$session_array[0];
			$session_array['logged_in'] = TRUE;
			$this->session->set_userdata($session_array);				
			redirect(base_url().'home');
		}							
	}
	
	public function logout() {
		$this->user_model->set_last_activity($this->session->userdata('id'));
		$this->session->sess_destroy();
		redirect(base_url().'login/lo');
	}     
	
	public function verifyLogin(){
		$return = $this->userauth_model->verifyLogin();
		
		if (count($return) == 0){
            $this->form_validation->set_message('verifyLogin', 'Invalid username or password.');
            return FALSE;
        }
        else {
            return TRUE;
        }
	}	
}