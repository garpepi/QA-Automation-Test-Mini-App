<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caseone extends CI_Controller {

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
  
  public function update($aor){
    $this->index($aor);
  }
  
	public function index($aor = NULL)
	{
    if($this->session->role == "maker")
    {
      if(!$this->input->post())
      {
        $this->maker();        
      }else{
        $this->makerDoPost();
      }
    }else{
      if(!$this->input->post())
      {
        $this->checker();        
      }else{
        $this->checkerDoPost($aor);
      }
    }
	}
  
  function maker(){
    $this->load->view('caseonewrapper');
  }
  
  function checker(){
    $this->load->model("caseonemodel");
    $this->load->view('caseonewrapper',array('fetchdata' => $this->caseonemodel->get_entries()));
  }
  
  function dataChecker()
  {
    $this->load->model("caseonemodel");
    
    if(empty($this->caseonemodel->get_one_entries(array("id" => $this->input->post("id"),"candidateName" => $this->session->candidateName))))
    {
      log_message('error', 'This data not belongs to your session!!');
      $this->form_validation->set_message('dataChecker', 'This data not belongs to your session!!');
      return FALSE;
    }
    return TRUE;
  }
  
  function checkerDoPost($aor){
    try{
      if($aor == 'accept' || $aor == 'reject')
      {
        $this->form_validation->set_rules('id', 'ID', 'required|trim|numeric|callback_dataChecker');
        if ($this->form_validation->run() == FALSE)
        {
          throw new Exception("Validation Error!! ".form_error("id"));
        }else{
          $updateData = array(
            "acceptedFlag" => $aor
          );
          $this->load->model("caseonemodel");
          if($this->caseonemodel->update_entry($this->input->post('id'),$updateData))
          {
            return TRUE;
          }
          else{
            throw new Exception("Error when Update DB!!");
          }
        }
      }else{
        throw new Exception("No Accept or Reject!!");
      }
    }catch(Exception $e){
      log_message('error', $e->getMessage());
      $this->custom_show_error($e->getMessage(),500);
    }
  }
  
  function custom_show_error( $message , $errorCode)
  {
      $status = array();
      $status["success"] = FALSE;
      $status["message"] = $message;
      
      //header('Cache-Control: no-cache, must-revalidate')
      //header("Content-Type: application/json");
      //header("HTTP/1.1 500 Internal Server Error");
      $this->output->set_status_header(500);
      
      echo json_encode($status);
      exit;
  } 
  
  function makerDoPost(){
    $rules = array(
        array(
                'field' => 'text1',
                'label' => 'Text 1',
                'rules' => 'required|alpha_numeric_spaces'
        ),
        array(
                'field' => 'text2',
                'label' => 'Text 2',
                'rules' => 'required|alpha'
        ),
        array(
                'field' => 'text3',
                'label' => 'Text 3',
                'rules' => 'required|numeric|greater_than[0.99]|regex_match[/^[0-9,]+$/]'
        ),
        array(
                'field' => 'text4',
                'label' => 'Text 4',
                'rules' => 'required|valid_email'
        ),
        array(
                'field' => 'options',
                'label' => '  ',
                'rules' => 'required'
        ),
        array(
                'field' => 'multipleoptions[]',
                'label' => 'Multiple select',
                'rules' => 'required'
        ),
        array(
                'field' => 'alltext',
                'label' => 'Textarea',
                'rules' => 'required'
        )
    );
    
    $this->form_validation->set_rules($rules);
    
    try{
      if ($this->form_validation->run() == FALSE)
      {
        throw new Exception("Validation Error!!");
      }
      else
      {
        $this->load->model("caseonemodel");
        if($this->caseonemodel->insert_entry($this->input->post()))
        {
          $this->session->set_flashdata('status', 'success');
        }else{
          $this->session->set_flashdata('status', 'failed');
        }
        redirect("caseone");
        
      }
    }catch(Exception $e){
      $this->load->view('caseonewrapper');
    }    
  }
}
