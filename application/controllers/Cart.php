<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();

    //Codeigniter : Write Less Do More
  }

  public function add_pesanan()
  {

    $selling_item = array(
      'id' => ($this->input->post('has_variant') == 1) ? $this->input->post('product_id').'_'.$this->input->post('variant_id') : $this->input->post('product_id'),
      'name' => htmlspecialchars($this->input->post('product_name')),
      'price' => htmlspecialchars($this->input->post('price')),
      'qty' => ($this->input->post('has_variant') == 1) ? 1 : $this->input->post('qty'),
      'product_code' => $this->input->post('product_code'),
      'weight' => $this->input->post('weight'),
      'ejen_price' => htmlspecialchars($this->input->post('ejen_price')),
      'ahli_price' => htmlspecialchars($this->input->post('ahli_price')),
      'base_komisyen' => $this->input->post('base_komisyen'),
      'komisyen_ejen' => $this->input->post('komisyen_ejen'),
      'has_variant' => $this->input->post('has_variant'),
    );

    // Insert to cart
    $this->cart->insert($selling_item);

    redirect('customer/cart', 'refresh');
  }

  public function add() {

    $selling_item = array(

      'id'            => $this->input->post('id'),
      'qty'           => 1,
      'price'         => $this->input->post('price'),
      'name'          => $this->input->post('product_name'),
      'product_id'    => $this->input->post('product_id'),
      'weight'        => $this->input->post('weight'),
      'weight_asal'   => $this->input->post('weight_asal'),
      'sn'            => $this->input->post('sn'),
      'size'          => $this->input->post('size'),
      'length'        => $this->input->post('length'),
      'width'         => $this->input->post('width'),
      'sb'            => $this->input->post('sb'),
      'pay'           => $this->input->post('pay'),
      'margin_pay'    => $this->input->post('margin_pay'),
      'mutu'          => $this->input->post('mutu'),
      'setup_price'   => $this->input->post('setup_price'),
      'diskaun'       => $this->input->post('diskaun'),
      'deposit'       => $this->input->post('deposit'),
      'adjustment'    => $this->input->post('adjustment'),
      'tax'           => $this->input->post('tax'),
      'sb_price'      => $this->input->post('serial_berat_price'),
      'nota'          => $this->input->post('nota'),

    );

    // Insert to cart
    $this->cart->insert($selling_item);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Produk Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('catalog/create_order', 'refresh');
  }

  //-----------------

  public function add_buy() {

    $buy_item = array(

      'id'            => $this->input->post('no_siri'),
      'qty'           => 1,
      'cust'          => $this->input->post('cust'),
      'price'         => $this->input->post('harga'),
      'name'          => $this->input->post('nama_produk'),
      'no_siri'       => $this->input->post('no_siri'),
      'mutu_id'       => $this->input->post('mutu_id'),
      // 'mutu'          => $this->input->post('mutu'),
      'keterangan'    => $this->input->post('keterangan'),
      'berat'         => $this->input->post('berat'),
      'saiz'          => $this->input->post('saiz'),
      'lebar'         => $this->input->post('lebar'),
      'panjang'       => $this->input->post('panjang'),
      'serial_berat'  => $this->input->post('serial_berat'),

    );

    // Insert to cart
    $this->cart->insert($buy_item);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Produk Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('buy/create_buy', 'refresh');
  }

  //-----------------------------

  public function update_cart()
  {
    $data=$this->cart->update(array(
      'rowid'=>$this->input->post('row_id'),
      'qty'=> $this->input->post('qty')
    ));

    $this->cart->update($data);

    redirect('customer/cart', 'refresh');
  }

  public function remove_cart($id)
  {
    $data=$this->cart->update(array(
      'rowid'=>$id,
      'qty'=> 0
    ));

    $this->cart->update($data);

    // $this->session->set_flashdata('upload', "<script>
    // Swal.fire({
    //   icon: 'success',
    //   title: '<h4>Produk Dipadam</h4>',
    //   showConfirmButton: false,
    //   timer: 900
    // })
    // </script>");

    redirect('catalog/create_order', 'refresh');
  }

  public function remove_cart_buy($id)
  {
    $data=$this->cart->update(array(
      'rowid'=>$id,
      'qty'=> 0
    ));

    $this->cart->update($data);

    // $this->session->set_flashdata('upload', "<script>
    // Swal.fire({
    //   icon: 'success',
    //   title: '<h4>Produk Dipadam</h4>',
    //   showConfirmButton: false,
    //   timer: 900
    // })
    // </script>");

    redirect('buy/create_buy', 'refresh');
  }

  public function reset_cart()
  {
    $this->cart->destroy();
    
    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Produk Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200 
    })
    </script>");

    redirect('catalog/create_order', 'refresh');
  }

}
