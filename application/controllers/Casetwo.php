<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Casetwo extends CI_Controller {

	/**
	 * 	Home Page for this controller.
	 *	Simple Site for Automation Purposes
	 *	GHA
	 *	mail@garpepic.com
	 */
  
  private $contentData = array('CaseNumber' => array('word' => 'Two','number' => 2));
  private $fetchData = array();
  
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
    $this->load->model("casetwomodel");
    $this->fetchData = (array('balance' => $this->casetwomodel->get_sumBallance()));
    
    $this->load->view('casewrapper',array_merge($this->contentData,array('fetchdata' => $this->fetchData)));
  }
  
  function checker(){
    $this->load->model("casetwomodel");
    $this->fetchData = (array('balance' => $this->casetwomodel->get_sumBallance()));
    
    $this->load->view('casewrapper',array_merge($this->contentData,array('fetchdata' => $this->fetchData)));
  }
  
  // Data Fetch
  public function DataFetch(){
    $this->load->model("casetwomodel");
    
    try{
      $data = $this->casetwomodel->get_entries();
      return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                        'data' => $data,
                        'role' => $this->session->role
                ))); 
    }catch(Exception $e){
      return $this->output
            ->set_content_type('application/json')
            ->set_status_header(500)
            ->set_output(json_encode(array(
                    'text' => 'Data Fetch Failed!',
                    'errorMessage' => "Please Contact Administrator"
            )));
    }
  }
  
  // Callback
  function balanceChecker()
  {
    $this->load->model("casetwomodel");
    
    $balance = $this->casetwomodel->get_sumBallance()->amount;
    $amount = $this->input->post('amount');
    
    if($this->input->post('type') == 'minus')
    {
      $amount = $amount * -1;
    }

    if($balance + $amount < 0 || $balance + $amount > 999999999)
    {
      log_message('error', 'Amount '.$this->input->post('type').' Balance more than 999,999,999 or less than 0!!');
      $this->form_validation->set_message('balanceChecker', 'Amount '.$this->input->post('type').' Balance more than 999,999,999 or less than 0!!');
      return FALSE;
    }
    return TRUE;
  }
  
  
  // Post Actions
  function makerDoCancel($id){
    if (!$this->input->is_ajax_request()) {
       exit('No direct script access allowed');
    }
    try{
      if($this->session->role != 'maker')
      {
        throw new Exception("Session Rejected");
      }
      
      //$this->form_validation->set_rules('id', 'ID', 'required|greater_than[0]|numeric');
      if (!is_numeric($id) || $id <= 0 || is_null($id))
      {
        throw new Exception("Validation Error");
      }
      else
      {
        $this->load->model('casetwomodel');
        if(!$this->casetwomodel->delete_entry($id))
        {
          throw new Exception("Database Issue");
        }
        else
        {
          return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                        'text' => 'Success Delete The Record!'
                )));
        }        
      }
      
    }catch(Exception $e){
      log_message('error',$e->getMessage());
      if($e->getMessage() == 'Validation Error')
      {        
        return $this->output
              ->set_content_type('application/json')
              ->set_status_header(400)
              ->set_output(json_encode(array(
                      'text' => 'Validation Broke!',
                      'errorMessage' => "Record Not Valid"
              )));
      }elseif($e->getMessage() == 'Database Issue'){
        return $this->output
              ->set_content_type('application/json')
              ->set_status_header(400)
              ->set_output(json_encode(array(
                      'text' => 'Failed to update to Database!',
                      'errorMessage' => "Please Contact Administrator"
              )));
      }elseif($e->getMessage() == 'Session Rejected')
      {
        return $this->output
              ->set_content_type('application/json')
              ->set_status_header(403)
              ->set_output(json_encode(array(
                      'text' => 'Forbidden!',
                      'errorMessage' => "Please re-login"
              )));
      }else{
        return $this->output
              ->set_content_type('application/json')
              ->set_status_header(500)
              ->set_output(json_encode(array(
                      'text' => 'General Error!',
                      'errorMessage' => "Please Contact Administrator"
              )));
      }
    }
  }
  
  function makerDoPost(){
    if (!$this->input->is_ajax_request()) {
       exit('No direct script access allowed');
    }
    try{
      if($this->session->role != 'maker')
      {
        throw new Exception("Session Rejected");
      }
      $rules = array(
          array(
                  'field' => 'type',
                  'label' => 'Type',
                  'rules' => 'required|in_list[plus,minus]'
          ),
          array(
                  'field' => 'amount',
                  'label' => 'Amount',
                  'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[999999999]|regex_match[/^[0-9]+$/]|callback_balanceChecker'
          ),
          array(
                  'field' => 'description',
                  'label' => 'Descriptions',
                  'rules' => 'required|max_length[50]|min_length[0]'
          )
      );
      
      $this->form_validation->set_rules($rules);
    
      if ($this->form_validation->run() == FALSE)
      {
        throw new Exception("Validation Error");
      }
      else
      {
        // Create or Update?
        $this->load->model('casetwomodel');

        if($this->input->post('id') <= 0)
        {
          if( $this->casetwomodel->insert_entry($this->input->post()) )
          {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                        'text' => 'Success Inserting to DB!'
                )));                  
          }else{
            throw new Exception("Database Issue");
          }  
        }else{
          $sanitizeData = $this->input->post();
          if(isset($sanitizeData['status']))
          {
            unset($sanitizeData['status']);
          }
          
          if( $this->casetwomodel->update_entry($this->input->post('id'),$this->input->post(),array('status' => 'Pending')) )
          {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                        'text' => 'Success Update The Record!'
                )));                  
          }else{
            throw new Exception("Database Issue");
          }  
        }
      }
    }catch(Exception $e){
      log_message('error',$e->getMessage());
      if($e->getMessage() == 'Validation Error')
      {        
        return $this->output
              ->set_content_type('application/json')
              ->set_status_header(400)
              ->set_output(json_encode(array(
                      'text' => 'Validation Broke!',
                      'errorMessage' => $this->form_validation->error_array()
              )));
      }elseif($e->getMessage() == 'Database Issue'){
        return $this->output
              ->set_content_type('application/json')
              ->set_status_header(400)
              ->set_output(json_encode(array(
                      'text' => 'Failed to update to Database!',
                      'errorMessage' => "Please Contact Administrator"
              )));
      }elseif($e->getMessage() == 'Session Rejected')
      {
        return $this->output
              ->set_content_type('application/json')
              ->set_status_header(403)
              ->set_output(json_encode(array(
                      'text' => 'Forbidden!',
                      'errorMessage' => "Please re-login"
              )));
      }else{
        return $this->output
              ->set_content_type('application/json')
              ->set_status_header(500)
              ->set_output(json_encode(array(
                      'text' => 'General Error!',
                      'errorMessage' => "Please Contact Administrator"
              )));
      }
    }    
  }
}
