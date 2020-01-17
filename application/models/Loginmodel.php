<?php

class loginmodel extends CI_Model {

        public $candidateName;
        public $makerUsername;
        public $checkerUsername;
        public $isLogin;
        public $lastLogin;
        public $createdDate;
        
        private $dbName = "users";
        
        public function checkUsername($username)
        {
          $this->db->where('makerUsername', $username);
          $this->db->or_where('checkerUsername', $username);
          $query = $this->db->get($this->dbName);
          return $query->result();
        }
                
        public function get_entries($where = array())
        {
          if(!empty($where))
          {
            $this->db->where($where);            
          }
          $query = $this->db->get($this->dbName);
          return $query->result();
        }
        
        public function get_one_entries($where = array())
        {
          if(!empty($where))
          {
            $this->db->where($where);            
          }
          $query = $this->db->get($this->dbName,1);
          return $query->row();
        }
        
        public function get_limited_entries($entires = 0)
        {
                $query = $this->db->get($this->dbName,$entires);
                return $query->result();
        }

        public function insert_entry($insertData)
        {
          $this->candidateName = $this->session->candidateName;
          $this->makerUsername = $insertData['makerUsername'];
          $this->checkerUsername = $insertData['checkerUsername'];
          $this->isLogin = $insertData['isLogin'];
          $this->lastLogin = $insertData['lastLogin'];
          $this->createdDate = $insertData['createdDate'];             
        
          $this->db->trans_start();
          $this->db->insert($this->dbName, $this);
          $this->db->trans_complete();

          if ($this->db->trans_status() === FALSE)
          {
            return FALSE;
          }
          
          return TRUE;
        }

        public function update_entry($id,$data,$where = array())
        {          
          $this->db->trans_start();
          if(!empty($where))
          {
            $this->db->where($where);            
          }
          $this->db->update($this->dbName, $data, array('id' => $id));
          $this->db->trans_complete();

          if ($this->db->trans_status() === FALSE)
          {
            return FALSE;
          }          
          return TRUE;
        }

}