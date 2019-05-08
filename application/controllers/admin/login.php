<?php 

class Login extends Controller 

{

	public function __construct(){

		parent::Controller();
		
		if($this->session->userdata('admin_id')){
			
				redirect('admin/user');
			
			}

		$this->load->model("admin/login_model");

	}

	public function index(){

		$this->load->library("validation");

		if($_POST['submit']!=""){
					
			//print_r($_POST); exit;
			
			$rules['username']   	= "trim|required|xss_clean";

			$rules['password']  	= "required";

			$rules['signin']  	    = "callback_admin_check";

			$this->validation->set_rules($rules);

			$fields['username']   	= "Username";

			$fields['password']  	= "Password";

			

			$this->validation->set_fields($fields);

	

			if ($this->validation->run() == TRUE){
			
			    
				$admin_details   = $this->login_model->admin_details($_POST);
				
				if($admin_details == 0)
				{
					$data['error'] = "<font style='color:#FF0000; font-weight:bold; font-size:14px;'>Invalid username or password.</font>";
					$this->load->view("admin/admin_login", $data);
				}
				else{
					$this->session->set_userdata($admin_details);
					$this->login_model->admin_logs_insert(array('logged_ip' => $this->session->userdata("ip_address"),'admin_id' => $admin_details['admin_id']));
					redirect("admin/user");
				}
				//d($this->session);
			}

			else{

				$data['menu']        = "branch";

		    	$data['who']         = "admin";


				$this->load->view('admin/admin_login',$data);

			}

		 }

		 else

		 {

			$data['menu']        = "branch";

		    $data['who']         = "admin";

			$this->load->view('admin/admin_login',$data);

		 }	   

	}

	public function admin_check(){

		$exist_admin = $this->login_model->admin_details();

		if ($exist_admin['status'])

		{   if($exist_admin['status']=="Deactive"){

				$this->validation->set_message('admin_check', 'Deactive Account');

			    return FALSE;

		    }else{

				return TRUE;

			}

		}

		else

		{

			$this->validation->set_message('admin_check', 'Invalid Username or Password');

			return FALSE;

		}

	}

}