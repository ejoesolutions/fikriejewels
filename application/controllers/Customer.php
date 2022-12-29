<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller{

  public function __construct()
	{
		parent::__construct();
		$this->load->database();

    $this->load->model(['customer_model','order_model','admin_model','catalog_model','user_model']);

		$this->lang->load('auth');

    if ($this->ion_auth->logged_in()) {
      $user = $this->ion_auth->user()->row();
      $this->data['user_profile'] = $this->user_model->get_profile($user->id);
      $this->data['count_pending'] = $this->product_model->count_pending();
    }else {
      redirect('user/login','refresh');
    }

    $this->data['logo'] = $this->admin_model->get_logo();
    $this->data['banner'] = $this->admin_model->get_banner();
    $this->data['pm'] = $this->catalog_model->list_pakej();
    $this->data['footer'] = $this->admin_model->get_footer();
    $this->data['state']=$this->user_model->state_list();
    $this->data['maklumat'] = $this->admin_model->get_maklumat();

	}

  public function register()
	{
    //$this->data['lists'] = $this->user_model->get_wakalah();
		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// validate form input
		$this->form_validation->set_rules('full_name', 'Nama Penuh', 'required');
    $this->form_validation->set_rules('phone', 'No Tel', 'required');
    $this->form_validation->set_rules('address', 'Alamat', 'required');
    $this->form_validation->set_rules('postcode', 'Poskod', 'required|is_numeric');
    $this->form_validation->set_rules('town_area', 'Bandar', 'required');
    $this->form_validation->set_rules('state_id', 'Negeri', 'required');


    $this->form_validation->set_rules('identity', 'Nama Pengguna', 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
    $this->form_validation->set_rules('email', 'Emel', 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
		$this->form_validation->set_rules('password', 'Katalaluan', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
		$this->form_validation->set_rules('password_confirm', 'Pengesahan Katalaluan', 'required|matches[password]');

    $this->data['state']=$this->user_model->state_list();

    if ($this->form_validation->run() === TRUE)
		{
      //$this->upload->do_upload('userfile');
			$email = strtolower($this->input->post('email'));
			$identity = $this->input->post('identity');
			$password = $this->input->post('password');
      $active = $this->input->post('active');
      // $upload_data = $this->upload->data();
      // $image_file = $upload_data['raw_name'] . $upload_data['file_ext'];


			$additional_data = array(
				'full_name' => strtoupper($this->input->post('full_name')),
        'nic_no' => null,
        'phone' => $this->input->post('phone'),
        'address' => strtoupper($this->input->post('address')),
        'postcode' => $this->input->post('postcode'),
        'town_area' => strtoupper($this->input->post('town_area')),
        'state_id' => $this->input->post('state_id'),

			);

		}
		if ($this->form_validation->run() === TRUE)
		{
      $id=$this->ion_auth->register($identity, $password, $email, $additional_data);
      $this->ion_auth->create_profile($additional_data,$id);
        $ship_data = array(
          'user_id' => $id,
          'ship_name' => strtoupper($this->input->post('full_name')),
          'ship_phone' => $this->input->post('phone'),
          'ship_address' => strtoupper($this->input->post('address')),
          'ship_postcode' => $this->input->post('postcode'),
          'ship_area' => strtoupper($this->input->post('town_area')),
          'ship_state' => $this->input->post('state_id'),
          'ship_default' => 1,
        );
        $this->db->insert('ci_shipping', $ship_data);

        ob_start();
        $m="Pendaftaran Berjaya.";
         echo "<script type='text/javascript'>alert('$m');</script>";
         redirect(base_url('customer/register'), 'refresh');
        ob_end_clean();

		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


      $this->data['full_name'] = array(
				'name' => 'full_name',
				'id' => 'full_name',
				'type' => 'text',
        'class' => 'form-control uppercase',
        'placeholder' => 'Nama Penuh',
				'value' => $this->form_validation->set_value('full_name'),
			);


			$this->data['phone'] = array(
				'name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
        'class' => 'form-control',
        'placeholder' => 'No Tel',
				'value' => $this->form_validation->set_value('phone'),
			);

      $this->data['address'] = array(
				'name' => 'address',
				'id' => 'address',
				'type' => 'text',
        'class' => 'form-control uppercase',
        'placeholder' => 'Alamat',
				'value' => $this->form_validation->set_value('address'),
			);

			$this->data['postcode'] = array(
				'name' => 'postcode',
				'id' => 'postcode',
				'type' => 'text',
        'class' => 'form-control',
        'placeholder' => 'Poskod',
				'value' => $this->form_validation->set_value('postcode'),
			);

      $this->data['town_area'] = array(
				'name' => 'town_area',
				'id' => 'town_area',
				'type' => 'text',
        'class' => 'form-control uppercase',
        'placeholder' => 'Bandar',
				'value' => $this->form_validation->set_value('town_area'),
			);

			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
        // 'maxlength' => '12',
        'class' =>'form-control',
        'placeholder' => 'Nama Pengguna',
				'value' => $this->form_validation->set_value('identity'),
			);

			$this->data['email'] = array(
				'name' => 'email',
				'id' => 'email',
				'type' => 'text',
        'class' => 'form-control',
        'placeholder' => 'Emel',
				'value' => $this->form_validation->set_value('email'),
			);


			$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
        'class' => 'form-control',
				'type' => 'password',
        'placeholder' => 'Katalaluan',
				'value' => $this->form_validation->set_value('password'),
			);

			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
        'class' => 'form-control',
				'type' => 'password',
        'placeholder' => 'Pengesahan Katalaluan',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

      $this->template->load('layouts/main', 'customer/customer_register',$this->data);
		}
	}

  public function upd_cust($id)
  {
    $data_user = array(
      'email' => $this->input->post('email'),
    );
    $this->db->where('id', $id);
    $this->db->update('ci_users', $data_user);

    $data_profile = array(
      'full_name' => strtoupper($this->input->post('full_name')),
      'nic_no' => strtoupper($this->input->post('nic_no')),
      'phone' => strtoupper($this->input->post('phone')),
      'address' => strtoupper($this->input->post('address')),
      'postcode' => strtoupper($this->input->post('postcode')),
      'town_area' => strtoupper($this->input->post('town_area')),
      'state_id' => strtoupper($this->input->post('state_id')),
    );
    $this->db->where('user_id', $id);
    $this->db->update('ci_users_profile', $data_profile);

    $this->session->set_flashdata('upload', "<script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Maklumat Dikemaskini</h4>',
      showConfirmButton: false,
      timer: 1200
    })
    </script>");
    
    redirect('user/detail_cust/'.$id);    
  }

  public function forgot_password()
	{

    $this->db->where('user_group',5);
    $this->db->where('email',$this->input->post('identity'));
    $this->db->where('removable IS NULL');
    $this->query = $this->db->get('ci_users');
    $res = $this->query->num_rows();

    if($res > 0)
    {
      $identity_column = $this->config->item('identity', 'ion_auth');
      // $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();
			$identity = $this->ion_auth->where('email = "'.$this->input->post('identity').'"')->users()->row();

      $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
      ob_start();
      $m="Sila semak emel anda.";
       echo "<script type='text/javascript'>alert('$m');</script>";
       redirect('customer/register', 'refresh');
       ob_end_clean();
    }else{
      ob_start();
      $m="Emel tidak dijumpai.";
       echo "<script type='text/javascript'>alert('$m');</script>";
       redirect('customer/register', 'refresh');
       ob_end_clean();
    }
	}

  public function login()
	{
		//$this->data['title'] = 'Login';

		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = false;

			if ($this->ion_auth->login_cust($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
          if(!empty($this->cart->contents())){
            redirect('customer/cart', 'refresh');
          }else{
            redirect('customer/dashboard', 'refresh');
          }

			}
			else
			{
				// if the login was un-successful
        	// $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				  // $this->session->set_flashdata('message', $this->ion_auth->errors());
          ob_start();
          $m="Nama Pengguna/Katalaluan Tidak Tepat.";
          echo "<script type='text/javascript'>alert('$m');</script>";
          redirect('customer/register', 'refresh');
          ob_end_clean();
          // echo "<script type='text/javascript'>alert('$m');window.location.href = '" . base_url() . "customer/register';</script>";

			}
		}
		else
		{
      ob_start();
      $m="Nama Pengguna/Katalaluan Tidak Tepat.";
      echo "<script type='text/javascript'>alert('$m');</script>";
      redirect('customer/register', 'refresh');
      ob_end_clean();

		}
	}

  public function logout()
	{
		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('', 'refresh');
	}

  public function dashboard(){

    if(!$this->ion_auth->logged_in()){
        redirect(base_url('customer/register'), 'refresh');
    }

    $this->data['state']=$this->user_model->state_list();
    $this->data['ship_id']=$this->customer_model->get_shipAddress($this->data['user_profile']['id']);

    $this->template->load('layouts/main', 'customer/customer_account',$this->data);

  }

  public function update_account(){
    $user_id=$this->input->post('user_id');
    $clean_phone = preg_replace("/[^0-9]/", '', $this->input->post('phone'));
    $acc=array(
      'full_name'=>strtoupper($this->input->post('full_name')),
      'phone'=>$this->input->post('phone'),
      // 'address'=>strtoupper($this->input->post('address')),
      // 'postcode'=>$this->input->post('postcode'),
      // 'town_area'=>strtoupper($this->input->post('town_area')),
      // 'state_id'=>$this->input->post('state_id'),
    );
    //
    // $ship_acc=array(
    //   'ship_name'=>strtoupper($this->input->post('full_name')),
    //   'ship_phone'=>$this->input->post('phone'),
    //   'ship_address'=>strtoupper($this->input->post('address')),
    //   'ship_postcode'=>$this->input->post('postcode'),
    //   'ship_area'=>strtoupper($this->input->post('town_area')),
    //   'ship_state'=>$this->input->post('state_id'),
    // );

    $this->data['unique']=$this->user_model->get_email($this->input->post('email'));

    if($this->input->post('password')!='' && $this->input->post('password_confirm')!=''){
      $this->db->where('user_id',$user_id);
      $this->db->update('ci_users_profile',$acc);

      // $this->db->where('shipping_id',$this->input->post('ship'));
      // $this->db->update('ci_shipping',$ship_acc);

      if($this->data['unique']['count']!=0 && $this->input->post('email')!=$this->input->post('ori_email')){
          ob_start();
          $m="Emel anda mungkin sudah digunakan/didaftarkan.";
          echo "<script type='text/javascript'>alert('$m');</script>";
          redirect('customer/dashboard', 'refresh');
          ob_end_clean();
      }else{
        $this->db->where('id',$user_id);
        $this->db->update('ci_users',array('email'=>$this->input->post('email')));
      }

      if($this->input->post('password')==$this->input->post('password_confirm')){
        $data['password']=$this->input->post('password');
        if($this->ion_auth->update($user_id, $data)){
          ob_start();
          $m="Kemaskini Berjaya.";
          echo "<script type='text/javascript'>alert('$m');</script>";
          redirect('customer/dashboard', 'refresh');
          ob_end_clean();
        }else{
          ob_start();
          $m="Kemaskini Tidak Berjaya.";
          echo "<script type='text/javascript'>alert('$m');</script>";
          redirect('customer/dashboard', 'refresh');
          ob_end_clean();
        }
      }else{
        ob_start();
        $m="Katalaluan Tidak Sepadan.";
         echo "<script type='text/javascript'>alert('$m');</script>";
         redirect('customer/dashboard', 'refresh');
         ob_end_clean();
      }
    }else{
      $this->db->where('user_id',$user_id);
      $this->db->update('ci_users_profile',$acc);
      //
      // $this->db->where('shipping_id',$this->input->post('ship'));
      // $this->db->update('ci_shipping',$ship_acc);

      if($this->data['unique']['count']!=0 && $this->input->post('email')!=$this->input->post('ori_email')){
        ob_start();
        $m="Emel anda mungkin sudah digunakan/didaftarkan.";
        echo "<script type='text/javascript'>alert('$m');</script>";
        redirect('customer/dashboard', 'refresh');
        ob_end_clean();
      }else{
        $this->db->where('id',$user_id);
        $this->db->update('ci_users',array('email'=>$this->input->post('email')));

        ob_start();
        $m="Kemaskini Berjaya.";
        echo "<script type='text/javascript'>alert('$m');</script>";
        redirect('customer/dashboard', 'refresh');
        ob_end_clean();
      }
    }
  }

  public function addresses(){
    if(!$this->ion_auth->logged_in()){
        redirect(base_url('customer/register'), 'refresh');
    }else{

      $this->data['state']=$this->user_model->state_list();
      $this->data['ship']=$this->customer_model->get_shipAddress($this->data['user_profile']['id']);
      $this->template->load('layouts/main', 'customer/customer_address',$this->data);
    }
  }

  public function update_shipAddress(){

    $shipping_id=$this->input->post('shipping_id');
    $ship=array(
      'ship_name'=>strtoupper($this->input->post('ship_name')),
      'ship_phone'=>$this->input->post('ship_phone'),
      'ship_address'=>strtoupper($this->input->post('ship_address')),
      'ship_postcode'=>$this->input->post('ship_postcode'),
      'ship_area'=>strtoupper($this->input->post('ship_area')),
      'ship_state'=>$this->input->post('ship_state'),
    );
    $this->db->where('shipping_id',$shipping_id);
    $this->db->update('ci_shipping',$ship);

    redirect('customer/addresses','refresh');
  }

  public function orders()
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('customer/register', 'refresh');
    }else{

        $this->data['orders'] = $this->order_model->get_order($this->data['user_profile']['id']);

        $this->template->load('layouts/main','customer/customer_order', $this->data);
    }
  }

  public function view_order($order_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('customer/register', 'refresh');
    }else{

        $this->data['orders'] = $this->order_model->get_order($this->data['user_profile']['id'],$order_id);
        $this->data['items'] = $this->order_model->get_items($order_id);
        $this->data['track'] = $this->order_model->get_track($order_id);
        // $this->data['bank'] = $this->order_model->get_list_bank();
        $this->data['order_status'] = $this->order_model->get_order_status($order_id);

        $this->template->load('layouts/main','customer/customer_view_order', $this->data);
    }
  }

  public function cart(){
      $this->template->load('layouts/main', 'customer/cart_list',$this->data);
  }

  public function clear_item_cart($id)
  {

    $this->cart->remove($id);
    //$this->session->set_flashdata('message','Maklumat jualan telah dipadam sepenuhnya.');

    redirect('customer/cart');
  }

  public function agent_member()
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('customer/register', 'refresh');
    }else{

        $this->data['rules'] = $this->admin_model->get_rules();
        $this->data['product_choosed']=$this->admin_model->get_rule_products_choosed();
        $this->data['commission']=$this->customer_model->commission_agent($this->data['user_profile']['agent_id']);
        $this->data['order_item']=$this->order_model->get_items();
        $this->data['sum_comm']=$this->customer_model->total_commission_by_agent($this->data['user_profile']['agent_id']);

        $this->template->load('layouts/main','customer/be_agent_member', $this->data);
    }
  }

  public function submit_member()
  {
    $agent_code = $this->input->post('agent_code');
    $check_exist_code = $this->customer_model->check_agent_code($agent_code);
    if(!empty($check_exist_code))
    {
      $data = [
        'agent_id'=>$check_exist_code['agent_id'],
        'user_id'=>$this->data['user_profile']['id'],
        'member_created'=>date('Y-m-d H:i:s')
      ];
      $this->db->insert('ci_agent_member',$data);

      $this->db->where('id',$this->data['user_profile']['id']);
      $this->db->update('ci_users',array('user_group'=>4));

        ob_start();
        $m="Tahniah kerana anda telah berjaya menjadi ahli kami.";
        echo "<script type='text/javascript'>alert('$m');</script>";
        redirect(base_url(), 'refresh');
        ob_end_clean();
    }else{
      ob_start();
      $m="Harap maaf, kod ejen yang dimasukkan tidak tepat.";
      echo "<script type='text/javascript'>alert('$m');</script>";
      redirect('customer/agent_member', 'refresh');
      ob_end_clean();
    }
  }

  public function get_check_username()
  {
    $this->db->where('removable IS NULL');
    $this->db->where('u.id !=',$this->input->post('user_id'));
    $this->db->where('u.username', $this->input->post('username'));
    $this->query = $this->db->get('ci_users u');
    if ($this->query->num_rows() > 0) {
      echo json_encode(array('status'=>1));
    }else{
      echo json_encode(array('status'=>0));
    }
  }

  public function manage_acc($user_id)
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('customer/register', 'refresh');
    }else{
        $this->data['agent'] = $this->user_model->agent_detail($user_id);
        $this->data['bank'] = $this->user_model->get_bank_list();
        $this->data['state']=$this->user_model->state_list();
        $this->template->load('layouts/main','customer/manage_agent_account', $this->data);
    }
  }

  public function req_withdraw()
  {
    if (!$this->ion_auth->logged_in())
    {
      redirect('customer/register', 'refresh');
    }else{

        $this->data['agent'] = $this->user_model->agent_detail($this->data['user_profile']['user_id']);
        $this->data['withdraw']=$this->customer_model->list_withdraw($this->data['user_profile']['agent_id']);
        $this->data['commission']=$this->customer_model->total_commission_by_agent($this->data['user_profile']['agent_id']);
        $this->template->load('layouts/main','customer/list_withdraw', $this->data);
    }
  }

  public function store_withdraw()
  {
    $agent_id = $this->input->post('agent_id');

    $data = array(
      'agent_id'=>$agent_id,
      'amount'=>$this->input->post('amount'),
      'record_date'=>date('Y-m-d H:i:s'),
      'wd_status'=>1
    );
    $this->db->insert('ci_withdraw',$data);
    redirect('customer/req_withdraw','refresh');
  }

}
