<?php echo $this->session->flashdata('upload'); ?>

<?php echo form_open('user/login', array('class'=>'col-lg-3 col-md-4 col-10 mx-auto text-center')); ?>

  <!-- <h1 class="text-primary"><i class="fas fa-gem fa-2x"></i></h1> -->
  <a class="navbar-brand mx-auto flex-fill text-center" href="#">
    <img src="<?php echo base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img" style="max-width: 50%;">
  </a>
  
  <!-- <h5 class="mb-3">Sistem Pengurusan Jualan Emas</h5> -->

  <div class="form-group">
    <label class="sr-only">Nama Pengguna</label>
    <?php echo form_input($identity);?>
  </div>
  <div class="form-group">
    <label class="sr-only">Katalaluan</label>
    <input class="form-control form-control-lg" type="password" name="password" autocomplete="off" placeholder="Katalaluan" name="password"/>
  </div>
  <div class="form-actions">
    <?php echo form_submit('submit', 'Login', array('class'=>'btn btn-lg btn-primary btn-block')); ?>
  </div>
  <!-- <h5 class="mt-4 mb-3 float-right" style="color:#808B96;">  -->
    <!-- <?= date("Y") ?> © <a href="<?= base_url('user/login') ?>">SPJE</a> | Designed & Developed by <a href="https://www.ejoesolutions.com/">ejoesolutions</a>  -->
    <!-- <a href="<?= base_url('manual_pengguna/sisemas.pdf') ?>" target="_blank"><i class="far fa-file-alt"></i> Manual Pengguna</a> -->
  <!-- </h5> -->

<?php echo form_close(); ?>
