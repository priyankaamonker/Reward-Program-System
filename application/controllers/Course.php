<?php
class Course extends CI_Controller {
     
    public function __construct() {
        parent::__construct();
		if($this->session->userdata('logged_in') == false){
            redirect(base_url().'login/li');
            exit;
        }
        $this->load->model('course_model');
    }
 
    public function index() {
        $data['course'] = $this->course_model->get_courses();	
		$data['title'] = 'Courses';
		
		$msg =  $this->uri->segment(3);
		if($msg=="success")
			$data['msg'] = "Course added successfully.";
		if($msg=="updated")
			$data['msg'] = "Course updated successfully.";
		if($msg=="deleted")
			$data['msg'] = "Course deleted successfully.";
		
		$this->load->view('templates/header', $data);
		$this->load->view('course/index', $data);
		$this->load->view('templates/footer');		
    }
	
	public function view($id = NULL){
		$data['course_item'] = $this->course_model->get_courses($id);

		if (empty($data['course_item'])){
			show_404();
		}

		$data['title'] = $data['course_item']['title'];

		$this->load->view('templates/header', $data);
		$this->load->view('course/view', $data);
		$this->load->view('templates/footer');
	}	
 
	public function create(){
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Courses';

		$this->form_validation->set_rules('title', 'Title', 'required|is_unique[course.title]');	
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('course/create');	
			$this->load->view('templates/footer');			
		}else{
			$this->course_model->set_course();
			redirect('/course/index/success');
		}		
	}
         
    public function edit($id){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['course_item'] = $this->course_model->get_courses($id);

		if (empty($data['course_item'])){
			show_404();
		}

		$data['title'] = 'Courses';
		
		$this->form_validation->set_rules('title', 'Title', 'required|callback_uniqueTitle');	

		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('course/edit', $data);
			$this->load->view('templates/footer');			
		}else{
			$this->course_model->set_course($id);
			redirect('/course/index/updated');
		}	
    }
	
	public function uniqueTitle($title){
		$id =  $this->uri->segment(3);
		$return = $this->course_model->uniqueTitle($id, $title);
		
		if (count($return) > 0){
            $this->form_validation->set_message('uniqueTitle', 'The {field} field must contain a unique value.');
            return FALSE;
        }
        else {
            return TRUE;
        }
	}

    public function delete(){	
		$id =  $this->uri->segment(3);
		$this->course_model->delete_course($id);
		redirect('/course/index/deleted');		
    }
         
}