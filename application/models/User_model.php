<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function get_users()
  {
    // $this->db->where('g.group_role !=', 0);
    // $this->db->where('g.group_role !=', 5);
    $this->db->where('u.removable IS NULL');
    $this->db->select('
      u.*,
      up.user_id,
      up.full_name,
      up.nic_no,
      up.phone,
      up.address,
      up.postcode,
      up.town_area,
      s.*,
      g.name as group_name,
      c.tag,
    ');
    $this->db->join('ci_users_profile up','up.user_id = u.id', 'left');
    $this->db->join('ci_state s','s.state_id = up.state_id', 'left');
    $this->db->join('ci_groups g','g.group_role = u.user_group', 'left');
    $this->db->join('cawangan c','c.id = u.cawangan_id', 'left');
    $this->db->order_by('user_group','asc');
    $this->db->order_by('user_id','desc');
    $this->query = $this->db->get('ci_users u');
    if ($this->query->num_rows() > 0) {
      foreach ($this->query->result_array() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
  }

  // public function get_cust()
  // {
  //   $this->db->where('g.group_role', 5);
  //   $this->db->where('u.removable IS NULL');
  //   $this->db->select('
  //     u.*,
  //     up.user_id,
  //     up.full_name,
  //     up.nic_no,
  //     up.phone,
  //     up.address,
  //     up.postcode,
  //     up.town_area,
  //     s.*,
  //     g.name as group_name
  //   ');
  //   $this->db->join('ci_users_profile up','up.user_id=u.id');
  //   $this->db->join('ci_state s','s.state_id=up.state_id');
  //   $this->db->join('ci_groups g','g.group_role=u.user_group');
  //   $this->db->order_by('u.id','desc');
  //   $this->query = $this->db->get('ci_users u');
  //   if ($this->query->num_rows() > 0) {
  //     foreach ($this->query->result_array() as $row) {
  //       $data[] = $row;
  //     }
  //     return $data;
  //   }
  //   return false;
  // }

  public function get_cust()
  {
    $this->db->select('
      c.*,
      c.state as cust_state,
      s.*
    ');
    $this->db->join('ci_state s','s.state_id = c.state', 'left');
    $this->db->order_by('c.id','desc');
    $this->query = $this->db->get('customer c');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_cust_detail($id)
  {
    $this->db->select('
      c.*,
      c.state as cust_state,
      s.*
    ');
    $this->db->where('c.id', $id);
    $this->db->join('ci_state s','s.state_id = c.state', 'left');
    $this->db->order_by('c.id','desc');
    $this->query = $this->db->get('customer c');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function count_cust()
  {
    $this->db->where('u.user_group','5');
    $this->db->where('u.removable IS NULL');
    $this->db->select('count(u.id) as cust');
    $this->db->join('ci_users_profile up','up.user_id=u.id');
    $this->db->join('ci_state s','s.state_id=up.state_id');
    $this->db->join('ci_groups g','g.group_role=u.user_group');
    $this->query = $this->db->get('ci_users u');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function get_profile($user_id = '')
  {
    if ($user_id) {
      $this->db->where('u.id', $user_id);
    }
    $this->db->where('removable IS NULL');
    $this->db->select('
      u.*,
      up.user_id,
      up.full_name,
      up.nic_no,
      up.phone,
      up.address,
      up.postcode,
      up.town_area,
      s.*,
      g.name as group_name,
      c.tag,
      c.id as cawangan_id,
    ');
    $this->db->join('ci_users_profile up','up.user_id = u.id', 'left');
    $this->db->join('ci_state s','s.state_id = up.state_id', 'left');
    $this->db->join('ci_groups g','g.group_role = u.user_group', 'left');
    $this->db->join('cawangan c','c.id = u.cawangan_id', 'left');
    $this->query = $this->db->get('ci_users u');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function state_list(){
    $this->query  = $this->db->get('ci_state')->result_array();
    if(is_array( $this->query ) && count( $this->query ) > 0)
    {
      $return[''] = '-- PILIH NEGERI --';
      foreach($this->query as $row)
      {
        $return[$row['state_id']] = $row['state'];
      }
      return $return;
    }
  }

  public function state($state_id=''){
    if($state_id){
      $this->db->where('state_id',$state_id);
      $this->query = $this->db->get('ci_state');
      if ($this->query->num_rows() > 0) {
        return $this->query->row_array();
      }
    }else{
      $this->query = $this->db->get('ci_state');
      if ($this->query->num_rows() > 0) {
        return $this->query->result_array();
      }
    }
  }

  public function get_bank_list(){
    $this->query  = $this->db->get('ci_list_bank')->result_array();
    if(is_array( $this->query ) && count( $this->query ) > 0)
    {
      $return[''] = '-- PILIH BANK --';
      foreach($this->query as $row)
      {
        $return[$row['bank_id']] = $row['bank_name'];
      }
      return $return;
    }
  }

  public function get_username()//check if username same
  {
    $this->db->where('removable IS NULL');
    $this->db->select('count(u.email) as count');
    $this->db->where('u.username', $email);
    $this->query = $this->db->get('ci_users u');
    if ($this->query->num_rows() > 0) {
      return 1;
    }else{
      return 0;
    }

  }

}
