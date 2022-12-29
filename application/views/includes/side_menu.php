<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
  <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
    <i class="fe fe-x"><span class="sr-only"></span></i>
  </a>
  <nav class="vertnav navbar navbar-light">
    <!-- nav bar -->
    <div class="w-100 mb-4 d-flex">
      <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="#">
        <img src="<?php echo base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img" style="max-width: 50%;">
      </a>
    </div>
    <ul class="navbar-nav flex-fill w-100 mb-2">
      <!-- <ul class="navbar-nav flex-fill w-100 mb-2"> -->
        <li class="nav-item w-100">
          <a class="nav-link <?php if($this->uri->segment(2)=="dashboard") { echo 'text-primary';}?>" href="<?php echo base_url('admin/dashboard'); ?>">
            <i class="fe fe-bar-chart-2 fe-16"></i>
            <span class="ml-3">Menu Utama</span>
          </a>
        </li>
      <!-- </ul> -->
      <li class="nav-item dropdown">
        <a href="#report" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
          <i class="fe fe-file-text fe-16"></i>
          <span class="ml-3 item-text">Laporan</span>
        </a>
        <ul class="collapse list-unstyled pl-4 w-100 w-100 <?php if($this->uri->segment(2)=="check" || $this->uri->segment(2)=="check_dulang" || $this->uri->segment(2)=="inv_supplier" || $this->uri->segment(2)=="summary" || $this->uri->segment(2)=="cash_in_out" || $this->uri->segment(2)=="buy_detail" || $this->uri->segment(2)=="list_buy" || $this->uri->segment(2)=="get_report" || $this->uri->segment(2)=="cash_in" || $this->uri->segment(2)=="variants_out" || $this->uri->segment(2)=="stok_in" || $this->uri->segment(2)=="stok_in_hand" || $this->uri->segment(2)=="get_refund" || $this->uri->segment(2)=="get_deleted_v") { echo 'show';}?>" id="report">
        <?php if ($user_profile['user_group'] == 0) { ?>
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="summary") { echo 'text-primary';}?>" href="<?php echo base_url('report/summary') ?>">
              <span class="ml-1 item-text">Ringkasan</span>
            </a>
          </li>
        <?php } ?>
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="get_report") { echo 'text-primary';}?>" href="<?php echo base_url('report/get_report') ?>">
              <span class="ml-1 item-text">Transaksi</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="variants_out") { echo 'text-primary';}?>" href="<?php echo base_url('report/variants_out') ?>">
              <span class="ml-1 item-text">Jualan</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="stok_in") { echo 'text-primary';}?>" href="<?php echo base_url('report/stok_in') ?>">
              <span class="ml-1 item-text">Stok In</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="stok_in_hand") { echo 'text-primary';}?>" href="<?php echo base_url('report/stok_in_hand') ?>">
              <span class="ml-1 item-text">Stok In Hand</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="check" || $this->uri->segment(2)=="check_dulang") { echo 'text-primary';}?>" href="<?php echo base_url('report/check_dulang') ?>">
              <span class="ml-1 item-text">Check Stok</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="list_buy" || $this->uri->segment(2)=="buy_detail") { echo 'text-primary';}?>" href="<?php echo base_url('buy/list_buy'); ?>"><span
              class="ml-1 item-text">Belian</span>
            </a>
          </li>  
          <!-- <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="cash_in_out") { echo 'text-primary';}?>" href="<?php echo base_url('report/cash_in_out') ?>">
              <span class="ml-1 item-text">Cash In / Out</span>
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="get_refund") { echo 'text-primary';}?>" href="<?php echo base_url('report/get_refund') ?>">
              <span class="ml-1 item-text">Batal Jualan</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="get_deleted_v") { echo 'text-primary';}?>" href="<?php echo base_url('report/get_deleted_v') ?>">
              <span class="ml-1 item-text">Variasi Dipadam</span>
            </a>
          </li>
          <?php if ($user_profile['user_group'] == 0 || $user_profile['user_group'] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="inv_supplier") { echo 'text-primary';}?>" href="<?php echo base_url('report/inv_supplier') ?>">
              <span class="ml-1 item-text">Invoice Supplier</span>
            </a>
          </li>
          <?php } ?>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="#support" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
          <i class="fe fe-book fe-16"></i>
          <span class="ml-3 item-text">Katalog</span>
        </a>
        <ul class="collapse list-unstyled pl-4 w-100 <?php if($this->uri->segment(1)=="catalog" && $this->uri->segment(2)!="create_order" && $this->uri->segment(2)!="tukang" && $this->uri->segment(2)!="all_variants") { echo 'show';}?>" id="support">
          <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="capital_price") { echo 'text-primary';}?>" href="<?php echo base_url('catalog/capital_price') ?>"><span class="ml-1">Harga Kapital</span></a>
          <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="new_product") { echo 'text-primary';}?>" href="<?php echo base_url('catalog/new_product') ?>"><span class="ml-1">Daftar Produk</span></a>
          <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="products" || $this->uri->segment(2)=="product_detail" || $this->uri->segment(2)=="product_edit") { echo 'text-primary';}?>" href="<?php echo base_url('catalog/products') ?>"><span class="ml-1">Senarai Produk</span></a>
          <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="supplier") { echo 'text-primary';}?>" href="<?php echo base_url('catalog/supplier') ?>"><span class="ml-1">Kategori/Dulang/Pembekal</span></a>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="#ui-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
          <i class="fe fe-shopping-cart fe-16"></i>
          <span class="ml-3 item-text">Pesanan</span>
        </a>
        <ul class="collapse list-unstyled pl-4 w-100 <?php if($this->uri->segment(1)=="orders" || $this->uri->segment(2)=="create_order" || $this->uri->segment(2)=="search_orders") { echo 'show';}?>" id="ui-elements">
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="create_order" || $this->uri->segment(2)=="checkout") { echo 'text-primary';}?>" href="<?php echo base_url('catalog/create_order') ?>"><span class="ml-1">Tambah pesanan</span></a>
            <?php if ($this->data['user_profile']['user_group'] != 1 && $this->data['user_profile']['user_group'] != 0) { ?>
              <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="search_orders") { echo 'text-primary';}?>" href="<?php echo base_url('orders/search_orders'); ?>">
                <span class="ml-1 item-text">Carian Pesanan</span>
              </a>
            <?php } ?> 
              <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="list_orders" || $this->uri->segment(2)=="detail") { echo 'text-primary';}?>" href="<?php echo base_url('orders/list_orders'); ?>">
                <span class="ml-1 item-text">Senarai Pesanan</span>
              </a>
          </li>
        </ul>
      </li>
      <!-- <li class="nav-item w-100">
        <a class="nav-link <?php if($this->uri->segment(2)=="all_variants" || $this->uri->segment(2)=="create_booking" || $this->uri->segment(2)=="create_repair" || $this->uri->segment(2)=="booking_invoices" || $this->uri->segment(2)=="repair_invoices") { echo 'text-primary';}?>" href="<?php echo base_url('booking/all_variants') ?>">
          <i class="fe fe-clipboard fe-16"></i>
          <span class="ml-3">Tempahan</span>
          <?php if ($count_pending['total']) { ?>
            <span class="badge badge-pill badge-warning text-light p-2"><?= $count_pending['total'] ?></span>
          <?php } ?>
        </a>
      </li> -->
      <li class="nav-item w-100">
        <a class="nav-link <?php if($this->uri->segment(2)=="create_buy" || $this->uri->segment(2)=="buy_checkout") { echo 'text-primary';}?>" href="<?php echo base_url('buy/create_buy') ?>">
          <i class="fe fe-dollar-sign fe-16"></i>
          <span class="ml-3">Belian / Trade In</span> <?php if ($this->product_model->get_item()) { echo '<span class="badge bg-danger text-light mt-1 pt-1">'.count($this->product_model->get_item()).'</span>'; } ?>
        </a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a href="#tukang" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
          <i class="fe fe-tool fe-16"></i>
          <span class="ml-3 item-text">Tukang ( Senarai )</span>
        </a>
        <ul class="collapse list-unstyled pl-4 w-100 <?php if(($this->uri->segment(1)=="catalog" & $this->uri->segment(2)=="tukang") || ($this->uri->segment(2)=="list_booking" || $this->uri->segment(2)=="repair" || $this->uri->segment(2)=="list_booking_shop" || $this->uri->segment(2)=="create_repair" || $this->uri->segment(2)=="list_repair" || $this->uri->segment(2)=="booking_detail" || $this->uri->segment(2)=="tempahan_detail" || $this->uri->segment(2)=="repair_detail") && $this->uri->segment(2)!="create_repair") { echo 'show';}?>" id="tukang">
          <li class="nav-item">
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="tukang") { echo 'text-primary';}?>" href="<?php echo base_url('catalog/tukang') ?>"><span class="ml-1">Tambah / Kerat</span></a>
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="list_booking_shop" || $this->uri->segment(2)=="tempahan_detail") { echo 'text-primary';}?>" href="<?php echo base_url('booking/list_booking_shop'); ?>"><span
                class="ml-1 item-text">Tempahan Kedai</span>
            </a>
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="list_booking" || $this->uri->segment(2)=="booking_detail") { echo 'text-primary';}?>" href="<?php echo base_url('booking/list_booking'); ?>"><span
                class="ml-1 item-text">Tempahan Baru</span>
            </a>
            <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="list_repair" || $this->uri->segment(2)=="repair_detail") { echo 'text-primary';}?>" href="<?php echo base_url('booking/list_repair') ?>"><span class="ml-1">Tempahan Baiki</span></a>
          </li>
        </ul>
      </li> -->
      <li class="nav-item w-100">
        <a class="nav-link <?php if($this->uri->segment(2)=="get_cust" || $this->uri->segment(2)=="detail_cust") { echo 'text-primary';}?>" href="<?php echo base_url('user/get_cust') ?>">
          <i class="fe fe-user fe-16"></i>
          <span class="ml-3">Pelanggan</span>
        </a>
      </li>
      <?php if ($this->data['user_profile']['user_group'] != 2) { ?>
      <li class="nav-item dropdown">
        <a href="#profile" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
          <i class="fe fe-shield fe-16"></i>
          <span class="ml-3 item-text">Pengguna</span>
        </a>
        <ul class="collapse list-unstyled pl-4 w-100 <?php if($this->uri->segment(1)=="user" && $this->uri->segment(2)!="get_cust" && $this->uri->segment(2)!="detail_cust" || $this->uri->segment(2)=="cash_in") { echo 'show';}?>" id="profile">
          <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="get_users" || $this->uri->segment(2)=="edit" || $this->uri->segment(2)=="cash_in") { echo 'text-primary';}?>" href="<?php echo base_url('user/get_users') ?>"><span class="ml-1">Senarai
              Pengguna</span></a>
          <a class="nav-link pl-3 <?php if($this->uri->segment(2)=="register") { echo 'text-primary';}?>" href="<?php echo base_url('user/register') ?>"><span class="ml-1">Daftar
              Pengguna</span></a>
        </ul>
      </li>
      <li class="nav-item dropdown">
      <li class="nav-item w-100">
        <a class="nav-link  <?php if($this->uri->segment(2)=="setting") { echo 'text-primary';}?>" href="<?php echo base_url('admin/setting') ?>">
          <i class="fe fe-settings fe-16"></i>
          <span class="ml-3 item-text">Tetapan</span>
        </a>
      </li>
      <?php } ?>
    </ul>
  </nav>
</aside>