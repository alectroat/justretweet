<?php 

class Rules extends Controller 

{
	public function __construct(){

		parent::Controller();
		//$this->load->model("admin/account_model");
		

	}

	public function index(){
	    //$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		$data['menu'] = 'rules';		
		$data['title'] = 'How to Access Just Retweet';
		$this->load->view('howto',$data);
	}
	
	public function refund(){
	    //$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		$data['menu'] = 'rules';		
		$data['title'] = 'Refund Policy of Just Retweet';
		$this->load->view('refund',$data);
	}

	public function contact(){
	    //$data['accounts'] = $this->account_model->getUserSpecificAccount($this->session->userdata('userid'));
		$data['menu'] = 'rules';		
		$data['title'] = 'How to contact at Just Retweet';
		$this->load->view('contact',$data);
	}
}
?>