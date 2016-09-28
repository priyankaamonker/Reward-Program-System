<?php
class User extends CI_Controller {
     
    public function __construct() {
        parent::__construct();
		if($this->session->userdata('logged_in') == false){
            redirect(base_url().'login/li');
            exit;
        }		
        $this->load->model('user_model');
    }
 
    public function index() {
        $data['user'] = $this->user_model->get_users();	
		$data['title'] = 'Users';
		
		$msg =  $this->uri->segment(3);
		if($msg=="success")
			$data['msg'] = "User added successfully.";
		if($msg=="updated")
			$data['msg'] = "User updated successfully.";
		if($msg=="deleted")
			$data['msg'] = "User deleted successfully.";
		
		$this->load->view('templates/header', $data);
		$this->load->view('user/index', $data);
		$this->load->view('templates/footer');		
    }
	
	public function view($id = NULL){
		$data['user_item'] = $this->user_model->get_users($id);

		if (empty($data['user_item'][0])){
			show_404();
		}

		$data['user_item'] = $data['user_item'][0];
		$data['title'] = "Users";
			
		$this->load->view('templates/header', $data);
		$this->load->view('user/view', $data);
		$this->load->view('templates/footer');
	}	
 
	public function create(){
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Users';

		$this->form_validation->set_rules('firstname', 'First Name', 'required');		
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');		
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'required');		
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('user/create');	
			$this->load->view('templates/footer');			
		}else{
			$this->user_model->set_user();
			redirect('/user/index/success');
		}		
	}
         
    public function edit($id){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['user_item'] = $this->user_model->get_users($id);
		$data['user_item'] = $data['user_item'][0];
		
		if (empty($data['user_item'])){
			show_404();
		}

		$data['title'] = 'Users';	
		
		$this->form_validation->set_rules('firstname', 'First Name', 'required');		
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_uniqueEmail');		
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('user/edit', $data);
			$this->load->view('templates/footer');			
		}else{
			$this->user_model->set_user($id);
			if($this->session->userdata('role')==1)
				redirect('/user/index/updated');
			else
				redirect('/user/profile');
		}	
    }
	
	public function uniqueEmail($email){
		$id =  $this->uri->segment(3);
		$return = $this->user_model->uniqueEmail($id, $email);
		
		if (count($return) > 0){
            $this->form_validation->set_message('uniqueEmail', 'The {field} field must contain a unique value.');
            return FALSE;
        }
        else {
            return TRUE;
        }
	}
	
    public function delete(){	
		$id =  $this->uri->segment(3);
		$this->user_model->delete_user($id);
		redirect('/user/index/deleted');		
    }
         
	public function profile(){
		$data['user_item'] = $this->user_model->get_users($this->session->userdata('id'));

		if (empty($data['user_item'][0])){
			show_404();
		}

		$data['user_item'] = $data['user_item'][0];
		$data['title'] = "Profile";
			
		$this->load->view('templates/header', $data);
		$this->load->view('user/profile', $data);
		$this->load->view('templates/footer');
	}		 
}