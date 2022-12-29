<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function get_cawangan()
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('id', $this->data['user_profile']['cawangan_id']);
    }
    $this->query = $this->db->get('cawangan');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function get_logo()
  {
    $this->db->where('status',1);
    $this->query = $this->db->get('ci_logo');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function syarat_pesanan_ikat()
  {
    $this->query = $this->db->get('syarat_pesanan_ikat');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function syarat_pesanan_semasa()
  {
    $this->query = $this->db->get('syarat_pesanan_semasa');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function syarat_belian()
  {
    $this->query = $this->db->get('syarat_belian');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function syarat_keluar()
  {
    $this->query = $this->db->get('syarat_keluar');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function syarat_kedai()
  {
    $this->query = $this->db->get('syarat_kedai');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function syarat_baru()
  {
    $this->query = $this->db->get('syarat_baru');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function syarat_baiki()
  {
    $this->query = $this->db->get('syarat_baiki');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function get_maklumat()
  {
    $this->query = $this->db->get('ci_maklumat');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function get_state()
  {
    $this->query = $this->db->get('ci_state');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

    
  public function count_products()
  {
    $this->db->select('count(product_id) as total_products');
    $this->query = $this->db->get('ci_products');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function count_sales()
  {
    $this->db->where('os.order_status','4');
    $this->db->select('SUM(ci_orders.total_all) as total_sales');
    $this->db->join('ci_orders','ci_orders.order_id=os.order_id');
    $this->query = $this->db->get('ci_order_status os');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }


  public function years_by_order()
  {
    $this->db->where('os.order_status',4);
    $this->db->select('distinct(YEAR(ci_orders.created_date)) as tahun');
    $this->db->join('ci_orders','ci_orders.order_id=os.order_id');
    $this->query = $this->db->get('ci_order_status os');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function sales_by_month()
  {
    if ($this->data['user_profile']['user_group'] != 1) {
      $this->db->where('ct.staff_id', $this->data['user_profile']['user_id']);
    }
    $this->db->where('os.order_status','4');
    $this->db->select('ct.bayaran as sales,MONTH(ci_orders.created_date) as bulan,YEAR(ci_orders.created_date) as tahun');
    // $this->db->join('ci_orders','ci_orders.order_id=os.order_id');
    $this->query = $this->db->get('ci_transaksi ct');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  //query for monthly sales

  public function sale_d_month() //this month sale
  {
    // if ($this->data['user_profile']['user_group'] != 1 && $this->data['user_profile']['user_group'] != 0) {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ct.staff_id', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      $this->db->group_start();
      $this->db->where('ct.vip', 1);
      $this->db->or_where('ct.vip IS NULL');
      $this->db->group_end();
    }
    $this->db->where('YEAR(ct.tarikh_transaksi)',date("Y"));
    $this->db->where('MONTH(ct.tarikh_transaksi)',date("m"));
    $this->db->select('SUM(ct.bayaran) as sales');
    $this->query = $this->db->get('ci_transaksi ct');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function get_komisen()
  {
    $this->db->order_by('min', 'asc');
    $this->query = $this->db->get('commission');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function sale_d_repair() //this month repair
  { 
    // if ($this->data['user_profile']['user_group'] != 1 && $this->data['user_profile']['user_group'] != 0) {
      if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ct.staff_id', $this->data['user_profile']['user_id']);
    }elseif ($this->data['user_profile']['user_group'] == 1) {
      $this->db->group_start();
      $this->db->where('ct.vip', 1);
      $this->db->or_where('ct.vip IS NULL');
      $this->db->group_end();
    }
    $this->db->where('YEAR(ct.tarikh_transaksi)',date("Y"));
    $this->db->where('MONTH(ct.tarikh_transaksi)',date("m"));
    $this->db->select('SUM(ct.harga_baiki) as repair');
    $this->query = $this->db->get('ci_transaksi ct');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function get_month()
  {
    $this->query = $this->db->get('month');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }
}
