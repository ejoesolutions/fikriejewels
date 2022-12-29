<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More

  }

  public function get_buy()
  {
    // $this->db->where('ci_buy.id', $buy_id);
    // $this->db->select('
    //   ci_users_profile.address as address
    // ');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_buy.cust_id');
    $this->query = $this->db->get('ci_buy');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }

    return false;
  }

  public function all_buy_products($buy_id='')
  {
    if ($buy_id) {
      $this->db->where('buy_id', $buy_id);
    }

    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_buy.created_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_buy.created_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_buy.created_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_buy.created_date)',$this->input->post('date_year'));
      }
    }

    // if ($this->data['user_profile']['user_group'] == -1) {
    //   $this->db->where('DATE(ci_buy.created_date)',date('Y-m-d'));
    // }

    $this->db->select('
      ci_buy.*,
      customer.name as cust,
      ci_buy_product.*,
      cup.username as staf_name,
      ci_price_capital.*,
      cawangan.tag
    ');
    $this->db->join('ci_buy','ci_buy.id = ci_buy_product.buy_id', 'left');
    $this->db->join('customer','customer.id = ci_buy.cust_id', 'left');
    $this->db->join('ci_users cup','cup.id = ci_buy.seller', 'left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_buy_product.mutu_id', 'left');
    $this->db->join('cawangan','cawangan.id = ci_buy.cawangan_id', 'left');
    $this->db->order_by('ci_buy_product.id', 'desc');
    $this->query = $this->db->get('ci_buy_product');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  // START All list buy query -------------------------------------------------------

  public function RowListBuy($postData){
    $this->_get_query_list_buy($postData);
    if($postData['length'] != -1){
      $this->db->limit($postData['length'], $postData['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  /*
  * Count all records
  */
  public function countAllListBuy(){
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cb.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }
    $this->db->join('ci_buy cb','cb.id = cbp.buy_id', 'left');
    $this->db->from('ci_buy_product cbp');
    return $this->db->count_all_results();
  }
  
  /*
  * Count records based on the filter params
  * @param $_POST filter data based on the posted parameters
  */
  public function countFilteredListBuy($postData){
    $this->_get_query_list_buy($postData);
    $query = $this->db->get();
    return $query->num_rows();
  }
  
  /*
  * Perform the SQL queries needed for an server-side processing requested
  * @param $_POST filter data based on the posted parameters
  */
  private function _get_query_list_buy($postData){
    $this->column_order = array(null,'cus.name', 'cup.username', 'c.tag', 'cbp.berat', 'cbp.serial_number' , 'cbp.harga', 'cb.created_date');
    $this->column_search = array('cus.name', 'cup.username', 'c.tag', 'cbp.berat', 'cbp.serial_number', 'cbp.harga', 'cb.created_date');
    $this->order = array('cbp.id' => 'desc');

    if ($_POST['choose']==1) {
      if ($_POST['dateStart']) {
        $this->db->where('DATE(cb.created_date) >=', date('Y-m-d', strtotime($_POST['dateStart'])));
      }
      if ($_POST['dateEnd']) {
        $this->db->where('DATE(cb.created_date) <=', date('Y-m-d', strtotime($_POST['dateEnd'])));
      }
    }

    if ($_POST['choose']==2) {
      if ($_POST['months']) {
        $this->db->where('MONTH(cb.created_date)', $_POST['months']);
      }
      if ($_POST['years']) {
        $this->db->where('YEAR(cb.created_date)', $_POST['years']);
      }
    }

    // if ($_POST['cawangan']) {
    //   $this->db->where('cb.cawangan_id', $_POST['cawangan']);
    // }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cb.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }

    $this->db->select('
      cb.*,
      cus.name as cust,
      cbp.*,
      cup.username as staf_name,
      cpp.*,
      c.tag
    ');
    $this->db->join('ci_buy cb','cb.id = cbp.buy_id', 'left');
    $this->db->join('customer cus','cus.id = cb.cust_id', 'left');
    $this->db->join('ci_users cup','cup.id = cbp.staf_id', 'left');
    $this->db->join('ci_price_capital cpp','cpp.row_id = cbp.mutu_id', 'left');
    $this->db->join('cawangan c','c.id = cb.cawangan_id', 'left');
    $this->db->from('ci_buy_product cbp');
    $i = 0;
    // loop searchable columns 
    foreach($this->column_search as $item){
      // if datatable send POST for search
      if($postData['search']['value']){
        // first loop
        if($i===0){
          // open bracket
          $this->db->group_start();
          $this->db->like($item, $postData['search']['value']);
        }else{
          $this->db->or_like($item, $postData['search']['value']);
        }
        
        // last loop
        if(count($this->column_search) - 1 == $i){
          // close bracket
          $this->db->group_end();
        }
      }
      $i++;
    }
      
    if(isset($postData['order'])){
      $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
    }else if(isset($this->order)){
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  // END All list buy query -------------------------------------------------------

  public function count_total_buy()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_buy.created_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_buy.created_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_buy.created_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_buy.created_date)',$this->input->post('date_year'));
      }
    }

    if ($this->data['user_profile']['user_group'] == 3) {
      $this->db->where('DATE(ci_buy.created_date)',date('Y-m-d'));
    }

    $this->db->select('
      count(ci_buy_product.id) as total,
    ');
    $this->db->join('ci_buy','ci_buy.id=ci_buy_product.buy_id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_buy.cust_id');
    $this->db->join('ci_users_profile cup','cup.user_id=ci_buy.seller');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_buy_product.mutu_id');
    $this->db->order_by('ci_buy_product.id', 'desc');
    $this->query = $this->db->get('ci_buy_product');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function count_weight()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_buy.created_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_buy.created_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_buy.created_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_buy.created_date)',$this->input->post('date_year'));
      }
    }

    if ($this->data['user_profile']['user_group'] == 3) {
      $this->db->where('DATE(ci_buy.created_date)',date('Y-m-d'));
    }

    $this->db->select('
      sum(ci_buy_product.berat) as total,
    ');
    $this->db->join('ci_buy','ci_buy.id=ci_buy_product.buy_id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_buy.cust_id');
    $this->db->join('ci_users_profile cup','cup.user_id=ci_buy.seller');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_buy_product.mutu_id');
    $this->db->order_by('ci_buy_product.id', 'desc');
    $this->query = $this->db->get('ci_buy_product');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function count_price()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_buy.created_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_buy.created_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_buy.created_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_buy.created_date)',$this->input->post('date_year'));
      }
    }

    if ($this->data['user_profile']['user_group'] == 3) {
      $this->db->where('DATE(ci_buy.created_date)',date('Y-m-d'));
    }

    $this->db->select('
      sum(ci_buy_product.harga) as total,
    ');
    $this->db->join('ci_buy','ci_buy.id=ci_buy_product.buy_id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_buy.cust_id');
    $this->db->join('ci_users_profile cup','cup.user_id=ci_buy.seller');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_buy_product.mutu_id');
    $this->db->order_by('ci_buy_product.id', 'desc');
    $this->query = $this->db->get('ci_buy_product');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

}
