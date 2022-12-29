<?php echo $this->session->flashdata('upload'); ?>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-md-2 text-center pr-0">
        <img src="<?php echo base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img mb-4" style="max-width: 55%;">
      </div>
      <div class="col-md-3">
        <p class="h5 mb-0"><?= $buy['name'] ?></p>
        <?= $buy['nama_tambahan'] ? '<p class="mb-1 h6">'.$buy['nama_tambahan'].'</p>' : '-' ?>
        <small><?= $buy['pendaftaran'] ?></small>
        <p class="mb-4">
          <?= $buy['alamat'] ?>,
          <br> <?= $buy['poskod'] ?> <?= $buy['bandar'] ?>, <?= $buy['state'] ?>
          <br> Telefon : <?= $buy['telefon'] ?>
          <br> H/P : <?= $buy['hp1'] ?>
          <?= $buy['hp2'] ? ', '.$buy['hp2'] : '-' ?>
        </p>
      </div>
      <!-- Maklumat Pembeli -->
      <div class="col-md-5 text-dark">
        <h5 class="text-secondary">Maklumat Penjual</h5>
          <div class="row ml-0">
            <div class="mr-2">
              Nama : <?= $buy['cust_name'] ? $buy['cust_name'] : '-' ?>
              <br> 
              Telefon : <?= $buy['cust_phone'] ? $buy['cust_phone'] : '-' ?>
              <br>
              Alamat : <?= $buy['cust_address'] ? $buy['cust_address'].', '.$buy['cust_state'] : '-' ?>
              <br>
              No K/p : <?= $buy['cust_kp'] ? $buy['cust_kp'] : '-' ?>
              <br> 
            </div>
          </div>
      </div>
      <!-- ./Maklumat Pembeli -->
      <!-- Resit / Invois button and modal -->
      <div class="col-md-2 text-left pr-5">
        <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#varyModal"
          data-whatever="@mdo" disabled>Surat Belian</button>

        <p class="mb-4">
          <br>No : #<?= $buy['no_id'] ?>
          <br>Tarikh : <?= date("d-m-Y", strtotime($buy['created_date'])); ?>
          <br>Jurujual : <?= $buy['staf_name'] ?>
          <br>
        </p>
      </div>
      <!-- Resit / Invois button and modal -->
    </div> <!-- /.row -->
    <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="text-center">Info Produk</th>
          <th class="text-center">Berat</th>
          <!-- <th class="text-center">RM / Serial Berat</th> -->
          <th class="text-center">Keterangan</th>
          <th class="text-center" width="12%">Harga ( RM )</th>
        </tr>
      </thead>
      <tbody>

      <?php

      foreach ($items as $item){  ?>
        <tr>
          <td>
            <div class="row justify-content-center text-center">
              <div class="">
                <?= $item['product_name'] ?>
                <br>
               <small>[ <?= $item['serial_number'] ?> ]</small> 
              </div>
              <div class="ml-3">
                Mutu : <?= $item['mutu'] ?>
              </div>
            </div>
          </td>
          <td class="text-center">
            <?= $item['berat'] ?> g
          </td>
          <!-- <td class="text-center">
            <small>
              RM : <?= $item['harga_semasa'] ?>
              <br>
              Sb : <?= $item['serial_berat'] ?>
            </small>
          </td> -->
          <td class="text-center">
            <small class="mb-0">
              <?php if ($item['jenis'] == 1) {
                echo "Jenis : Belian";
              }elseif ($item['jenis'] == 2) {
                echo "Jenis : Trade In";
              } ?>
              <br>
              <?= $item['keterangan'] ?>
            </small>
          </td>
          <td class="text-center" width="12%"><?= $item['harga'] ?></td>
        </tr>
      <?php } ?>

        <tr>
          <td colspan="2" class="text-dark test" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important; ">

          <?php if ($syarat_belian) {

            $i = 1 ;

            foreach ($syarat_belian as $key ) { ?>
              <small><?= $i++ ?> . <?= $key['text'] ?></small><br>
            <?php }
          } ?>

          </td>
          <td class="text-right pb-0"
            style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            Jumlah :
          </td>
          <td class="text-center pb-0" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
           <input type="text" class="form-control text-center" style='' value="<?= $buy['total_harga'] ?>" readonly>
          </td>
        </tr>
        <?php if ($resit) { 

          foreach ($resit as $key) { ?>
            <tr class="pb-0">
              <td colspan="1" class="text-dark pb-1"
                style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              </td>
              <td class="text-dark pb-1 text-right" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              </td>
              <td class="text-right pb-1" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;">
              <?php if ($key['cara_bayaran'] == 1) { 
                echo "Tunai";
              }elseif ($key['cara_bayaran'] == 2) {
                echo "Bank In";
              }elseif ($key['cara_bayaran'] == 3) {
                echo "Debit / Credit";
              } ?>
              :
              </td>
              <td class="text-center pb-1" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;"><?= $key['bayaran'] ?></td>
            </tr> 
        <?php }
        } ?>
        <tr class="pb-0">
          <td class="text-dark pb-0" colspan="2" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            <!-- <span>----------------------------------</span><span class="ml-5">----------------------------------</span><br>
            <span class="ml-4">Tandatangan Penjual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <span class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Staf </span> -->
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</div>

<a href="<?= base_url('buy/buy_print/'.$buy['bil_id']) ?>" target="_blank" class="btn btn-info float-right text-light"><span class="fe fe-printer fe-16"></span> CETAK </a>
<!-- <a href="javascript: w=window.open('http://yoursite.com/LinkToThePDF.pdf'); w.print(); w.close(); ">​​​​​​​​​​​​​​​​​print pdf</a> -->

