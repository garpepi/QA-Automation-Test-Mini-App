<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * 	Home Page for this controller.
	 *	Simple Site for Automation Purposes
	 *	GHA
	 *	mail@garpepic.com
	 */
   
	public function __construct()
  {
    parent::__construct();
    if(!$this->session->isLogin)
    {
      redirect('login');
    }
  }
  
	public function index()
	{
    $this->load->view('Home');
	}
  
}
