<?php

class Casetwomodel extends CI_Model {

        public $type;
        public $amount;
        public $description;
        public $status;
        public $created_date;
        public $modified_date;
        
        private $dbName = "casetwo";
        
        public function get_sumBallance()
        {
          $this->db->where(array('type' => 'plus','status' => 'Approved' ));
          $this->db->select_sum('amount');
          $query = $this->db->get($this->dbName);
          return $query->row();
        }
        
        public function get_entries($where = array())
        {
          if(!empty($where))
          {
            $this->db->where($where);            
          }
          $this->db->order_by('created_date', 'DESC');
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
          $this->type = $insertData['type'];
          $this->amount = $insertData['amount'];
          $this->description = $insertData['description'];           
          $this->status = 'Pending';
          
          $this->db->trans_start();
          $this->db->insert($this->dbName, $this);
          $this->db->trans_complete();

          if ($this->db->trans_status() === FALSE)
          {
            log_message('error',$this->db->error());
            return FALSE;
          }
          
          return TRUE;
        }

        public function update_entry($id,$data,$where = array())
        {
          unset($data['id']);
          $this->db->trans_start();
          if(!empty($where))
          {
            $this->db->where($where);            
          }
          $this->db->update($this->dbName, $data, array('id' => $id));
          $this->db->trans_complete();

          if ($this->db->trans_status() === FALSE)
          {
            log_message('error',$this->db->error());
            return FALSE;
          }          
          return TRUE;
        }
        
        public function delete_entry($id)
        {
          $this->db->trans_start();
          $this->db->delete($this->dbName, array('id' => $id,'status' => 'pending'));
          $this->db->trans_complete();

          if ($this->db->trans_status() === FALSE)
          {
            log_message('error',$this->db->error());
            return FALSE;
          }          
          return TRUE;
        }

}