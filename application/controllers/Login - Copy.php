<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * 	Login Page for this controller.
	 *	Simple Site for Automation Purposes
	 *	GHA
	 *	mail@garpepic.com
	 */
	
  public function __construct()
  {
    parent::__construct();
    if($this->session->isLogin)
    {
      redirect('home');
    }
  }
  
	public function index()
	{
    if($this->input->post())
		{
			$this->doLogin();
		}else{
      $this->load->view('login');      
    }
    
	}
	
  function checkUsernamePassword()
  {
    $users = array(
			array(
				'username' => 'maker',
				'password' => 'makercreatepassword',
				'role' => 'maker'
			),
			array(
				'username' => 'checker',
				'password' => 'checkercheckpassword',
				'role' => 'checker'
			)
		);
    
    $usrFind = array_search(strtolower($this->input->post('username')), array_column($users, 'username'));
    try{
      if($usrFind !== false) {
        if($users[$usrFind]['password'] != $this->input->post('password'))
        {	
          throw new Exception("Validation Error!! Username and Password not match");
        }
        else{
          $session = $users[$usrFind];
          unset($session['password']);
          $session['candidateName'] = $this->input->post('name');
          $session['isLogin'] = 1;
          $this->session->set_userdata($session);
          return TRUE;
        }
      }
      else {
        throw new Exception("Validation Error!! Username and Password not match");
      }
    }catch(Exception $e)
    {
      $this->form_validation->set_message('checkUsernamePassword', 'Username and Password not match!');
      return FALSE;
    }
    
  }
  
	public function doLogin()
	{
		if(!$this->input->post())
		{
			redirect('login');
		}

		
		try{
			$this->form_validation->set_rules('name', 'Candidate Name', 'required|trim');
      $this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|callback_checkUsernamePassword',
					array('required' => 'You must provide a %s.',)
			);

			if ($this->form_validation->run() == FALSE)
			{
				throw new Exception("Validation Error!!");
			}
			else
			{
				redirect("home");
			}
		
		}catch(Exception $e)
		{
			log_message('error',$e->getMessage());
			$this->load->view('login');
		}
		
	}
}
