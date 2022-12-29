<?php
defined('BASEPATH') OR exit('No direct sctipt access allowed');

class Report_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function get_report()
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ct.staff_id', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      $this->db->group_start();
      $this->db->where('ct.vip', 1);
      $this->db->group_end();
    }
    
    if ($this->input->post('carian') == 1 || $this->input->post('carian') == 4) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ct.tarikh_transaksi) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ct.tarikh_transaksi) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ct.tarikh_transaksi)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ct.tarikh_transaksi)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('staf_id')) {
      $this->db->where('ct.staff_id',$this->input->post('staf_id'));
    }

    if ($this->input->post('category')) {
      $this->db->where('ct.status',$this->input->post('category'));
    }

    if ($this->input->post('cara_bayaran')) {
      $this->db->where('ct.cara_bayaran',$this->input->post('cara_bayaran'));
    }
    
    $this->db->select('
      ct.*,
      cup.username as staff,
      c.name as cust,
      cawangan.tag,
    ');
    $this->db->join('ci_users cup','cup.id = ct.staff_id');
    $this->db->join('customer c','c.id = ct.cust_id');
    $this->db->join('cawangan','cawangan.id = ct.cawangan_id');
    $this->db->order_by('ct.transaksi_id', 'desc');
    $this->query = $this->db->get('ci_transaksi as ct');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  // START All variant out query -------------------------------------------------------

  public function RowReport($postData){
    $this->_get_query_report($postData);
    if($postData['length'] != -1){
      $this->db->limit($postData['length'], $postData['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  /*
  * Count all records
  */
  public function countAllReport(){
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ct.staff_id', $this->data['user_profile']['user_id']);
    }
    $this->db->from('ci_transaksi ct');
    return $this->db->count_all_results();
  }
  
  /*
  * Count records based on the filter params
  * @param $_POST filter data based on the posted parameters
  */
  public function countFilteredReport($postData){
    $this->_get_query_report($postData);
    $query = $this->db->get();
    return $query->num_rows();
  }
  
  /*
  * Perform the SQL queries needed for an server-side processing requested
  * @param $_POST filter data based on the posted parameters
  */
  private function _get_query_report($postData){

    $this->column_order = array(null,'cus.name','cu.username','c.tag','ct.bayaran','ct.cara_bayaran','ct.bayaran', 'ct.tarikh_transaksi');
    $this->column_search = array('cus.name','cu.username','c.tag','ct.bayaran','ct.cara_bayaran','ct.bayaran', 'ct.tarikh_transaksi');
    $this->order = array('ct.transaksi_id' => 'desc');

    if ($_POST['choose']==1) {
      if ($_POST['dateStart']) {
        $this->db->where('DATE(ct.tarikh_transaksi) >=', date('Y-m-d', strtotime($_POST['dateStart'])));
      }
      if ($_POST['dateEnd']) {
        $this->db->where('DATE(ct.tarikh_transaksi) <=', date('Y-m-d', strtotime($_POST['dateEnd'])));
      }
      if ($_POST['category']) {
        $this->db->where('ct.keterangan', $_POST['category']);
      }
      if ($_POST['cara_bayaran']) {
        $this->db->where('ct.cara_bayaran', $_POST['cara_bayaran']);
      }
    }

    if ($_POST['choose']==2) {
      if ($_POST['months']) {
        $this->db->where('MONTH(ct.tarikh_transaksi)', $_POST['months']);
      }
      if ($_POST['years']) {
        $this->db->where('YEAR(ct.tarikh_transaksi)', $_POST['years']);
      }
      if ($_POST['category']) {
        $this->db->where('ct.keterangan', $_POST['category']);
      }
      if ($_POST['cara_bayaran']) {
        $this->db->where('ct.cara_bayaran', $_POST['cara_bayaran']);
      }
    }

    if ($_POST['choose']==3) {
      if ($_POST['category']) {
        $this->db->where('ct.keterangan', $_POST['category']);
      }
    }

    if ($_POST['choose']==4) {
      if ($_POST['staf_id']) {
        $this->db->where('ct.staff_id', $_POST['staf_id']);
      }
      if ($_POST['dateStart']) {
        $this->db->where('DATE(ct.tarikh_transaksi) >=', date('Y-m-d', strtotime($_POST['dateStart'])));
      }
      if ($_POST['dateEnd']) {
        $this->db->where('DATE(ct.tarikh_transaksi) <=', date('Y-m-d', strtotime($_POST['dateEnd'])));
      }
      if ($_POST['category']) {
        $this->db->where('ct.keterangan', $_POST['category']);
      }
      if ($_POST['cara_bayaran']) {
        $this->db->where('ct.cara_bayaran', $_POST['cara_bayaran']);
      }
    }

    if ($_POST['choose']==5) {
      if ($_POST['cara_bayaran']) {
        $this->db->where('ct.cara_bayaran', $_POST['cara_bayaran']);
      }
    }

    // if ($_POST['cawangan']) {
    //   $this->db->where('ct.cawangan_id', $_POST['cawangan']);
    // }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ct.staff_id', $this->data['user_profile']['user_id']);
    }

    $this->db->select('
      ct.*,
      cu.username as staff,
      cus.name as cust,
      c.tag,
    ');
    $this->db->join('ci_users cu','cu.id = ct.staff_id', 'left');
    $this->db->join('customer cus','cus.id = ct.cust_id', 'left');
    $this->db->join('cawangan c','c.id = ct.cawangan_id', 'left');
    $this->db->from('ci_transaksi ct');
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

  // END All variant out query -------------------------------------------------------

  public function get_report_dash()
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ct.staff_id', $this->data['user_profile']['user_id']);
    }
    $this->db->select('
      ct.*,
      cup.username as staff,
      c.name as cust,
      cawangan.tag,
    ');
    $this->db->join('ci_users cup','cup.id = ct.staff_id', 'left');
    $this->db->join('customer c','c.id = ct.cust_id', 'left');
    $this->db->join('cawangan','cawangan.id = ct.cawangan_id', 'left');
    $this->db->order_by('ct.transaksi_id', 'desc');
    $this->query = $this->db->get('ci_transaksi as ct', 5);
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_trans_by_month($m, $cawangan_id)
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ci_transaksi.staff_id', $this->data['user_profile']['user_id']);
    }
    $this->db->where('YEAR(tarikh_transaksi)', date('Y'));

    if ($m) {
      $this->db->where('MONTH(tarikh_transaksi)', $m);
    }
    
    $this->db->where('cawangan_id', $cawangan_id);
    $this->db->select('
      SUM(bayaran) as total
    ');
    $this->query = $this->db->get('ci_transaksi');
    return $this->query->row()->total;
  }

  public function get_refund()
  { 
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ci_products.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }
    $this->db->select('
      ri.*,
      ci_variants.*,
      ci_products.*,
      cawangan.tag,
    ');
    $this->db->join('ci_variants','ci_variants.variant_id = ri.variants_id','left');
    $this->db->join('ci_products', 'ci_products.product_id = ci_variants.product_id', 'left');
    $this->db->join('cawangan', 'cawangan.id = ci_products.cawangan_id', 'left');
    $this->db->order_by('ri.id', 'desc');
    $this->query = $this->db->get('refund_item ri');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_deleted_v()
  { 
    $this->db->where('cv.deleted', 1);
    $this->db->select('
      cv.*,
      cvs.*,
      cawangan.tag
    ');
    $this->db->join('ci_variants_sta cvs','cvs.variants_id = cv.variant_id','left');
    $this->db->join('ci_products', 'ci_products.product_id = cv.product_id');
    $this->db->join('cawangan', 'cawangan.id = ci_products.cawangan_id');
    $this->db->order_by('cv.variant_id', 'desc');
    $this->query = $this->db->get('ci_variants cv');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function v_out()
  { 
    $this->db->where('ci_order_items.order_category', NULL);
    $this->db->where('ci_variants.v_status', 1);
    $this->db->select('
      LPAD(ci_order_items.order_id,8,0) as order_no,
      LPAD(ci_dn.dn_id,8,0) as dn_no,
      ci_order_items.*,
      ci_products.*,
      ci_variants_sta.diskaun,
      ci_variants_sta.harga as deposit,
      ci_variants_sta.vip as vip,
      ci_category.category_name,
      ci_variants.variant_id,
      ci_variants.v_weight,
      ci_variants.v_size,
      ci_variants.v_length,
      ci_variants.v_width,
      ci_variants.v_sn,
      ci_variants.v_sb,
      ci_variants.v_pay,
      ci_variants.v_kaunter,  
      ci_variants.v_kod,  
      ci_price_capital.mutu,
      ci_price_capital.setup_price as per_gram_semasa,
      ci_price_capital.serial_berat as sb_price_semasa,
      ci_users.username as staf,
      cawangan.tag,
    ');
    $this->db->join('ci_products', 'ci_products.product_id = ci_order_items.product_id','left');
    $this->db->join('ci_category','ci_category.cat_id = ci_products.cat_id','left');
    $this->db->join('ci_variants','ci_variants.variant_id = ci_order_items.variant_id','left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id','left');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id = ci_order_items.variant_id','left');
    $this->db->join('ci_users','ci_users.id = ci_order_items.staf_id','left');
    $this->db->join('cawangan','cawangan.id = ci_products.cawangan_id','left');
    $this->db->join('ci_dn','ci_dn.order_id = ci_order_items.order_id','left');
    $this->db->order_by('ci_order_items.id', 'desc');    
    $this->query = $this->db->get('ci_order_items');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  // START All variant out query -------------------------------------------------------

  public function RowVariantOut($postData){
    $this->_get_query_variant_out($postData);
    if($postData['length'] != -1){
      $this->db->limit($postData['length'], $postData['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  /*
  * Count all records
  */
  public function countAllVariantOut(){
    // $this->db->where('cv.deleted', NULL);
    $this->db->where('coi.order_category', NULL);
    $this->db->from('ci_order_items coi');
    return $this->db->count_all_results();
  }
  
  /*
  * Count records based on the filter params
  * @param $_POST filter data based on the posted parameters
  */
  public function countFilteredVariantOut($postData){
    $this->_get_query_variant_out($postData);
    $query = $this->db->get();
    return $query->num_rows();
  }
  
  /*
  * Perform the SQL queries needed for an server-side processing requested
  * @param $_POST filter data based on the posted parameters
  */
  private function _get_query_variant_out($postData){

    $this->column_order = array(null,'cp.product_name','cu.username','cv.v_sn','c.tag','coi.ordered_weight','coi.subtotal','coi.ordered_margin_pay','coi.updated', 'coi.updated', 'co.order_no');
    $this->column_search = array('cp.product_name','cv.v_sn','cu.username','c.tag','coi.ordered_weight','coi.subtotal','coi.ordered_margin_pay','coi.updated', 'coi.updated', 'co.order_no');
    $this->order = array('coi.id' => 'desc');

    if ($_POST['choose']==1) {

      if ($_POST['dateStart']) {
        $this->db->where('DATE(coi.updated) >=', date('Y-m-d', strtotime($_POST['dateStart'])));
      }

      if ($_POST['dateEnd']) {
        $this->db->where('DATE(coi.updated) <=', date('Y-m-d', strtotime($_POST['dateEnd'])));
      }
    }

    if ($_POST['choose']==2) {

      if ($_POST['months']) {
        $this->db->where('MONTH(coi.updated)', $_POST['months']);
      }

      if ($_POST['years']) {
        $this->db->where('YEAR(coi.updated)', $_POST['years']);
      }
    }

    // if ($_POST['cawangan']) {
    //   $this->db->where('cp.cawangan_id', $_POST['cawangan']);
    // }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('coi.staf_id',$this->data['user_profile']['user_id']);
    }else {
      if ($_POST['staf_id']) {
        $this->db->where('coi.staf_id', $_POST['staf_id']);
      }
    }

    $this->db->where('coi.order_category', NULL);
    $this->db->where('cv.v_status', 1);
    $this->db->select('
      coi.*,
      cp.*,
      cvs.diskaun,
      cvs.harga as deposit,
      cvs.vip as vip,
      cc.category_name,
      cv.variant_id,
      cv.v_weight,
      cv.v_size,
      cv.v_length,
      cv.v_width,
      cv.v_sn,
      cv.v_sb,
      cv.v_pay,
      cv.v_kaunter,  
      cv.v_kod,  
      cpp.mutu,
      cpp.setup_price as per_gram_semasa,
      cpp.serial_berat as sb_price_semasa,
      cu.username as staf,
      c.tag,
      co.order_no,
    ');
    $this->db->join('ci_products cp', 'cp.product_id = coi.product_id','left');
    $this->db->join('ci_category cc','cc.cat_id = cp.cat_id','left');
    $this->db->join('ci_variants cv','cv.variant_id = coi.variant_id','left');
    $this->db->join('ci_price_capital cpp','cpp.row_id = cp.mutu_id','left');
    $this->db->join('ci_variants_sta cvs','cvs.variants_id = coi.variant_id','inner');
    $this->db->join('ci_users cu','cu.id = coi.staf_id','left');
    $this->db->join('cawangan c','c.id = cp.cawangan_id','left');
    $this->db->join('ci_orders co','co.order_id = coi.order_id','left');
    $this->db->from('ci_order_items coi');
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

  // END All variant out query -------------------------------------------------------

  public function count_price()
  { 
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_order_items.updated) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_order_items.updated) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_order_items.updated)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_order_items.updated)',$this->input->post('date_year'));
      }
    }

    if ($this->data['user_profile']['user_group'] == 3) {
      $this->db->where('DATE(ci_order_items.updated)',date('Y-m-d'));
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      // $this->db->where('ci_variants_sta.vip',NULL);
      $this->db->where('ci_variants_sta.vip',1);
    }elseif ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ci_order_items.staf_id',$this->data['user_profile']['user_id']);
    }

    if ($this->input->post('staf_id')) {
      $this->db->where('ci_order_items.staf_id',$this->input->post('staf_id'));
    }
    
    $this->db->where('ci_order_items.order_category', NULL);
    $this->db->where('ci_variants.v_status', 1);
    $this->db->select('
      sum(ci_order_items.ordered_margin_pay) as subtotal,
      sum(ci_variants.v_kod) as total_kod,
    ');
    $this->db->join('ci_products', 'ci_products.product_id = ci_order_items.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_products.product_id');
    $this->db->join('ci_category','ci_category.cat_id=ci_products.cat_id');
    $this->db->join('ci_variants','ci_variants.variant_id=ci_order_items.variant_id','left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id','left');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_order_items.variant_id','left');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_order_items.staf_id','left');
    $this->db->order_by('ci_order_items.id', 'desc');    
    $this->query = $this->db->get('ci_order_items');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function count_weight()
  { 
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_order_items.updated) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_order_items.updated) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_order_items.updated)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_order_items.updated)',$this->input->post('date_year'));
      }
    }

    if ($this->data['user_profile']['user_group'] == 3) {
      $this->db->where('DATE(ci_order_items.updated)',date('Y-m-d'));
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      // $this->db->where('ci_variants_sta.vip',NULL);
      $this->db->where('ci_variants_sta.vip',1);
    }elseif ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ci_order_items.staf_id',$this->data['user_profile']['user_id']);
    }

    if ($this->input->post('staf_id')) {
      $this->db->where('ci_order_items.staf_id',$this->input->post('staf_id'));
    }
    
    $this->db->where('ci_order_items.order_category', NULL);
    $this->db->where('ci_variants.v_status', 1);
    $this->db->select('
      sum(ci_order_items.ordered_weight) as total
    ');
    $this->db->join('ci_products', 'ci_products.product_id = ci_order_items.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_products.product_id');
    $this->db->join('ci_category','ci_category.cat_id=ci_products.cat_id');
    $this->db->join('ci_variants','ci_variants.variant_id=ci_order_items.variant_id','left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id','left');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_order_items.variant_id','left');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_order_items.staf_id','left');
    $this->db->order_by('ci_order_items.id', 'desc');    
    $this->query = $this->db->get('ci_order_items');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function count_stok_in()
  { 
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_order_items.updated) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_order_items.updated) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_order_items.updated)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_order_items.updated)',$this->input->post('date_year'));
      }
    }

    if ($this->data['user_profile']['user_group'] == 3) {
      $this->db->where('DATE(ci_order_items.updated)',date('Y-m-d'));
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      // $this->db->where('ci_variants_sta.vip',NULL);
      $this->db->where('ci_variants_sta.vip',1);
    }elseif ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ci_order_items.staf_id',$this->data['user_profile']['user_id']);
    }

    if ($this->input->post('staf_id')) {
      $this->db->where('ci_order_items.staf_id',$this->input->post('staf_id'));
    }
    
    $this->db->where('ci_order_items.order_category', NULL);
    $this->db->where('ci_variants.v_status', 1);
    $this->db->select('
      count(ci_order_items.id) as total
    ');
    $this->db->join('ci_products', 'ci_products.product_id = ci_order_items.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_products.product_id');
    $this->db->join('ci_category','ci_category.cat_id=ci_products.cat_id');
    $this->db->join('ci_variants','ci_variants.variant_id=ci_order_items.variant_id','left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id','left');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_order_items.variant_id','left');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_order_items.staf_id','left');
    $this->db->order_by('ci_order_items.id', 'desc');    
    $this->query = $this->db->get('ci_order_items');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function get_report_dashboard()
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ct.staff_id', $this->data['user_profile']['user_id']);
    // }elseif ($this->data['user_profile']['user_group'] == -1) {
    //   $this->db->where('ct.staff_id', $this->data['user_profile']['user_id']);
    //   $this->db->or_where('ct.staff_id', 2);
    //   $this->db->where('DATE(ct.tarikh_transaksi)',date('Y-m-d'));
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      // $this->db->where('ct.vip', NULL);
      $this->db->where('ct.vip', 1);
      // $this->db->or_where('ct.vip', 0);
    }

    $this->db->select('
      ct.*,
      cup.username as staff,
      cup2.full_name as cust,
    ');
    // $this->db->join('ci_users_profile cup','cup.user_id=ct.staff_id');
    $this->db->join('ci_users cup','cup.id=ct.staff_id');
    $this->db->join('ci_users_profile cup2','cup2.user_id=ct.cust_id');
    $this->db->order_by('ct.transaksi_id', 'desc');
    $this->query = $this->db->get('ci_transaksi as ct', 6);
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_keluar()
  {
    $this->db->where('cv.v_status', 1);
    $this->db->or_where('cv.v_status', 2);
    $this->db->order_by('cv.variant_id', 'desc');
    $this->query = $this->db->get('ci_variants as cv');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function all_cash($user_id='')
  { 
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cio.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cio.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cio.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cio.tarikh)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('kategori')) {
      $this->db->where('cio.category',$this->input->post('kategori'));
    }

    $this->db->where('cio.staf_id', $user_id);
    $this->db->order_by('cio.id', 'desc');
    $this->query = $this->db->get('cash_in_out as cio');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function cash_report()
  { 
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cio.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cio.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cio.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cio.tarikh)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('kategori') && $this->input->post('kategori')!=4) {
      $this->db->where('cio.category',$this->input->post('kategori'));
    }elseif ($this->input->post('kategori')==4) { //search duit ditangan
      $this->db->group_start();
      $this->db->where('cio.cara_bayaran',1);
      $this->db->or_where('cio.cara_bayaran IS NULL');
      $this->db->group_end();
    }

    if ($this->input->post('staf_id')) {
      $this->db->where('cio.staf_id', $this->input->post('staf_id'));
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cio.staf_id', $this->data['user_profile']['user_id']);
    }

    // if ($this->data['user_profile']['user_group'] == -1) {
    //   $this->db->where('cio.staf_id', $this->data['user_profile']['user_id']);
    //   $this->db->or_where('DATE(cio.tarikh)', date('Y-m-d'));
    // }

    $this->db->select('
      cup.*,
      cio.id as c_id,
      cio.*,
      c.tag
    ');
    $this->db->join('ci_users cup','cup.id = cio.staf_id', 'left');
    $this->db->join('cawangan c','c.id = cio.cawangan_id', 'left');
    $this->db->order_by('cio.id', 'desc');
    $this->query = $this->db->get('cash_in_out as cio');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function cash_in_total()
  { 
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cio.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cio.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cio.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cio.tarikh)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('kategori')) {
      $this->db->where('cio.category',$this->input->post('kategori'));
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cio.staf_id', $this->data['user_profile']['user_id']);
    }

    // if ($this->data['user_profile']['user_group'] == -1) {
    //   $this->db->where('cio.staf_id', $this->data['user_profile']['user_id']);
    //   $this->db->or_where('DATE(cio.tarikh)', date('Y-m-d'));
    // }

    $this->db->where('cio.category', 1);
    $this->db->select('SUM(cio.total) as total');
    $this->db->join('ci_users_profile cup','cup.user_id=cio.staf_id');
    $this->db->order_by('cio.id', 'desc');
    $this->query = $this->db->get('cash_in_out as cio');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function cash_out_total()
  { 
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cio.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cio.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cio.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cio.tarikh)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('kategori')) {
      $this->db->where('cio.category',$this->input->post('kategori'));
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cio.staf_id', $this->data['user_profile']['user_id']);
    }

    // if ($this->data['user_profile']['user_group'] == -1) {
    //   $this->db->where('cio.staf_id', $this->data['user_profile']['user_id']);
    //   $this->db->or_where('DATE(cio.tarikh)', date('Y-m-d'));
    // }

    $this->db->where('cio.category', 2);
    $this->db->select('SUM(cio.total) as total');
    $this->db->join('ci_users_profile cup','cup.user_id=cio.staf_id');
    $this->db->order_by('cio.id', 'desc');
    $this->query = $this->db->get('cash_in_out as cio');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function expenses_total()
  { 
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cio.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cio.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cio.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cio.tarikh)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('kategori')) {
      $this->db->where('cio.category',$this->input->post('kategori'));
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cio.staf_id', $this->data['user_profile']['user_id']);
    }

    // if ($this->data['user_profile']['user_group'] == -1) {
    //   $this->db->where('cio.staf_id', $this->data['user_profile']['user_id']);
    //   $this->db->or_where('DATE(cio.tarikh)', date('Y-m-d'));
    // }

    $this->db->where('cio.category', 3);
    $this->db->select('SUM(cio.total) as total');
    $this->db->join('ci_users_profile cup','cup.user_id=cio.staf_id');
    $this->db->order_by('cio.id', 'desc');
    $this->query = $this->db->get('cash_in_out as cio');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_jualan()
  {
    //carian tarikh
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_order_items.updated) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_order_items.updated) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      //carian bulan
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_order_items.updated)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_order_items.updated)',$this->input->post('date_year'));
      }
    }

    $this->db->where('ci_order_items.order_category', NULL);
    $this->db->where('ci_variants.v_status', 1);
    $this->db->select('SUM(ci_order_items.subtotal) as total');
    $this->db->join('ci_variants','ci_variants.variant_id=ci_order_items.variant_id','left');
    $this->query = $this->db->get('ci_order_items');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_upah()
  {
    //carian tarikh
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_order_items.updated) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_order_items.updated) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    //carian bulan
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_order_items.updated)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_order_items.updated)',$this->input->post('date_year'));
      }
    }
    $this->db->where('ci_order_items.order_category', NULL);
    $this->db->where('ci_variants.v_status', 1);
    $this->db->select('SUM(ci_order_items.ordered_margin_pay) as total');
    $this->db->join('ci_variants','ci_variants.variant_id=ci_order_items.variant_id','left');
    $this->query = $this->db->get('ci_order_items');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_kod_jualan()
  {
    //carian tarikh
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_order_items.updated) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_order_items.updated) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    //carian bulan
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_order_items.updated)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_order_items.updated)',$this->input->post('date_year'));
      }
    }
    $this->db->where('ci_order_items.order_category', NULL);
    $this->db->where('ci_variants.v_status', 1);
    $this->db->select('SUM(ci_variants.v_kod) as total_kod');
    $this->db->join('ci_variants','ci_variants.variant_id=ci_order_items.variant_id','left');
    $this->query = $this->db->get('ci_order_items');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_belian()
  {
    //carian harian
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_buy.created_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_buy.created_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      //carian bulan
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_buy.created_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_buy.created_date)',$this->input->post('date_year'));
      }
    }

    $this->db->select('SUM(ci_buy_product.harga) as total');
    $this->db->join('ci_buy','ci_buy.id=ci_buy_product.buy_id');
    $this->db->order_by('ci_buy_product.id', 'desc');
    $this->query = $this->db->get('ci_buy_product');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_cash_in()
  {
    //carian harian
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cio.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cio.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      //carian bulan
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cio.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cio.tarikh)',$this->input->post('date_year'));
      }
    }

    $this->db->where('cio.category', 1);
    $this->db->select('SUM(cio.total) as total');
    $this->query = $this->db->get('cash_in_out as cio');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_cash_out()
  {
     //carian harian
     if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cio.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cio.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      //carian bulan
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cio.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cio.tarikh)',$this->input->post('date_year'));
      }
    }

    $this->db->where('cio.category', 2);
    $this->db->select('SUM(cio.total) as total');
    $this->query = $this->db->get('cash_in_out as cio');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_expenses()
  {
     //carian harian
     if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(cio.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(cio.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      //carian bulan
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(cio.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(cio.tarikh)',$this->input->post('date_year'));
      }
    }

    $this->db->where('cio.category', 3);
    $this->db->select('SUM(cio.total) as total');
    $this->query = $this->db->get('cash_in_out as cio');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_deposit()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ct.tarikh_transaksi) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ct.tarikh_transaksi) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ct.tarikh_transaksi)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ct.tarikh_transaksi)',$this->input->post('date_year'));
      }
    }
    $this->db->group_start();
    $this->db->where('ct.status', 3);
    $this->db->or_where('ct.status', 4);
    $this->db->or_where('ct.status', 5);
    $this->db->or_where('ct.status', 6);
    $this->db->group_end();
    $this->db->select('SUM(ct.bayaran) as total');
    $this->query = $this->db->get('ci_transaksi as ct');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_transaksi_bayaran()
  {
    //carian tarikh
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ct.tarikh_transaksi) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ct.tarikh_transaksi) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      //carian bulan
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ct.tarikh_transaksi)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ct.tarikh_transaksi)',$this->input->post('date_year'));
      }
    }

    $this->db->select('SUM(ct.bayaran) as total');
    $this->query = $this->db->get('ci_transaksi as ct');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function sum_transaksi_baiki()
  {
    //carian tarikh
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ct.tarikh_transaksi) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ct.tarikh_transaksi) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      //carian bulan
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ct.tarikh_transaksi)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ct.tarikh_transaksi)',$this->input->post('date_year'));
      }
    }

    $this->db->select('SUM(ct.harga_baiki) as total');
    $this->query = $this->db->get('ci_transaksi as ct');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function get_staf()
  {
    $this->db->select('
      cu.username as full_name,
      cu.id,
    ');
    $this->db->where('cu.user_group !=', 1);
    $this->db->where('cu.user_group !=', 0);
    $this->db->where('cu.user_group !=', 5);
    $this->db->where('cu.removable IS NULL');
    // $this->db->join('ci_users_profile cup','cu.id=cup.user_id','left');
    $this->query = $this->db->get('ci_users as cu');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_staf_all() //except admin(1)
  {
    $this->db->select('
      cu.username as full_name,
      cu.id,
    ');
    $this->db->where('cu.user_group !=', 1);
    $this->db->where('cu.user_group !=', 5);
    // $this->db->join('ci_users_profile cup','cu.id=cup.user_id','left');
    $this->query = $this->db->get('ci_users as cu');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_staf_detail($id)
  {
    $this->db->where('cu.id', $id);
    $this->db->select('
      cup.full_name,
      cu.id,
    ');
    $this->db->where('cu.user_group !=', 1);
    $this->db->where('cu.user_group !=', 5);
    $this->db->join('ci_users_profile cup','cu.id=cup.user_id','left');
    $this->query = $this->db->get('ci_users as cu');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function get_inv_supplier()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(inv_supplier.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(inv_supplier.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(inv_supplier.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(inv_supplier.tarikh)',$this->input->post('date_year'));
      }
    }

    $this->db->select('
      inv_supplier.id as inv_id,
      inv_supplier.*,
      cawangan.*,
      ci_supplier.supplier_name
    ');
    $this->db->join('cawangan', 'cawangan.id = inv_supplier.cawangan_id', 'left');
    $this->db->join('ci_supplier', 'ci_supplier.id = inv_supplier.supplier', 'left');
    
    $this->db->order_by('inv_supplier.id', 'desc');
    $this->query = $this->db->get('inv_supplier');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function berat_inv_supplier()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(inv_supplier.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(inv_supplier.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(inv_supplier.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(inv_supplier.tarikh)',$this->input->post('date_year'));
      }
    }

    $this->db->select('
      sum(inv_supplier.berat) as total,
    ');
    
    $this->query = $this->db->get('inv_supplier');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function upah_inv_supplier()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(inv_supplier.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(inv_supplier.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(inv_supplier.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(inv_supplier.tarikh)',$this->input->post('date_year'));
      }
    }

    $this->db->select('
      sum(inv_supplier.total_upah) as total,
    ');
    
    $this->query = $this->db->get('inv_supplier');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  public function total_inv_supplier()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(inv_supplier.tarikh) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(inv_supplier.tarikh) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(inv_supplier.tarikh)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(inv_supplier.tarikh)',$this->input->post('date_year'));
      }
    }

    $this->db->select('
      sum(inv_supplier.total) as total,
    ');
    
    $this->query = $this->db->get('inv_supplier');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false;
  }

  // public function get_by_dulang()
  // {
  //   $this->db->where('cd.deleted', NULL);
  //   $this->db->join('
  //   (SELECT count(id) as count_check,dulang_id
  //     FROM check_stok
  //     WHERE status = 1
  //     GROUP BY dulang_id) AS count_check
  //   ','count_check.dulang_id = cd.id','left');
  //   $this->db->join('
  //   (
  //     SELECT
  //       count(ci_variants.variant_id) as stock,
  //       cp.dulang_id
  //     FROM
  //       `ci_variants`
  //     left join ci_products cp on cp.product_id=ci_variants.product_id
  //     WHERE ci_variants.v_status = 0 AND ci_variants.deleted IS NULL
  //     GROUP BY cp.dulang_id
  //     ) as avail_stock
  //   ','avail_stock.dulang_id=cd.id','left');
  //   $this->db->order_by('cd.id', 'asce');
  //   $this->query = $this->db->get('ci_dulang cd');
  //   if ($this->query->num_rows() > 0) {
  //     return $this->query->result_array();
  //   }
  //   return false; 
  // }

  public function get_by_dulang($cawangan_id)
  {
    // $this->db->where('cd.deleted', NULL);
    $this->db->select('
      cd.*
    ');
    $this->db->group_by('cp.dulang_id');
    $this->db->join('ci_dulang cd', 'cd.id = cp.dulang_id', 'left');
    $this->query = $this->db->get('ci_products cp');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false; 
  }

  public function get_stock_dulang($dulang_id, $cawangan_id)
  {
    $this->db->where('ci_variants.v_status !=', 1);
    // $this->db->where('ci_variants.v_status !=', 3);
    $this->db->where('ci_variants.deleted', NULL);
    $this->db->where('ci_products.dulang_id', $dulang_id);
    $this->db->where('ci_products.cawangan_id', $cawangan_id);
    $this->db->select('
      count(ci_variants.variant_id) as total
    ');
    $this->db->join('ci_products', 'ci_products.product_id = ci_variants.product_id', 'left');
    $query = $this->db->get('ci_variants');
    $ret = $query->row();
    if ($query->num_rows() > 0) {
      return $ret->total;
    }
    return 0;
  }

  public function get_check_stok($dulang_id, $cawangan_id)
  {
    // $this->db->where('ci_variants.v_status !=', 1);
    // $this->db->where('ci_variants.v_status !=', 3);
    // $this->db->where('ci_variants.deleted', NULL);
    $this->db->where('check_stok.status', 1);
    $this->db->where('check_stok.dulang_id', $dulang_id);
    $this->db->where('ci_products.cawangan_id', $cawangan_id);
    $this->db->select('
      count(check_stok.id) as total
    ');
    $this->db->join('ci_products', 'ci_products.product_id = check_stok.product_id', 'left');
    $query = $this->db->get('check_stok');
    $ret = $query->row();
    if ($query->num_rows() > 0) {
      return $ret->total;
    }
    return 0;
  }

  public function get_test()
  {
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  public function get_test1()
  {
    $this->db->where('v_status', 1);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  public function get_test0()
  {
    $this->db->where('v_status', 0);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  public function get_test2()
  {
    $this->db->where('v_status', 2);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  public function get_test3()
  {
    $this->db->where('v_status', 3);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  public function get_test4()
  {
    $this->db->where('v_status', 4);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  public function get_test5()
  {
    $this->db->where('v_status', 5);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  
  public function get_test6()
  {
    $this->db->where('v_status', 6);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  
  public function get_test7()
  {
    $this->db->where('v_status', 7);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  public function get_test7_list()
  {
    $this->db->where('v_status', 7);
    $this->db->select('
      ci_variants.variant_id,
      ci_variants.v_sn,
      LPAD(ci_repair.id,8,0) as repair_no,
    ');
    
    $this->db->join('ci_repair', 'ci_repair.variant_id = ci_variants.variant_id', 'left');
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false; 
  }

  
  public function get_test8()
  {
    $this->db->where('v_status', 8);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  
  public function get_test9()
  {
    $this->db->where('v_status', 9);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  
  public function get_test10()
  {
    $this->db->where('v_status', 10);
    $this->db->select('
     count(variant_id) as total
    ');
    
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }

  public function get_test99()
  {
    $this->db->where('v_status', 99);
    $this->db->select('
     count(ci_variants.variant_id) as total,
    ');
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    return false; 
  }


}
