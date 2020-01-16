<?php

class caseonemodel extends CI_Model {

        public $text1;
        public $text2;
        public $text3;
        public $text4;
        public $options;
        public $multipleoptions;
        public $alltext;
        
        private $dbName = "caseone";
        
        public function get_entries($where = array())
        {
          if(!empty($where))
          {
            $this->db-where($where);            
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
          $this->text1 = $insertData['text1'];
          $this->text2 = $insertData['text2'];
          $this->text3 = $insertData['text3'];
          $this->text4 = $insertData['text4'];
          $this->options = $insertData['options'];
          $this->multipleoptions = implode(",",$insertData['multipleoptions']);
          $this->alltext = $insertData['alltext'];               
        
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
            $this->db-where($where);            
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