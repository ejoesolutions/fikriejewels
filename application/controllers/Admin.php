<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->database();
    
    if ($this->ion_auth->logged_in())
    {
      $user = $this->ion_auth->user()->row();
      $this->data['user_profile'] = $this->user_model->get_profile($user->id);
      $this->data['count_pending'] = $this->product_model->count_pending();
      $this->data['cawangan'] = $this->admin_model->get_cawangan();
      $this->data['month'] = $this->admin_model->get_month();
      $this->data['maklumat'] = $this->admin_model->get_maklumat();
    }else {
      redirect('user/login','refresh');
    }

    // if ($this->data['user_profile']['user_group'] > 2)
    // {
    //   return show_404('The page you requested was not found.');
    // }

    $this->data['logo'] = $this->admin_model->get_logo();
  }

  public function index()
  {
    // redirect('user/login', 'refresh');
  }

  public function dashboard()
  {
    $this->data['transaksi'] = $this->report_model->get_report_dash();
    $this->data['order'] = $this->order_model->get_dash_orders();
    $this->data['variants'] = $this->product_model->list_all_variant();

    $this->template->load('layouts/admin','pages/dashboard', $this->data);
  }

  public function setting(){

    if ($this->data['user_profile']['user_group'] == 2)
    {
      return show_404('The page you requested was not found.');
    }

    $this->data['username'] = $this->db->username;
    // $this->data['cost'] = $this->admin_model->get_weightcost();
    // $this->data['email']=$this->admin_model->get_admin_email();
    $this->data['syarat_ikat'] = $this->admin_model->syarat_pesanan_ikat();
    $this->data['syarat_semasa'] = $this->admin_model->syarat_pesanan_semasa();
    $this->data['syarat_belian'] = $this->admin_model->syarat_belian();
    $this->data['syarat_keluar'] = $this->admin_model->syarat_keluar();
    $this->data['syarat_kedai'] = $this->admin_model->syarat_kedai();
    $this->data['syarat_baru'] = $this->admin_model->syarat_baru();
    $this->data['syarat_baiki'] = $this->admin_model->syarat_baiki();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();
    // $this->data['komisen'] = $this->admin_model->get_komisen();
    $this->data['state'] = $this->admin_model->get_state();
    $this->data['cawangan'] = $this->admin_model->get_cawangan();
    
    $this->template->load('layouts/admin','pages/setting_page', $this->data);
  }

  public function update_cawangan()
  {
    $cawangan = array(
      'name' => $this->input->post('nama'),
      'cawangan_code' => $this->input->post('code'),
      'nama_tambahan' => $this->input->post('n_tambahan'),
      'pendaftaran' => $this->input->post('pendaftaran'),
      'alamat' => $this->input->post('alamat'),
      'poskod' => $this->input->post('poskod'),
      'bandar' => $this->input->post('bandar'),
      'negeri' => $this->input->post('negeri'),
      'telefon' => $this->input->post('telefon'),
      'hp1' => $this->input->post('hp1'),
      'hp2' => $this->input->post('hp2'),
      'tag' => $this->input->post('tag'),
    );
    $this->db->where('id', $this->input->post('cawangan_id'));
    $this->db->update('cawangan', $cawangan);
    
    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Kemaskini Cawangan Bejaya</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('admin/setting/maklumat', 'refresh');
  }

  public function store_logo(){
    
    // Muat naik imej
    $config['upload_path'] = 'logo';
    $config['allowed_types']  = 'jpg|png|jpeg';
    $config['max_width']  =  1500;
    $config['max_height']  =  1500;
    $config['encrypt_name']  =  TRUE;
    $config['remove_spaces']  =  TRUE;
    $config['file_ext_tolower']  =  TRUE;
    $config['overwrite']  =  FALSE;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('userfile')) {

      $upload_data = $this->upload->data();
      $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];

      // Simpan imej dalam database
      $imageData = array(
        'image_file' => $image_file,
        'status'=>1,
      );

      if($this->data['logo']['logo_id'] != ''){
        $this->db->where('logo_id',$this->input->post('logo_id'));
        $this->db->update('ci_logo',$imageData);

        unlink("logo/".$this->input->post('temp_logo'));
      }else{
        $this->db->insert('ci_logo',$imageData);
      }

      $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Kemaskini Logo Bejaya</h4>',
        showConfirmButton: false,
        timer: 1200
      })
      </script>");

      redirect('admin/setting', 'refresh');

    }else{

      $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'error',
        title: 'Kemaskini Logo Tidak Berjaya',
        text: 'Sila Semak Saiz Gambar!'
      })
      </script>");

      redirect('admin/setting', 'refresh');
    }
  }

  //Syarat Ikat Harga
  public function store_syarat_ikat()
  {
    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->insert('syarat_pesanan_ikat',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/pesanan','refresh');
  }
  
  public function edit_syarat_ikat()
  {
    $id = $this->input->post('id');

    $data = array(
      'text' => $this->input->post('syarat')
    );
    $this->db->where('id', $id);
    $this->db->update('syarat_pesanan_ikat',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/pesanan','refresh');
  }
  
  public function delete_syarat_ikat($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('syarat_pesanan_ikat');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/pesanan','refresh');
  }
  //./Syarat Ikat Harga   

  //Syarat Harga Semasa
  public function store_syarat_semasa()
  {
    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->insert('syarat_pesanan_semasa',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/pesanan','refresh');
  }

  public function edit_syarat_semasa()
  {
    $id = $this->input->post('id');

    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->where('id', $id);
    $this->db->update('syarat_pesanan_semasa',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/pesanan','refresh');
  }
  
  public function delete_syarat_semasa($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('syarat_pesanan_semasa');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/pesanan','refresh');
  }

  //Syarat Belian
  public function store_syarat_belian()
  {
    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->insert('syarat_belian',$data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/belian','refresh');
  }
 
  public function edit_syarat_belian()
  {
    $id = $this->input->post('id');

    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->where('id', $id);
    $this->db->update('syarat_belian',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/belian','refresh');
  }
   
  public function delete_syarat_belian($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('syarat_belian');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/belian','refresh');
  }

  //Syarat Keluar
  public function store_syarat_keluar()
  {
    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->insert('syarat_keluar',$data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }
 
  public function edit_syarat_keluar()
  {
    $id = $this->input->post('id');

    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->where('id', $id);
    $this->db->update('syarat_keluar',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }
   
  public function delete_syarat_keluar($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('syarat_keluar');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }

  //Syarat Kedai
  public function store_syarat_kedai()
  {
    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->insert('syarat_kedai',$data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }
 
  public function edit_syarat_kedai()
  {
    $id = $this->input->post('id');

    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->where('id', $id);
    $this->db->update('syarat_kedai',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }
   
  public function delete_syarat_kedai($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('syarat_kedai');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }

  //Syarat Baru
  public function store_syarat_baru()
  {
    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->insert('syarat_baru',$data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }
 
  public function edit_syarat_baru()
  {
    $id = $this->input->post('id');

    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->where('id', $id);
    $this->db->update('syarat_baru',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }
   
  public function delete_syarat_baru($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('syarat_baru');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }

  //Syarat Baiki
  public function store_syarat_baiki()
  {
    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->insert('syarat_baiki',$data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }
  
  public function edit_syarat_baiki()
  {
    $id = $this->input->post('id');

    $data=array(
      'text'=>$this->input->post('syarat')
    );
    $this->db->where('id', $id);
    $this->db->update('syarat_baiki',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }
    
  public function delete_syarat_baiki($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('syarat_baiki');

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Terma & Syarat Dipadam</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/tempahan','refresh');
  }

  public function store_detail()
  {
    $data = array(
      'komisen' => $this->input->post('komisen'),
      'margin_upah' => $this->input->post('margin_upah'),
      'pesanan' => $this->input->post('jenis_pesanan'),
    );
    $this->db->where('id', 1);
    $this->db->update('ci_maklumat',$data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Maklumat Dikemaskini</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('admin/setting/maklumat','refresh');
  }

  //Komisen
  public function store_komisen()
  {
    $data=array(
      'min'=>$this->input->post('min_komisen'),
      'komisen'=>$this->input->post('komisen_komisen')
    );
    $this->db->insert('commission',$data);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Komisen Ditambah</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");

    redirect('admin/setting/komisen','refresh');
  }
  
  public function edit_komisen()
  {
    $id = $this->input->post('id_komisen');

    $data = array(
      'min' => $this->input->post('min_komisen'),
      'komisen' => $this->input->post('komisen_komisen')
    );
    $this->db->where('id', $id);
    $this->db->update('commission',$data);

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Komisen Dikemaskini</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('admin/setting/komisen','refresh');
  }
  
  public function delete_komisen($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('commission');

    $this->session->set_flashdata('upload', "<script>
      Swal.fire({
        icon: 'success',
        title: '<h4>Komisen Dipadam</h4>',
        showConfirmButton: false,
        timer: 1200
      })
    </script>");

    redirect('admin/setting/komisen','refresh');
  }
  //./Komisen 

  public function backup()
  {
    if ($this->data['user_profile']['user_group'] > 2)
    {
      return show_404('The page you requested was not found.');
    }else {
      $this->load->view('pages/db');
    
      redirect('admin/setting/backup','refresh');
    }
  }

  public function send_tac(){

    $total_pay = $this->input->post('total_pay');
    
    redirect('admin/dashboard','refresh');
    
  }


}