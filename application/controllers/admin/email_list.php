<?php 

class Email_list extends Controller 

{
  
	public function __construct(){

		parent::Controller();
		$this->load->model("admin/user_model");
					
	}

	public function index(){
	
		
			$result = $this->user_model->getAllUserEmail();
			
			$file = 'export';
			$csv_output = "";
			$csv_output .= "User Name ,";
            $csv_output .= "Email Account";
            $csv_output .= "\n\n";
			
			
			foreach($result as $list){
			$csv_output .= $list->username." ,";
            $csv_output .= $list->email;
            $csv_output .= "\n";			
			}
			
			$filename = $file."_".strtotime("now");
			header("Content-type: application/vnd.ms-excel");
			header("Content-disposition: csv" . date("Y-m-d") . ".csv");
			header( "Content-disposition: filename=".$filename.".csv");
			
			print $csv_output;
			
			exit;
		
	
	}
	
}
?>