<footer id="footer" class="section section-black">
  <!-- container -->
  <div class="container white-color">
    <!-- row -->
    <div class="row">
      <!-- footer widget -->
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="footer">
          <!-- footer logo -->
          <div class="footer-logo">
            <a class="logo" href="#">
              <img src="<?php echo base_url('logo/'.$logo['image_file']); ?>" alt="Logo">
              <!-- <img src="<?php echo base_url('assets/layouts'); ?>/layout_shop/img/logo.png" alt=""> -->
            </a>
          </div>
          <!-- /footer logo -->

          <p><?php echo nl2br($footer['site_description']); ?></p>

          <!-- footer social -->
          <ul class="footer-social">
            <?php $none=base_url('#'); ?>
            <li><a href="<?php if($footer['facebook']!=NULL){ echo $footer['facebook']; }else{echo $none;} ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="<?php if($footer['twitter']!=NULL){ echo $footer['twitter']; }else{echo $none;} ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a href="<?php if($footer['instagram']!=NULL){ echo $footer['instagram']; }else{echo $none;} ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
            <li><a href="<?php if($footer['pinterest']!=NULL){ echo $footer['pinterest']; }else{echo $none;} ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
          </ul>
          <!-- /footer social -->
        </div>
      </div>
      <!-- /footer widget -->

      <!-- footer widget -->
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="footer">
          <h3 class="footer-header white-color">Akaun</h3>
          <ul class="list-links">
            <li><a href="<?php echo base_url('customer/dashboard') ?>" class="white-color">Akaun Saya</a></li>
            <!-- <li><a href="#">My Wishlist</a></li> -->
            <!-- <li><a href="#">Compare</a></li> -->
            <li><a href="<?php echo base_url('orders/checkout') ?>" class="white-color">Semak Keluar</a></li>
            <?php if(!$this->ion_auth->logged_in()){ ?>
            <li><a href="<?php echo base_url('customer/register') ?>"class="white-color">Log Masuk</a></li>
          <?php }else{ ?>
            <li><a href="<?php echo base_url('customer/logout') ?>"class="white-color">Log Keluar</a></li>
          <?php } ?>
          </ul>
        </div>
      </div>
      <!-- /footer widget -->

      <div class="clearfix visible-sm visible-xs"></div>

      <!-- footer widget -->
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="footer">
          <h3 class="footer-header white-color">Servis Pelanggan</h3>
          <ul class="list-links">
            <li><a href="<?php if($footer['about_us']!=NULL){ echo $footer['about_us']; }else{echo $none;} ?>" target="_blank" class="white-color">Tentang Kami</a></li>
            <li><a href="<?php if($footer['shipping_return']!=NULL){ echo $footer['shipping_return']; }else{echo $none;} ?>" target="_blank" class="white-color">Penghantaran & Pulangan</a></li>
            <li><a href="<?php if($footer['shipping_guide']!=NULL){ echo $footer['shipping_guide']; }else{echo $none;} ?>" target="_blank" class="white-color">Info Penghantaran</a></li>
            <li><a href="<?php if($footer['faq']!=NULL){ echo $footer['faq']; }else{echo $none;} ?>" target="_blank" class="white-color">FAQ</a></li>
          </ul>
        </div>
      </div>
      <!-- /footer widget -->

      <!-- footer subscribe -->
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="footer">
          <h3 class="footer-header white-color">Kekal Berhubung</h3>
          <p><?php echo $footer['stay_connected'] ?></p>
          <!-- <form> -->
          <?php echo form_open('admin/add_newslatter') ?>
            <div class="form-group">
              <input class="input" placeholder="Enter Email Address" type="email" name="email" required>
            </div>
            <button class="primary-btn" name="submit">Join Kami</button>
            <?php echo form_close(); ?>
          <!-- </form> -->
        </div>
      </div>
      <!-- /footer subscribe -->
    </div>
    <!-- /row -->
    <hr>
    <!-- row -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2 text-center">
        <!-- footer copyright -->
        <div class="footer-copyright">
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved |
            Developed by <a href="https://www.ejoesolutions.com/" target="blank" class="white-color">ejoeSolutions</a>
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </div>
        <!-- /footer copyright -->
      </div>
    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</footer>
