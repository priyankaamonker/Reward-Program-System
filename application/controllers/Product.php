<?php
class Product extends CI_Controller {
     
    public function __construct() {
        parent::__construct();
		if($this->session->userdata('logged_in') == false){
            redirect(base_url().'login/li');
            exit;
        }		
        $this->load->model('product_model');
    }
 
    public function index() {
        //$data['product'] = $this->product_model->get_products();	
		$data['title'] = 'Products';
		
		$msg =  $this->uri->segment(3);
		if($msg=="success")
			$data['msg'] = "Product added successfully.";
		if($msg=="updated")
			$data['msg'] = "Product updated successfully.";
		if($msg=="deleted")
			$data['msg'] = "Product deleted successfully.";
			
		$this->load->view('templates/header', $data);
		$this->load->view('product/index', $data);
		$this->load->view('templates/footer');			
    }
	
	public function datatable() {

	}
	
	public function view($id = NULL){
		$data['product_item'] = $this->product_model->get_products($id);

		if (empty($data['product_item'])){
			show_404();
		}

		$data['title'] = $data['product_item']['title'];

		$this->load->view('templates/header', $data);
		$this->load->view('product/view', $data);
		$this->load->view('templates/footer');
	}	
 
	public function create(){
		$this->load->helper('form');
		$this->load->library('form_validation');

		$data['title'] = 'Products';

		$this->form_validation->set_rules('title', 'Title', 'required|is_unique[product.title]');	
		
		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('product/create');	
			$this->load->view('templates/footer');			
		}else{
			$this->product_model->set_product();
			redirect('/product/index/success');
		}		
	}
         
    public function edit($id){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['product_item'] = $this->product_model->get_products($id);

		if (empty($data['product_item'])){
			show_404();
		}

		$data['title'] = 'Products';
		
		$this->form_validation->set_rules('title', 'Title', 'required|callback_uniqueTitle');	

		if ($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('product/edit', $data);
			$this->load->view('templates/footer');			
		}else{
			$this->product_model->set_product($id);
			redirect('/product/index/updated');
		}	
    }
	
	public function uniqueTitle($title){
		$id =  $this->uri->segment(3);
		$return = $this->product_model->uniqueTitle($id, $title);
		
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
		$this->product_model->delete_product($id);
		redirect('/product/index/deleted');		
    }
         

    public function ajax_list()
    {
        $list = $this->product->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $product) {
            $no++;
            $row = array();
            $row[] = $product->title;
            $row[] = $product->description;
            $row[] = $product->status;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_product('."'".$product->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Delete" onclick="delete_product('."'".$product->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->product->count_all(),
                        "recordsFiltered" => $this->product->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->product->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'status' => $this->input->post('status'),
            );
        $insert = $this->product->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'status' => $this->input->post('status'),
            );
        $this->product->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->product->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('title') == '')
        {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'Title is required';
            $data['status'] = FALSE;
        }
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }		 
}