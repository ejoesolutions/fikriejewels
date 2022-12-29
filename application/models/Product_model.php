<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function drop_down_products()
  {
    $this->db->where('ci_products.status!=',3);
    $this->db->where('ci_products.has_variant IS NULL');
    $this->db->select('ci_products.*,avail_stock.stock');
    $this->db->order_by('product_id', 'desc');
    $this->query  = $this->db->get('ci_products')->result_array();
    if(is_array( $this->query ) && count( $this->query ) > 0)
    {
      $return[''] = 'Pilih Produk';
      foreach($this->query as $row)
      {
        // $return[$row['product_id']] = strtoupper($row['product_name']).' [ Stok : '.($row['stock']>0)?$row['stock']: '0'.' ]';
        $return[$row['product_id']] = strtoupper($row['product_name']).' [ Stok Semasa : '.$row['stock'].' ]';
      }
      return $return;
    }
  }

  public function get_all_dulang() //kecuali dulang tempahan, belian
  {
    $this->db->where('ci_dulang.dulang_name !=', 'TEMPAHAN');
    $this->db->where('ci_dulang.dulang_name !=', 'BELIAN');
    $this->db->where('deleted', NULL);
    $this->query = $this->db->get('ci_dulang');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_item()
  {
    $this->db->where('status', 2);
    $this->db->where('staf_id', $this->data['user_profile']['user_id']);
    $this->db->select('
      ci_buy_product.*,
      ci_price_capital.mutu
      '
    );
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_buy_product.mutu_id', 'left');
    $this->query = $this->db->get('ci_buy_product');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function test()
  {
    $this->db->select('(SELECT SUM(ci_buy_product.harga) FROM ci_buy_product WHERE ci_buy_product.status=2) AS amount_paid', FALSE);
    $query = $this->db->get('ci_buy_product');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function get_all_supplier()
  {
    $this->db->where('deleted', NULL);
    $this->query = $this->db->get('ci_supplier');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function last_id_buy()
  {
    $this->db->order_by('id', 'desc');
    $this->db->limit(1);
    $query = $this->db->get('ci_buy_product');
    $ret = $query->row();
    return $ret->id;
  }

  public function get_all_product()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_products.created_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_products.created_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_products.created_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_products.created_date)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('pembekal') ) {
      $this->db->where('ci_products.supplier_id',$this->input->post('pembekal'));
    }
    
    if ($this->input->post('dulang')) {
      $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ci_products.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }

    // $this->db->where('ci_products.status !=', 3);
    // $this->db->where('ci_variants.v_status !=', 7);
    $this->db->select('
      ci_products.*,
      ci_supplier.supplier_code,
      ci_supplier.supplier_name,
      ci_dulang.dulang_code,
      ci_dulang.dulang_name,
      ci_category.category_name,
      ci_category.category_code,
      avail_stock.stock,
      ci_images.file_name as product_image,
      ci_price_capital.row_id,
      ci_price_capital.mutu as mutu_grade,
      ci_price_capital.karat,
      ci_price_capital.base_weight,
      ci_price_capital.setup_price,
      ci_price_capital.serial_berat,
      all_stock.all_stock,
      sold_stock.sold_stock,
      out_stock.out_stock,
      cawangan.name as nama_cwgn,
      '
    );
    $this->db->join('
      (SELECT count(variant_id) as sold_stock,product_id
      FROM ci_variants
      WHERE v_status = 1
      GROUP BY product_id) AS sold_stock
    ','sold_stock.product_id=ci_products.product_id','left');
    $this->db->join('
    (SELECT count(variant_id) as out_stock,product_id
      FROM ci_variants
      WHERE v_status = 2 AND deleted IS NULL
      GROUP BY product_id) AS out_stock
    ','out_stock.product_id=ci_products.product_id','left');
    $this->db->join('
      (SELECT count(variant_id) as all_stock,product_id
      FROM ci_variants
      WHERE deleted IS NULL
      GROUP BY product_id) AS all_stock
    ','all_stock.product_id = ci_products.product_id','left');
    $this->db->join('
      (SELECT count(variant_id) as stock,product_id
      FROM ci_variants
      WHERE v_status = 0 AND deleted IS NULL
      GROUP BY product_id) AS avail_stock
    ','avail_stock.product_id = ci_products.product_id','left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id', 'left');
    $this->db->join('ci_images','ci_images.product_id = ci_products.product_id', 'left');
    $this->db->join('ci_dulang','ci_dulang.id = ci_products.dulang_id', 'left');
    $this->db->join('ci_supplier','ci_supplier.id = ci_products.supplier_id', 'left');
    $this->db->join('ci_category','ci_category.cat_id = ci_products.cat_id', 'left');
    $this->db->join('ci_variants', 'ci_variants.product_id = ci_products.product_id', 'left');
    $this->db->join('cawangan', 'cawangan.id = ci_products.cawangan_id', 'left');
    // $this->db->join('ci_repair','ci_repair.variant_id=ci_variants.variant_id', 'left');
    $this->db->group_by('ci_products.product_id');
    
    $this->db->order_by("stock desc,all_stock desc,ci_supplier.id desc");
    $this->query  = $this->db->get('ci_products');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->result_array();
    }
  }

  public function get_all_variants()
  {
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_images','ci_images.product_id=ci_products.product_id');
    $this->db->join('ci_dulang','ci_dulang.id=ci_products.dulang_id');
    $this->db->join('ci_supplier','ci_supplier.id=ci_products.supplier_id');
    $this->db->join('ci_category','ci_category.cat_id=ci_products.cat_id');
    $this->query  = $this->db->get('ci_products');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->result_array();
    }
  }

  public function product_view($product_id)
  {
    $this->db->where('ci_products.product_id',$product_id);
    $this->db->select('
      ci_products.*,
      ci_dulang.dulang_code,
      ci_supplier.supplier_code,
      ci_category.category_name,
      ci_category.category_code,
      avail_stock.stock,
      ci_images.image_id,
      ci_images.file_name as product_image,
      ci_price_capital.row_id,
      ci_price_capital.mutu as mutu_grade,
      ci_price_capital.karat,
      ci_price_capital.base_weight,
      ci_price_capital.setup_price,
      ci_price_capital.serial_berat,
      all_stock.all_stock
      '
    );
    $this->db->join('
      (SELECT count(variant_id) as stock,product_id
      FROM ci_variants
      WHERE v_status = 0
      GROUP BY product_id) AS avail_stock
    ','avail_stock.product_id=ci_products.product_id','left');
    $this->db->join('
      (SELECT count(variant_id) as all_stock,product_id
      FROM ci_variants
      GROUP BY product_id) AS all_stock
    ','all_stock.product_id=ci_products.product_id','left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_images','ci_images.product_id=ci_products.product_id');
    $this->db->join('ci_category','ci_category.cat_id=ci_products.cat_id');
    $this->db->join('ci_dulang','ci_dulang.id=ci_products.dulang_id');
    $this->db->join('ci_supplier','ci_supplier.id=ci_products.supplier_id');
    $this->query  = $this->db->get('ci_products');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function get_other_image($product_id)
  {
    $this->db->where('product_id',$product_id);
    $this->query = $this->db->get('ci_image_addition');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
    return false;
  }

  public function list_variant($product_id)
  {
    $this->db->where('ci_variants.deleted', NULL);
    $this->db->where('ci_variants.product_id', $product_id);
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id', 'left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id', 'left');
    $this->db->join('cawangan','cawangan.id = ci_products.cawangan_id', 'left');
    $this->db->order_by('ci_variants.v_status', 'asce');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function list_variant_sold($product_id)
  {
    $this->db->where('ci_variants.product_id',$product_id);
    $this->db->select('
      ci_variants.*,
      ci_order_items.setup_price,
      ci_price_capital.mutu,
      '
    );
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_order_items','ci_order_items.variant_id=ci_variants.variant_id');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->result_array();
    }
  }

  public function list_variant_tukang()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_variants.tukang_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_variants.tukang_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_variants.tukang_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_variants.tukang_date)',$this->input->post('date_year'));
      }
    }

    // if ($this->input->post('staf_id')) {
    //   $this->db->where('ci_variants.staf_id',$this->input->post('staf_id'));
    // }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ci_products.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }

    $this->db->where('ci_variants.baki_berat !=',0); //Kerat
    $this->db->join('ci_products','ci_products.product_id = ci_variants.product_id', 'left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id', 'left');
    $this->db->join('cawangan','cawangan.id = ci_products.cawangan_id', 'left');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function list_all_variant($sn = '')
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_variants.insert_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_variants.insert_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_variants.insert_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_variants.insert_date)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('status') && $this->input->post('status') != 11) {
      $this->db->where('ci_variants.v_status',$this->input->post('status'));
    }elseif ($this->input->post('status') == 11) {
      $this->db->where('ci_variants.v_status',0);
    }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ci_products.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }

    if ($sn) {
      $this->db->where('ci_variants.v_sn', $sn); 
    }

    $this->db->where('ci_variants.v_status !=', 1);
    $this->db->where('ci_variants.v_status !=', 3);
    $this->db->where('ci_variants.deleted', NULL);

    $this->db->select('
      ci_variants.*,
      ci_products.*,
      ci_price_capital.*,
      ci_images.file_name as image,
      ci_variants_sta.harga as sta_harga,
      ci_variants_sta.cust_id as sta_cust,
      ci_variants_sta.tarikh as sta_tarikh,
      ci_variants_sta.order_id as order_id,
      ci_variants_sta.nota as sta_nota,
      customer.name as full_name,
      cup2.username as staf_name,
      cawangan.tag,
      '
    );
    $this->db->join('ci_products','ci_products.product_id = ci_variants.product_id', 'left');
    $this->db->join('ci_images','ci_images.product_id = ci_variants.product_id', 'left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id', 'left');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id = ci_variants.variant_id', 'inner');
    $this->db->join('customer','customer.id = ci_variants_sta.cust_id', 'left');
    $this->db->join('ci_users as cup2','cup2.id = ci_variants.staf_id', 'left');
    $this->db->join('cawangan','cawangan.id = ci_products.cawangan_id', 'left');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function count_pending()
  {
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cp.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }
    // $this->db->where('ci_variants.v_status !=', 1);
    // $this->db->where('ci_variants.v_status !=', 3);
    $this->db->where('ci_variants.v_status', 6);
    $this->db->where('ci_variants.deleted', NULL);
    $this->db->where('ci_variants_sta.cust_id IS NULL');
    $this->db->select('count(ci_variants.variant_id) as total');
    $this->db->join('ci_products cp','cp.product_id = ci_variants.product_id', 'left');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id = ci_variants.variant_id', 'left');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function count_stok_in()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_variants.insert_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_variants.insert_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_variants.insert_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_variants.insert_date)',$this->input->post('date_year'));
      }
    }elseif ($this->input->post('carian') == 3) {
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }

    if ($this->input->post('status') && $this->input->post('status') != 11) {
      $this->db->where('ci_variants.v_status',$this->input->post('status'));
    }elseif ($this->input->post('status') == 11) {
      $this->db->where('ci_variants.v_status',0);
    }

    $this->db->where('ci_variants.deleted', NULL);

    $this->db->select('
      count(ci_variants.variant_id) as total,
    ');
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_variants.variant_id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_variants_sta.cust_id');
    $this->db->join('ci_users_profile as cup2','cup2.user_id=ci_variants.staf_id');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function count_stok_in_hand()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_variants.insert_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_variants.insert_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_variants.insert_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_variants.insert_date)',$this->input->post('date_year'));
      }
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }elseif ($this->input->post('carian') == 3) {
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }

    if ($this->input->post('status') && $this->input->post('status') != 11) {
      $this->db->where('ci_variants.v_status',$this->input->post('status'));
    }elseif ($this->input->post('status') == 11) {
      $this->db->where('ci_variants.v_status',0);
    }

    $this->db->where('ci_variants.deleted', NULL);
    // $this->db->where('ci_variants.v_status !=', 6);
    // $this->db->where('ci_variants.v_status !=', 1);
    // $this->db->where('ci_variants.v_status !=', 2);
    $this->db->where('ci_variants.v_status', 0);

    $this->db->select('
      count(ci_variants.variant_id) as total,
    ');
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_variants.variant_id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_variants_sta.cust_id');
    $this->db->join('ci_users_profile as cup2','cup2.user_id=ci_variants.staf_id');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function count_weight()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_variants.insert_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_variants.insert_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_variants.insert_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_variants.insert_date)',$this->input->post('date_year'));
      }
    }elseif ($this->input->post('carian') == 3) {
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }

    $this->db->where('ci_variants.deleted', NULL);

    if ($this->input->post('status') && $this->input->post('status') != 11) {
      $this->db->where('ci_variants.v_status',$this->input->post('status'));
    }elseif ($this->input->post('status') == 11) {
      $this->db->where('ci_variants.v_status',0);
    }

    $this->db->select('
      sum(ci_variants.v_weight) as total,
    ');
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_variants.variant_id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_variants_sta.cust_id');
    $this->db->join('ci_users_profile as cup2','cup2.user_id=ci_variants.staf_id');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function count_weight_hand()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_variants.insert_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_variants.insert_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_variants.insert_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_variants.insert_date)',$this->input->post('date_year'));
      }
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }elseif ($this->input->post('carian') == 3) {
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }

    if ($this->input->post('status') && $this->input->post('status') != 11) {
      $this->db->where('ci_variants.v_status',$this->input->post('status'));
    }elseif ($this->input->post('status') == 11) {
      $this->db->where('ci_variants.v_status',0);
    }

    $this->db->where('ci_variants.deleted', NULL);
    // $this->db->where('ci_variants.v_status !=', 6);
    // $this->db->where('ci_variants.v_status !=', 1);
    // $this->db->where('ci_variants.v_status !=', 2);
    $this->db->where('ci_variants.v_status', 0);

    $this->db->select('
      sum(ci_variants.v_weight) as total,
    ');
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_variants.variant_id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_variants_sta.cust_id');
    $this->db->join('ci_users_profile as cup2','cup2.user_id=ci_variants.staf_id');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function count_price()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_variants.insert_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_variants.insert_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_variants.insert_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_variants.insert_date)',$this->input->post('date_year'));
      }
    }elseif ($this->input->post('carian') == 3) {
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }

    if ($this->input->post('status') && $this->input->post('status') != 11) {
      $this->db->where('ci_variants.v_status',$this->input->post('status'));
    }elseif ($this->input->post('status') == 11) {
      $this->db->where('ci_variants.v_status',0);
    }

    $this->db->where('ci_variants.deleted', NULL);
    
    $this->db->select('
      Sum(ci_price_capital.setup_price * ci_variants.v_weight) AS total
    ');
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_variants.variant_id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_variants_sta.cust_id');
    $this->db->join('ci_users_profile as cup2','cup2.user_id=ci_variants.staf_id');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function count_price_hand()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_variants.insert_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_variants.insert_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_variants.insert_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_variants.insert_date)',$this->input->post('date_year'));
      }
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }elseif ($this->input->post('carian') == 3) {
      if ($this->input->post('dulang')) {
        $this->db->where('ci_products.dulang_id',$this->input->post('dulang'));
      }
    }

    if ($this->input->post('status') && $this->input->post('status') != 11) {
      $this->db->where('ci_variants.v_status',$this->input->post('status'));
    }elseif ($this->input->post('status') == 11) {
      $this->db->where('ci_variants.v_status',0);
    }

    $this->db->where('ci_variants.deleted', NULL);
    // $this->db->where('ci_variants.v_status !=', 6);
    // $this->db->where('ci_variants.v_status !=', 1);
    // $this->db->where('ci_variants.v_status !=', 2);
    $this->db->where('ci_variants.v_status', 0);

    $this->db->select('
      Sum(ci_price_capital.setup_price * ci_variants.v_weight) AS total
    ');
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id');
    $this->db->join('ci_images','ci_images.product_id=ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_variants.variant_id');
    $this->db->join('ci_users_profile','ci_users_profile.user_id=ci_variants_sta.cust_id');
    $this->db->join('ci_users_profile as cup2','cup2.user_id=ci_variants.staf_id');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function list_stok_in()
  {
    if ($this->input->post('carian') == 1) {
      if ($this->input->post('date_min')) {
        $this->db->where('DATE(ci_variants.insert_date) >=',date('Y-m-d',strtotime($this->input->post('date_min'))));
      }
      if ($this->input->post('date_max')) {
        $this->db->where('DATE(ci_variants.insert_date) <=',date('Y-m-d',strtotime($this->input->post('date_max'))));
      }
    }elseif ($this->input->post('carian') == 2) {
      if ($this->input->post('date_month') && $this->input->post('date_month') != "00") {
        $this->db->where('MONTH(ci_variants.insert_date)',$this->input->post('date_month'));
      }
      if ($this->input->post('date_year')) {
        $this->db->where('YEAR(ci_variants.insert_date)',$this->input->post('date_year'));
      }
    }

    if ($this->input->post('status') && $this->input->post('status') != 11) {
      $this->db->where('ci_variants.v_status',$this->input->post('status'));
    }elseif ($this->input->post('status') == 11) {
      $this->db->where('ci_variants.v_status',0);
    }

    $this->db->where('ci_variants.deleted', NULL);

    $this->db->select('
      ci_variants.*,
      ci_products.*,
      ci_price_capital.*,
      ci_images.file_name as image,
      ci_variants_sta.harga as sta_harga,
      ci_variants_sta.cust_id as sta_cust,
      ci_variants_sta.status as sta_status,
      ci_variants_sta.tarikh as sta_tarikh,
      ci_variants_sta.nota as sta_nota,
      cup2.full_name as staf_name,
      cawangan.tag
    ');
    $this->db->join('ci_products','ci_products.product_id = ci_variants.product_id', 'left');
    $this->db->join('ci_images','ci_images.product_id = ci_variants.product_id', 'left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id', 'left');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id = ci_variants.variant_id', 'left');
    $this->db->join('cawangan','cawangan.id = ci_products.cawangan_id', 'left');
    $this->db->join('ci_users_profile as cup2','cup2.user_id = ci_variants.staf_id', 'left');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  // START All stok in query -------------------------------------------------------

  public function RowStokIn($postData){
    $this->_get_query_stok_in($postData);
    if($postData['length'] != -1){
      $this->db->limit($postData['length'], $postData['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }
  
  /*
  * Count all records
  */
  public function countAllStokIn(){
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cp.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }
    $this->db->where('cv.deleted', NULL);
    $this->db->join('ci_products cp','cp.product_id = cv.product_id', 'left');
    $this->db->from('ci_variants cv');
    return $this->db->count_all_results();
  }
  
  /*
  * Count records based on the filter params
  * @param $_POST filter data based on the posted parameters
  */
  public function countFilteredStokIn($postData){
    $this->_get_query_stok_in($postData);
    $query = $this->db->get();
    return $query->num_rows();
  }
  
  /*
  * Perform the SQL queries needed for an server-side processing requested
  * @param $_POST filter data based on the posted parameters
  */
  private function _get_query_stok_in($postData){

    $this->column_order = array(null,'cp.product_name','cv.v_sn','c.tag','cv.v_kod','cv.v_weight','cv.insert_date', 'cup2.username');
    $this->column_search = array('cp.product_name','cv.v_sn','c.tag','cv.v_kod','cv.v_weight','cv.insert_date', 'cup2.username');
    $this->order = array('cv.variant_id' => 'desc');

    if ($_POST['choose']==1) {

      if ($_POST['dateStart']) {
        $this->db->where('DATE(cv.insert_date) >=', date('Y-m-d', strtotime($_POST['dateStart'])));
      }

      if ($_POST['dateEnd']) {
        $this->db->where('DATE(cv.insert_date) <=', date('Y-m-d', strtotime($_POST['dateEnd'])));
      }
    }

    if ($_POST['choose']==2) {

      if ($_POST['months']) {
        $this->db->where('MONTH(cv.insert_date)', $_POST['months']);
      }

      if ($_POST['years']) {
        $this->db->where('YEAR(cv.insert_date)', $_POST['years']);
      }
    }

    //utk page stok in hand
    if ($_POST['in_hand']==1) {
      // $this->db->where('cv.v_status', 0);
      $this->db->where('cv.v_status !=', 1);
    }

    // if ($_POST['cawangan']) {
    //   $this->db->where('cp.cawangan_id', $_POST['cawangan']);
    // }

    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('cp.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }

    $this->db->where('cv.deleted', NULL);
    // $this->db->where('cp.dulang !=', 1);
    $this->db->select('
      cv.v_weight,cv.v_kod,cv.insert_date,cv.v_sn,
      cp.product_name,cp.product_id,
      cpp.setup_price,
      c.tag,
      cup2.username as staf,
    ');
    $this->db->join('ci_products cp','cp.product_id = cv.product_id', 'left');
    $this->db->join('ci_price_capital cpp','cpp.row_id = cp.mutu_id', 'left');
    // $this->db->join('ci_variants_sta cvs','cvs.variants_id = cv.variant_id', 'left');
    $this->db->join('cawangan c','c.id = cp.cawangan_id', 'left');
    $this->db->join('ci_users cup2','cup2.id = cv.staf_id', 'left');
    $this->db->from('ci_variants cv');
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

  // END All stok in query -------------------------------------------------------

  public function list_stok_in_hand($cawangan_id='', $dulang='')
  {
    if ($this->input->post('status') && $this->input->post('status') != 11) {
      $this->db->where('ci_variants.v_status',$this->input->post('status'));
    }elseif ($this->input->post('status') == 11) {
      $this->db->where('ci_variants.v_status',0);
    }

    if ($this->input->post('textbox')) {
      $this->db->where('ci_variants.v_status',$this->input->post('textbox'));
    }

    if ($cawangan_id) {
      $this->db->where('ci_products.cawangan_id', $cawangan_id);
    }

    if ($dulang) {
      $this->db->where('ci_products.dulang_id', $dulang);
      $this->db->where('ci_variants.v_status !=', 1);
    }else {
      $this->db->where('ci_variants.v_status', 0);
    }
    
    $this->db->where('ci_variants.deleted', NULL);
    // $this->db->where('ci_variants.v_status !=', 6);
    // $this->db->where('ci_variants.v_status !=', 1);
    // $this->db->where('ci_variants.v_status !=', 2);
    $this->db->select('
      ci_variants.*,
      ci_products.*,
      ci_price_capital.*,
      ci_images.file_name as image,
      ci_variants_sta.harga as sta_harga,
      ci_variants_sta.cust_id as sta_cust,
      ci_variants_sta.tarikh as sta_tarikh,
      ci_variants_sta.nota as sta_nota,
      cup2.full_name as staf_name,
      cawangan.tag
    ');
    $this->db->join('ci_products','ci_products.product_id = ci_variants.product_id', 'left');
    $this->db->join('ci_images','ci_images.product_id = ci_variants.product_id','left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id','left');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id = ci_variants.variant_id', 'left');
    $this->db->join('ci_users_profile as cup2','cup2.user_id = ci_variants.staf_id', 'left');
    $this->db->join('cawangan','cawangan.id = ci_products.cawangan_id', 'left');
    $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function check_stok($cawangan_id, $id)
  {
    if ($id) {
      $this->db->where('check_stok.dulang_id', $id);
    }
    if ($id) {
      $this->db->where('check_stok.cawangan_id', $cawangan_id);
    }
    $this->db->join('ci_users', 'ci_users.id = check_stok.user_id', 'left');
    $this->db->join('ci_products', 'ci_products.product_id = check_stok.product_id', 'left');
    $this->db->join('ci_variants', 'ci_variants.v_sn = check_stok.v_sn', 'inner');
    $this->db->order_by('check_stok.status', 'desc');
    $this->db->order_by('check_stok.date_checked', 'desc');
    $this->query  = $this->db->get('check_stok');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function dulang_detail($id)
  {
    // $this->db->where('id', $id);
    // $this->query = $this->db->get('ci_dulang');
    // if ($this->query->num_rows() > 0)
    // {
    //   return $this->query->row_array();
    // }
    $this->db->where('id', $id);
    $query = $this->db->get('ci_dulang');
    $ret = $query->row();
    return $ret->dulang_name;
  }

  public function dulang_reset($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('ci_dulang');
    $ret = $query->row();
    return $ret->reset_at;
  }

  public function list_all_variant_shop()
  {
    $this->db->where('ci_variants.v_status', 5);
    $this->db->select('
      ci_variants.*,
      ci_products.*,
      ci_price_capital.*,
      ci_variants_sta.harga as sta_harga,
      ci_variants_sta.cust_id as sta_cust,
      ci_variants_sta.status as sta_status,
      ci_variants_sta.tarikh as sta_tarikh,
      ci_variants_sta.nota as sta_nota,
      customer.name as full_name,
      '
    );
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id=ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id=ci_variants.variant_id');
    $this->db->join('customer','customer.id = ci_variants_sta.cust_id');
    // $this->db->order_by('ci_variants.variant_id', 'asce');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->result_array();
    }
  }

  public function list_variant_in_stock($cawangan_id='')
  {
    if ($cawangan_id) {
      $this->db->where('ci_products.cawangan_id', $cawangan_id); 
    }
    if ($this->data['user_profile']['user_group'] == 2) {
      $this->db->where('ci_products.cawangan_id', $this->data['user_profile']['cawangan_id']);
    }

    $this->db->where('v_status !=', 1);
    $this->db->where('deleted',NULL);
    // $this->db->select('
    //   ci_variants.*,
    //   ci_products.*,
    //   ci_price_capital.*,
    // ');
    $this->db->join('ci_products','ci_products.product_id = ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id = ci_variants.variant_id');
    // $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function list_variant_total_weight()
  {
    $this->db->where('v_status !=', 1);
    $this->db->where('deleted', NULL);
    $this->db->select('
      SUM(ci_variants.v_weight) as total,
    ');
    $this->db->join('ci_products','ci_products.product_id = ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id = ci_variants.variant_id');
    // $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function list_variant_for_order()
  {
    $this->db->where('v_status', 0);
    $this->db->where('deleted',NULL);
    $this->db->join('ci_products','ci_products.product_id = ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id = ci_variants.variant_id');
    // $this->db->order_by('ci_variants.variant_id', 'desc');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function get_variant($v_id)
  {
    $this->db->where('ci_variants.v_sn', $v_id);
    $this->db->where('deleted', NULL);
    $this->db->join('ci_products','ci_products.product_id = ci_variants.product_id');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id');
    $this->db->join('ci_variants_sta','ci_variants_sta.variants_id = ci_variants.variant_id');
    $this->query  = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->result_array();
    }
  }

  public function last_sn_variant($product_id)
  {
    $this->db->where('product_id',$product_id);
    $this->db->select('count(variant_id) as max_sn');
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function last_sn_buy()
  {
    $this->db->select('count(id) as max_sn');
    $this->query  = $this->db->get('ci_buy_product');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function last_sn_book()
  {
    // $this->db->select('count(id) as num');
    // $this->query  = $this->db->get('ci_booking');
    // if ($this->query->num_rows() > 0) {
    //   return $this->query->row_array();
    // }
    $this->db->order_by('id', 'desc');
    $query = $this->db->get('ci_book_shop');
    $ret = $query->row();
    if ($query->num_rows() > 0) {
      return $ret->id;
    }
    return 0;
  }

  public function last_sn_repair()
  {
    // $this->db->select('count(id) as max_repair');
    // $this->query  = $this->db->get('ci_repair');
    // if ($this->query->num_rows() > 0)
    // {
    //   return $this->query->row_array();
    // }
    $this->db->order_by('id', 'desc');
    $query = $this->db->get('ci_repair_add');
    $ret = $query->row();
    if ($query->num_rows() > 0) {
      return $ret->id;
    }
    return 0;
  }

  public function get_variant_detail($variant_id)
  {
    $this->db->where('variant_id', $variant_id);
    $this->db->join('ci_products','ci_products.product_id = ci_variants.product_id', 'left');
    $this->db->join('ci_price_capital','ci_price_capital.row_id = ci_products.mutu_id', 'left');
    $this->db->join('cawangan','cawangan.id = ci_products.cawangan_id', 'left');
    $this->query = $this->db->get('ci_variants');
    if ($this->query->num_rows() > 0) {
      return $this->query->row_array();
    }
  }

  public function get_add_repair($variant_id)
  {
    $this->db->where('variant_id',$variant_id);
    $this->query  = $this->db->get('ci_repair_add');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }

  public function sta_variant_detail($v_id)
  {
    $this->db->where('ci_variants_sta.variants_id',$v_id);
    $this->db->select('
      ci_variants.*,
      ci_variants_sta.*,
      ci_variants_sta.harga as deposit,
      customer.id as cust_id,
      customer.name as cust_name,
      customer.phone as cust_phone,
      customer.kp as cust_kp,
      customer.address as cust_address,
      customer.state as cust_state,
      cup2.username as staf_name,
      ci_products.*,
      ci_price_capital.mutu,
      ci_price_capital.serial_berat,
      ci_price_capital.setup_price,
      ci_state.*,
      cawangan.*,
    ');
    $this->db->join('ci_variants', 'ci_variants.variant_id = ci_variants_sta.variants_id', 'left');
    $this->db->join('ci_products','ci_products.product_id=ci_variants.product_id', 'left');
    $this->db->join('ci_price_capital', 'ci_price_capital.row_id = ci_products.mutu_id', 'left');
    $this->db->join('customer', 'customer.id = ci_variants_sta.cust_id', 'left');
    $this->db->join('ci_users cup2', 'cup2.id = ci_variants_sta.staf_id', 'left');
    $this->db->join('cawangan', 'cawangan.id = ci_products.cawangan_id', 'left');
    $this->db->join('ci_state', 'ci_state.state_id = customer.state', 'left');
    $this->query  = $this->db->get('ci_variants_sta');
    if ($this->query->num_rows() > 0)
    {
      return $this->query->row_array();
    }
  }


}
