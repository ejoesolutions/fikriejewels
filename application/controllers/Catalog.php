<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalog extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('catalog_model','product_model','admin_model','order_model'));

    if ($this->ion_auth->logged_in()) {
      $user = $this->ion_auth->user()->row();
      $this->data['user_profile'] = $this->user_model->get_profile($user->id);
      $this->data['count_pending'] = $this->product_model->count_pending();
    }else {
      redirect('user/login','refresh');
    }
    
    // if ($this->data['user_profile']['user_group'] == 2)
    // {
    //   return show_404('The page you requested was not found.');
    // }

    $this->data['logo'] = $this->admin_model->get_logo();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();
  }

  public function capital_price()
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('user/login', 'refresh');
    }

    $this->data['title'] = 'Harga Kapital';
    $this->data['capital'] = $this->catalog_model->list_capital_price();
    $this->data['mutu'] = $this->catalog_model->list_mutu();

    $this->template->load('layouts/admin','catalog/price_capital', $this->data);
  }

  public function update_capital()
  {
    $row_id = $this->input->post('capital_id');
    $base_weight = $this->input->post('base_weight');
    $select = $this->input->post('select');
    $price = str_replace(',','',$this->input->post('price'));
    $sb_price = str_replace(',','',$this->input->post('sb_price'));

    if ($select == 1) {
      $price = $sb_price / $base_weight;
      $sb = $sb_price;
    }else {
      $sb = $price * $base_weight;
    }
  
    $data=[
      'base_weight'=>$base_weight,
      'setup_price'=>$price,
      'last_update'=>date('Y-m-d H:i:s'),
      'serial_berat'=>$sb
    ];

    $this->db->where('row_id',$row_id);
    $this->db->update('ci_price_capital',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Harga Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/capital_price','refresh');
  }

  public function status_variants()
  {
    $v_id = $this->input->post('v_id');
    $in_v_sn = $this->input->post('in_v_sn');
    $cust_id = $this->input->post('customer');

    if ($this->input->post('status') == 5) {
      $book = array(
        'variant_id' => $v_id,
      );
      $this->db->insert('ci_book_shop',$book);
    }
    
    $data = array(
      // 'variants_id' => $this->input->post('v_id'),
      // 'status' => $this->input->post('status'),
      'harga' => $this->input->post('harga'),
      'cust_id' => $cust_id,
      'staf_id' => $this->data['user_profile']['id'],
      'tarikh' => $this->input->post('tarikh'),
      'nota' => $this->input->post('nota_status'),
    );
    $this->db->where('variants_id',$v_id);
    $this->db->update('ci_variants_sta',$data);    

    $status = array(
      'v_status' => $this->input->post('status')
    );
    $this->db->where('variant_id', $v_id);
    $this->db->update('ci_variants', $status);

    if ($this->input->post('status') == 5) {
      $x = 3;  
      $keterangan = "Deposit Tempahan Kedai";
    }elseif ($this->input->post('status') == 2) {
      $x = 4;  
      $keterangan = "Deposit Keluar";
    }

    //table transaksi
    $trans_data = array(
      'cawangan_id' => $this->input->post('cawangan'),
      'variant_id' => $v_id,
      'cust_id' => $cust_id,
      'bayaran' => $this->input->post('harga'), 
      'cara_bayaran' => $this->input->post('cara_bayaran'), 
      'keterangan' => $keterangan,
      'tarikh_transaksi' => date("Y-m-d H:i:s"), 
      'staff_id' => $this->data['user_profile']['user_id'],
      'status' => $x,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    //table cash in/out
    if ($this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == 3) {
      $cash_data = array(
        'staf_id' => $this->data['user_profile']['user_id'],
        'cawangan_id' => $this->input->post('cawangan'),
        'total' => $this->input->post('harga'),
        'cara_bayaran' => $this->input->post('cara_bayaran'),
        'category' => 4,
        'tarikh' => date("Y-m-d H:i:s"),
        'perincian' => $keterangan,
        'v_id' => $v_id,
        'status' => $x,
        'note' => $this->input->post('nota_status'),
      );
      $this->db->insert('cash_in_out', $cash_data);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Status Ditambah</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('booking/all_variants/'.$in_v_sn,'refresh');
  }

  public function upd_status_variants()
  {
    $v_id = $this->input->post('upd_v_id');
    $v_sn = $this->input->post('up_sta_sn');
    
    if ($this->input->post('up_sta_status') == 5) {
      // $book = array(
      //   'variant_id' => $v_id,
      // );
      // $this->db->insert('ci_book_shop',$book);

      $data = array(
        // 'variants_id' => $this->input->post('upd_v_id'),
        // 'status' => $this->input->post('up_sta_status'),
        // 'harga' => 0,
        'tarikh' => $this->input->post('up_sta_tarikh'),
        // 'nota' => NULL,
        'nota' => $this->input->post('up_sta_nota'),
      );
      $this->db->where('variants_id',$v_id);
      $this->db->update('ci_variants_sta',$data);
  
      $status = array(
        'v_status' => $this->input->post('up_sta_status')
      );
      $this->db->where('variant_id',$v_id);
      $this->db->update('ci_variants',$status);

    }elseif ($this->input->post('up_sta_status') ==  0) {

      $data = array(
        // 'variants_id' => $this->input->post('upd_v_id'),
        // 'status' => $this->input->post('up_sta_status'),
        'cust_id' => NULL,
        'staf_id' => NULL,
        'harga' => 0,
        'diskaun' => 0,
        'tarikh' => NULL,
        'nota' => NULL,
      );
      $this->db->where('variants_id',$v_id);
      $this->db->update('ci_variants_sta',$data);
  
      $status = array(
        'v_status' => $this->input->post('up_sta_status')
      );
      $this->db->where('variant_id',$v_id);
      $this->db->update('ci_variants',$status);

    }else {

      $data = array(
        'variants_id' => $this->input->post('upd_v_id'),
        // 'status' => $this->input->post('up_sta_status'),
        // 'harga' => 0,
        'tarikh' => $this->input->post('up_sta_tarikh'),
        'nota' => $this->input->post('up_sta_nota'),
      );
      $this->db->where('variants_id',$v_id);
      $this->db->update('ci_variants_sta',$data);
  
      $status = array(
        'v_status' => $this->input->post('up_sta_status')
      );
      $this->db->where('variant_id',$v_id);
      $this->db->update('ci_variants',$status);
  
      if ($this->input->post('status_sn') != $this->input->post('up_sta_status')) { //kalau tukar status delete kat tempahan kedai
        $this->db->where('variant_id', $v_id);
        $this->db->delete('ci_book_shop');
      }
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Status Dikemaskini</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('booking/all_variants/'.$v_sn,'refresh');
  }

  public function invoice_list()
  {
    $this->data['invoice_list'] = $this->catalog_model->list_invoice();

    $this->template->load('layouts/admin','product/invoices_list', $this->data);
  }

  public function print_detail_order($id)
  {
    $this->data['invoice_list'] = $this->catalog_model->list_invoice($id);

    $this->load->view('product/order_invoice', $this->data);
  }

  public function print_tempahan($v_id)
  {
    $this->data['book'] = $this->product_model->sta_variant_detail($v_id);
    $this->data['syarat_kedai']=$this->admin_model->syarat_kedai();
    $this->data['maklumat']=$this->admin_model->get_maklumat();

    $this->load->view('catalog/print_tempahan', $this->data);
  }

  public function print_keluar($v_id)
  {
    $this->data['variant'] = $this->product_model->sta_variant_detail($v_id);
    $this->data['syarat_keluar'] = $this->admin_model->syarat_keluar();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();

    $this->load->view('catalog/print_keluar', $this->data);
  }

  public function new_product()
  {
		$tables = $this->config->item('tables', 'ion_auth');

    $this->form_validation->set_rules('product_name', 'Nama Produk', 'required');
    $this->form_validation->set_rules('description', 'Keterangan', 'trim');
		$this->form_validation->set_rules('product_code', 'kod produk', 'required|is_unique[' . $tables['products'] . '.product_code]');

    // Muat naik imej
    $config['upload_path'] = 'images';
    $config['allowed_types']  = 'jpg|png|jpeg';
    // $config['max_width']  =  500;
    // $config['max_height']  =  500;
    // $config['max_size']  =  1024;
    $config['encrypt_name']  =  TRUE;
    $config['remove_spaces']  =  TRUE;
    $config['file_ext_tolower']  =  TRUE;
    $config['overwrite']  =  FALSE;

    $this->load->library('upload', $config);

    if ($this->form_validation->run() == TRUE && $this->upload->do_upload('userfile')) {

      $upload_data = $this->upload->data();
      $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];

      $config['image_library'] = 'gd2';
      $config['source_image'] = 'images/'.$image_file;
      // $config['create_thumb'] = TRUE;
      $config['maintain_ratio'] = TRUE;
      $config['width']         = 500;
      // $config['max_size']  =  256;
      $config['height']       = 500;
      $config['new_image'] = 'images/thumbnail/'.$image_file;

      $this->load->library('image_lib',$config);
      $this->image_lib->resize();

      //delete gambar lepas compressed
      unlink("images/".$image_file);

      $product = array(
        'product_name' => strtoupper($this->input->post('product_name')),
        'product_code' => strtoupper($this->input->post('product_code')),
        'cawangan_id' => $this->input->post('cawangan'),
        'cat_id' => $this->input->post('category'),
        'dulang_id' => $this->input->post('dulang'),
        'mutu_id' => $this->input->post('mutu'),
        'supplier_id' => $this->input->post('pembekal'),
        'description' => empty($this->input->post('description')) ? NULL : $this->input->post('description'),
        'created_date'=>date("Y-m-d H:i:s"),
        'jenis'=> $this->input->post('type'),
      );
      $this->db->insert('ci_products', $product);
      $p_id = $this->db->insert_id();
      
      $images = array(
        'product_id' => $p_id,
        'file_name' => $image_file
      );
      $this->db->insert('ci_images', $images);

      $this->session->set_flashdata('upload', "<script>
        Swal.fire({
          icon: 'success',
          title: '<h4>Produk Ditambah</h4>',
          showConfirmButton: false,
          timer: 1200
        })
      </script>");

      redirect('catalog/product_edit/'.$p_id,'refresh');
          
    } else {

      if ($this->upload->display_errors()) {
        $this->data['error_image'] = $this->upload->display_errors();
      }

      // Dropdown input
      $this->data['cawangan'] = $this->admin_model->get_cawangan();
      $this->data['mutu'] = $this->catalog_model->list_capital_price();
      $this->data['category'] = $this->catalog_model->list_category();
      $this->data['dulang'] = $this->product_model->get_all_dulang();
      $this->data['pembekal'] = $this->product_model->get_all_supplier();

      $this->data['product_name'] = array(
        'name'=>'product_name',
        'id'=>'product_name',
        'autocomplete' => 'off',
        'required' => '',
        'class' =>'form-control uppercase',
        'value' => $this->form_validation->set_value('product_name')
      );

      $this->data['product_code'] = array(
        'name'=>'product_code',
        'id'=>'product_code',
        'autocomplete' => 'off',
        'class' =>'form-control uppercase',
        'readonly' => '',
        'value' => $this->form_validation->set_value('product_code')
      );

      $this->data['description'] = array(
        'name'=>'description',
        'id'=>'description',
        'autocomplete' => 'off',
        'class' =>'form-control',
        'value' => $this->form_validation->set_value('description')
      );

      $this->template->load('layouts/admin', 'product/register_new_product', $this->data);
    }
  }

  public function add_stock()
  {
    if(!$this->ion_auth->logged_in()){
      redirect('user/login','refresh');
    }
    $this->data['title'] = 'Pengurusan Stok';

    $this->data['list_products'] = $this->product_model->drop_down_products();

    $this->template->load('layouts/admin', 'product/add_stock', $this->data);
  }

  public function supplier()
  {
    if(!$this->ion_auth->logged_in()){
      redirect('user/login','refresh');
    }

    $this->data['list_dulang'] = $this->product_model->get_all_dulang();
    $this->data['list_supplier'] = $this->product_model->get_all_supplier();
    $this->data['category'] = $this->catalog_model->list_category();

    $this->template->load('layouts/admin', 'product/supplier', $this->data);
  }

  public function add_invoice()
  {
    $data_orders = array(
      'user_id'=>$this->input->post('things'),
      'total_price' => $this->input->post('grand_total'),
      'invoice_date' =>date("Y-m-d H:i:s"),
    );
    $this->db->insert('ci_invoice_orders', $data_orders);
    $invoice_id=$this->db->insert_id();

    $data_items = array(
      'invoice_id'=>$invoice_id,
      'variant_id' => $this->input->post('variants'),
      'discount' =>$this->input->post('v_name')
    );
    $this->db->insert('ci_invoice_items', $data_items);
    
    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Kemaskini Berjaya</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/create_order', 'refresh');
  }

  public function store_category()
  {
    $data = array(
      'category_name' => strtoupper($this->input->post('category_name')),
      'category_code' => strtoupper($this->input->post('category_code')),
    );
    $this->db->insert('ci_category', $data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Kategori Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/supplier', 'refresh');
  }

  public function store_dulang()
  {
    $data = array(
      'dulang_name' => strtoupper($this->input->post('dulang_name')),
      'dulang_code' => strtoupper($this->input->post('dulang_code')),
    );
    $this->db->insert('ci_dulang', $data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Dulang Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/supplier', 'refresh');
  }

  public function store_supplier()
  {
    $data = array(
      'supplier_name' => strtoupper($this->input->post('supplier_name')),
      'supplier_code' => strtoupper($this->input->post('supplier_code')),
    );
    $this->db->insert('ci_supplier', $data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Pembekal Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/supplier', 'refresh');
  }

  public function upd_supplier()
  {
    $data = array(
      'supplier_name' => strtoupper($this->input->post('supplier_name')),
      'supplier_code' => strtoupper($this->input->post('upd_supplier_code')),
    );
    $this->db->where('id', $this->input->post('supplier_id'));
    $this->db->update('ci_supplier',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Pembekal Diubah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/supplier', 'refresh');
  }

  public function upd_category()
  {
    $data = array(
      'category_name' => strtoupper($this->input->post('category_name')),
      'category_code' => strtoupper($this->input->post('category_code')),
    );
    $this->db->where('cat_id', $this->input->post('category_id'));
    $this->db->update('ci_category',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Kategori Diubah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/supplier', 'refresh');
  }

  public function upd_dulang()
  {
    $data = array(
      'dulang_name' => strtoupper($this->input->post('dulang_name')),
      'dulang_code' => strtoupper($this->input->post('upd_dulang_code')),
    );
    $this->db->where('id', $this->input->post('dulang_id'));
    $this->db->update('ci_dulang',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Dulang Diubah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/supplier', 'refresh');
  }

  public function del_dulang($id)
  {
    $data = array(
      'deleted' => 1,
    );
    $this->db->where('id', $id);
    $this->db->update('ci_dulang',$data);

    redirect('catalog/supplier', 'refresh');
  }

  public function del_supplier($id)
  {
    $data = array(
      'deleted' => 1,
    );
    $this->db->where('id', $id);
    $this->db->update('ci_supplier',$data);

    redirect('catalog/supplier', 'refresh');
  }

  public function del_category($id)
  {
    $data = array(
      'deleted' => 1,
    );
    $this->db->where('cat_id', $id);
    $this->db->update('ci_category',$data);

    redirect('catalog/supplier', 'refresh');
  }

  public function products()
  {
    $this->data['products'] = $this->product_model->get_all_product();
    $this->data['dulang'] = $this->product_model->get_all_dulang();
    $this->data['pembekal'] = $this->product_model->get_all_supplier();
    
    $this->template->load('layouts/admin', 'product/table_products', $this->data);
  }

  // public function invoices()
  // {
  //   if(!$this->ion_auth->logged_in()){
  //     redirect('user/login','refresh');
  //   }
  //   $this->data['title'] = 'Senarai Produk';

  //   $this->data['cust'] = $this->user_model->get_cust();
  //   $this->data['variants'] = $this->product_model->list_all_variant();

  //   $this->template->load('layouts/admin', 'product/invoices', $this->data);
  // }

  public function create_order($siri = '')
  {
    $this->data['a'] = $siri;
    $this->data['cust'] = $this->user_model->get_cust();
    if ($siri) {
      $this->data['variants'] = $this->product_model->get_variant($siri);
    }else {
      $this->data['variants'] = $this->product_model->list_variant_for_order();
    }

    $this->template->load('layouts/admin', 'product/invoices', $this->data);
  }

  public function check_account_exist(){
    $acc=$this->input->post('acc');
    $this->data['data_penerima']='asldas';
    //echo json_encode($this->data);
    $this->load->view('product/show_maklumat_penerima', $this->data);
    //$this->template->load('layouts/admin','pages/dashboard', $this->data);
  }


  public function product_detail($id)
  {
    $p = $this->uri->segment(4);
    $this->data['p_detail'] = $this->product_model->product_view($id);
    $this->data['imej'] = $this->product_model->get_other_image($id);
    $this->data['title'] = 'Maklumat Produk';
  
    $this->template->load('layouts/admin', 'product/admin_product_detail', $this->data);
  }

  public function store_other_image(){
    $product_id=$this->input->post('product_id');
    // Muat naik imej
    $config['upload_path'] = 'images';
    $config['allowed_types']  = 'jpg|png|jpeg';
    $config['max_width']  =  500;
    $config['max_height']  =  500;
    $config['max_size']  =  256;
    $config['encrypt_name']  =  TRUE;
    $config['remove_spaces']  =  TRUE;
    $config['file_ext_tolower']  =  TRUE;
    $config['overwrite']  =  FALSE;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('imej_tambahan')!='') {

      $upload_data = $this->upload->data();
      $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];

      $config['image_library'] = 'gd2';
      $config['source_image'] = 'images/'.$image_file;
      // $config['create_thumb'] = TRUE;
      $config['maintain_ratio'] = TRUE;
      $config['width']         = 150;
      $config['height']       = 150;
      $config['new_image'] = 'images/thumbnail/'.$image_file;

      $this->load->library('image_lib',$config);
      $this->image_lib->resize();

      $otherImage=array(
        'image_add_file'=>$image_file,
        'product_id' => $product_id,
      );
      $this->db->insert('ci_image_addition',$otherImage);
      $image_add_id=$this->db->insert_id();

      }

    redirect('catalog/product_detail/'.$product_id,'refresh');
  }

  public function del_other_image($id,$file,$pID){
    $this->db->where('image_add_id',$id);
    $this->db->delete('ci_image_addition');

    unlink("images/".$file);
    $info = pathinfo( $file );
    $no_extension =  basename( $file, '.'.$info['extension'] );
    $thumb_image = $no_extension.'_thumb.'.$info['extension'];
    unlink("images/thumbnail/".$thumb_image);

    redirect('catalog/product_detail/'.$pID,'refresh');
  }

  public function product_edit($id)
  {
    $this->data['product'] = $this->product_model->product_view($id);
    $this->data['variants'] = $this->product_model->list_variant($id);
    $this->data['variants_sold'] = $this->product_model->list_variant_sold($id);
    $this->data['v_sn'] = $this->product_model->last_sn_variant($id);
    $this->data['cawangan'] = $this->admin_model->get_cawangan();
    $this->data['mutu'] = $this->catalog_model->list_capital_price();
    $this->data['category'] = $this->catalog_model->list_category();
    $this->data['dulang'] = $this->product_model->get_all_dulang();
    $this->data['pembekal'] = $this->product_model->get_all_supplier();
    $this->data['maklumat']=$this->admin_model->get_maklumat();

    $product = $this->data['product'];

    $this->data['product_name'] = array(
      'name'=>'product_name',
      'id'=>'product_name',
      'autocomplete' => 'off',
      'required' => '',
      'class' =>'form-control uppercase',
      'readonly' => '',
      'value' => $this->form_validation->set_value('product_name',$product['product_name'])
    );

    $this->data['description'] = array(
      'name'=>'description',
      'id'=>'description',
      'autocomplete' => 'off',
      'class' =>'form-control',
      'value' => $this->form_validation->set_value('description',$product['description'])
    );

    $this->data['product_code'] = array(
      'name'=>'product_code',
      'id'=>'product_code',
      'class' =>'form-control uppercase',
      'autocomplete' => 'off',
      'readonly'=>'',
      'value' => $this->form_validation->set_value('product_code',$product['product_code'])
    );
  
    $this->data['weight'] = array(
      'name'=>'weight',
      'autocomplete' => 'off',
      'id'=>'weight',
      'class' =>'form-control',
      'value' => $this->form_validation->set_value('weight',$product['weight'])
    );

    $this->template->load('layouts/admin', 'product/edit_product', $this->data);
  }

  public function tukang()
  {
    $this->data['title'] = 'Senarai Tambah / Kerat';
    
    if(!$this->ion_auth->logged_in()){
      redirect('user/login','refresh');
    }

    if ($this->input->post('carian') == 1) {
      $this->data['trigger'] = 1;
      $this->data['date_min'] = $this->input->post('date_min');
      $this->data['date_max'] = $this->input->post('date_max');
    }elseif ($this->input->post('carian') == 2) {
      $this->data['trigger'] = 2;
      $this->data['date_month'] = $this->input->post('date_month');
      $this->data['date_year'] = $this->input->post('date_year');
    }else {
      $this->data['trigger'] = null;
    }

    if ($this->input->post('staf_id')) {
      $this->data['staf_id'] = $this->input->post('staf_id');
    }else {
      $this->data['staf_id'] = null;
    }

    $this->data['variants'] = $this->product_model->list_variant_tukang();

    $this->template->load('layouts/admin', 'product/tukang', $this->data);
  }

  public function store_product_update()
  {
    // $this->output->enable_profiler(true);
    // $this->upd_price_each_variant($this->input->post('product_id'),$this->input->post('pakej'));
    $product_id = $this->input->post('product_id');
    $this->form_validation->set_rules('product_name', 'Nama Produk', 'required');
    // $this->form_validation->set_rules('product_code', 'Kod Produk', 'required|edit_unique[ci_products.product_code.product_id.'.$product_id.']');
    $this->form_validation->set_rules('description', 'Keterangan', 'trim');
    // Muat naik imej
    $config['upload_path'] = 'images';
    $config['allowed_types']  = 'jpg|png|jpeg';
    // $config['max_width']  =  500;
    // $config['max_height']  =  500;
    // $config['max_size']  =  256;
    $config['encrypt_name']  =  TRUE;
    $config['remove_spaces']  =  TRUE;
    $config['file_ext_tolower']  =  TRUE;
    $config['overwrite']  =  FALSE;

    $this->load->library('upload', $config);

    if ($this->form_validation->run() == TRUE || $this->input->post('userfile')!='') {

      if ($this->upload->do_upload('userfile')) {
        $upload_data = $this->upload->data();
        $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];

        $config['image_library'] = 'gd2';
        $config['source_image'] = 'images/'.$image_file;
        // $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 500;//150
        $config['height']       = 500;//150
        $config['new_image'] = 'images/thumbnail/'.$image_file;

        $this->load->library('image_lib',$config);
        $this->image_lib->resize();

        $this->db->where('image_id',$this->input->post('image_id'));
        $this->db->update('ci_images',array('file_name'=>$image_file));

        if($this->input->post('temp_image')!=''){
          $temp_image=$this->input->post('temp_image');
          unlink("images/".$image_file);
          $info = pathinfo( $temp_image );
          $no_extension =  basename( $temp_image, '.'.$info['extension'] );
          $thumb_image = $no_extension.'_thumb.'.$info['extension'];
          unlink("images/thumbnail/".$thumb_image);
        }

      }
      
      $product = array(
        'product_name' => strtoupper($this->input->post('product_name')),
        'product_code' => strtoupper($this->input->post('product_code')),
        'dulang_id' => $this->input->post('dulang'),
        'supplier_id' => $this->input->post('pembekal'),
        'mutu_id' => $this->input->post('mutu'),
        'cat_id' => $this->input->post('category'),
        'weight' => $this->input->post('weight'),
        'jenis' => $this->input->post('type'),
        'kaunter_price' => $this->input->post('kaunter_price'),
        'description' => empty($this->input->post('description')) ? NULL : $this->input->post('description'),
      );

      $this->db->where('product_id', $product_id);
      $this->db->update('ci_products', $product);
 
      if ($this->upload->display_errors() && $_FILES['userfile']['name']!='') {
        $this->data['error_image'] = $this->upload->display_errors();
        ob_start();
        $m = "Sila muatnaik saiz imej sekurangnya bawah 250KB";
        echo "<script type='text/javascript'>alert('$m');</script>";
      }

      $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Kemaskini Berjaya</h4>',
        showConfirmButton: false,
        timer: 1200
      })
      </script>");
     
      redirect('catalog/product_edit/'.$product_id,'refresh');
      ob_end_clean();
    } else {
      $this->product_edit($product_id);
    }
  }

  public function upd_price_each_variant($product_id,$pakej_id)
  {
    // $this->db->where('product_id',$product_id);
    // $this->query  = $this->db->get('ci_variants');
    // if ($this->query->num_rows() > 0)
    // {
    //   $variant = $this->query->result_array();
    // }

    // $pakej = $this->catalog_model->list_pakej();
    // if(!empty($variant)){
    //   foreach ($variant as $key) {
    //     foreach ($pakej as $key2) {
    //       if($key2['pakej_id'] == $pakej_id)
    //       {
    //         if($key2['unit_measure']==1)//ikut gram
    //         {
    //           $asas = ($key['v_weight']*$key2['setup_price'])+($key['v_weight']*$key2['upah'])+($key['v_weight']*$key2['margin']);
    //           $ejen = $asas;
    //           $kaunter = $asas+($key['v_weight']*$key2['ejen']);
    //           $ahli = $kaunter-($key['v_weight']*$key2['ahli']);
    //           $komisyen = ($key['v_weight']*$key2['komisyen']);
    //         }
    //         else if($key2['unit_measure']==2)//ikut pcs
    //         {
    //           $asas = ($key['v_weight']*$key2['setup_price']) + floatval($key2['upah']) + floatval($key2['margin']);
    //           $ejen = $asas;
    //           $kaunter = $asas + floatval($key2['ejen']);
    //           $ahli = $kaunter - floatval($key2['ahli']);
    //           $komisyen = floatval($key2['komisyen']);
    //         }

    //         $this->db->where('variant_id',$key['variant_id']);
    //         $this->db->update('ci_variants',array('v_kaunter'=>$kaunter,'v_ahli'=>$ahli,'v_ejen'=>$ejen,'v_komisyen'=>$komisyen));

    //       }
    //     }
    //   }
    // }
  }

  public function product_delete($product_id)
  {
    $this->db->where('product_id', $product_id);
    $this->db->update('ci_products',array('status'=>3));

    redirect('catalog/products', 'refresh');
  }

  public function set_publish($state,$product_id)
  {
    if($state==2)
    {
      $this->db->where('product_id',$product_id);
      $this->db->update('ci_products',array('status'=>2));
    }else{
      $this->db->where('product_id',$product_id);
      $this->db->update('ci_products',array('status'=>1));
    }
    redirect('catalog/products','refresh');
  }

  public function store_variant()
  {
    $tables = $this->config->item('tables', 'ion_auth');

    $this->data['siri'] = $siri = $this->catalog_model->get_nmbr_siri($this->input->post('product_id'));

    $count_siri = $siri['v_sn'] ? substr($siri['v_sn'], -4) + 1 : 0 + 1;
    $create_siri = str_pad($count_siri, 4, '0', STR_PAD_LEFT);
    
    $data = [
      'product_id' => $this->input->post('product_id'),
      'v_weight' => $this->input->post('v_weight'),
      'v_size' => empty($this->input->post('v_size')) ? NULL : $this->input->post('v_size'),
      'v_length' => empty($this->input->post('v_length')) ? NULL : $this->input->post('v_length'),
      'v_width' => empty($this->input->post('v_width')) ? NULL : $this->input->post('v_width'),
      'v_sn' => strtoupper($this->input->post('product_code').$create_siri),
      'v_kaunter' => $this->input->post('counter_price'),
      'v_emas' => $this->input->post('gold_price'),
      'v_margin' => $this->input->post('v_margin'),
      'v_margin_pay' => $this->input->post('margin_pay'),
      'v_pay' => $this->input->post('v_pay'),
      'v_dasar' => $this->input->post('base_price'),
      'v_sb' => $this->input->post('serial_berat'),
      'v_kod' => strtoupper($this->input->post('v_kod')),
      'v_status' => 0,
      'insert_date' => date("Y-m-d H:i:s"),
      'staf_id' => $this->data['user_profile']['id'],
    ];
    $this->db->insert('ci_variants',$data);
    $insert_id = $this->db->insert_id();
  
    $data_sta = array(
      'variants_id' => $insert_id,
      // 'status' => 0
    );
    $this->db->insert('ci_variants_sta', $data_sta);
  
    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Tambah Variasi Berjaya</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('catalog/product_edit/'.$this->input->post('product_id'),'refresh');
  }

  public function upd_variant()
  {
    $data = [
      'product_id'=>$this->input->post('product_id'),
      'v_weight'=>$this->input->post('upd_v_weight'),
      'v_size'=>empty($this->input->post('upd_v_size')) ? NULL : $this->input->post('upd_v_size'),
      'v_length'=>empty($this->input->post('upd_v_length')) ? NULL : $this->input->post('upd_v_length'),
      'v_width'=>empty($this->input->post('upd_v_width')) ? NULL : $this->input->post('upd_v_width'),
      'v_sn'=>strtoupper($this->input->post('upd_v_sn')),
      'v_kaunter'=>$this->input->post('upd_v_kaunter'),
      'v_emas'=>$this->input->post('upd_gold_price'),
      'v_margin'=>$this->input->post('upd_v_margin'),
      'v_margin_pay'=>$this->input->post('upd_margin_pay'),
      'v_pay'=>$this->input->post('upd_v_pay'),
      'v_dasar'=>$this->input->post('upd_base_price'),
      'v_sb'=>$this->input->post('upd_serial_berat'),
      'v_kod'=>strtoupper($this->input->post('upd_v_kod')),
      'staf_id' => $this->data['user_profile']['id'],
    ];
    $this->db->where('variant_id',$this->input->post('upd_v_id'));
    $this->db->update('ci_variants',$data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Kemaskini Variasi Berjaya</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('catalog/product_edit/'.$this->input->post('product_id'),'refresh');
  }

  
  // public function search()
  // {
  //   $this->data['title'] = 'Search';
  //   $search = $this->input->post('search');

  //   if ($search != '') {
  //     $this->data['variant'] =  $this->product_model->get_variant_detail($search);  
  //   }
  //   $this->template->load('layouts/admin', 'product/invoices', $this->data);
  // }

  public function delete_variant()
  {
    $variant_id = $this->input->post('v_id');
    $product_id = $this->input->post('p_id');

    $this->db->where('variant_id',$variant_id);
    $this->db->update('ci_variants',array('deleted'=>1,'delete_date'=>date("Y-m-d H:i:s")));

    if ($this->input->post('nota')) {
      $this->db->where('variants_id',$variant_id);
      $this->db->update('ci_variants_sta',array('nota'=>$this->input->post('nota')));
    }
    
    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Variasi Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/product_edit/'.$product_id,'refresh');
  }

  public function create_barcode($variant_id)
  {
    $product = $this->product_model->get_variant_detail($variant_id);
    // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    // echo $generator->getBarcode($product['v_sn'], $generator::TYPE_CODE_128);
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
 	 	file_put_contents('barcode/'.$product['v_sn'].'.png', $generator->getBarcode($product['v_sn'], $generator::TYPE_CODE_128));
    // echo "<img src='".base_url('barcode/'.$product['v_sn'].'.png')."'>";
  }

  public function create_tag($product_id,$variant_id){

    $product = $this->product_model->get_variant_detail($variant_id);
    $this->create_barcode($variant_id);
    $this->png_to_jpg("barcode/".$product['v_sn'].".png");

    $stamp = imagecreatefromjpeg("barcode/".$product['v_sn'].".jpg");
		$im = imagecreatefromjpeg('283_151.jpg');
    // $im = imagecreatetruecolor(283, 151);

		// Output and free from memory
		header('Content-Type: image/jpeg');
		$marge_right = 15;
		$marge_bottom = 30;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);
		$color = imagecolorallocate($im, 0, 0, 0);
		$font = 'fonts/arial.ttf';
		// $font = './fonts/arial.ttf'; // path to font
		// Merge the stamp onto our photo with an opacity of 50%
		$string1 = "Mutu : ".$product['mutu']." (".$product['pakej_name'].")";
		$string2 = "Berat : ".$product['v_weight']."g";
		$string3 = "Saiz : ".$product['v_size']."cm";
		$string4 = "Panjang : ".$product['v_length']."cm";
		$string5 = "Lebar : ".$product['v_width']."cm";
		$fontSize = 10;

		imagettftext($im, 6, 0, 148, 13, $color, $font, $string1);
    imagettftext($im, 6, 0, 148, 26, $color, $font, $string2);
    imagettftext($im, 6, 0, 148, 39, $color, $font, $string3);
    imagettftext($im, 6, 0, 148, 52, $color, $font, $string4);
    imagettftext($im, 6, 0, 148, 65, $color, $font, $string5);

		imagecopymerge($im, $stamp, imagesx($im) - $sx- $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 100);
    imagettftext($im, 6, 0, 185, 135, $color, $font, $product['v_sn']);

		// Save the image to file and free memory
		imagejpeg($im);
		imagedestroy($im);

  }

  public function png_to_jpg($image_path)
  {
    $filePath=$image_path;
    $res = explode('.',$filePath);
    $image = imagecreatefrompng($filePath);
    $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    imagealphablending($bg, TRUE);
    imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    imagedestroy($image);
    $quality = 100; // 0 = worst / smaller file, 100 = better / bigger file
    imagejpeg($bg, $res[0] . ".jpg", $quality);
    unlink($filePath);
    imagedestroy($bg);
  }

  public function check_p_code()
  {
    $product_code = $this->input->post('product_code');
    $old_product_code = $this->input->post('old_product_code');

    if ($old_product_code == $product_code) {
      $this->data['check'] = false;
    }else {
      $this->data['check'] = $this->catalog_model->check_p_code($product_code);
    }

    $this->load->view('product/ajax_check_product', $this->data);
  }

}
