<?php
class Logout extends Controller {
  function __construct() {
    parent::Controller();
  }
  function index() {

	setcookie("user_id",  "", time()-3600, "/");
	
	$this->session->sess_destroy();
	redirect("main");
  }

}
?>