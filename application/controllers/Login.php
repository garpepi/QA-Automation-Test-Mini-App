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
    try{
      $this->load->model('loginmodel');
      $user = $this->loginmodel->checkUsername($this->input->post('username'));
      if(!empty($user)) {
        if('Abcd1234' != $this->input->post('password'))
        {	
          throw new Exception("Validation Error!! Username and Password not match");
        }
        else{
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
        // Set Session
        $this->load->model('loginmodel');
        $user = $this->loginmodel->checkUsername($this->input->post('username'))[0];

        if($user->isLogin == 1)
        {
          if(!empty($user->lastLogin))
          {
            $lastLogin = strtotime($user->lastLogin);
            $twoHour = strtotime("-2 Hours");
            //print_r($lastLogin);exit();
            // Less than 2 hour session exist. Can;t Login
            if($lastlogin >= $twoHour){
              throw new Exception("User Already Login!");
            }            
            
          }else{
            throw new Exception("User Already Login!");            
          }          
        }
        
        $session = array();
        
        if($this->input->post('username') == $user->makerUsername){
          $session = array(
            'userid' => $user->id,
            'candidateName' => $user->candidateName,
            'username' => $user->makerUsername,
            'role' => 'maker',
            'isLogin' => 1
          );
          $this->loginmodel->update_entry($user->id,array('lastLogin' => date("Y-m-d H:m:s",time()),'isLogin'=> 1), array('makerUsername' => $this->input->post('username')));
        }elseif($this->input->post('username') == $user->checkerUsername){
          $session = array(
            'userid' => $user->id,
            'candidateName' => $user->candidateName,
            'username' => $user->checkerUsername,
            'role' => 'checker',
            'isLogin' => 1
          );
          $this->loginmodel->update_entry($user->id,array('lastLogin' => date("Y-m-d H:m:s",time()),'isLogin'=> 1), array('checkerUsername' => $this->input->post('username')));
        }else{
          throw new Exception("Validation Error !");
        }
        $this->session->set_userdata($session);
				redirect("home");
			}
		
		}catch(Exception $e)
		{
			log_message('error',$e->getMessage());
			$this->load->view('login');
		}
		
	}
}
