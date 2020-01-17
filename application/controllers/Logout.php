<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	/**
	 * 	Home Page for this controller.
	 *	Simple Site for Automation Purposes
	 *	GHA
	 *	mail@garpepic.com
	 */
   
	public function __construct()
  {
    parent::__construct();
    $this->load->model('loginmodel');
    $this->loginmodel->update_entry($this->session->userid,array('lastLogin' => date("Y-m-d HH:mm:ss",time()),'isLogin'=> 1 ));

    $this->session->sess_destroy();
    
  }
  
	public function index()
	{
    redirect("home");
	}
  
}
