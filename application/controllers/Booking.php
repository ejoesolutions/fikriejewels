<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('Mobile_Detect');
    $this->data['detect'] = new Mobile_Detect();

    if ($this->ion_auth->logged_in()) {
      $user = $this->ion_auth->user()->row();
      $this->data['user_profile'] = $this->user_model->get_profile($user->id);
      $this->data['logo'] = $this->admin_model->get_logo();
      $this->data['count_pending'] = $this->product_model->count_pending();
      $this->data['cawangan'] = $this->admin_model->get_cawangan();
      $this->data['maklumat'] = $this->admin_model->get_maklumat();
    }else {
      redirect('user/login','refresh');
    }
  }

  public function all_variants()
  {
    $this->data['variants'] = $this->product_model->list_all_variant(); 
    $this->data['cust'] = $this->user_model->get_cust();

    $this->template->load('layouts/admin','catalog/list_all_variants', $this->data);
  }

  public function create_booking()
  {
    $this->data['title'] = 'Tempahan Baru';
    $this->data['mutu'] = $this->catalog_model->list_capital_price();
    $this->data['category'] = $this->catalog_model->list_category();
    $this->data['dulang'] = $this->product_model->get_all_dulang();
    $this->data['cust'] = $this->user_model->get_cust();
    $this->data['v_sn'] = $this->product_model->last_sn_book();
    $this->data['item'] = $this->product_model->get_item();

    $this->template->load('layouts/admin','booking/create_booking', $this->data);
  }

  public function create_repair()
  {
    $this->data['title'] = 'Tempahan Baiki';
    $this->data['mutu'] = $this->catalog_model->list_capital_price();
    $this->data['category'] = $this->catalog_model->list_category();
    $this->data['dulang'] = $this->product_model->get_all_dulang();
    $this->data['cust'] = $this->user_model->get_cust();
    $this->data['v_sn'] = $this->product_model->last_sn_repair();
    $this->data['item'] = $this->product_model->get_item();

    $this->template->load('layouts/admin','booking/create_repair', $this->data);
  }

  public function booking_invoices($variant_id='')
  {
    $this->data['cust'] = $this->user_model->get_cust();
    $this->data['variants'] = $this->product_model->get_variant_detail($variant_id);
    $this->data['maklumat'] = $this->admin_model->get_maklumat();
    $this->data['cawangan'] = $this->admin_model->get_cawangan();

    $this->template->load('layouts/admin','booking/booking_invoices', $this->data);
  }
  
  public function repair_invoices($variant_id='')
  {
    $this->data['cust'] = $this->user_model->get_cust();
    $this->data['variants'] = $this->product_model->get_variant_detail($variant_id);
    $this->data['repair'] = $this->product_model->get_add_repair($variant_id);
    $this->data['maklumat']=$this->admin_model->get_maklumat();

    $this->template->load('layouts/admin','booking/repair_invoices', $this->data);
  }
  

  public function new_product()
  {
    if(!$this->ion_auth->logged_in()){
      redirect('user/login','refresh');
    }

    $this->data['title'] = 'Daftar Produk';

    // $this->form_validation->set_rules('product_name', 'Nama Produk', 'required');
    // $this->form_validation->set_rules('description', 'Keterangan', 'trim');

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

    if ($this->upload->do_upload('userfile')) {

      //insert into image data
      $upload_data = $this->upload->data();
      $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];

      $config['image_library'] = 'gd2';
      $config['source_image'] = 'images/'.$image_file;
      // $config['create_thumb'] = TRUE;
      $config['maintain_ratio'] = TRUE;
      $config['width']         = 500;
      $config['height']       = 500;
      $config['new_image'] = 'images/thumbnail/'.$image_file;

      $this->load->library('image_lib',$config);
      $this->image_lib->resize();

      //insert into product table
      $product = array(
        'cawangan_id' => $this->input->post('cawangan'),
        'product_name' => strtoupper($this->input->post('nama_produk')),
        'cat_id' => $this->input->post('category'),
        'dulang_id' => 1, //1 tu dulang tempahan
        'supplier_id' => 1,
        'product_code' => $this->input->post('product_code'),
        // 'jenis' => 'A',
        'mutu_id' => $this->input->post('mutu_id'),
        'description' => empty($this->input->post('keterangan')) ? NULL : $this->input->post('keterangan'),
        'created_date'=>$this->input->post('insert_date'),
      );
      $this->db->insert('ci_products', $product);
      $p_id = $this->db->insert_id();
      
      $images = array(
        'product_id' => $p_id,
        'file_name' => $image_file
      );
      $this->db->insert('ci_images', $images);

      $last_sn = str_pad($this->product_model->last_sn_book() + 1, 7, '0', STR_PAD_LEFT);
      $v_sn = $this->input->post('product_code').$last_sn;

      //insert into variants table
      $data = [
        'product_id' => $p_id,
        'v_weight' => $this->input->post('v_weight'),
        'v_size' => empty($this->input->post('v_size')) ? NULL : $this->input->post('v_size'),
        'v_length' => empty($this->input->post('v_length')) ? NULL : $this->input->post('v_length'),
        'v_width' => empty($this->input->post('v_width')) ? NULL : $this->input->post('v_width'),
        'v_sn' => $v_sn,
        'v_kaunter' => $this->input->post('counter_price'),
        'v_emas' => $this->input->post('gold_price'),
        'v_margin' => $this->input->post('v_margin'),
        'v_margin_pay' => $this->input->post('margin_pay'),
        'v_pay' => $this->input->post('v_pay'),
        'v_dasar' => $this->input->post('base_price'),
        'v_sb' => $this->input->post('serial_berat'),
        'v_kod' => strtoupper($this->input->post('v_kod')),
        'v_status' => 6, //tempahan baru
        'insert_date' => date("Y-m-d H:i"),
        'staf_id' => $this->data['user_profile']['user_id'],
      ];
      $this->db->insert('ci_variants',$data);
      $insert_id = $this->db->insert_id();
  
      $data_sta = array(
        'variants_id' => $insert_id,
        // 'cust_id' => 2,
        // 'status' => 6 //tempahan baru
      );
      $this->db->insert('ci_variants_sta', $data_sta);

      $book = array(
        'variant_id' => $insert_id
      );
      $this->db->insert('ci_book_shop',$book);      

      // $this->session->set_flashdata('upload', "<script>
      // Swal.fire({
      //   icon: 'success',
      //   title: '<h4>Produk berjaya Ditambah</h4>',
      //   showConfirmButton: false,
      //   timer: 1200
      // })
      // </script>");
  
      redirect('booking/booking_invoices/'.$insert_id, 'refresh');
    
    } else {
      $this->data['error_image'] = $this->upload->display_errors();
    
      // $this->template->load('layouts/admin', 'booking/create_booking', $this->data);

      $this->session->set_flashdata('upload', "<script>
        Swal.fire({
          icon: 'error',
          title: 'Tidak Berjaya',
          text: 'Sila semak saiz / jenis gambar yang dimasukkan!'
        })
      </script>");
      
      redirect('booking/create_booking','refresh');
      
    }
  }

  public function repair_product()
  {
    if(!$this->ion_auth->logged_in()){
      redirect('user/login','refresh');
    }

    // $this->form_validation->set_rules('product_name', 'Nama Produk', 'required');
    // $this->form_validation->set_rules('description', 'Keterangan', 'trim');

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

    if ($this->upload->do_upload('userfile')) {

      //insert into image data
      $upload_data = $this->upload->data();
      $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];

      $config['image_library'] = 'gd2';
      $config['source_image'] = 'images/'.$image_file;
      // $config['create_thumb'] = TRUE;
      $config['maintain_ratio'] = TRUE;
      $config['width']         = 500;
      $config['height']       = 500;
      $config['new_image'] = 'images/thumbnail/'.$image_file;

      $this->load->library('image_lib',$config);
      $this->image_lib->resize();

      //insert into product table
      $product = array(
        'cawangan_id' => $this->input->post('cawangan'),
        'product_name' => strtoupper($this->input->post('nama_produk')),
        'cat_id' => $this->input->post('category'),
        'dulang_id' => 1, //1 tu dulang tempahan
        'supplier_id' => 1,
        'product_code' => $this->input->post('product_code'),
        'jenis' => 'A',
        'mutu_id' => $this->input->post('mutu_id'),
        'description' => empty($this->input->post('keterangan')) ? NULL : $this->input->post('keterangan'),
        'created_date' => $this->input->post('insert_date'),
      );
      $this->db->insert('ci_products', $product);
      $product_id = $this->db->insert_id();

      $this->db->insert('ci_images',array('product_id' => $product_id,'file_name' => $image_file));
      
      $last_sn = str_pad($this->product_model->last_sn_repair() + 1, 7, '0', STR_PAD_LEFT);
      $v_sn = $this->input->post('product_code').$last_sn;

      //insert into variants table
      $data = [
        'product_id' => $product_id,
        'v_weight' => $this->input->post('v_weight'),
        'v_size' => empty($this->input->post('v_size')) ? NULL : $this->input->post('v_size'),
        'v_length' => empty($this->input->post('v_length')) ? NULL : $this->input->post('v_length'),
        'v_width' => empty($this->input->post('v_width')) ? NULL : $this->input->post('v_width'),
        'v_sn' => strtoupper($v_sn),
        'v_kaunter' => $this->input->post('counter_price'),
        'v_emas' => $this->input->post('gold_price'),
        'v_margin' => $this->input->post('v_margin'),
        'v_margin_pay' => $this->input->post('margin_pay'),
        'v_pay' => $this->input->post('v_pay'),
        'v_dasar' => $this->input->post('base_price'),
        'v_sb' => $this->input->post('serial_berat'),
        'v_kod' => strtoupper($this->input->post('v_kod')),
        'v_status' => 7, //repair
        'insert_date' => date("Y-m-d"),
      ];
      $this->db->insert('ci_variants',$data);
      $insert_id = $this->db->insert_id();

      //add repair
      $data_repair = array(
        'variant_id' => $insert_id,
        'add_berat' => $this->input->post('add_weight'),
        'add_saiz' => $this->input->post('add_size'),
        'add_lebar' => $this->input->post('add_width'),
        'add_panjang' => $this->input->post('add_length'),
      );
      $this->db->insert('ci_repair_add', $data_repair);
  
      //variants status
      $data_sta = array(
        'variants_id' => $insert_id,
        // 'cust_id' => 2,
        // 'status' => 7 //tempahan baru
      );
      $this->db->insert('ci_variants_sta', $data_sta);

      // $this->session->set_flashdata('upload', "<script>
      // Swal.fire({
      //   icon: 'success',
      //   title: '<h4>Produk Baiki berjaya Ditambah</h4>',
      //   showConfirmButton: false,
      //   timer: 1200
      // })
      // </script>");
  
      redirect('booking/repair_invoices/'.$insert_id, 'refresh');
    
    } else {
  
      $this->data['error_image'] = $this->upload->display_errors();
    
      $this->template->load('layouts/admin', 'booking/create_repair', $this->data);
    }
  }

  public function add_booking()
  {
    $v_id = $this->input->post('v_id');
    
    $data = array(
      'cust_id' => $this->input->post('cust_id'),
      'variant_id' => $this->input->post('v_id'),
      'deposit' => $this->input->post('deposit'),
      'tarikh' => date('Y-m-d')
    );
    $this->db->insert('ci_booking', $data);
    $book_id = $this->db->insert_id();

    $this->db->where('id', $book_id);
    $this->db->update('ci_booking', array('booking_id' => '#'.str_pad($book_id, 8, '0', STR_PAD_LEFT)));    

    //table order
    // $order = array(
    //   'cawangan_id' => $this->input->post('cawangan'),
    //   'cust_id' => $this->input->post('cust_id'),
    //   'seller' => $this->data['user_profile']['user_id'],
    //   'created_date' => date("Y-m-d H:i:s"),
    //   'paid_total' => $this->input->post('deposit'), 
    // );
    // $this->db->insert('ci_orders', $order);
    // $order_id = $this->db->insert_id();

    // //create no siri
    // $this->db->where('order_id', $order_id);
    // $this->db->update('ci_orders', array('order_no' => '#'.str_pad($order_id, 7, '0', STR_PAD_LEFT)));

    $data_sta = array(
      'cust_id' => $this->input->post('cust_id'),
      'staf_id' => $this->data['user_profile']['user_id'],
      'harga' => $this->input->post('deposit'),
      // 'order_id' => $order_id,
      'tarikh'=> date('Y-m-d'),
    );
    $this->db->where('variants_id', $this->input->post('v_id'));
    $this->db->update('ci_variants_sta', $data_sta);

    //table transaksi
    $trans_data = array(
      'variant_id' => $v_id,
      'cust_id' => $this->input->post('cust_id'),
      'cawangan_id' => $this->input->post('cawangan'),
      'bayaran' => $this->input->post('deposit'), 
      'cara_bayaran' => $this->input->post('cara_bayaran'), 
      'keterangan' => 'Deposit Tempahan Baru',
      'tarikh_transaksi' => date("Y-m-d H:i:s"), 
      'staff_id' => $this->data['user_profile']['user_id'],
      'status' => 5,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    //table cash in/out
    if ($this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == 3) {
      $cash_data = array(
        'cawangan_id' => $this->input->post('cawangan'),
        'staf_id' => $this->data['user_profile']['user_id'],
        'total' => $this->input->post('deposit'),
        'cara_bayaran' => $this->input->post('cara_bayaran'),
        'category' => 4,
        'tarikh' => date("Y-m-d H:i:s"),
        'perincian' => 'Deposit Tempahan Baru',
        'v_id' => $v_id,
        'status' => 5,
      );
      $this->db->insert('cash_in_out', $cash_data);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Tempahan Ditambah</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('booking/booking_detail/'.$v_id, 'refresh');
  }

  public function delete_booking_item($v_id,$product_id)
  {
    $this->db->where('product_id', $product_id);
    $this->db->delete('ci_images');

    $this->db->where('product_id', $product_id);
    $this->db->delete('ci_images');

    $this->db->where('product_id', $product_id);
    $this->db->delete('ci_products');

    $this->db->where('variant_id', $v_id);
    $this->db->delete('ci_book_shop');

    $this->db->where('variant_id', $v_id);
    $this->db->delete('ci_variants');

    $this->db->where('variants_id', $v_id);
    $this->db->delete('ci_variants_sta');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Tempahan Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('booking/all_variants', 'refresh');
  }

  public function add_repair()
  {
    $v_id = $this->input->post('v_id');

    $data = array(
      'cust_id' => $this->input->post('cust_id'),
      'staf_id' => $this->data['user_profile']['user_id'],
      'variant_id' => $this->input->post('v_id'),
      'harga' => $this->input->post('deposit'),
      'tarikh' => date('Y-m-d')
    );
    $this->db->insert('ci_repair', $data);
    $repair_id = $this->db->insert_id();

    $this->db->where('id', $repair_id);
    $this->db->update('ci_repair', array('repair_id' => '#'.str_pad($repair_id, 8, '0', STR_PAD_LEFT)));

    $data_sta = array(
      'cust_id' => $this->input->post('cust_id'),
      'harga' => $this->input->post('deposit'),
      'tarikh' => date('Y-m-d'),
      // 'repair_id'=> $repair_id,
    );
    $this->db->where('variants_id', $this->input->post('v_id'));
    $this->db->update('ci_variants_sta', $data_sta);

    //table transaksi
    $trans_data = array(
      'variant_id' => $v_id,
      'cawangan_id' => $this->input->post('cawangan'),
      'cust_id' => $this->input->post('cust_id'),
      'bayaran' => $this->input->post('deposit'),
      'cara_bayaran' => $this->input->post('cara_bayaran'),
      'keterangan' => 'Deposit Tempahan Baiki',
      'tarikh_transaksi' => date("Y-m-d H:i:s"), 
      'staff_id' => $this->data['user_profile']['user_id'],
      'status' => 6,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    //table cash in/out
    if ($this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == 3) {
      $cash_data = array(
        'cawangan_id' => $this->input->post('cawangan'),
        'staf_id' => $this->data['user_profile']['user_id'],
        'total' => $this->input->post('deposit'),
        'cara_bayaran' => $this->input->post('cara_bayaran'),
        'category' => 4,
        'tarikh' => date("Y-m-d H:i:s"),
        'perincian' => 'Deposit Tempahan Baiki',
        'v_id' => $v_id,
        'status' => 6,
      );
      $this->db->insert('cash_in_out', $cash_data);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Baiki Ditambah</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('booking/repair_detail/'.$v_id, 'refresh');
  }

  public function repair_detail($v_id)
  {
    $this->data['id'] = $v_id;
    $this->data['book'] = $this->order_model->get_repair($v_id);
    $this->data['syarat_baiki'] = $this->admin_model->syarat_baiki();
    // $this->data['repair'] = $this->product_model->get_add_repair($variant_id);
    $this->data['maklumat'] = $this->admin_model->get_maklumat();

    $this->template->load('layouts/admin', 'booking/repair_detail', $this->data);
  }

  public function booking_detail($v_id)
  {
    $this->data['title'] = "TEMPAHAN";
    $this->data['book'] = $this->order_model->get_book($v_id);
    $this->data['syarat_baru'] = $this->admin_model->syarat_baru();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();

    $this->template->load('layouts/admin', 'booking/booking_detail', $this->data);
  }

  public function tempahan_detail($book_id)
  {
    $this->data['book'] = $this->product_model->sta_variant_detail($book_id);
    $this->data['syarat_kedai'] = $this->admin_model->syarat_kedai();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();

    $this->template->load('layouts/admin', 'booking/tempahan_detail', $this->data);
  }

  public function print_booking($book_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('user/login', 'refresh');
    }

    $this->data['book'] = $this->order_model->get_book($book_id);
    $this->data['syarat_baru'] = $this->admin_model->syarat_baru();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();
    
    $this->load->view('booking/print_booking', $this->data);
  }

  public function print_repair($repair_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('user/login', 'refresh');
    }

    // $this->data['id'] = $v_id;
    $this->data['book'] = $this->order_model->get_repair($repair_id);
    $this->data['syarat_baiki'] = $this->admin_model->syarat_baiki();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();
    
    $this->load->view('booking/print_repair', $this->data);
  }

  public function list_booking()
  {
    $this->data['title'] = "Senarai Tempahan Baru";
    $this->data['book'] = $this->order_model->get_all_book();

    $this->template->load('layouts/admin','booking/list_booking', $this->data);
  }

  public function list_repair()
  {
    $this->data['title'] = "Senarai Baiki";
    $this->data['book'] = $this->order_model->get_all_repair();

    $this->template->load('layouts/admin','booking/list_repair', $this->data);
  }

  public function list_booking_shop()
  {
    $this->data['book'] = $this->order_model->book_shop();

    $this->template->load('layouts/admin','booking/list_booking_shop', $this->data);
  }

  public function product_in()
  {
    $id = $this->input->post('v_id');

    // $data_sta = array(
    //   'status' => 8
    // );
    // $this->db->where('variants_id', $id);
    // $this->db->update('ci_variants_sta', $data_sta);

    $data_var = array(
      'v_status' => 8
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_variants', $data_var);

    $new_data = array(
      'new_weight' =>  $this->input->post('new_weight'),
      'new_length' => $this->input->post('new_length'),
      'new_width' => $this->input->post('new_width'),
      'new_size' => $this->input->post('new_size'),
      'note' => $this->input->post('note'),
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_book_shop', $new_data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Produk Dimasukkan</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('booking/list_booking_shop', 'refresh');
  }

  public function book_done()
  {
    $id = $this->input->post('v_id');

    // $data_sta = array(
    //   'status'=> 9
    // );
    // $this->db->where('variants_id', $id);
    // $this->db->update('ci_variants_sta', $data_sta);

    $data_var = array(
      'V_status'=> 9,
      'v_kod'=> $this->input->post('new_kod'),
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_variants', $data_var);

    $new_data = array(
      'new_weight'=> $this->input->post('new_weight'),
      'new_length'=>$this->input->post('new_length'),
      'new_width'=>$this->input->post('new_width'),
      'new_size'=>$this->input->post('new_size'),
      // 'note'=>$this->input->post('note'),
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_book_shop', $new_data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Produk Dimasukkan</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('booking/list_booking', 'refresh');
  }

  public function edit_book_done()
  {
    $id = $this->input->post('edit_v_id');

    $data_var = array(
      'v_kod'=> $this->input->post('new_kod'),
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_variants', $data_var);

    $new_data = array(
      'new_weight'=> $this->input->post('new_weight'),
      'new_length'=>$this->input->post('new_length'),
      'new_width'=>$this->input->post('new_width'),
      'new_size'=>$this->input->post('new_size'),
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_book_shop', $new_data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Produk Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('booking/list_booking', 'refresh');
  }

  public function repair_done()
  {
    $id = $this->input->post('v_id');
    $p_id = $this->input->post('p_id');
    $c_id = $this->input->post('c_id');

    // $data_sta = array(
    //   'status'=> 10
    // );
    // $this->db->where('variants_id', $id);
    // $this->db->update('ci_variants_sta', $data_sta);

    $data_var = array(
      'V_status'=> 10
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_variants', $data_var);

    $new_data = array(
      'add_berat'=> $this->input->post('new_weight'),
      'add_panjang'=>$this->input->post('new_length'),
      'add_lebar'=>$this->input->post('new_width'),
      'add_saiz'=>$this->input->post('new_size'),
      'bayaran'=>$this->input->post('bayaran'),
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_repair_add', $new_data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Produk Dimasukkan</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('booking/list_repair', 'refresh');
  }

  public function edit_repair_done()
  {
    $id = $this->input->post('v_id');
    $p_id = $this->input->post('p_id');
    $c_id = $this->input->post('c_id');

    $new_data = array(
      'add_berat'=> $this->input->post('new_weight'),
      'add_panjang'=>$this->input->post('new_length'),
      'add_lebar'=>$this->input->post('new_width'),
      'add_saiz'=>$this->input->post('new_size'),
      'bayaran'=>$this->input->post('new_harga'),
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_repair_add', $new_data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Produk Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('booking/list_repair', 'refresh');
  }
  
  public function add_buy_shop($id,$v_sn,$weight,$length,$width,$size)
  {
    // $data_sta = array(
    //   'status'=> 0
    // );
    // $this->db->where('variants_id', $id);
    // $this->db->update('ci_variants_sta', $data_sta);

    // $data_var = array(
    //   'v_status'=> 0
    // );
    // $this->db->where('variant_id', $id);
    // $this->db->update('ci_variants', $data_var);

    // $data_book = array(
    //   'status'=> 1
    // );
    // $this->db->where('variant_id', $id);
    // $this->db->update('ci_book_shop', $data_book);

    redirect('catalog/create_order/'.$v_sn.'/'.$weight.'/'.$length.'/'.$width.'/'.$size, 'refresh');
  }

  public function add_buy($id,$v_sn)
  {
    // $data_sta = array(
    //   'status'=> 0
    // );
    // $this->db->where('variants_id', $id);
    // $this->db->update('ci_variants_sta', $data_sta);

    $data_var = array(
      'V_status'=> 0
    );
    $this->db->where('variant_id', $id);
    $this->db->update('ci_variants', $data_var);

    redirect('catalog/create_order/'.$v_sn, 'refresh');
  }

  public function repair_paid()
  {
    $v_id = $this->input->post('v_id');
    $p_id = $this->input->post('p_id');
    $cust_id = $this->input->post('c_id');

    // $data_sta = array(
    //   'status'=> 1
    // );
    // $this->db->where('variants_id', $v_id);
    // $this->db->update('ci_variants_sta', $data_sta);

    $data_var = array(
      'v_status'=> 1
    );
    $this->db->where('variant_id', $v_id);
    $this->db->update('ci_variants', $data_var);

    // $data_cat = array(
    //   'order_category'=> 9,
    //   'subtotal'=> $deposit,
    // );
    // $this->db->where('variant_id', $v_id);
    // $this->db->update('ci_order_items', $data_cat);

    $order = array(
      'cust_id' => $cust_id,
      'cawangan_id' => $this->input->post('cawangan'),
      'seller' => $this->data['user_profile']['user_id'],
      'created_date' => date("Y-m-d H:i:s"),
      'kategori' => 3,
      'paid_total' => 0,
    );
    $this->db->insert('ci_orders', $order);
    $order_id = $this->db->insert_id();

    //create no siri
    $this->db->where('order_id', $order_id);
    $this->db->update('ci_orders', array('order_no' => '#'.str_pad($order_id, 7, '0', STR_PAD_LEFT)));

    $order_item = array(
      'order_id' => $order_id,
      'product_id' => $p_id,
      'variant_id' => $v_id,
      'order_category' => 9,
      'subtotal'=> $this->input->post('bayaran'),
    );
    $this->db->insert('ci_order_items', $order_item);

     //table transaksi
     $trans_data=array(
      'variant_id' => $v_id,
      'cust_id' => $cust_id,
      'cawangan_id' => $this->input->post('cawangan'),
      'harga_baiki' => $this->input->post('baki'), 
      'cara_bayaran' => $this->input->post('cara_bayaran'), 
      'keterangan' => 'Bayaran Tempahan Baiki',
      'tarikh_transaksi' => date("Y-m-d H:i:s"), 
      'staff_id' => $this->data['user_profile']['user_id'],
      'status' => 7,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    //table cash in/out
    if ($this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == 3) {
      $cash_data = array(
        'staf_id' => $this->data['user_profile']['user_id'],
        'cawangan_id' => $this->input->post('cawangan'),
        'total' => $this->input->post('baki'),
        'cara_bayaran' => $this->input->post('cara_bayaran'),
        'category' => 4,
        'tarikh' => date("Y-m-d H:i:s"),
        'perincian' => 'Bayaran Tempahan Baiki',
        'v_id' => $v_id,
        'status' => 7,
      );
      $this->db->insert('cash_in_out', $cash_data);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Bayaran Berjaya</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('booking/repair_detail/'.$v_id, 'refresh');
  }

  public function deposit_booking()
  {
    $v_id = $this->input->post('v_id');
    $cust_id = $this->input->post('c_id');
    $deposit = $this->input->post('deposit');
    $tambah = $this->input->post('tambah');

    $data = array(
      'deposit' =>  $deposit + $tambah
    );
    $this->db->where('variant_id', $v_id);
    $this->db->update('ci_booking', $data);

    $sta = array(
      'harga'=> $deposit + $tambah
    );
    $this->db->where('variants_id', $v_id);
    $this->db->update('ci_variants_sta', $sta);

    //table transaksi
    $trans_data = array(
      'cawangan_id' => $this->input->post('cawangan_id'),
      'variant_id' => $v_id,
      'cust_id' => $cust_id,
      'bayaran' => $tambah, 
      'cara_bayaran' => $this->input->post('cara_bayaran'), 
      'keterangan' => 'Deposit Tempahan Baru',
      'tarikh_transaksi' => date("Y-m-d H:i:s"), 
      'staff_id' => $this->data['user_profile']['user_id'],
      'status' => 5,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    //table cash in/out
    if ($this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == 3) {
      $cash_data = array(
        'staf_id' => $this->data['user_profile']['user_id'],
        'cawangan_id' => $this->input->post('cawangan'),
        'total' => $tambah,
        'cara_bayaran' => $this->input->post('cara_bayaran'),
        'category' => 4,
        'tarikh' => date("Y-m-d H:i:s"),
        'perincian' => 'Tambah Deposit Tempahan Baru',
        'v_id' => $v_id,
        'status' => 5,
      );
      $this->db->insert('cash_in_out', $cash_data);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Deposit Ditambah</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('booking/booking_detail/'.$v_id, 'refresh');
  }

  public function deposit_booking_shop()
  {
    $v_id = $this->input->post('v_id');
    $cust_id = $this->input->post('c_id');
    $deposit = $this->input->post('deposit');
    $tambah = $this->input->post('tambah');

    $data = array(
      'harga'=> $deposit + $tambah
    );
    $this->db->where('variants_id', $v_id);
    $this->db->update('ci_variants_sta', $data);

    //table transaksi
    $trans_data = array(
      'variant_id' => $v_id,
      'cawangan_id' => $this->input->post('cawangan'),
      'cust_id' => $cust_id,
      'bayaran' => $tambah, 
      'cara_bayaran' => $this->input->post('cara_bayaran'), 
      'keterangan' => 'Deposit Tempahan Kedai',
      'tarikh_transaksi' => date("Y-m-d H:i:s"), 
      'staff_id' => $this->data['user_profile']['user_id'],
      'status' => 3,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    //table cash in/out
    if ($this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == 3) {
      $cash_data = array(
        'staf_id' => $this->data['user_profile']['user_id'],
        'cawangan_id' => $this->input->post('cawangan'),
        'total' => $tambah,
        'cara_bayaran' => $this->input->post('cara_bayaran'),
        'category' => 4,
        'tarikh' => date("Y-m-d H:i:s"),
        'perincian' => 'Tambah Deposit Tempahan Kedai',
        'v_id' => $v_id,
        'status' => 3,
      );
      $this->db->insert('cash_in_out', $cash_data);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Deposit Ditambah</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('booking/tempahan_detail/'.$v_id, 'refresh');
  }

  public function deposit_booking_repair()
  {
    $v_id = $this->input->post('v_id');
    $cust_id = $this->input->post('c_id');
    $deposit = $this->input->post('deposit');
    $tambah = $this->input->post('tambah');

    $data = array(
      'harga'=> $deposit + $tambah
    );
    $this->db->where('variant_id', $v_id);
    $this->db->update('ci_repair', $data);

    //table transaksi
    $trans_data = array(
      'cawangan_id' => $this->input->post('cawangan_id'),
      'variant_id' => $v_id,
      'cust_id' => $cust_id,
      'bayaran' => $tambah, 
      'cara_bayaran' => $this->input->post('cara_bayaran'), 
      'keterangan' => 'Deposit Tempahan Baiki',
      'tarikh_transaksi' => date("Y-m-d H:i:s"), 
      'staff_id' => $this->data['user_profile']['user_id'],
      'status' => 6,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    //table cash in/out
    if ($this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == 3) {
      $cash_data = array(
        'cawangan_id' => $this->input->post('cawangan_id'),
        'staf_id' => $this->data['user_profile']['user_id'],
        'total' => $tambah,
        'cara_bayaran' => $this->input->post('cara_bayaran'),
        'category' => 4,
        'tarikh' => date("Y-m-d H:i:s"),
        'perincian' => 'Tambah Deposit Tempahan Baiki',
        'v_id' => $v_id,
        'status' => 6,
      );
      $this->db->insert('cash_in_out', $cash_data);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Deposit Ditambah</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('booking/repair_detail/'.$v_id, 'refresh');
  }


}

