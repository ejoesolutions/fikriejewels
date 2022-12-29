<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{

  public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('user_model');
		$this->load->model(array('admin_model','order_model'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');

		if ($this->ion_auth->logged_in()) {
			$user = $this->ion_auth->user()->row();
			$this->data['user_profile'] = $this->user_model->get_profile($user->id);
			$this->data['count_pending'] = $this->product_model->count_pending();

			$_SESSION['user_id'] = $this->data['user_profile']['id'];
			$_SESSION['username'] = $this->data['user_profile']['username'];
			$_SESSION['full_name'] = $this->data['user_profile']['full_name'];
		}

    	$this->data['logo'] = $this->admin_model->get_logo();
			$this->data['maklumat'] = $this->admin_model->get_maklumat();
    	$this->output->enable_profiler(false);
	}

  public function get_users()
  {
    if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		} else {
			// if ($this->ion_auth->logged_in() && $this->data['user_profile']['user_group'] != 1)
			// {
			//   return show_404('The page you requested was not found.');
			// }
	
			$this->data['users'] = $this->user_model->get_users();

			$this->template->load('layouts/admin', 'user/users_table', $this->data);
		}
  }

  
  public function get_cust()
  {
    $this->data['title'] = 'Senarai Pelanggan';

    if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		} else {
			$this->data['cust'] = $this->user_model->get_cust();

			$this->template->load('layouts/admin', 'customer/table_customers', $this->data);
		}
  }

  public function edit($id)
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}

		$this->data['user_info'] = $this->user_model->get_profile($id);
		$tables = $this->config->item('tables', 'ion_auth');

		// validate form input
		if($this->data['user_profile']['user_group']==0 || $this->data['user_profile']['id']==$id){
			$this->form_validation->set_rules('username', 'Nama Pengguna', 'trim|required');
		}

		$this->form_validation->set_rules('full_name', 'Nama Penuh', 'trim|required');

		if (isset($_POST) && !empty($_POST))
		{
			// update the password if it was posted
			if ($this->input->post('password')){
				$this->form_validation->set_rules('password', '<script>
					Swal.fire({
						icon: "error",
						title: "<h4>Kemaskini Tidak Berjaya.Sila Semak Maklumat</h4>",
						showConfirmButton: false,
						timer: 1600
					})
				</script> Katalaluan', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
				$this->form_validation->set_rules('password_confirm', '<script>
					Swal.fire({
						icon: "error",
						title: "<h4>Kemaskini Tidak Berjaya.Sila Semak Maklumat</h4>",
						showConfirmButton: false,
						timer: 1600
					})
				</script> Pengesahan Katalaluan', 'required|matches[password]');
			}

			if($this->input->post('email') != $this->input->post('ori_email')){
				$this->form_validation->set_rules('email', '<script>
					Swal.fire({
						icon: "error",
						title: "<h4>Kemaskini Tidak Berjaya.Sila Semak Maklumat</h4>",
						showConfirmButton: false,
						timer: 1600
					})
				</script> Emel', 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
			}

			if($this->input->post('username') != $this->input->post('ori_username')){
				$this->form_validation->set_rules('username', '<script>
					Swal.fire({
						icon: "error",
						title: "<h4>Kemaskini Tidak Berjaya.Sila Semak Maklumat</h4>",
						showConfirmButton: false,
						timer: 1600
					})
				</script> Nama Pengguna', 'required|is_unique[' . $tables['users'] . '.username]');
			}

			if ($this->form_validation->run() === TRUE)
			{
				// update the password if it was posted
				if ($this->input->post('password')){

					$data = array(
						'password' => $this->input->post('password'),
					);
					
					$this->ion_auth->update($this->data['user_info']['id'], $data);
				}

        if ($this->input->post('username'))
				{
          $data = array(
            'username' => $this->input->post('username'),
  				);

          $this->db->where('id',$this->data['user_info']['id']);
          $this->db->update('ci_users',$data);
				}

				$profile_data = array(
					'full_name' => strtoupper($this->input->post('full_name')),
					'phone' => $this->input->post('phone'),
					'address' => strtoupper($this->input->post('address')),
					'postcode' => $this->input->post('postcode'),
					'town_area' => strtoupper($this->input->post('town_area')),
					'state_id' => $this->input->post('state_id'),
				);
				$this->db->where('user_id', $this->data['user_info']['id']);
				$this->db->update('ci_users_profile', $profile_data);
				// redirect them back to the admin page if admin, or to the base url if non admin
				$this->session->set_flashdata('message', $this->ion_auth->messages());

				$this->db->where('id', $this->data['user_info']['id']);
				$this->db->update('ci_users', array('email'=>$this->input->post('email')));

				$status_user=array(
					'active' =>$this->input->post('active')
				);
				$this->db->where('id', $this->data['user_info']['id']);
				$this->db->update('ci_users', $status_user);
			
				$this->session->set_flashdata('upload', "<script>
					Swal.fire({
						icon: 'success',
						title: '<h4>Maklumat Dikemaskini</h4>',
						showConfirmButton: false,
						timer: 1100
					})
				</script>");

				redirect('user/edit/'.$this->data['user_info']['id'], 'refresh');
			}
		}

		// $this->session->set_flashdata('upload', "<script>Swal.fire({icon: 'success',title: '<h4>Maklumat Dikemaskini</h4>',showConfirmButton: false,timer: 1100})</script>");

		// set the flash data error message if there is one
		// $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

    $this->data['state']=$this->user_model->state_list();

		$this->data['full_name'] = array(
			'name'  => 'full_name',
			'id'    => 'full_name',
			'type'  => 'text',
			'required' => '',
      'class' => 'form-control uppercase',
			'value' => $this->form_validation->set_value('full_name', $this->data['user_info']['full_name']),
		);

    if($this->data['user_profile']['user_group']==1 || $this->data['user_profile']['user_group']==0 || $this->data['user_profile']['id']==$id)
    {
      $this->data['username'] = array(
  			'name'  => 'username',
  			'id'    => 'username',
  			'type'  => 'text',
  			'required'  => '',
        'class' =>'form-control',
  			'value' => $this->form_validation->set_value('username', $this->data['user_info']['username']),
  		);
    }else{
      $this->data['username'] = array(
  			'name'  => 'username',
  			'id'    => 'username',
  			'type'  => 'text',
        'class' =>'form-control',
        'readonly' =>'readonly',
  			'value' => $this->form_validation->set_value('username', $this->data['user_info']['username']),
  		);
    }

    $this->data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'text',
      'class' => 'form-control',
			'value' => $this->form_validation->set_value('email', $this->data['user_info']['email']),
		);

    $this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
      'class' => 'form-control',
			'value' => $this->form_validation->set_value('phone', $this->data['user_info']['phone']),
		);

    $this->data['address'] = array(
			'name'  => 'address',
			'id'    => 'address',
			'type'  => 'text',
      'class' => 'form-control',
			'value' => $this->form_validation->set_value('address', $this->data['user_info']['address']),
		);

		$this->data['postcode'] = array(
			'name'  => 'postcode',
			'id'    => 'postcode',
			'type'  => 'text',
      'class' => 'form-control',
			'value' => $this->form_validation->set_value('postcode', $this->data['user_info']['postcode']),
		);

    $this->data['town_area'] = array(
			'name'  => 'town_area',
			'id'    => 'town_area',
			'type'  => 'text',
      'class' => 'form-control uppercase',
			'value' => $this->form_validation->set_value('town_area', $this->data['user_info']['town_area']),
		);

    $this->data['state_id'] = array(
			'name'  => 'state_id',
			'id'    => 'state_id',
			'type'  => 'text',
      'class' => 'form-control',
			'value' => $this->form_validation->set_value('state_id', $this->data['user_info']['state_id']),
		);

		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
      'class' => 'form-control',
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
      'class' => 'form-control',
		);

    $this->template->load('layouts/admin', 'user/edit_user', $this->data);

	}

	public function detail_user($user_id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('user/login', 'refresh');
		}

		if ($this->data['user_profile']['user_group'] == 2 && $this->data['user_profile']['user_id'] != $user_id)
    {
      return show_404('The page you requested was not found.');
    }

		$this->data['detail'] = $this->user_model->get_profile($user_id);
		$this->data['state'] = $this->admin_model->get_state();

    $this->template->load('layouts/admin', 'user/edit_user', $this->data);
	}

	public function detail_cust($id)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('user/login', 'refresh');
		}

		$this->data['cust'] = $this->user_model->get_cust_detail($id);
		$this->data['state'] = $this->admin_model->get_state();

    $this->template->load('layouts/admin', 'customer/cust_detail', $this->data);
	}


	public function login()
	{
		$this->data['title'] = 'Login';

		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());

        redirect('admin/dashboard', 'refresh');
			}
			else
			{
				$this->session->set_flashdata('upload', "<script>
				Swal.fire({
					icon: 'error',
					title: '<h4>Nama Pengguna atau Katalaluan tidak tepat</h4>',
					showConfirmButton: false,
					timer: 1400
				})
				</script>");

				redirect('user/login', 'refresh');
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
        'class' => 'form-control form-control-lg',
        'autocomplete' => 'off',
        'placeholder' => 'Nama Pengguna',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
        'class' => 'form-control',
			);

      $this->template->load('layouts/auth', 'auth/login', $this->data);
      // $this->load->view('layouts/auth', $this->data);
		}
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		// log the user out
		$logout = $this->ion_auth->logout();
		
		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());

		redirect('user/login', 'refresh');
	}

  /**
	 * Create a new user
	 */
	public function register()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}

		if ($this->data['user_profile']['user_group'] == 2)
		{
			return show_404('The page you requested was not found.');
		}

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// validate form input
		$this->form_validation->set_rules('full_name', 'Nama Penuh', 'required');

		$this->form_validation->set_rules('identity', 'Nama Pengguna', 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
		// $this->form_validation->set_rules('email', 'Emel', 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
		$this->form_validation->set_rules('password', 'Katalaluan', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
		$this->form_validation->set_rules('password_confirm', 'Pengesahan Katalaluan', 'required|matches[password]');


		if ($this->form_validation->run() === TRUE)
		{
			$email = strtolower($this->input->post('email'));
			$identity = $this->input->post('identity');
			$password = $this->input->post('password');
			$active = $this->input->post('active');

			if ($this->input->post('user_group') == 2) {
				$user = array(
					'username' => $identity,
					'password' => password_hash($password, PASSWORD_DEFAULT),
					'active' => $active,
					'user_group' => $this->input->post('user_group'),
					// 'cawangan_id' => $this->input->post('cawangan') ? $this->input->post('cawangan') : NULL,
					'cawangan_id' => 1,
					'verify_acc' => 1,
				);
			}else {
				$user = array(
					'username' => $identity,
					'password' => password_hash($password, PASSWORD_DEFAULT),
					'active' => $active,
					'user_group' => $this->input->post('user_group'),
					'cawangan_id' => NULL,
					'verify_acc' => 1,
				);
			}
			$this->db->insert('ci_users', $user);
			$user_id = $this->db->insert_id();

			// if (!$this->input->post('state_id')) {
				// $state_id = 17;
			// }else {
				$state_id = 17;
			// }

			$additional_data = array(
				'user_id' => $user_id,
				'full_name' => strtoupper($this->input->post('full_name')),
				'phone' => $this->input->post('phone'),
				//'nic_no' => $this->input->post('identity'),
				'address' => strtoupper($this->input->post('address')),
				'postcode' => $this->input->post('postcode'),
				'town_area' => strtoupper($this->input->post('town_area')),
				'state_id' => $state_id
			);
			$this->db->insert('ci_users_profile', $additional_data);
			

			$this->session->set_flashdata('upload', "<script>
				Swal.fire({
					icon: 'success',
					title: '<h4>Pengguna Ditambah</h4>',
					showConfirmButton: false,
					timer: 1100
				})
			</script>");

			redirect('user/get_users', 'refresh');
		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['state'] = $this->admin_model->get_state();
			$this->data['cawangan'] = $this->admin_model->get_cawangan();

			$this->data['full_name'] = array(
				'name' => 'full_name',
				'id' => 'full_name',
				'type' => 'text',
				'class' => 'form-control uppercase',
				'required' => '',
				'value' => $this->form_validation->set_value('full_name'),
			);

			$this->data['phone'] = array(
				'name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('phone'),
			);

			$this->data['address'] = array(
				'name' => 'address',
				'id' => 'address',
				'type' => 'text',
				'class' => 'form-control uppercase',
				'value' => $this->form_validation->set_value('address'),
			);

			$this->data['postcode'] = array(
				'name'  => 'postcode',
				'id'    => 'postcode',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('postcode'),
			);

			$this->data['town_area'] = array(
				'name'  => 'town_area',
				'id'    => 'town_area',
				'type'  => 'text',
				'class' => 'form-control uppercase',
				'value' => $this->form_validation->set_value('town_area'),
			);

			$this->data['state_id'] = array(
				'name'  => 'state_id',
				'id'    => 'state_id',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('state_id'),
			);

			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'class' =>'form-control',
				'required' => '',
				'value' => $this->form_validation->set_value('identity'),
			);

			$this->data['email'] = array(
				'name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('email'),
			);

			$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'class' => 'form-control',
				'type' => 'password',
				'required' => '',
				'value' => $this->form_validation->set_value('password'),
			);

			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'class' => 'form-control',
				'required' => '',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->template->load('layouts/admin', 'user/register', $this->data);
		}
	}

	public function update_user()
	{
		$user_id = $this->input->post('id');

		$users = array(
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'active' => $this->input->post('active'),
		);
		$this->db->where('id', $user_id);
		$this->db->update('ci_users', $users);

		if ($this->input->post('password')) {
			$this->db->where('id', $user_id);
			$this->db->update('ci_users', array('password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)));
		}
		
		$users_profile = array(
			'full_name' => $this->input->post('full_name'),
			'phone' => $this->input->post('phone'),
			'address' => $this->input->post('address'),
			'postcode' => $this->input->post('postcode'),
			'town_area' => $this->input->post('town_area'),
			'state_id' => $this->input->post('state_id'),
		);
		$this->db->where('user_id', $user_id);
		$this->db->update('ci_users_profile', $users_profile);

		$this->session->set_flashdata('upload', "<script>
			Swal.fire({
				icon: 'success',
				title: '<h4>Pengguna Dikemaskini</h4>',
				showConfirmButton: false,
				timer: 1100
			})
		</script>");
		
		redirect('user/detail_user/'.$user_id,'refresh');
	}

	public function register_cust_checkout()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}

		$customer = array(
			'name' => strtoupper($this->input->post('full_name')),
			'phone' => $this->input->post('phone'),
			'kp' => $this->input->post('kp'),
			'address' => $this->input->post('address'),
			'state' => $this->input->post('state'),
		);
		$this->db->insert('customer', $customer);
		$cust_id = $this->db->insert_id();
		
		$this->session->set_flashdata('upload', "<script>
			Swal.fire({
				icon: 'success',
				title: '<h4>Pendaftaran Berjaya</h4>',
				showConfirmButton: false,
				timer: 1200
			})
		</script>");

		redirect('orders/checkout/'.$cust_id,'refresh');
	}

	public function register_cust_buy()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}

		$customer = array(
			'name' => strtoupper($this->input->post('full_name')),
			'phone' => $this->input->post('phone'),
			'kp' => $this->input->post('kp'),
			'address' => $this->input->post('address'),
			'state' => $this->input->post('state'),
		);
		$this->db->insert('customer', $customer);
    $cust_id = $this->db->insert_id();
		
		$this->session->set_flashdata('upload', "<script>
			Swal.fire({
				icon: 'success',
				title: '<h4>Pendaftaran Berjaya</h4>',
				showConfirmButton: false,
				timer: 1200
			})
		</script>");

		redirect('buy/buy_checkout/'.$cust_id,'refresh');
	}

	public function register_cust_variants()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}

		$show_id = $this->input->post('show_id');
		$v_sn_2 = $this->input->post('v_sn_2');
		
		$customer = array(
			'name' => strtoupper($this->input->post('full_name')),
			'phone' => $this->input->post('phone'),
			'kp' => $this->input->post('kp'),
			'address' => $this->input->post('address'),
			'state' => $this->input->post('state'),
		);
		$this->db->insert('customer', $customer);
		$cust_id = $this->db->insert_id();
		
		$this->session->set_flashdata('upload', "<script>
			Swal.fire({
				icon: 'success',
				title: '<h4>Pendaftaran Berjaya</h4>',
				showConfirmButton: false,
				timer: 1200
			})
		</script>");

		redirect('booking/all_variants/'.$cust_id.'/'.$show_id.'/'.$v_sn_2,'refresh');
	}

	public function register_cust_new()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}

		$v_id = $this->input->post('v_id');

		$customer = array(
			'name' => strtoupper($this->input->post('full_name')),
			'phone' => $this->input->post('phone'),
			'kp' => $this->input->post('kp'),
			'address' => $this->input->post('address'),
			'state' => $this->input->post('state'),
		);
		$this->db->insert('customer', $customer);
    $cust_id = $this->db->insert_id();
		
		$this->session->set_flashdata('upload', "<script>
			Swal.fire({
				icon: 'success',
				title: '<h4>Pendaftaran Berjaya</h4>',
				showConfirmButton: false,
				timer: 1200
			})
		</script>");

		redirect('booking/booking_invoices/'.$v_id.'/'.$cust_id,'refresh');
	}

	public function register_cust_repair()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('user/login', 'refresh');
		}

		$v_id = $this->input->post('v_id');

		$customer = array(
			'name' => strtoupper($this->input->post('full_name')),
			'phone' => $this->input->post('phone'),
			'kp' => $this->input->post('kp'),
			'address' => $this->input->post('address'),
			'state' => $this->input->post('state'),
		);
		$this->db->insert('customer', $customer);
    $cust_id = $this->db->insert_id();
		
		$this->session->set_flashdata('upload', "<script>
			Swal.fire({
				icon: 'success',
				title: '<h4>Pendaftaran Berjaya</h4>',
				showConfirmButton: false,
				timer: 1200
			})
		</script>");

		redirect('booking/repair_invoices/'.$v_id.'/'.$cust_id,'refresh');
	}

	public function register_cust_all()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('user/login', 'refresh');
		}

		$customer = array(
			'name' => strtoupper($this->input->post('full_name')),
			'phone' => $this->input->post('phone'),
			'kp' => $this->input->post('kp'),
			'address' => $this->input->post('address'),
			'state' => $this->input->post('state'),
		);
		$this->db->insert('customer', $customer);
		
		$this->session->set_flashdata('upload', "<script>
			Swal.fire({
				icon: 'success',
				title: '<h4>Pendaftaran Berjaya</h4>',
				showConfirmButton: false,
				timer: 1200
			})
		</script>");

		redirect('user/get_cust','refresh');
	}

	public function upd_cust()
	{
		$cust = array(
			'name' => strtoupper($this->input->post('name')),
			'phone' => $this->input->post('phone'),
			'kp' => $this->input->post('kp'),
			'address' => $this->input->post('address'),
			'state' => $this->input->post('state'),
		);
		$this->db->where('id', $this->input->post('cust_id'));
		$this->db->update('customer', $cust);
		
		$this->session->set_flashdata('upload', "<script>
			Swal.fire({
				icon: 'success',
				title: '<h4>Kemaskini Berjaya</h4>',
				showConfirmButton: false,
				timer: 1200
			})
		</script>");

		redirect('user/detail_cust/'.$this->input->post('cust_id'),'refresh');
	}



  /**
	 * Forgot password
	 */
	public function forgot_password()
	{
		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() === FALSE)
		{

			if($this->input->post('user_group')==5){
				$m="Invalid Email";
				//  echo "<script type='text/javascript'>alert('$m');</script>";
				//  redirect('customer/register', 'refresh');
				echo "<script type='text/javascript'>alert('$m');window.location.href = '" . base_url() . "customer/register';</script>";
			}

			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'class' => 'form-control form-control-solid placeholder-no-fix',
				'autocomplete' => 'off',
			);

			if ($this->config->item('identity', 'ion_auth') != 'email')
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = "Make sure email is correct.";

      		$this->template->load('layouts/auth','auth/forgot_password', $this->data);
			// $this->_render_page('auth/forgot_password', $this->data);
		}
		else
		{
			$identity_column = $this->config->item('identity', 'ion_auth');
      		// $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();
			$identity = $this->ion_auth->where('email = "'.$this->input->post('identity').'"')->users()->row();

			if (empty($identity))
			{

				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				}
				else
				{
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
        if($this->input->post('user_group')==5){
          $m="Invalid Username/Email";
        //   echo "<script type='text/javascript'>alert('$m');</script>";
        //   redirect('customer/register', 'refresh');
        echo "<script type='text/javascript'>alert('$m');window.location.href = '" . base_url() . "customer/register';</script>";
        }
				redirect('user/forgot_password', 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
        if($this->input->post('user_group')==5){
          $m="Check your email to reset password.";
        //   echo "<script type='text/javascript'>alert('$m');</script>";
        //   redirect('customer/register', 'refresh');
        echo "<script type='text/javascript'>alert('$m');window.location.href = '" . base_url() . "customer/register';</script>";
        }
        $m="Check your email to reset password.";
        //echo "<script type='text/javascript'>alert('$m');</script>";
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		//redirect('user/login', 'refresh');
		echo "<script type='text/javascript'>alert('$m');window.location.href = '" . base_url() . "user/login';</script>";
			}
			else
			{
        if($this->input->post('user_group')==2){
          $m="Invalid Username/Email";
        //   echo "<script type='text/javascript'>alert('$m');</script>";
        //   redirect('customer/register', 'refresh');
        echo "<script type='text/javascript'>alert('$m');window.location.href = '" . base_url() . "customer/register';</script>";
        }
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('user/forgot_password', 'refresh');
			}
		}
	}

  public function verify_account(){
    if(isset($_GET['id'])){
        $this->db->where('id',$_GET['id']);
        $this->db->update('ci_users', array('verify_acc'=>1));
        $m="Your account has been verified. Thank you.";
        // echo "<script type='text/javascript'>alert('$m');</script>";
        // redirect('customer/register', 'refresh');
        echo "<script type='text/javascript'>alert('$m');window.location.href = '" . base_url() . "customer/register';</script>";
    }
  }

  public function newslatter()
  {
    if(!$this->ion_auth->logged_in()){
      redirect('user/login','refresh');
	}
	
	if ($this->data['user_profile']['user_group'] > 2)
    {
      return show_404('The page you requested was not found.');
	}

	$this->data['title'] = 'Newslatter';
	$this->data['news'] = $this->user_model->newslatter();
	$this->template->load('layouts/admin', 'user/newslatter', $this->data);
  }

  public function delete_user($user_id)
  {
		if ($this->data['user_profile']['user_group'] != 0 && $this->data['user_profile']['user_group'] != 1)
    {
      return show_404('The page you requested was not found.');
		}
	
    $this->db->where('id',$user_id);
    $this->db->update('ci_users',array('removable'=>1));

		$this->session->set_flashdata('upload', "<script>
		Swal.fire({
			icon: 'success',
			title: '<h4>Pengguna Dipadam</h4>',
			showConfirmButton: false,
			timer: 1200
		})
		</script>");

    redirect('user/get_users','refresh');
  }

  /**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}

}
