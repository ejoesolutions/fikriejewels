<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('pdf_report');

    if ($this->ion_auth->logged_in()) {
      $user = $this->ion_auth->user()->row();
      $this->data['user_profile'] = $this->user_model->get_profile($user->id);
      $this->data['logo'] = $this->admin_model->get_logo();
      $this->data['count_pending'] = $this->product_model->count_pending();
      $this->data['cawangan'] = $this->admin_model->get_cawangan();
      $this->data['month'] = $this->admin_model->get_month();
      $this->data['maklumat'] = $this->admin_model->get_maklumat();
    }else {
      redirect('user/login','refresh');
    }
  }

  public function create_buy()
  {
    $this->data['mutu'] = $this->catalog_model->list_capital_price();
    $this->data['category'] = $this->catalog_model->list_category();
    $this->data['dulang'] = $this->product_model->get_all_dulang();
    $this->data['cust'] = $this->user_model->get_cust();
    // $this->data['last_id'] = $this->product_model->last_id_buy();
    // $this->data['v_sn'] = $this->product_model->last_sn_buy();
    $this->data['item'] = $this->product_model->get_item();

    $this->template->load('layouts/admin','buy/create_buy', $this->data);
  }

  public function delete_buy($id)
  {
    $this->db->where('status', 2);
    $this->db->delete('ci_buy_product');

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Produk Dipadam</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");
    
    redirect('buy/create_buy','refresh');
  }

  public function insert_item()
  {
    // $this->data['last_id'] = $last_id = $this->product_model->last_id_buy();

    $tables = $this->config->item('tables', 'ion_auth');
    
    // $this->form_validation->set_rules('no_siri', 'Nombor Siri', 'required|is_unique[' . $tables['ci_buy_product'] . '.serial_number]');

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

    // if ($this->upload->do_upload('userfile') && $this->form_validation->run() == TRUE) {
    if ($this->upload->do_upload('userfile')) {

      $upload_data = $this->upload->data();
      $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];

      $config['image_library'] = 'gd2';
      $config['source_image'] = 'images/'.$image_file;
      // $config['create_thumb'] = TRUE;
      $config['maintain_ratio'] = TRUE;
      $config['width'] = 500;
      $config['height'] = 500;
      $config['new_image'] = 'images/thumbnail/'.$image_file;

      $this->load->library('image_lib',$config);
      $this->image_lib->resize();

      //delete gambar lepas compressed
      unlink("images/".$image_file);

      $buy_item = array(
        'product_name'  => $this->input->post('nama_produk'),
        'staf_id'       => $this->data['user_profile']['user_id'],
        'mutu_id'       => $this->input->post('mutu_id'),
        'harga_semasa'  => $this->input->post('harga_semasa'),
        'serial_berat'  => $this->input->post('serial_berat'),
        'berat'         => $this->input->post('berat'),
        'saiz'          => $this->input->post('saiz'),
        'lebar'         => $this->input->post('lebar'),
        'panjang'       => $this->input->post('panjang'),
        'harga'         => $this->input->post('harga'),
        'keterangan'    => $this->input->post('keterangan'),
        'jenis'         => $this->input->post('jenis'),
        'status'        => 2,
        'picture'       => $image_file
      );
      $this->db->insert('ci_buy_product', $buy_item);
      $item_id = $this->db->insert_id();
      
      $this->db->where('id', $item_id);
      $this->db->update('ci_buy_product', array('serial_number' => 'BL'.str_pad($item_id, 8, '0', STR_PAD_LEFT)));

      $this->session->set_flashdata('upload', "<script>
        Swal.fire({
          icon: 'success',
          title: '<h4>Produk Ditambah</h4>',
          showConfirmButton: false,
          timer: 1200
        })
      </script>");

    }else {
      if ($this->upload->display_errors()) {
        $this->data['error_image'] = $this->upload->display_errors();
      }

      $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'error',
        title: 'Tidak Berjaya',
        text: 'Masukkan gambar atau nombor siri bertindan,Sila Masukkan Sekali Lagi'
      })
      </script>");
    }

    redirect('buy/create_buy', 'refresh');
  }

  public function add_buy_product()
  {
    $arr_buyID = $this->input->post('product_id[]');

    //buy_detail
    $buy = array(
      'cawangan_id' => $this->input->post('cawangan'),
      'cust_id' => $this->input->post('cust_id'),
      'seller' => $this->data['user_profile']['user_id'],
      'total_harga' => $this->input->post('jumlah'),
      'created_date' => date("Y-m-d H:i"),
    );
    $this->db->insert('ci_buy', $buy);
    $buy_id = $this->db->insert_id();


    //--------------------------------------

    if ($this->input->post('tunai')) {
      $trans_tunai=array(
        'cawangan_id' => $this->input->post('cawangan'),
        'buy_id' => $buy_id,
        'cust_id' => $this->input->post('cust_id'),
        'bayaran' => '-'.$this->input->post('tunai'), 
        'cara_bayaran' => 1, 
        'keterangan' => 'Bayaran Belian',
        'tarikh_transaksi' => date("Y-m-d H:i:s"), 
        'staff_id' => $this->data['user_profile']['user_id'],
        'status' => 2,
      );
      $this->db->insert('ci_transaksi', $trans_tunai);

      //table cash in/out
      if ($this->data['user_profile']['user_group'] != 0 && $this->data['user_profile']['user_group'] != 1) {
        $cash_tunai = array(
          'cawangan_id' => $this->input->post('cawangan'),
          'staf_id' => $this->data['user_profile']['user_id'],
          'total' => '-'.$this->input->post('tunai'),
          'cara_bayaran' => 1,
          'category' => 4,
          'tarikh' => date("Y-m-d H:i:s"),
          'perincian' => 'Bayaran Belian',
          'buy_id' => $buy_id,
        );
        $this->db->insert('cash_in_out', $cash_tunai);
      }
    }

    if ($this->input->post('bank')) {
      $trans_credit = array(
        'cawangan_id' => $this->input->post('cawangan'),
        'buy_id' => $buy_id,
        'cust_id' => $this->input->post('cust_id'),
        'bayaran' => '-'.$this->input->post('bank'), 
        'cara_bayaran' => 2, 
        'keterangan' => 'Bayaran Belian',
        'tarikh_transaksi' => date("Y-m-d H:i:s"), 
        'staff_id' => $this->data['user_profile']['user_id'],
        'status' => 2,
      );
      $this->db->insert('ci_transaksi', $trans_credit);

      //table cash in/out
      if ($this->data['user_profile']['user_group'] != 0 && $this->data['user_profile']['user_group'] != 1) {
        $cash_bank = array(
          'cawangan_id' => $this->input->post('cawangan'),
          'staf_id' => $this->data['user_profile']['user_id'],
          'total' => '-'.$this->input->post('bank'),
          'cara_bayaran' => 2,
          'category' => 4,
          'tarikh' => date("Y-m-d H:i:s"),
          'perincian' => 'Bayaran Belian',
          'buy_id' => $buy_id,
        );
        $this->db->insert('cash_in_out', $cash_bank);
      }
    }

    if ($this->input->post('credit')) {
      $trans_credit = array(
        'cawangan_id' => $this->input->post('cawangan'),
        'buy_id' => $buy_id,
        'cust_id' => $this->input->post('cust_id'),
        'bayaran' => '-'.$this->input->post('credit'), 
        'cara_bayaran' => 3, 
        'keterangan' => 'Bayaran Belian',
        'tarikh_transaksi' => date("Y-m-d H:i:s"), 
        'staff_id' => $this->data['user_profile']['user_id'],
        'status' => 2,
      );
      $this->db->insert('ci_transaksi', $trans_credit);

      //table cash in/out
      if ($this->data['user_profile']['user_group'] != 0 && $this->data['user_profile']['user_group'] != 1) {
        $cash_credit = array(
          'cawangan_id' => $this->input->post('cawangan'),
          'staf_id' => $this->data['user_profile']['user_id'],
          'total' => '-'.$this->input->post('credit'),
          'cara_bayaran' => 3,
          'category' => 4,
          'tarikh' => date("Y-m-d H:i:s"),
          'perincian' => 'Bayaran Belian',
          'buy_id' => $buy_id,
        );
        $this->db->insert('cash_in_out', $cash_credit);
      }
    }

    for($i=0; $i < count($arr_buyID); $i++){
      
      $res = explode('_',$arr_buyID[$i]);
      $item = array(
        'buy_id' => $buy_id,
        'status' => 1
      );
      $this->db->where('id', $arr_buyID[$i]);
      $this->db->update('ci_buy_product', $item);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Belian Ditambah</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('buy/buy_detail/'.$buy_id);
  }

  public function list_buy()
  {
    // if ($this->input->post('carian') == 1) {
    //   $this->data['trigger'] = 1;
    //   $this->data['date_min'] = $this->input->post('date_min');
    //   $this->data['date_max'] = $this->input->post('date_max');
    // }elseif ($this->input->post('carian') == 2) {
    //   $this->data['trigger'] = 2;
    //   $this->data['date_month'] = $this->input->post('date_month');
    //   $this->data['date_year'] = $this->input->post('date_year');
    // }else {
    //   $this->data['trigger'] = null;
    // }
    
    // $this->data['buy'] = $this->buy_model->all_buy_products();

    $this->template->load('layouts/admin','buy/list_buy', $this->data);
  }

  public function query_list_buy()
  {
    $data = $row = array();
    
    // Fetch model
    $modelData = $this->buy_model->RowListBuy($_POST);
    
    $i = $_POST['start'];
    foreach($modelData as $row){
      $i++;

      $product = '
      <span class="d-inline-block text-truncate mt-2 text-dark" style="max-width: 250px;">'.$row->product_name.'</span>
      <div>
        <small class="text-dark">'.$row->serial_number.'</small>
      </div>
      ';

      if ($row->berat) {
        $berat = $row->berat.' g';
      }else {
        $berat = '-';
      }

      if ($row->panjang) {
        $panjang = $row->panjang.' cm';
      }else {
        $panjang = '-';
      }

      if ($row->lebar) {
        $lebar = $row->lebar.' cm';
      }else {
        $lebar = '-';
      }

      if ($row->saiz) {
        $saiz = $row->saiz;
      }else {
        $saiz = '-';
      }

      if ($row->mutu) {
        $mutu = $row->mutu;
      }else {
        $mutu = '-';
      }

      // if ($row->serial_berat) {
      //   $serial_berat = $row->serial_berat;
      // }else {
      //   $serial_berat = '-';
      // }

      $detail = '
      <div class="row">
        <div>
          <small>B : '.$berat.'</small><br><small>P : '.$panjang.'</small><br><small> L : '.$lebar.'</small>
        </div>
        <div class="ml-3">
          <small>Sz : '.$saiz.'</small><br><small>M : '.$mutu.'</small>
        </div>
      </div>';

      if ($row->buy_id) {
        $click = '<a href="'.base_url('buy/buy_detail/'.$row->buy_id).'" title="Lihat Invois" class="text-green"><span class="fe fe-file fe-20"></span></a>
        |
        <a href="'.base_url('buy/buy_print/'.$row->buy_id).'" target="_blank" title="Cetak Invois" class=""><span class="fe fe-printer fe-20"></span></a>';
      }else {
        $click = '<span class="text-danger">Belum Selesai</span>';
      }

      $data[] = array(
        $i,
        '<img src="'.base_url('images/thumbnail/'.$row->picture).'">',
        $product,
        $detail,
        $row->berat,
        '<span class="d-inline-block text-truncate mt-2 text-dark" style="max-width: 250px;">'.$row->cust.'</span>',
        $row->staf_name,
        $row->harga,
        $row->created_date ? date('d-m-Y', strtotime($row->created_date)).' | '.date('h:i a', strtotime($row->created_date)) : '-',
        $click,
      );
    }
    
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->buy_model->countAllListBuy(),
      "recordsFiltered" => $this->buy_model->countFilteredListBuy($_POST),
      "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
  }

  public function print_buy()
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

    $this->data['buy'] = $this->buy_model->all_buy_products();
    $this->data['count_total_buy'] = $this->buy_model->count_total_buy();
    $this->data['count_weight'] = $this->buy_model->count_weight();
    $this->data['count_price'] = $this->buy_model->count_price();
    $this->data['maklumat']= $this->admin_model->get_maklumat();

    $this->load->view('buy/print_buy', $this->data);
  }

  public function buy_detail($order_id)
  {
    $this->data['buy'] = $this->order_model->get_buy($order_id);
    $this->data['items'] = $this->order_model->get_buy_items($order_id);
    $this->data['syarat_belian'] = $this->admin_model->syarat_belian();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();
    $this->data['resit'] = $this->order_model->get_resit_buy($order_id);
    
    $this->template->load('layouts/admin','buy/buy_detail', $this->data);
  }

  public function buy_print($order_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('user/login', 'refresh');
    }

    $this->data['buy'] = $this->order_model->get_buy($order_id);
    $this->data['items'] = $this->order_model->get_buy_items($order_id);
    $this->data['syarat_belian'] = $this->admin_model->syarat_belian();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();
    $this->data['resit'] = $this->order_model->get_resit_buy($order_id);
    
    $this->load->view('buy/buy_print', $this->data);
  }

  public function buy_checkout($order_id = '',$no_siri = '',$msg = '')
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('user/login', 'refresh');
    }

    $this->data['cust'] = $this->user_model->get_cust();
    $this->data['item'] = $this->product_model->get_item();
    $this->data['test'] = $this->product_model->test();
    $this->data['maklumat']=$this->admin_model->get_maklumat();

    $this->template->load('layouts/admin','buy/buy_checkout', $this->data);
  }

}

