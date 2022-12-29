<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function get_order($order_id)
  {
    $this->db->where('ci_orders.order_id', $order_id);
    $this->db->select('
      LPAD(ci_orders.order_id,8,0) as order_no,
      LPAD(ci_dn.dn_id,8,0) as dn_no,
      ci_orders.*,
      customer.id as cust_id,
      customer.name as cust_name,
      customer.phone as cust_phone,
      customer.kp as cust_kp,
      customer.address as cust_address,
      customer.state as cust_state,
      user_profile2.username AS staff,
      cawangan.*,
      ci_state.state
    ');
    $this->db->join('customer','customer.id = ci_orders.cust_id', 'left');
    $this->db->join('ci_users AS user_profile2','ci_orders.seller = user_profile2.id', 'left');
    $this->db->join('cawangan','cawangan.id = ci_orders.cawangan_id', 'left');
    $this->db->join('ci_state','ci_state.state_id = cawangan.negeri', 'left');
    $this->db->join('ci_dn','ci_dn.order_id = ci_orders.order_id', 'left');
    $this->db->order_by('ci_orders.order_id','desc');
    $this->query = $this->db->get('ci_orders');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function get_order_summary()
  {
    //carian tarikh
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(co.created_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(co.created_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      //carian bulan
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(co.created_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(co.created_date)',$this->input->post('date_year'));
      }
    }

    $this->db->select('
      SUM(co.paid_total) as total
    ');
    // $this->db->join('customer cus','cus.id = co.cust_id', 'left');
    // $this->db->join('ci_users cu','cu.id = co.seller', 'left');
    // $this->db->join('ci_order_items coi','coi.order_id = co.order_id', 'left');
    $this->db->join('cawangan c','c.id = co.cawangan_id', 'left');
    $this->query = $this->db->get('ci_orders co');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function get_buy($order_id='')
  {
    $this->db->where('ci_buy.id', $order_id);
    $this->db->select('
      LPAD(ci_buy.id,8,0) as no_id,
      ci_buy.id as bil_id,
      ci_buy.*,
      customer.name AS cust_name,
      customer.kp AS cust_kp,
      customer.phone AS cust_phone,
      customer.address AS cust_address,
      ci_state.state AS cust_state,
      cup.username AS staf_name,
      cawangan.*,
      state.state,
    ');
    $this->db->join('customer','customer.id = ci_buy.cust_id', 'left');
    $this->db->join('ci_users cup','cup.id = ci_buy.seller', 'left');
    $this->db->join('ci_state','ci_state.state_id = customer.state', 'left');
    $this->db->join('cawangan','cawangan.id = ci_buy.cawangan_id', 'left');
    $this->db->join('ci_state state','state.state_id = cawangan.negeri', 'left');
    $this->db->order_by('ci_buy.id','desc');
    $this->query = $this->db->get('ci_buy');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function get_book($v_id='')
  {
    $this->db->where('ci_booking.variant_id', $v_id);
    $this->db->select('
      LPAD(ci_booking.id,8,0) as book_no,
      ci_booking.*,
      cv.*,
      cp.*,
      pc.*,
      customer.id as cust_id,
      customer.name as cust_name,
      customer.phone as cust_phone,
      customer.kp as cust_kp,
      customer.address as cust_address,
      customer.state as cust_state,
      user_profile2.username AS staf_name,
      ci_state.state AS state,
      cawangan.*
    ');
    $this->db->join('ci_variants as cv','cv.variant_id = ci_booking.variant_id', 'left');
    $this->db->join('ci_variants_sta as cvs','cvs.variants_id = ci_booking.variant_id', 'left');
    $this->db->join('ci_products as cp','cp.product_id = cv.product_id', 'left');
    $this->db->join('ci_price_capital as pc','pc.row_id = cp.mutu_id', 'left');
    $this->db->join('customer','customer.id = ci_booking.cust_id', 'left');
    $this->db->join('ci_state','ci_state.state_id = customer.state', 'left');
    $this->db->join('ci_users user_profile2','user_profile2.id = cvs.staf_id', 'left');
    $this->db->join('cawangan','cawangan.id = cp.cawangan_id', 'left');
    $this->db->order_by('ci_booking.id','desc');
    $this->query = $this->db->get('ci_booking');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function get_repair($v_id='')
  {
    $this->db->where('ci_repair.variant_id', $v_id);
    $this->db->select('
      LPAD(ci_repair.id,8,0) as repair_no,
      ci_repair.*,
      cv.*,
      cp.*,
      pc.*,
      ra.*,
      customer.id as cust_id,
      customer.name as cust_name,
      customer.phone as cust_phone,
      customer.kp as cust_kp,
      customer.address as cust_address,
      customer.state as cust_state,
      user_profile2.username as staf_name,
      cawangan.*,
      ci_state.state,
    ');
    $this->db->join('ci_variants as cv','cv.variant_id = ci_repair.variant_id', 'left');
    $this->db->join('ci_repair_add as ra','ra.variant_id = ci_repair.variant_id', 'left');
    $this->db->join('ci_products as cp','cp.product_id = cv.product_id', 'left');
    $this->db->join('ci_price_capital as pc','pc.row_id = cp.mutu_id', 'left');
    $this->db->join('customer','customer.id = ci_repair.cust_id', 'left');
    $this->db->join('ci_users AS user_profile2','user_profile2.id = ci_repair.staf_id', 'left');
    $this->db->join('cawangan','cawangan.id = cp.cawangan_id', 'left');
    $this->db->join('ci_state','ci_state.state_id = cawangan.negeri', 'left');
    $this->db->order_by('ci_repair.id','desc');
    $this->query = $this->db->get('ci_repair');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function count_orders($cawangan_id)
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }
    // elseif ($this->data['user_profile']['user_group'] == 1) {
    //   $this->db->where('co.vip', 1);
    // }
    // $this->db->where('co.kategori !=', 3);
    $this->db->where('co.cawangan_id', $cawangan_id);
    $this->db->where('YEAR(co.created_date)',date("Y"));
    $this->db->where('MONTH(co.created_date)',date("m"));
    $this->db->select('
      count(co.order_id) as count,
    ');
    $this->query = $this->db->get('ci_orders co');
    return $this->query->row()->count;
  }

  public function payment_orders($cawangan_id)
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }
    // elseif ($this->data['user_profile']['user_group'] == 1) {
      // $this->db->where('co.vip', NULL);
      // $this->db->where('co.vip', 1);
    // }
    $this->db->where('co.cawangan_id', $cawangan_id);
    $this->db->where('YEAR(co.created_date)',date("Y"));
    $this->db->where('MONTH(co.created_date)',date("m"));
    $this->db->where('co.kategori IS NOT NULL');
    $this->db->select('
      sum(co.paid_total) as total,
    ');
    $this->query = $this->db->get('ci_orders co');
    return $this->query->row()->total;
  }

  public function payment_orders_hr()
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      // $this->db->where('co.vip', NULL);
      $this->db->where('co.vip', 1);
    }
    $this->db->where('DATE(co.created_date)',date('Y-m-d'));
    $this->db->where('co.kategori IS NOT NULL');
    $this->db->select('
      sum(co.paid_total) as payment_count,
    ');
    $this->query = $this->db->get('ci_orders co');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function count_orders_hr()
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      // $this->db->where('co.vip', NULL);
      $this->db->where('co.vip', 1);
    }
    $this->db->where('co.kategori !=', 3);
    $this->db->where('DATE(co.created_date)',date('Y-m-d'));
    $this->db->select('
      count(co.order_id) as orders_count,
    ');
    $this->query = $this->db->get('ci_orders co');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function payment_orders_lm()
  {
    if ($this->data['user_profile']['user_group'] != 1 || $this->data['user_profile']['user_group'] != 0 && $this->data['user_profile']['user_group'] != 3) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      // $this->db->where('co.vip', NULL);
      $this->db->where('co.vip', 1);
    }
    $this->db->where('YEAR(co.created_date)',date("Y"));
    $this->db->where('MONTH(co.created_date)',date("m"));
    $this->db->where('co.kategori IS NOT NULL');
    $this->db->select('
      sum(co.paid_total) as payment_count,
    ');
    $this->query = $this->db->get('ci_orders co');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function payment_orders_lm_hr()
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      $this->db->where('co.vip', 1);
      // $this->db->where('co.vip', NULL);
    }
    $this->db->where('DATE(co.created_date)',date('Y-m-d'));
    $this->db->where('co.kategori IS NOT NULL');
    $this->db->select('
      sum(co.paid_total) as payment_count,
    ');
    $this->query = $this->db->get('ci_orders co');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function count_orders_lm()
  {
    if ($this->data['user_profile']['user_group'] != 1) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      $this->db->where('co.vip', 1);
      // $this->db->where('co.vip', NULL);
    }
    $this->db->where('YEAR(co.created_date)',date("Y"));
    $this->db->where('MONTH(co.created_date)',date("m") - 1);
    $this->db->select('
      count(co.order_id) as orders_count,
    ');
    $this->query = $this->db->get('ci_orders co');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function count_orders_lm_hr()
  {
    if ($this->data['user_profile']['user_group'] != 1) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      $this->db->where('co.vip', 1);
      // $this->db->where('co.vip', NULL);
    }
    $this->db->where('DATE(co.created_date)',date('Y-m-d'));
    $this->db->select('
      count(co.order_id) as orders_count,
    ');
    $this->query = $this->db->get('ci_orders co');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function get_all_orders($date="")
  {
    if ($date == 1) {
      $this->db->where('DATE(co.created_date)',date('Y-m-d'));
    }elseif ($date == 2) {
      $this->db->where('MONTH(co.created_date)',date('m'));
    }  

    if ($this->input->post('carian') == 1 || $this->input->post('carian') == 4) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(co.created_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(co.created_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(co.created_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(co.created_date)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('category') && $this->input->post('category') != 9) {
      $this->db->where('co.kategori',$this->input->post('category'));
    }
    elseif ($this->input->post('category') == 9) {
      $this->db->where('order_items.order_category',$this->input->post('category'));
    }

    if ($this->input->post('status') == 1) {
      $this->db->group_start();
      $this->db->where('co.sold',$this->input->post('status'));
      // $this->db->where('co.kategori !=', NULL);
      $this->db->or_where('co.kategori',3);
      $this->db->group_end();
    }elseif ($this->input->post('status') == 2) {
      $this->db->where('co.sold', NULL);
      $this->db->where('co.kategori !=',3);
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      $this->db->where('co.vip', 1);
    }

    if ($this->input->post('staf_id')) {
      $this->db->where('co.seller',$this->input->post('staf_id'));
    }

    $this->db->select('
      LPAD(co.order_id,8,0) as order_no,
      co.*,
      customer.name as cust,
      order_items.subtotal,
      order_items.order_category,
      order_items.variant_id as repair_id,
      user_profile2.username as staf,
      LPAD(dn.dn_id,8,0) as dn_number,
      cawangan.tag as cawangan,
    ');
    $this->db->join('customer','customer.id = co.cust_id', 'left');
    $this->db->join('ci_users AS user_profile2','user_profile2.id = co.seller', 'left');
    $this->db->join('ci_order_items AS order_items','order_items.order_id = co.order_id', 'left');
    $this->db->join('ci_products AS products','products.product_id = order_items.product_id', 'left');
    $this->db->join('ci_dn AS dn','dn.order_id = co.order_id', 'left');
    $this->db->join('cawangan','cawangan.id = co.cawangan_id', 'left');
    $this->db->group_by('co.order_id'); 
    $this->db->order_by('co.order_id','desc');
    $this->query = $this->db->get('ci_orders co');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }

    return false;
  }

  // START All order list query -------------------------------------------------------

  public function RowListOrder($postData){
    $this->_get_query_list_order($postData);
    if($postData['length'] != -1){
      $this->db->limit($postData['length'], $postData['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  /*
  * Count all records
  */
  public function countAllListOrder(){
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }
    $this->db->from('ci_orders co');
    return $this->db->count_all_results();
  }
  
  /*
  * Count records based on the filter params
  * @param $_POST filter data based on the posted parameters
  */
  public function countFilteredListOrder($postData){
    $this->_get_query_list_order($postData);
    $query = $this->db->get();
    return $query->num_rows();
  }
  
  /*
  * Perform the SQL queries needed for an server-side processing requested
  * @param $_POST filter data based on the posted parameters
  */
  private function _get_query_list_order($postData){
    $this->column_order = array(null,'co.order_no','cus.name','cu.username','c.tag','co.paid_total');
    $this->column_search = array('co.order_no','cus.name','cu.username','c.tag','co.paid_total');
    $this->order = array('co.order_id' => 'desc');

    if ($_POST['choose']==1) {
      if ($_POST['dateStart']) {
        $this->db->where('DATE(co.created_date) >=', date('Y-m-d', strtotime($_POST['dateStart'])));
      }
      if ($_POST['dateEnd']) {
        $this->db->where('DATE(co.created_date) <=', date('Y-m-d', strtotime($_POST['dateEnd'])));
      }
      if ($_POST['category']) {
        $this->db->where('co.kategori', $_POST['category']);
      }
      if ($_POST['status']) {
        $this->db->where('co.sold', $_POST['status']);
      }
    }

    if ($_POST['choose']==2) {
      if ($_POST['months']) {
        $this->db->where('MONTH(co.created_date)', $_POST['months']);
      }
      if ($_POST['years']) {
        $this->db->where('YEAR(co.created_date)', $_POST['years']);
      }
      if ($_POST['category']) {
        $this->db->where('co.kategori', $_POST['category']);
      }
      if ($_POST['status']) {
        $this->db->where('co.sold', $_POST['status']);
      }
    }

    if ($_POST['choose']==3) {
      if ($_POST['category']) {
        $this->db->where('co.kategori', $_POST['category']);
      }
      if ($_POST['status'] == 1 || $_POST['status'] == 2) {
        $this->db->where('co.sold', $_POST['status']);
      }elseif ($_POST['status']) {
        $this->db->where('co.sold', NULL);
      }
    }

    if ($_POST['choose']==4) {
      if ($_POST['staf_id']) {
        $this->db->where('co.seller', $_POST['staf_id']);
      }
      if ($_POST['dateStart']) {
        $this->db->where('DATE(co.created_date) >=', date('Y-m-d', strtotime($_POST['dateStart'])));
      }
      if ($_POST['dateEnd']) {
        $this->db->where('DATE(co.created_date) <=', date('Y-m-d', strtotime($_POST['dateEnd'])));
      }
      if ($_POST['category']) {
        $this->db->where('co.kategori', $_POST['category']);
      }
      if ($_POST['status']) {
        $this->db->where('co.sold', $_POST['status']);
      }
    }

    // if ($_POST['cawangan']) {
    //   $this->db->where('co.cawangan_id', $_POST['cawangan']);
    // }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }

    $this->db->select('
      co.*,
      cus.name as cust,
      coi.subtotal,
      coi.order_category,
      coi.variant_id as repair_id,
      cu.username as staf,
      c.tag as cawangan,
    ');
    $this->db->join('customer cus','cus.id = co.cust_id', 'left');
    $this->db->join('ci_users cu','cu.id = co.seller', 'left');
    $this->db->join('ci_order_items coi','coi.order_id = co.order_id', 'left');
    $this->db->join('cawangan c','c.id = co.cawangan_id', 'left');
    $this->db->group_by('co.order_id');
    $this->db->from('ci_orders co');
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

  // END All list order query -------------------------------------------------------

  public function search_orders()
  {
    if ($this->input->post('search')) {

      if ($this->data['user_profile']['user_group'] == 2) {
        $this->db->where('co.cawangan_id', $this->data['user_profile']['cawangan_id']);
      }

      $this->db->where('co.order_no', $this->input->post('search'));
      $this->db->select('
        co.*,
        cus.name as cust,
        coi.subtotal,
        coi.order_category,
        coi.variant_id as repair_id,
        cu.username as staf,
        c.tag as cawangan,
      ');
      $this->db->join('customer cus','cus.id = co.cust_id', 'left');
      $this->db->join('ci_users cu','cu.id = co.seller', 'left');
      $this->db->join('ci_order_items coi','coi.order_id = co.order_id', 'left');
      $this->db->join('cawangan c','c.id = co.cawangan_id', 'left');
      $this->db->order_by('co.order_id','desc');
      $this->query = $this->db->get('ci_orders co');
      if ($this->query->num_rows() > 0) {
        return $this->query->result_array();
      }

      return false;
    }
  }
  
  public function count_dn()
  {
    $this->db->where('dn.dn_id !=',NULL);
    $this->db->select('count(dn.id) as dn_last');
    $this->query = $this->db->get('ci_dn dn');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function get_dash_orders()
  {
    // if ($this->data['user_profile']['user_group'] == 2) {
    //   $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    // }elseif ($this->data['user_profile']['user_group'] == 1) {
    //   $this->db->where('co.vip', 1);
    // }
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }
    $this->db->select('
      co.*,
      cus.name as cust,
      coi.subtotal,
      coi.order_category,
      coi.variant_id as repair_id,
      cu.username as staf,
      c.tag as cawangan,
    ');
    $this->db->join('customer cus','cus.id = co.cust_id', 'left');
    $this->db->join('ci_users cu','cu.id = co.seller', 'left');
    $this->db->join('ci_order_items coi','coi.order_id = co.order_id', 'left');
    $this->db->join('cawangan c','c.id = co.cawangan_id', 'left');
    $this->db->group_by('co.order_id'); 
    $this->db->order_by('co.order_id','desc');
    $this->query = $this->db->get('ci_orders co', 5);
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_payment_repair($cawangan_id)
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('co.seller', $this->data['user_profile']['user_id']);
    }
    if ($cawangan_id) {
      $this->db->where('co.cawangan_id', $cawangan_id);
    }
    $this->db->where('coi.order_category', 9);
    $this->db->select('
      SUM(coi.subtotal) as total
    ');
    $this->db->join('ci_order_items coi', 'coi.order_id = co.order_id', 'left');
    $this->query = $this->db->get('ci_orders co');
    return $this->query->row()->total;
  }

  public function get_all_book()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cb.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cb.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cb.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cb.tarikh)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('category') == 3) {
      $this->db->where('cv.v_status', 3);
    }elseif ($this->input->post('category') == 9) {
      $this->db->where('cv.v_status', 9);
    }elseif ($this->input->post('category') == 1) {
      $this->db->where('cv.v_status', 1);
    }elseif ($this->input->post('category') == 6) {
      $this->db->where('cv.v_status', 6);
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cp.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }

    $this->db->select('
      cb.*,
      cv.*,
      cp.*,
      pc.*,
      cvs.order_id as order_link,
      customer.name AS full_name,
      ci_book_shop.*,
      user_profile2.username AS staf_name,
      cawangan.tag,
    ');
    $this->db->join('ci_variants as cv','cv.variant_id = cb.variant_id', 'left');
    $this->db->join('ci_products as cp','cp.product_id = cv.product_id', 'left');
    $this->db->join('ci_variants_sta as cvs','cvs.variants_id = cb.variant_id', 'left');
    $this->db->join('ci_price_capital as pc','pc.row_id = cp.mutu_id', 'left');
    $this->db->join('customer','customer.id = cb.cust_id', 'left');
    $this->db->join('ci_users AS user_profile2','user_profile2.id = cvs.staf_id', 'left');
    $this->db->join('ci_book_shop','ci_book_shop.variant_id = cb.variant_id', 'left');
    $this->db->join('cawangan','cawangan.id = cp.cawangan_id', 'left');
    $this->db->order_by('cv.v_status','desc');
    $this->query = $this->db->get('ci_booking cb');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_all_repair()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cr.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cr.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cr.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cr.tarikh)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('category') == 7) {
      $this->db->where('cv.v_status', 7);
    }elseif ($this->input->post('category') == 10) {
      $this->db->where('cv.v_status', 10);
    }elseif ($this->input->post('category') == 3) {
      $this->db->where('cv.v_status', 3);
    }elseif ($this->input->post('category') == 1) {
      $this->db->where('cv.v_status', 1);
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cp.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }

    $this->db->select('
      cr.id as book_id,
      cr.*,
      cv.*,
      cp.*,
      pc.*,
      ra.*,
      customer.id as cust_id,
      customer.name as full_name,
      user_profile2.username AS staf_name,
      cawangan.tag,
    ');
    $this->db->join('ci_variants as cv','cv.variant_id = cr.variant_id', 'left');
    $this->db->join('ci_repair_add as ra','ra.variant_id = cr.variant_id', 'left');
    $this->db->join('ci_products as cp','cp.product_id = cv.product_id', 'left');
    $this->db->join('ci_price_capital as pc','pc.row_id = cp.mutu_id', 'left');
    $this->db->join('customer','customer.id = cr.cust_id', 'left');
    $this->db->join('cawangan','cawangan.id = cp.cawangan_id', 'left');
    $this->db->join('ci_users as user_profile2','user_profile2.id = cr.staf_id', 'left');
    $this->db->order_by('cv.v_status','desc');
    $this->query = $this->db->get('ci_repair cr');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }


  public function get_resit($order_id)
  {
    $this->db->where('ci_resit.order_id', $order_id);
    $this->db->order_by('id','desc');
    $this->db->select('
    ci_resit.*
    ');
    $this->query = $this->db->get('ci_resit');
    if ($this->query->num_rows() > 0) {
      foreach ($this->query->result_array() as $row) {
        $data[] = $row;
      }
      return $data;
    }

    return false;
  }

  public function book_shop()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cvs.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cvs.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cvs.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cvs.tarikh)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('category') == 3) {
      $this->db->where('cv.v_status', 3); 
    }elseif ($this->input->post('category') == 1) {
      $this->db->where('cv.v_status', 1); 
    }elseif ($this->input->post('category') == 8) {
      $this->db->where('cv.v_status', 8); 
    }elseif ($this->input->post('category') == 5) {
      $this->db->where('cv.v_status', 5);
    }else {
      $this->db->group_start();
      $this->db->where('cv.v_status', 5);
      $this->db->or_where('cv.v_status', 8); //lepas tekan link produk masuk
      $this->db->or_where('cv.v_status', 3); //dah beli tp x bayar penuh lagi
      $this->db->or_where('cv.v_status', 1); //dijual dan bayar habis
      $this->db->or_where('cv.v_status', 0); //dijual dan bayar habis
      $this->db->group_end();
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cp.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }
    
    $this->db->select('
      cvs.harga as sta_harga,
      cvs.variants_id as id,
      cvs.tarikh as sta_tarikh,
      cvs.nota as sta_nota,
      cvs.order_id as order_link,
      cv.*,
      cp.*,
      pc.*,
      ci_book_shop.*,
      cust.name as cust,
      user_profile2.username AS staf_name,
      c.tag
    ');
    $this->db->join('ci_variants as cv','cv.variant_id = cvs.variants_id', 'left');
    $this->db->join('ci_products as cp','cp.product_id = cv.product_id', 'left');
    $this->db->join('ci_price_capital as pc','pc.row_id = cp.mutu_id', 'left');
    $this->db->join('customer cust','cust.id = cvs.cust_id', 'left');
    $this->db->join('ci_users user_profile2','user_profile2.id = cvs.staf_id', 'left');
    $this->db->join('ci_book_shop','ci_book_shop.variant_id = cvs.variants_id');
    $this->db->join('cawangan c','c.id = cp.cawangan_id');
    $this->db->order_by('cv.v_status', 'desc');
    $this->query = $this->db->get('ci_variants_sta cvs');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_resit_buy($order_id='')
  {
    $this->db->where('ci_transaksi.buy_id', $order_id);
    $this->query = $this->db->get('ci_transaksi');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  // public function get_resit_sum($order_id)
  // {
  //   $this->db->select_sum('jumlah');
  //   $this->query = $this->db->get('ci_resit');
  //   if ($this->query->num_rows() > 0) {
  //     foreach ($this->query->result_array() as $row) {
  //       $data[] = $row;
  //     }
  //     return $data;
  //   }

  //   return false;
  // }

  public function get_items($order_id = '')
  {
    if ($order_id) {
      $this->db->where('ci_order_items.order_id', $order_id);
    }
    $this->db->select('
      ci_order_items.*,
      ci_products.*,
      ci_variants_sta.diskaun,
      ci_variants_sta.harga as deposit,
      ci_category.category_name,
      ci_variants.variant_id,
      ci_variants.v_weight,
      ci_variants.v_size,
      ci_variants.v_length,
      ci_variants.v_width,
      ci_variants.v_sn,
      ci_variants.v_sb,
      ci_variants.v_pay,
      ci_variants.v_kod,
      ci_variants.v_kaunter,
      ci_price_capital.mutu,
      ci_price_capital.setup_price as per_gram_semasa,
      ci_price_capital.serial_berat as sb_price_semasa,
    ');
    $this->db->join('ci_products', 'ci_products.product_id = ci_order_items.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_products.product_id');
    $this->db->join('ci_category','ci_category.cat_id=ci_products.cat_id');
    $this->db->join('ci_variants','ci_variants.variant_id=ci_order_items.variant_id','left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id','left');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_order_items.variant_id','left');
    $this->query = $this->db->get('ci_order_items');
    if ($this->query->num_rows() > 0) {
      foreach ($this->query->result_array() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
  }

  // public function get_items_re($order_id = '')
  // {
  //   if ($order_id) {
  //     $this->db->where('ci_order_items.order_id', $order_id);
  //     $this->db->where('ci_order_items.order_category', 99);
  //   }
  //   $this->db->select('
  //     ci_order_items.*,
  //     ci_products.*,
  //     ci_variants_sta.diskaun,
  //     ci_variants_sta.harga as deposit,
  //     ci_category.category_name,
  //     ci_variants.variant_id,
  //     ci_variants.v_weight,
  //     ci_variants.v_size,
  //     ci_variants.v_length,
  //     ci_variants.v_width,
  //     ci_variants.v_sn,
  //     ci_variants.v_sb,
  //     ci_variants.v_pay,
  //     ci_variants.v_kaunter,
  //     sn.serial_no,
  //     ci_price_capital.mutu,
  //     ci_price_capital.setup_price as per_gram_semasa,
  //     ci_price_capital.serial_berat as sb_price_semasa,
  //   ');
  //   $this->db->join('ci_products', 'ci_products.product_id = ci_order_items.product_id');
  //   $this->db->join('ci_images','ci_images.product_id=ci_products.product_id');
  //   $this->db->join('ci_category','ci_category.cat_id=ci_products.cat_id');
  //   $this->db->join('ci_variants','ci_variants.variant_id=ci_order_items.variant_id','left');
  //   $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id','left');
  //   $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_order_items.variant_id','left');
  //   $this->db->join('
  //   (
  //   select GROUP_CONCAT(serial_no) as serial_no,product_id,order_id
  //     FROM ci_temp_siri
  //     group by product_id,order_id
  //   ) as sn
  //   ','sn.product_id=ci_order_items.product_id and sn.order_id=ci_order_items.order_id','left');
  //   $this->query = $this->db->get('ci_order_items');
  //   if ($this->query->num_rows() > 0) {
  //     foreach ($this->query->result_array() as $row) {
  //       $data[] = $row;
  //     }
  //     return $data;
  //   }
  //   return false;
  // }

  public function get_buy_items($order_id = '')
  {
    if ($order_id) {
      $this->db->where('ci_buy_product.buy_id', $order_id);
    }
    $this->db->select('
      ci_buy_product.*,
      ci_price_capital.mutu,
      ci_price_capital.serial_berat as sb_price_semasa,
    ');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_buy_product.mutu_id','left');
    $this->query = $this->db->get('ci_buy_product');
    if ($this->query->num_rows() > 0) {
      foreach ($this->query->result_array() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
  }

  public function get_track($order_id) {
    $this->db->where('order_id', $order_id);
    $this->query = $this->db->get('ci_tracking');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

    public function get_order_status($order_id=''){
      if($order_id!=''){
        $this->db->where('order_id',$order_id);
      }
      $this->db->where('ct.transaction_status=os.order_status and os.order_status_id=ct.order_status_id');
      $this->db->join('ci_transaction ct','ct.order_status_id=os.order_status_id');
      $this->query = $this->db->get('ci_order_status os');
      if($order_id){
        return $this->query->row_array();
      }else{
        return $this->query->result_array();
      }

    }

    public function get_list_courier(){
      $this->db->distinct();
      $this->db->select('courier_name');
      $this->query = $this->db->get('ci_tracking');
      return $this->query->result_array();
    }

    public function get_productID_2($order_id)
  {
    $this->db->distinct();
    $this->db->select('count(serial_no) as total,product_id');
    $this->db->where('order_id', $order_id);
    $this->db->group_by('product_id');
    $this->query = $this->db->get('ci_serial_no');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function get_siri($order_id='')
  {

      if($order_id){
        $this->db->where('ci_serial_no.order_id', $order_id);
        $this->db->join('ci_orders', 'ci_orders.order_id = ci_serial_no.order_id');
        $this->db->join('ci_products', 'ci_products.product_id = ci_serial_no.product_id');
      $this->query = $this->db->get('ci_serial_no');
      if ($this->query->num_rows() > 0) {
        foreach ($this->query->result_array() as $row) {
          $data[] = $row;
        }
        return $data;
      }
      return false;
    }
  }

  public function get_all_siri()
  {
    $this->db->distinct();
    $this->db->select('product_id,serial_no');

    $this->query = $this->db->get('ci_temp_siri');

    if ($this->query->num_rows() > 0) {
      foreach ($this->query->result_array() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
  }

  //buy model
  
  public function get_commission($total_semasa)
  {
    if ($total_semasa==0) {
      $this->db->where('min <=', $total_semasa);
    }else {
      $this->db->where('min <=', $total_semasa);
    }
    
    $this->db->order_by('min', 'desc');
    
    $query = $this->db->get('commission');

    $ret = $query->row();
    return $ret->komisen;
  }

}
