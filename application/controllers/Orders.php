<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('pdf_report');

    if ($this->ion_auth->logged_in())
		{
      $user = $this->ion_auth->user()->row();
      $this->data['user_profile'] = $this->user_model->get_profile($user->id);
      $this->data['count_pending'] = $this->product_model->count_pending();
      $this->data['logo'] = $this->admin_model->get_logo();
      $this->data['cawangan'] = $this->admin_model->get_cawangan();
      $this->data['month'] = $this->admin_model->get_month();
      $this->data['maklumat'] = $this->admin_model->get_maklumat();
    }else {
      redirect('user/login','refresh');
    }
  }

  public function list_orders()
  {
    // if ($this->uri->segment(3)) {
    //   $this->data['orders'] = $this->order_model->get_all_orders($this->uri->segment(3));
    // }else {
    //   $this->data['orders'] = $this->order_model->get_all_orders();
    // }

    // $this->data['maklumat'] = $this->admin_model->get_maklumat();
    $this->data['staf'] = $this->report_model->get_staf_all(); //except admin 

    $this->template->load('layouts/admin','orders/orders_table', $this->data);
  }

  public function query_list_order()
  {
    $data = $row = array();
    
    // Fetch model
    $modelData = $this->order_model->RowListOrder($_POST);
    
    $i = $_POST['start'];
    foreach($modelData as $row){
      $i++;

      if ($row->order_category == 9) {
        $total = $row->subtotal;
      }else {
        $total = $row->paid_total;
      }

      if ($row->kategori == 1) {
        $category = "Ikat Harga";
      }elseif ($row->kategori == 2) {
        $category = "Harga Semasa";
      }elseif ($row->order_category == 9) {
        $category = "Tempahan Baiki";
      }

      if ($row->sold == 1 || $row->order_category == 9) {
        $status = "<span class='text-green'>Selesai</span>";
      }elseif ($row->sold == 2) {
        $status = "<span class='text-danger'>Batal</span>";
      }else {
        $status = "<span class='text-warning'>Deposit</span>"; 
      }

      if ($row->order_category == 9) {
        $detail = '<a href="'.base_url('booking/repair_detail/'.$row->repair_id).'"  title="Lihat Invois" class="text-green"><span class="fe fe-file fe-20"></span></a>';
      }else {
        $detail = '<a href="'.base_url('orders/detail/'.$row->order_id).'"  title="Lihat Invois" class="text-green"><span class="fe fe-file fe-20"></span></a>';
      }

      if ($row->order_category == 9) {
        $print = '<a href="'.base_url('booking/print_repair/'.$row->repair_id).'" target="_blank" title="Cetak Invois" class=""><span class="fe fe-printer fe-20"></span></a>';
      }else {
        $print = '<a href="'.base_url('orders/print_order/'.$row->order_id).'" target="_blank" title="Cetak Invois" class=""><span class="fe fe-printer fe-20"></span></a>';
      }

      $data[] = array(
        $i,
        $row->order_no,
        $row->cust,
        $row->staf,
        // $row->cawangan,
        $total,
        $category,
        date('d-m-Y', strtotime($row->created_date)).' | '.date('h:i a', strtotime($row->created_date)),
        $status,
        $detail.' | '.$print
      );
    }
    
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->order_model->countAllListOrder(),
      "recordsFiltered" => $this->order_model->countFilteredListOrder($_POST),
      "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
  }

  public function search_orders()
  {
    $this->data['title'] = "Carian";
    $this->data['orders'] = $this->order_model->search_orders();

    $this->template->load('layouts/admin','orders/search_orders',$this->data);
  }
  
  public function detail($order_id='')
  {
    $this->data['orders'] = $this->order_model->get_order($order_id);
    $this->data['items'] = $this->order_model->get_items($order_id);
    $this->data['resit'] = $this->order_model->get_resit($order_id);
    $this->data['syarat_ikat'] = $this->admin_model->syarat_pesanan_ikat();
    $this->data['syarat_semasa'] = $this->admin_model->syarat_pesanan_semasa();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();

    $this->template->load('layouts/admin','orders/order_detail', $this->data);
  }

  public function cancel_order($order_id='')
  {
    if (!$this->ion_auth->logged_in()) {
      redirect('user/login', 'refresh');
    }

    $this->data['orders'] = $this->order_model->get_order($order_id);
    $this->data['items'] = $this->order_model->get_items($order_id);
    $this->data['resit'] = $this->order_model->get_resit($order_id);
    $this->data['syarat_ikat'] = $this->admin_model->syarat_pesanan_ikat();
    $this->data['syarat_semasa'] = $this->admin_model->syarat_pesanan_semasa();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();

    $this->template->load('layouts/admin','orders/cancel_order', $this->data);
  }

  public function checkout(){

    $this->data['cust'] = $this->user_model->get_cust();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();
    $this->data['count_dn'] = $this->order_model->count_dn();
    $this->data['cawangan'] = $this->admin_model->get_cawangan();

    $this->template->load('layouts/admin','product/invoices_checkout', $this->data); 
  }

  public function add_resit($order_id, $cust_id)
  { 
    $total_semasa = $this->input->post('total_semasa');

    $resit_data = array(
      'order_id' => $order_id,
      'cara_bayaran' => $this->input->post('cara_bayaran'),
      'tarikh_bayaran' => $this->input->post('tarikh_bayaran'), 
      'jumlah' => $this->input->post('jumlah_bayaran'),
      'nota' => $this->input->post('nota_bayaran'),
    );
    $this->db->insert('ci_resit', $resit_data);

    //table transaksi
    $trans_data = array(
      'cawangan_id' => $this->input->post('cawangan_id'),
      'order_id' => $order_id,
      'cust_id' => $cust_id,
      'bayaran' => $this->input->post('jumlah_bayaran'), 
      'keterangan' => 'Bayaran Pesanan',
      'cara_bayaran' => $this->input->post('cara_bayaran'),
      'tarikh_transaksi' => date("Y-m-d H:i:s"), 
      'staff_id' => $this->data['user_profile']['user_id'],
      'status' => 1,
      // 'vip' => $this->input->post('vip'),
    );
    $this->db->insert('ci_transaksi', $trans_data);

    //table cash in/out
    if ($this->data['user_profile']['user_group'] != 0 && $this->data['user_profile']['user_group'] != 1) {
      $cash_data=array(
        'cawangan_id' => $this->input->post('cawangan_id'),
        'staf_id' => $this->data['user_profile']['user_id'],
        'total' => $this->input->post('jumlah_bayaran'),
        'cara_bayaran' => $this->input->post('cara_bayaran'),
        'category' => 4,
        'tarikh' => date("Y-m-d H:i:s"),
        'perincian' => 'Bayaran Pesanan',
        'order_id' => $order_id,
        'note' => $this->input->post('nota_bayaran'),
      );
      $this->db->insert('cash_in_out', $cash_data);
    }

    $balance_total = ($this->input->post('balance_total') - $this->input->post('jumlah_bayaran'));
    $paid_total = ($this->input->post('paid_total') + $this->input->post('jumlah_bayaran'));
    $total_paid = $total_semasa - $paid_total;

    $minus_balance = array(
      'balance_total' => $balance_total,
      'paid_total' => $paid_total
    );
    $this->db->where('order_id',$order_id);
    $this->db->update('ci_orders',$minus_balance);

    $v_id = $this->input->post('v_id[]');

    $per_gram_semasa = $this->input->post('per_gram_semasa[]')? $this->input->post('per_gram_semasa[]') : NULL;
    $sb_price_semasa = $this->input->post('sb_price_semasa[]')? $this->input->post('sb_price_semasa[]') : NULL;
    $subtotal        = $this->input->post('subtotal[]')? $this->input->post('subtotal[]') : NULL;

    if ($balance_total == 0 || $total_paid == 0) {
      foreach ($v_id as $key => $value) {
        $update_status = array(
          'v_status' => 1
        );
        $this->db->where('variant_id',$value);
        $this->db->update('ci_variants',$update_status);

        $update_v_out = array(
          'updated' => date("Y-m-d H:i:s"),
        );
        $this->db->where('variant_id',$value);
        $this->db->update('ci_order_items',$update_v_out);
      }

      //get commision
      $maklumat = $this->admin_model->get_maklumat();

      if ($this->input->post('kategori') == 2) {
        for($i=0;$i < count($per_gram_semasa);$i++){

          $res = explode('_',$v_id[$i]);
  
          $update = array(
            'setup_price' => $per_gram_semasa[$i],
            'sb_price' => $sb_price_semasa[$i],
            'subtotal' => $subtotal[$i],
            'komisen' => $maklumat['komisen']
          );
          $this->db->where('variant_id',$res[0]);
          $this->db->update('ci_order_items',$update);
        }
      }


      $minus_balance = array(
        'balance_total' => 0,
        'total_all' => $total_semasa,
        'sold' => 1,
        // 'komisen'=>$comm,
      );
      $this->db->where('order_id',$order_id);
      $this->db->update('ci_orders',$minus_balance);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Resit / Invois Ditambah</h4>',
        showConfirmButton: false,
        timer: 1200 
      })
    </script>");

    redirect('orders/detail/'.$order_id,'refresh');
  }

  public function store_order()
  {
    $_SESSION['total_all'] = $total_all = $this->input->post('upd_total_all');
    $_SESSION['total_real'] = $total_all = $this->input->post('total_all');

    $_SESSION['arr_itemID'] = $arr_itemID = $this->input->post('item_id[]') ? $this->input->post('item_id[]') : NULL;
    $_SESSION['arr_productID'] = $arr_itemID = $this->input->post('item_product_id[]') ? $this->input->post('item_product_id[]') : NULL;
    
    $_SESSION['arr_itemName'] = $arr_itemName = $this->input->post('item_name[]') ? $this->input->post('item_name[]') : NULL;
    $_SESSION['arr_itemPrice'] = $arr_itemPrice = $this->input->post('item_price[]') ? $this->input->post('item_price[]') : NULL;
    $_SESSION['arr_itemDis'] = $arr_itemDis = $this->input->post('item_dis[]') ? $this->input->post('item_dis[]') : NULL;
    $_SESSION['arr_itemDepo'] = $arr_itemDepo = $this->input->post('item_depo[]') ? $this->input->post('item_depo[]') : NULL;
    $_SESSION['arr_itemSubtotal'] = $arr_itemSubtotal = $this->input->post('item_subtotal[]') ? $this->input->post('item_subtotal[]') : NULL;
    $_SESSION['arr_itemSetupPrice'] = $arr_itemSetupPrice = $this->input->post('item_setup_price[]') ? $this->input->post('item_setup_price[]') : NULL;
    $_SESSION['arr_itemSbPrice'] = $arr_itemSbPrice = $this->input->post('item_sb_price[]') ? $this->input->post('item_sb_price[]') : NULL;
    $_SESSION['arr_itemWeight'] = $arr_itemWeight = $this->input->post('item_weight[]') ? $this->input->post('item_weight[]') : NULL;
    $_SESSION['arr_itemMarginPay'] = $arr_itemMarginPay = $this->input->post('item_margin_pay[]') ? $this->input->post('item_margin_pay[]') : NULL;
    $_SESSION['arr_itemWeightAsal'] = $arr_itemWeightAsal = $this->input->post('item_weight_asal[]') ? $this->input->post('item_weight_asal[]') : NULL;
    $_SESSION['arr_itemNota'] = $arr_itemNota = $this->input->post('item_nota[]') ? $this->input->post('item_nota[]') : NULL;

    $a = array_sum($_SESSION['arr_itemDepo']);

    $order = array(
      'cawangan_id' => $this->input->post('cawangan'),
      'cust_id' => $this->input->post('cust_id'),
      'seller' => $this->data['user_profile']['user_id'],
      'created_date' => date("Y-m-d H:i:s"),
      'total_real' => $_SESSION['total_real'],
      'tracking_num' => $this->input->post('tracking_num'),
      'total_shipping' => $this->input->post('postage'),
      'total_tax_rm' => $this->input->post('tax_rm'),
      'total_tax' => $this->input->post('tax'),
      'total_adjustment' => $this->input->post('adjustment'),
      'total_all' => $_SESSION['total_all'],
      'balance_total' => $_SESSION['total_all'] - $a,
      'kategori' => $this->input->post('kategori'),
      'paid_total' => $a,
      // 'vip'=>$this->input->post('vip'),
    );
    $this->db->insert('ci_orders', $order);
    $order_id = $this->db->insert_id();

    //create no siri
    $this->db->where('order_id', $order_id);
    $this->db->update('ci_orders', array('order_no' => '#'.str_pad($order_id, 7, '0', STR_PAD_LEFT)));

    // if ($this->input->post('vip')) {
    //   $dn = array(
    //     'order_id' => $order_id,
    //     'dn_id' => $this->input->post('dn'),
    //   );
    //   $this->db->insert('ci_dn', $dn);
    // }else {
    //   $dn = array(
    //     'order_id' => $order_id
    //   );
    //   $this->db->insert('ci_dn', $dn);
    // }

    if ($a != 0) {
      $resit = array(
        'order_id' => $order_id,
        'cara_bayaran' => 4,
        'jumlah' => $a,
        'tarikh_bayaran' => date("Y-m-d"),
      );
      $this->db->insert('ci_resit', $resit);

      //table transaksi
      // $trans_data=array(
      //   'order_id'=>$order_id,
      //   'cust_id'=>$this->input->post('things'),
      //   'bayaran'=>$a, 
      //   'keterangan'=> 'Bayaran Pesanan',
      //   'tarikh_transaksi'=>date("Y-m-d H:i:s"), 
      //   'staff_id'=>$this->data['user_profile']['user_id'],
      //   'status'=>1,
      // );
      // $this->db->insert('ci_transaksi', $trans_data);
    }
    

    for($i=0;$i < count($_SESSION['arr_itemID']);$i++){
      
      $res = explode('_',$_SESSION['arr_itemID'][$i]);
      $items = array(
        'order_id' => $order_id,
        'product_id' => $_SESSION['arr_productID'][$i],
        'variant_id' => $res[0],
        'qty' => 1,
        'ordered_price' => $_SESSION['arr_itemPrice'][$i],
        'ordered_dis' => $_SESSION['arr_itemDis'][$i],
        'ordered_margin_pay' => $_SESSION['arr_itemMarginPay'][$i],
        'ordered_weight' => $_SESSION['arr_itemWeight'][$i],
        'setup_price' => $_SESSION['arr_itemSetupPrice'][$i],
        'sb_price' => $_SESSION['arr_itemSbPrice'][$i],
        'subtotal' => $_SESSION['arr_itemSubtotal'][$i],
        'updated' => date("Y-m-d H:i:s"),
        'staf_id' => $this->data['user_profile']['user_id'],
        'nota' => $_SESSION['arr_itemNota'][$i],
      );
      $this->db->insert('ci_order_items', $items);

      $v_price = ($_SESSION['arr_itemWeight'][$i] * $_SESSION['arr_itemSetupPrice'][$i]) + $_SESSION['arr_itemMarginPay'][$i];
      $v_beli_calc =  $v_price - $_SESSION['arr_itemDis'][$i];

      $sold_items = array(
        'v_status' => 3,
        'v_beli' => $v_beli_calc,
        'baki_berat' => $_SESSION['arr_itemWeightAsal'][$i] - $_SESSION['arr_itemWeight'][$i],
        'tukang_date' => date("Y-m-d H:i:s"),
        'kategori' => $this->input->post('kategori'),
      );
      $this->db->where('variant_id',$res[0]);
      $this->db->update('ci_variants',$sold_items);

      $data_sta = array(
        'diskaun' => $_SESSION['arr_itemDis'][$i],
        'order_id' => $order_id,
        // 'vip'=>$this->input->post('vip'),
      );
      $this->db->where('variants_id',$res[0]);
      $this->db->update('ci_variants_sta',$data_sta);

    }

    $order_status=array(
      'order_id' => $order_id,
      'order_status' => 1,
    );
    $this->db->insert('ci_order_status', $order_status);
    $order_statusID=$this->db->insert_id();

    $this->cart->destroy();

    redirect('orders/detail/'.$order_id,'refresh');
  }

  public function refund_item($order_id,$user_id)
  {
    $_SESSION['arr_v_id'] = $arr_v_id = $this->input->post('v_id[]')? $this->input->post('v_id[]') : NULL;
    $_SESSION['arr_check'] =$arr_check = $this->input->post('check[]')? $this->input->post('check[]') : NULL;
    $_SESSION['arr_bayar_balik'] = $arr_bayar_balik = $this->input->post('bayar_balik[]')? $this->input->post('bayar_balik[]') : NULL;
    $_SESSION['arr_nota'] = $arr_itemPrice = $this->input->post('nota[]')? $this->input->post('nota[]') : NULL;
    $_SESSION['arr_ordered_price'] = $arr_ordered_price = $this->input->post('ordered_price[]')? $this->input->post('ordered_price[]') : NULL;

    $after_refund = 0;

    // for($i=0;$i<count($_SESSION['arr_check']);$i++){
    for($i = 0;$i < count($_SESSION['arr_bayar_balik']);$i++){

      if ($_SESSION['arr_bayar_balik'][$i]) {

        $res = explode('_',$_SESSION['arr_v_id'][$i]);

        $items = array(
          'variants_id' => $res[0],
          'harga_jual' => $_SESSION['arr_ordered_price'][$i],
          'bayar_balik' => $_SESSION['arr_bayar_balik'][$i],
          'nota' => $_SESSION['arr_nota'][$i],
          'order_id' => $order_id,
          'tarikh' => date("Y-m-d H:i:s"),
        );
        $this->db->insert('refund_item', $items);

        $order_item = array(
          'order_category' => 99,
          'komisen' => 0,
          'refund' => $_SESSION['arr_ordered_price'][$i] - $_SESSION['arr_bayar_balik'][$i],
        );
        $this->db->where('order_id', $order_id);
        $this->db->where('variant_id', $res[0]);
        $this->db->update('ci_order_items', $order_item);

        $variants = array(
          'v_status' => 0,
          'v_beli' => NULL,
          'baki_berat' => NULL,
          'tukang_date' => NULL,
          'kategori' => 0,
        );
        $this->db->where('variant_id', $res[0]);
        $this->db->update('ci_variants', $variants);

        $variants_sta = array(
          // 'status' => 0,
          // 'cust_id' => 2,
          'staf_id' => NULL,
          'harga' => 0.00,
          'diskaun' => 0.00,
          'tarikh' => NULL,
          'nota' => NULL,
          'order_id' => NULL,
          'bayar_baki' => NULL,
        );
        $this->db->where('variants_id', $res[0]);
        $this->db->update('ci_variants_sta', $variants_sta);

        $after_refund += $_SESSION['arr_bayar_balik'][$i];
        
      }
    }

    $total_semasa = $this->input->post('paid_total') - $after_refund;

    // $comm = $this->order_model->get_commission($total_semasa);

    $order = array(
      'total_all' => $this->input->post('total_all') - $after_refund,
      'paid_total' => $this->input->post('paid_total') - $after_refund,
      // 'komisen' => $comm,
      'sold' => 2,
    );
    $this->db->where('order_id', $order_id);
    $this->db->update('ci_orders', $order);

    if ($this->input->post('refund_tunai')) {
      $resit_tunai = array(
        'order_id' => $order_id,
        'cara_bayaran' => 1,
        'jumlah' => '-'.$this->input->post('refund_tunai'),
        'tarikh_bayaran'=>date("Y-m-d H:i:s"),
        'nota'=> 'Refund',
      );
      $this->db->insert('ci_resit', $resit_tunai);

      //table transaksi
      $trans_tunai = array(
        'cawangan_id' => $this->input->post('cawangan'),
        'order_id' => $order_id,
        'cust_id' => $user_id,
        'bayaran' => '-'.$this->input->post('refund_tunai'), 
        'keterangan' => 'Bayaran Balik',
        'cara_bayaran' => 1,
        'tarikh_transaksi' => date("Y-m-d H:i:s"), 
        'staff_id' => $this->data['user_profile']['user_id'],
        'status' => 99,
      );
      $this->db->insert('ci_transaksi', $trans_tunai);
    }
    
    if ($this->input->post('refund_bank')) {
      $resit_bank = array(
        'order_id' => $order_id,
        'cara_bayaran' => 2,
        'jumlah' => '-'.$this->input->post('refund_bank'),
        'tarikh_bayaran' => date("Y-m-d H:i:s"),
        'nota' => 'Refund',
      );
      $this->db->insert('ci_resit', $resit_bank);

      //table transaksi
      $trans_bank = array(
        'cawangan_id' => $this->input->post('cawangan'),
        'order_id' => $order_id,
        'cust_id' => $user_id,
        'bayaran' => '-'.$this->input->post('refund_bank'), 
        'keterangan' => 'Bayaran Balik',
        'cara_bayaran' => 2,
        'tarikh_transaksi' => date("Y-m-d H:i:s"), 
        'staff_id' => $this->data['user_profile']['user_id'],
        'status' => 99,
      );
      $this->db->insert('ci_transaksi', $trans_bank);
    }

    if ($this->input->post('refund_credit')) {
      $resit_credit = array(
        'order_id' => $order_id,
        'cara_bayaran' => 3,
        'jumlah' => '-'.$this->input->post('refund_credit'),
        'tarikh_bayaran'=>date("Y-m-d H:i:s"),
        'nota'=> 'Refund',
      );
      $this->db->insert('ci_resit', $resit_credit);

      //table transaksi
      $trans_credit = array(
        'cawangan_id' => $this->input->post('cawangan'),
        'order_id' => $order_id,
        'cust_id' => $user_id,
        'bayaran' => '-'.$this->input->post('refund_credit'), 
        'keterangan' => 'Bayaran Balik',
        'cara_bayaran' => 3,
        'tarikh_transaksi' => date("Y-m-d H:i:s"), 
        'staff_id' => $this->data['user_profile']['user_id'],
        'status' => 99,
      );
      $this->db->insert('ci_transaksi', $trans_credit);
    }

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Batal Jualan Berjaya</h4>',
        showConfirmButton: false,
        timer: 1200 
      })
    </script>");

    redirect('orders/detail/'.$order_id,'refresh');
  }

  public function print_order($order_id){
    
    $this->data['title'] = 'Cetak Maklumat Pesanan';
    $this->data['orders'] = $this->order_model->get_order($order_id);
    $this->data['items'] = $this->order_model->get_items($order_id);
    $this->data['resit'] = $this->order_model->get_resit($order_id);
    $this->data['syarat_ikat']=$this->admin_model->syarat_pesanan_ikat();
    $this->data['syarat_semasa']=$this->admin_model->syarat_pesanan_semasa();
    $this->data['maklumat']=$this->admin_model->get_maklumat();

    $this->load->view('orders/print_order', $this->data);
  }

  public function print_tag($variant_id){

    $this->data['variant'] = $this->product_model->get_variant_detail($variant_id);
    $this->data['maklumat']=$this->admin_model->get_maklumat();

    $this->load->view('orders/print_tag', $this->data);
  }

  public function print_tag2($variant_id){

    $this->data['variant'] = $this->product_model->get_variant_detail($variant_id);

    $this->load->view('orders/print_tag2', $this->data);
  }

}
