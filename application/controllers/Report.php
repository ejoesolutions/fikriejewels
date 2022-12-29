<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('pdf_report');

    if (!$this->ion_auth->logged_in()) {
			redirect('user/login', 'refresh');
		} else {
      $user = $this->ion_auth->user()->row();
      $this->data['user_profile'] = $this->user_model->get_profile($user->id);
      $this->data['logo'] = $this->admin_model->get_logo();
      $this->data['count_pending'] = $this->product_model->count_pending();
      $this->data['cawangan'] = $this->admin_model->get_cawangan();
      $this->data['month'] = $this->admin_model->get_month();
      $this->data['maklumat'] = $this->admin_model->get_maklumat();
    }
  }

  public function get_report()
  {
    // $this->data['report'] = $this->report_model->get_report();
    $this->data['staf'] = $this->report_model->get_staf_all(); //except admin

    $this->template->load('layouts/admin','report/report_table', $this->data);
  }

  public function query_report()
  {
    $data = $row = array();
    
    // Fetch model
    $modelData = $this->report_model->RowReport($_POST);
    
    $i = $_POST['start'];
    foreach($modelData as $row){
      $i++;

      if ($row->status == 8 || $row->status == 9) {
        $customer = '-';
      }else {
        $customer = '<span class="d-inline-block text-truncate pt-2" style="max-width: 250px;">'.$row->cust.'</span>';
      }

      if ($row->cara_bayaran == 1) { 
        $bayar = "Tunai";
      }elseif ($row->cara_bayaran == 2) {
        $bayar = "Bank In";
      } elseif ($row->cara_bayaran == 3) {
        $bayar = "Debit/Credit";
      }else {
        $bayar = "-";
      }

      if ($row->bayaran) {
        $total = $row->bayaran;
      }elseif ($row->harga_baiki) {
        $total = $row->harga_baiki;
      }

      if ($row->order_id) {
        $link = '<a href="'.base_url('orders/detail/'.$row->order_id).'">Lihat Perincian</a>';
      }elseif ($row->buy_id) {
        $link = '<a href="'.base_url('buy/buy_detail/'.$row->buy_id).'">Lihat Perincian</a>';
      }elseif ($row->variant_id && $row->status==3) {
        $link = '<a href="'.base_url('booking/tempahan_detail/'.$row->variant_id).'">Lihat Perincian</a>';
      }elseif ($row->variant_id && $row->status==4) {
        $link = '<a href="'.base_url('catalog/print_keluar/'.$row->variant_id).'">Lihat Perincian</a>';
      }elseif ($row->variant_id && $row->status==5) {
        $link = '<a href="'.base_url('booking/booking_detail/'.$row->variant_id).'">Lihat Perincian</a>';
      }elseif ($row->variant_id && $row->status==6) {
        $link = '<a href="'.base_url('booking/repair_detail/'.$row->variant_id).'">Lihat Perincian</a>';
      }elseif ($row->variant_id && $row->status==7) {
        $link = '<a href="'.base_url('booking/repair_detail/'.$row->variant_id).'">Lihat Perincian</a>';
      }else {
        $link = '-';
      }

      $data[] = array(
        $i,
        $customer,
        $row->staff,
        // $row->tag,
        $row->keterangan,
        $bayar,
        $total,
        date('d-m-Y', strtotime($row->tarikh_transaksi)).' | '.date('h:i a', strtotime($row->tarikh_transaksi)),
        $link,
      );
    }
    
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->report_model->countAllReport(),
      "recordsFiltered" => $this->report_model->countFilteredReport($_POST),
      "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
  }

  public function get_keluar()
  {
    $this->data['keluar'] = $this->report_model->get_keluar();

    $this->template->load('layouts/admin','report/report_keluar', $this->data);
  }

  public function get_refund()
  {
    $this->data['refund'] = $this->report_model->get_refund();

    $this->template->load('layouts/admin','report/report_refund', $this->data);
  }

  public function get_deleted_v()
  {
    $this->data['deleted'] = $this->report_model->get_deleted_v();

    $this->template->load('layouts/admin','report/deleted_v', $this->data);
  }
  
  public function check_dulang()
  {
    // $this->data['dulang'] = $this->report_model->get_by_dulang(NULL);

    $this->template->load('layouts/admin','report/check_by_dulang', $this->data);
  }

  // public function show_type()
  // {
  //   $this->data['type'] = $this->input->post('type');
  //   $this->data['sub'] = $this->input->post('sub');

  //   $this->load->view('load/old_type', $this->data);
  // }

  public function add_check_stok($cawangan_id, $id, $n)
  {
    $this->data['dulang'] = $dulang = $this->product_model->list_stok_in_hand($cawangan_id, $id);

    if ($id && $dulang) {

      $this->db->where('cawangan_id', $cawangan_id);
      $this->db->where('dulang_id', $id);
      $this->db->delete('check_stok');
      
      foreach ($dulang as $key) {
        $data = array(
          'cawangan_id' => $cawangan_id,
          'product_id' => $key['product_id'],
          'v_sn' => $key['v_sn'],
          'dulang_id' => $key['dulang_id']
        );
        $this->db->insert('check_stok', $data);
      }
    }

    $this->db->where('id', $id);
    $this->db->update('ci_dulang', array('reset_at' => date('Y-m-d H:i:s')));
    
    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Set Semula</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    if ($n == 1) {
      redirect('report/check_dulang','refresh');
    }elseif ($n == 2) {
      redirect('report/check/'.$cawangan_id.'/'.$id,'refresh');
    }
  }

  public function check($cawangan_id, $id)
  {    
    $this->data['check'] = $this->product_model->check_stok($cawangan_id, $id);
    $this->data['dulang'] = $this->product_model->dulang_detail($id);
    $this->data['reset'] = $this->product_model->dulang_reset($id);

    $this->template->load('layouts/admin','report/check_stok', $this->data);
  }


  public function check_stok()
  {
    $variants = $this->input->post('variants');
    $id = $this->input->post('id');
    $cawangan_id = $this->input->post('cawangan_id');

    $data = array(
      'user_id' => $this->data['user_profile']['user_id'],
      'date_checked' => date('Y-m-d H:i:s'),
      'status' => 1
    );
    $this->db->where('v_sn', $variants);
    $this->db->update('check_stok', $data);

    $this->data['check'] = $this->product_model->check_stok($cawangan_id, $id);
    
    $this->template->load('layouts/ajax','report/ajax_check_stok', $this->data);
  }

  public function variants_out()
  {
    // if ($this->data['user_profile']['user_group'] == 2)
    // {
    //   return show_404('The page you requested was not found.');
    // }

    // $this->data['variants'] = $this->report_model->v_out();
    $this->data['staf'] = $this->report_model->get_staf_all();

    $this->template->load('layouts/admin','report/variants_out', $this->data);
  }

  public function query_variants_out()
  {
    $data = $row = array();
    
    // Fetch model
    $modelData = $this->report_model->RowVariantOut($_POST);
    
    $i = $_POST['start'];
    foreach($modelData as $row){
      $i++;

      $product = 
      '<span class="d-inline-block text-truncate mt-2 text-dark" style="max-width: 200px;">'.$row->product_name.'</span>
      <br>
      <small><a class="text-dark">['.$row->v_sn.']</a></small>
      <br>
      <small>'.$row->order_no.'</small>';

      $data[] = array(
        $i,
        $product,
        // $row->tag,
        $row->staf,
        number_format($row->ordered_weight, 2, '.', ''),
        $row->subtotal,
        $row->ordered_margin_pay,
        // $row->komisen,
        date('d-m-Y', strtotime($row->updated)).'<br>'.date('h:i a', strtotime($row->updated)),
        '<a title="Lihat Perincian" href="'.base_url('orders/detail/'.$row->order_id).'"><i class="fe fe-search fe-20"></i></a>'
      );
    }
    
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->report_model->countAllVariantOut(),
      "recordsFiltered" => $this->report_model->countFilteredVariantOut($_POST),
      "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
  }

  public function print_v_out()
  {
    if (!$this->ion_auth->logged_in()) {
			redirect('user/login', 'refresh');
		} else {

      if ($this->input->post('carian') == 1) {
        $this->data['date_month'] = null;
        $this->data['date_min'] = $this->input->post('date_min');
        $this->data['date_max'] = $this->input->post('date_max');
      }elseif ($this->input->post('carian') == 2) {
        $this->data['date_min'] = null;
        $this->data['date_month'] = $this->input->post('date_month');
        $this->data['date_year'] = $this->input->post('date_year');
      }else {
        $this->data['date_month'] = null;
        $this->data['date_min'] = null;
      }
      
      if ($this->input->post('staf_id')) {
        $this->data['staf'] = $this->report_model->get_staf_detail($this->input->post('staf_id'));
      }else {
        $this->data['staf'] = null; 
      }

      $this->data['variants'] = $this->report_model->v_out();
      // $this->data['staf'] = $this->report_model->get_staf_all();
      $this->data['count_total_item'] = $this->report_model->count_stok_in();
      $this->data['count_weight'] = $this->report_model->count_weight();
      $this->data['count_price'] = $this->report_model->count_price();
      $this->data['maklumat']= $this->admin_model->get_maklumat();
  
      if ($this->data['user_profile']['user_group'] == 0) {
        $this->load->view('report/print_v_out', $this->data);
      }else {
        $this->load->view('report/print_v_out2', $this->data);
      }
    }
  }

  public function print_cash()
  {
    if (!$this->ion_auth->logged_in()) {
			redirect('user/login', 'refresh');
		} else {

      if ($this->input->post('carian') == 1) {
        $this->data['date_month'] = null;
        $this->data['date_min'] = $this->input->post('date_min');
        $this->data['date_max'] = $this->input->post('date_max');
      }elseif ($this->input->post('carian') == 2) {
        $this->data['date_min'] = null;
        $this->data['date_month'] = $this->input->post('date_month');
        $this->data['date_year'] = $this->input->post('date_year');
        $this->data['kategori'] = $this->input->post('kategori');
      }elseif ($this->input->post('carian') == 3) {
        $this->data['date_month'] = null;
        $this->data['date_min'] = null;
        $this->data['kategori'] = $this->input->post('kategori');
      }else {
        $this->data['date_month'] = null;
        $this->data['date_min'] = null;
        $this->data['kategori'] = null;
      }

      $this->data['cash'] = $this->report_model->cash_report();
      $this->data['staf'] = $this->report_model->get_staf();
      $this->data['cash_in_total'] = $this->report_model->cash_in_total();
      $this->data['cash_out_total'] = $this->report_model->cash_out_total();
      $this->data['expenses_total'] = $this->report_model->expenses_total();
      $this->data['maklumat']= $this->admin_model->get_maklumat();
  
      $this->load->view('report/print_cash_out', $this->data);
    }
  }

  public function cash_in_out()
  {
    if (!$this->ion_auth->logged_in()) {
			redirect('user/login', 'refresh');
		} else {

      if ($this->input->post('carian') == 1) {
        $this->data['trigger'] = 1;
        $this->data['date_min'] = $this->input->post('date_min');
        $this->data['date_max'] = $this->input->post('date_max');
        $this->data['kategori'] = $this->input->post('kategori');
        $this->data['staf_id'] = $this->input->post('staf_id');
      }elseif ($this->input->post('carian') == 2) {
        $this->data['trigger'] = 2;
        $this->data['date_month'] = $this->input->post('date_month');
        $this->data['date_year'] = $this->input->post('date_year');
        $this->data['kategori'] = $this->input->post('kategori');
        $this->data['staf_id'] = $this->input->post('staf_id');
      }elseif ($this->input->post('carian') == 3) {
        $this->data['trigger'] = 3;
        $this->data['kategori'] = $this->input->post('kategori');
        $this->data['staf_id'] = $this->input->post('staf_id');
      }else {
        $this->data['trigger'] = null;
        $this->data['kategori'] = null;
        $this->data['staf_id'] = null;
      }
      
      $this->data['cash'] = $this->report_model->cash_report();
      $this->data['staf'] = $this->report_model->get_staf();

      $this->template->load('layouts/admin','report/cash_in_out', $this->data);
    }
  }

  public function stok_in()
  {
    // $this->data['variants'] = $this->product_model->list_stok_in();

    $this->template->load('layouts/admin','report/stok_in', $this->data);
  }

  public function query_stok_in(){
    $data = $row = array();
    
    // Fetch model
    $modelData = $this->product_model->RowStokIn($_POST);
    
    $i = $_POST['start'];
    foreach($modelData as $row){
      $i++;

      $product_name = '<span class="d-inline-block text-truncate mt-2" style="max-width: 250px;"><a class="text-dark" title="Lihat Produk" href="'.base_url('catalog/product_edit/'.$row->product_id).'">
        '.$row->product_name.'
      </a></span>';

      if ($this->data['user_profile']['user_group'] == 1 || $this->data['user_profile']['user_group'] == 0) {
        $data[] = array(
          $i,
          $product_name,
          $row->v_sn,
          $row->v_kod,
          $row->staf,
          $row->v_weight,
          number_format($row->v_weight * $row->setup_price, 2, '.', ''),
          date('d-m-Y', strtotime($row->insert_date)).' | '.date('h:i a', strtotime($row->insert_date)),
        );
      }else {
        $data[] = array(
          $i,
          $product_name,
          $row->v_sn,
          $row->v_kod,
          $row->v_weight,
          number_format($row->v_weight * $row->setup_price, 2, '.', ''),
          date('d-m-Y', strtotime($row->insert_date)).' | '.date('h:i a', strtotime($row->insert_date)),
        );
      }
      
    }
    
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->product_model->countAllStokIn(),
      "recordsFiltered" => $this->product_model->countFilteredStokIn($_POST),
      "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
  }

  public function stok_in_hand()
  {
    $this->data['dulang'] = $this->product_model->get_all_dulang();
    
    $this->template->load('layouts/admin','report/stok_in_hand', $this->data);
  }

  public function print_stok()
  {
    if ($this->input->post('carian') == 1) {
      $this->data['date_month'] = null;
      $this->data['date_min'] = $this->input->post('date_min');
      $this->data['date_max'] = $this->input->post('date_max');
    }elseif ($this->input->post('carian') == 2) {
      $this->data['date_min'] = null;
      $this->data['date_month'] = $this->input->post('date_month');
      $this->data['date_year'] = $this->input->post('date_year');
    }else {
      $this->data['date_month'] = null;
      $this->data['date_min'] = null;
    }

    $this->data['variants'] = $this->product_model->list_stok_in(); 
    $this->data['count_total_item'] = $this->product_model->count_stok_in();
    $this->data['count_weight'] = $this->product_model->count_weight();
    $this->data['count_price'] = $this->product_model->count_price();
    $this->data['maklumat']= $this->admin_model->get_maklumat();

    $this->load->view('report/print_stok', $this->data);
  }

  public function print_stok_hand()
  {
    if ($this->input->post('carian') == 1) {
      $this->data['date_month'] = null;
      $this->data['date_min'] = $this->input->post('date_min');
      $this->data['date_max'] = $this->input->post('date_max');
    }elseif ($this->input->post('carian') == 2) {
      $this->data['date_min'] = null;
      $this->data['date_month'] = $this->input->post('date_month');
      $this->data['date_year'] = $this->input->post('date_year');
    }else {
      $this->data['date_month'] = null;
      $this->data['date_min'] = null;
    }

    $this->data['variants'] = $this->product_model->list_stok_in_hand(); 
    $this->data['count_total_item'] = $this->product_model->count_stok_in_hand();
    $this->data['count_weight'] = $this->product_model->count_weight_hand();
    $this->data['count_price'] = $this->product_model->count_price_hand();
    $this->data['maklumat']= $this->admin_model->get_maklumat();

    // $this->load->view('report/print_stok_hand', $this->data);
    $this->load->view('report/print_stok', $this->data);
  }

  public function del_cash_in($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('cash_in_out');

    $this->db->where('cash_in_id', $id);
    $this->db->delete('ci_transaksi');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Berjaya Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");
    
    redirect('report/cash_in_out','refresh');
  }

  public function update_cash_admin()
  {
    $id = $this->input->post('id');
    $category = $this->input->post('category');

    if ($category == 1) {
      $x = "";
    }elseif ($category == 3) {
      $x = "-";
    }elseif ($category == 2) {
      $x = "-";
    }elseif ($category == 4) {
      $x = "";
    }

    $cash_data = array(
      'total' => $x.$this->input->post('upd_total'),
      'note' => $this->input->post('upd_note'),
    );
    $this->db->where('id', $id);
    $this->db->update('cash_in_out', $cash_data);

    $trans_data = array(
      'bayaran' => $x.$this->input->post('upd_total'),
    );
    $this->db->where('cash_in_id', $id);
    $this->db->update('ci_transaksi', $trans_data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Berjaya Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('report/cash_in_out','refresh');
  }

  public function insert_cash_admin()
  {
    $id = $this->input->post('staf_id');
    $category = $this->input->post('category');
    $staf = $this->user_model->get_profile($id);

    if ($this->input->post('cawangan')) {
      $cawangan = $this->input->post('cawangan');
    }else {
      $cawangan = $staf['cawangan_id'];
    }

    if ($category == 1) {
      $keterangan = "Cash In";
      $x = "";
    }elseif ($category == 3) {
      $keterangan = "Expenses";
      $x = "-";
    }elseif ($category == 2) {
      $keterangan = "Cash Out";
      $x = "-";
    }

    $data = array(
      'cawangan_id' => $cawangan,
      'staf_id' => $id,
      'total' => $x.$this->input->post('jumlah'),
      'category' => $category,
      'tarikh' => date('Y-m-d H:i:s'),
      'note' => $this->input->post('note'),
    );
    $this->db->insert('cash_in_out', $data);
    $cash_id = $this->db->insert_id();

     //table transaksi
     $trans_data = array(
      'cawangan_id' => $cawangan,
      'cust_id' => $id,
      'bayaran' => $x.$this->input->post('jumlah'),
      'keterangan' => $keterangan,
      'cara_bayaran' => 1,
      'cash_in_id' => $cash_id,
      'tarikh_transaksi' => date("Y-m-d H:i:s"), 
      'staff_id' => $id,
      'status' => 8,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Ditambah</h4>',
        showConfirmButton: false,
        timer: 1100
      })
    </script>");

    redirect('report/cash_in_out', 'refresh');
  }

  public function insert_cash()
  {
    $id = $this->input->post('staf_id');

    $data = array(
      'staf_id' => $id,
      'total' => $this->input->post('jumlah'),
      'category' => 1,
      'tarikh' => date('Y-m-d H:i:s'),
      'note' => $this->input->post('note'),
    );
    $this->db->insert('cash_in_out', $data);

     //table transaksi
     $trans_data=array(
      'cust_id'=>$id,
      'bayaran'=>$this->input->post('jumlah'),
      'keterangan'=> 'Cash In',
      'tarikh_transaksi'=>date("Y-m-d H:i:s"), 
      'staff_id'=>$id,
      'status'=>8,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Cash In</h4>',
      showConfirmButton: false,
      timer: 1100
    })
    </script>");

    redirect('report/cash_in/'.$id, 'refresh');
  }

  public function takeout_cash()
  {
    $id = $this->input->post('staf_id');

    $data = array(
      'staf_id' => $id,
      'total' => '-'.$this->input->post('jumlah'),
      'category' => $this->input->post('category'),
      'tarikh' => date('Y-m-d H:i:s'),
      'note' => $this->input->post('note'),
    );
    $this->db->insert('cash_in_out', $data);

    if ($this->input->post('category') == 2) {
      $k = "Cash Out";
      $status = 9;
    }elseif ($this->input->post('category') == 3) {
      $k = "Expenses";
      $status = 10;
    }
     //table transaksi
     $trans_data=array(
      'cust_id'=>$id,
      'bayaran'=>'-'.$this->input->post('jumlah'),
      'keterangan'=> $k,
      'tarikh_transaksi'=>date("Y-m-d H:i:s"), 
      'staff_id'=>$id,
      'status'=>$status,
    );
    $this->db->insert('ci_transaksi', $trans_data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Cash Out</h4>',
      showConfirmButton: false,
      timer: 1100
    })
    </script>");

    redirect('report/cash_in/'.$id, 'refresh');
  }

  public function summary()
  {
    if ($this->data['user_profile']['user_group'] == 1 || $this->data['user_profile']['user_group'] == 2)
    {
      return show_404('The page you requested was not found.');
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

    $this->data['jualan'] = $this->report_model->sum_jualan();
    $this->data['belian'] = $this->report_model->sum_belian();
    $this->data['weight'] = $this->product_model->list_variant_total_weight();
    $this->data['order'] = $this->order_model->get_order_summary();
    // $this->data['cash_in'] = $this->report_model->sum_cash_in();
    // $this->data['cash_out'] = $this->report_model->sum_cash_out();
    // $this->data['expenses'] = $this->report_model->sum_expenses();
    // $this->data['upah'] = $this->report_model->sum_upah();
    // $this->data['untung'] = $this->report_model->sum_kod_jualan();
    // $this->data['deposit'] = $this->report_model->sum_deposit();
    // $this->data['transaksi_bayaran'] = $this->report_model->sum_transaksi_bayaran();
    // $this->data['transaksi_baiki'] = $this->report_model->sum_transaksi_baiki();
    // $this->data['stock'] = $this->catalog_model->count_stock();

    $this->template->load('layouts/admin','report/summary', $this->data);
  }

  public function print_summary()
  {
    if (!$this->ion_auth->logged_in()) {
			redirect('user/login', 'refresh');
		} else {

      // if ($this->data['user_profile']['user_group'] == 1 || $this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == -1)
      // {
      //   return show_404('The page you requested was not found.');
      // }

      if ($this->input->post('carian') == 1) {
        $this->data['date_month'] = null;
        $this->data['date_min'] = $this->input->post('date_min');
        $this->data['date_max'] = $this->input->post('date_max');
      }elseif ($this->input->post('carian') == 2) {
        $this->data['date_min'] = null;
        $this->data['date_month'] = $this->input->post('date_month');
        $this->data['date_year'] = $this->input->post('date_year');
      }else {
        $this->data['date_month'] = null;
        $this->data['date_min'] = null;
      }

      $this->data['jualan'] = $this->report_model->sum_jualan();
      $this->data['belian'] = $this->report_model->sum_belian();
      $this->data['cash_in'] = $this->report_model->sum_cash_in();
      $this->data['cash_out'] = $this->report_model->sum_cash_out();
      $this->data['expenses'] = $this->report_model->sum_expenses();
      $this->data['upah'] = $this->report_model->sum_upah();
      $this->data['untung'] = $this->report_model->sum_kod_jualan();
      $this->data['deposit'] = $this->report_model->sum_deposit();
      $this->data['transaksi_bayaran'] = $this->report_model->sum_transaksi_bayaran();
      $this->data['transaksi_baiki'] = $this->report_model->sum_transaksi_baiki();
      $this->data['stock'] = $this->catalog_model->count_stock();
      $this->data['maklumat']= $this->admin_model->get_maklumat();
      
      $this->load->view('report/print_summary', $this->data);

    } 
  }

  public function inv_supplier()
  {
    if ($this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == 3)
    {
      return show_404('The page you requested was not found.');
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

    $this->data['list_supplier'] = $this->product_model->get_all_supplier();
    $this->data['supplier'] = $this->report_model->get_inv_supplier();

    $this->template->load('layouts/admin','report/inv_supplier', $this->data);
  }

  public function print_supplier()
  {
    if (!$this->ion_auth->logged_in()) {
			redirect('user/login', 'refresh');
		} else {

      if ($this->data['user_profile']['user_group'] == 2 || $this->data['user_profile']['user_group'] == 3)
      {
        return show_404('The page you requested was not found.');
      }

      if ($this->input->post('carian') == 1) {
        $this->data['date_month'] = null;
        $this->data['date_min'] = $this->input->post('date_min');
        $this->data['date_max'] = $this->input->post('date_max');
      }elseif ($this->input->post('carian') == 2) {
        $this->data['date_min'] = null;
        $this->data['date_month'] = $this->input->post('date_month');
        $this->data['date_year'] = $this->input->post('date_year');
      }else {
        $this->data['date_month'] = null;
        $this->data['date_min'] = null;
      }

      $this->data['supplier'] = $this->report_model->get_inv_supplier();
      $this->data['berat_inv_supplier'] = $this->report_model->berat_inv_supplier();
      $this->data['upah_inv_supplier'] = $this->report_model->upah_inv_supplier();
      $this->data['total_inv_supplier'] = $this->report_model->total_inv_supplier();
      $this->data['maklumat']= $this->admin_model->get_maklumat();

      $this->load->view('report/print_supplier', $this->data);
    }
  }

  public function del_invoice($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('inv_supplier');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Invoice Supplier Dipadam</h4>',
      showConfirmButton: false,
      timer: 1100
    })
    </script>");

    redirect('report/inv_supplier', 'refresh');
  }

  public function insert_invoice()
  {
    $data = array(
      'cawangan_id' => $this->input->post('cawangan'),
      'inv_no' => $this->input->post('inv_no'),
      'per_gram' => $this->input->post('per_gram'),
      'supplier' => $this->input->post('supplier'),
      'berat' => $this->input->post('berat'),
      'total_upah' => $this->input->post('total_upah'),
      'total' => $this->input->post('total'),
      'tarikh' => $this->input->post('tarikh'),
      'note' => $this->input->post('note') ? $this->input->post('note') : NULL,
    );
    $this->db->insert('inv_supplier', $data);
    $invoice_id = $this->db->insert_id();
    

    $config['upload_path'] = 'attach';
    $config['allowed_types']  = 'jpg|png|jpeg|pdf';
    $config['encrypt_name']  =  TRUE;
    $config['remove_spaces']  =  TRUE;
    $config['file_ext_tolower']  =  TRUE;
    $config['overwrite']  =  FALSE;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('attach')) {

      $upload_data = $this->upload->data();
      $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];
      
      $this->db->where('id', $invoice_id);
      $this->db->update('inv_supplier', array('attach' => $image_file));
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Invoice Supplier Ditambah</h4>',
        showConfirmButton: false,
        timer: 1100
      })
    </script>");

    redirect('report/inv_supplier', 'refresh');
  }

  public function edit_invoice()
  {
    $data = array(
      'cawangan_id' => $this->input->post('cawangan'),
      'inv_no' => $this->input->post('inv_no'),
      'per_gram' => $this->input->post('per_gram'),
      'supplier' => $this->input->post('supplier'),
      'berat' => $this->input->post('berat'),
      'total_upah' => $this->input->post('total_upah'),
      'total' => $this->input->post('total'),
      'tarikh' => $this->input->post('tarikh'),
      'note' => $this->input->post('note') ? $this->input->post('note') : NULL,
    );
    $this->db->where('id', $this->input->post('inv_id'));
    $this->db->update('inv_supplier', $data);
    

    $config['upload_path'] = 'attach';
    $config['allowed_types']  = 'jpg|png|jpeg|pdf';
    $config['encrypt_name']  =  TRUE;
    $config['remove_spaces']  =  TRUE;
    $config['file_ext_tolower']  =  TRUE;
    $config['overwrite']  =  FALSE;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('attach')) {

      unlink('attach/'.$this->input->post('old_attach'));

      $upload_data = $this->upload->data();
      $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];
      
      $this->db->where('id', $this->input->post('inv_id'));
      $this->db->update('inv_supplier', array('attach' => $image_file));
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Invoice Supplier Dikemaskini</h4>',
        showConfirmButton: false,
        timer: 1100
      })
    </script>");

    redirect('report/inv_supplier', 'refresh');
  }

  public function check_list_variants()
  {
    $sn = $this->input->post('sn');

    $this->data['result'] = $this->product_model->list_all_variant($sn);

    $this->load->view('report/ajax_check_variant', $this->data);
  }

  public function check_list_variants_dash()
  {
    $sn = $this->input->post('sn');

    $this->data['result'] = $this->product_model->list_all_variant($sn);

    $this->load->view('report/ajax_check_variant_dash', $this->data);
  }

  public function test()
  {
    $this->data['all'] = $this->report_model->get_test();
    $this->data['sold'] = $this->report_model->get_test1();
    $this->data['aval'] = $this->report_model->get_test0();
    $this->data['test2'] = $this->report_model->get_test2();
    $this->data['test3'] = $this->report_model->get_test3();
    $this->data['test4'] = $this->report_model->get_test4();
    $this->data['test5'] = $this->report_model->get_test5();
    $this->data['test6'] = $this->report_model->get_test6();
    $this->data['test7'] = $this->report_model->get_test7();
    $this->data['test8'] = $this->report_model->get_test8();
    $this->data['test9'] = $this->report_model->get_test9();
    $this->data['test10'] = $this->report_model->get_test10();
    $this->data['test99'] = $this->report_model->get_test99();
    $this->data['get_test7_list'] = $this->report_model->get_test7_list();

    $this->template->load('layouts/admin','report/test', $this->data);
  }

}


