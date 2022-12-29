<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalog_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More

  }

  public function list_capital_price()
  {
    $this->db->order_by('order_row', 'asc');
    $this->query = $this->db->get('ci_price_capital');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function list_pakej($parameter_id='')
  {
    if($parameter_id){
      $this->db->where('parameter_id',$parameter_id);
    }

    $this->db->select('
      p.*,
      pkj.pakej_name,
      capital.mutu,
      capital.karat,
      capital.base_weight,
      capital.setup_price,
      capital.serial_berat,
      capital.last_update
    ');
    $this->db->join('ci_pakej pkj','pkj.pakej_id=p.pakej_id');
    $this->db->join('ci_price_capital capital','capital.row_id=p.mutu_id');
    $this->query = $this->db->get('ci_parameter p');
    if ($this->query->num_rows() > 0) {
      if($parameter_id){
        return $this->query->row_array();
      }else{
        return $this->query->result_array();
      }

    }
  }

  public function list_category()
  {
    $this->db->where('deleted IS NULL');
    $this->query = $this->db->get('ci_category');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function list_mutu()
  {
    // $this->db->where('deleted IS NULL');
    $this->query = $this->db->get('ci_price_capital');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function count_stock()
  {
    $this->db->where('v_status', 0);
    $this->db->where('deleted', NULL);
    $this->db->select('
      count(variant_id) as stock,
    ');
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function get_nmbr_siri($p_id)
  {
    $this->db->where('ci_products.product_id', $p_id);
    $this->db->select('
      ci_variants.v_sn
    ');
    $this->db->join('ci_variants', 'ci_variants.product_id = ci_products.product_id', 'left');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query = $this->db->get('ci_products');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
    // return $this->query->campaign_id;
  }

  public function list_invoice($id='')
  {
    if ($id) {
      $this->db->where('ci_invoice_orders.id', $id);
    }
    $this->db->select('
      ci_invoice_orders.*,
      ci_invoice_items.*,
      ci_users_profile.*
    ');
    $this->db->join('ci_invoice_items','ci_invoice_items.invoice_id=ci_invoice_orders.id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_invoice_orders.user_id');
    $this->query = $this->db->get('ci_invoice_orders');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function check_p_code($product_code)
  {
    $this->db->where('product_code', $product_code);
    $this->query = $this->db->get('ci_products');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

}
