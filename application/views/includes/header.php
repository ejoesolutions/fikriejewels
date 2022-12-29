
<div class="container">
  <div class="pull-left">
   <!-- Logo -->
    <div class="header-logo">
      <a class="logo" href="<?php echo base_url() ?>">
        <img src="<?php echo base_url('logo/'.$logo['image_file']); ?>" alt="Logo">
      </a>
    </div>
    <!-- /Logo -->

    <!-- Search -->

    <!-- /Search -->
  </div>
  <div class="pull-right">


    <ul class="header-btns">
      <!-- Account -->

        <li class="header-account header-search">
            <?= form_open('main/search',array('class'=>'','method'=>'get')); ?>
              <input class="search-input" type="text" name="search_text" placeholder="Masukkan carian anda.." style="height:40px">
      				<button class="search-btn"><i class="fa fa-search"></i></button>
            <?= form_close(); ?>
        </li>

      <!-- /Account -->

      <!-- Cart -->
      <?php
      $total=0.0;
      foreach ($this->cart->contents() as $items){
        $total=$total+$items['subtotal'];
      }
       ?>
      <!--<li class="header-cart dropdown default-dropdown">-->
      <!--  <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">-->
      <!--    <div class="header-btns-icon">-->
      <!--      <i class="fa fa-shopping-cart"></i>-->
      <!--      <span class="qty"><?php echo count($this->cart->contents()) ?></span>-->
      <!--    </div>-->
      <!--  </a>-->
      <!--  <div class="custom-menu">-->
      <!--    <div id="shopping-cart">-->
      <!--      <div class="shopping-cart-btns">-->
      <!--        <a href="<?php echo base_url('customer/cart') ?>"><button class="main-btn">View Cart</button></a>-->
      <!--        <a href="<?php echo base_url('orders/checkout') ?>"><button class="primary-btn">Checkout <i class="fa fa-arrow-circle-right"></i></button></a>-->
      <!--      </div>-->
      <!--    </div>-->
      <!--  </div>-->
      <!--</li>-->
      <li class="dropdown dropdown-user header-cart">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

          <div class="header-btns-icon">
            <i class="fa fa-shopping-cart"></i>
            <span class="qty"><?php echo count($this->cart->contents()) ?></span>
          </div>
        </a>
        <ul class="dropdownshop-menu dropdown-menu-default">
          <li align="center">
            <a href="<?php echo base_url('customer/cart') ?>"><button class="main-btn" style="width: 100%;">Lihat Troli</button></a>
          </li>
          <li align="center">
            <?php if(!empty($this->cart->contents())){ ?>
            <a href="<?php echo base_url('orders/checkout') ?>"><button class="primary-btn" style="width: 100%;">Semak Keluar <i class="fa fa-arrow-circle-right"></i></button></a>
          <?php }else{
            ?>
              <a href="#"><button class="primary-btn" style="width: 100%;">Semak Keluar <i class="fa fa-arrow-circle-right"></i></button></a>
            <?php
          } ?>
          </li>
        </ul>
      </li>

      <li class="nav-toggle">
        <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
      </li>

      <?php if(!empty($user_profile)){ ?>
        <li><span class="white-color">Hai, <br><?php echo $user_profile['full_name'] ?></span></li>
      <?php } ?>
      <!-- /Cart -->

      <li class="dropdown dropdown-user header-cart">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

          <div class="header-btns-icon">
            <i class="fa fa-user"></i>
            <!-- <span class="qty"><?php echo count($this->cart->contents()) ?></span> -->
          </div>
        </a>
        <ul class="dropdownshop-menu dropdown-menu-default">
          <?php
          if(!$this->ion_auth->logged_in()){
            ?>
            <li align="center">
              <a href="<?php echo base_url('customer/register') ?>"><button class="main-btn" style="width: 100%;">Log Masuk/Daftar</button></a>
            </li>
            <?php
          }else{
          ?>
          <li align="center">
            <a href="<?php echo base_url('customer/dashboard') ?>"><button class="main-btn" style="width: 100%;">Akaun Saya</button></a>
          </li>
           <li align="center">
             <a href="<?php echo base_url('customer/logout') ?>"><button class="main-btn" style="width: 100%;">Log Keluar</button></a>
           </li>
          <?php
          }
          ?>
        </ul>
      </li>
      <!-- Mobile nav toggle-->
      <!-- <li class="nav-toggle">
        <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
      </li> -->
      <!-- / Mobile nav toggle -->
    </ul>
  <!--  <?php if(!empty($user_profile)){ ?>-->
  <!--  <div class="pull-right">-->
  <!--    <p style="color:white">Hello, <?php echo $user_profile['full_name'] ?></p>-->
  <!--  </div>-->
  <!--<?php } ?>-->
  </div>
</div>
