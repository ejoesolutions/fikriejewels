<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Adriana Gold</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/simplebar.css">
    <!-- Fonts CSS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
    
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/feather.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dropzone.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.css">

    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app-dark.css" id="darkTheme" disabled>
    <!-- File Input -->
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <!-- Jquery -->
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> -->

    <style>
    th {
      color: #001a4e !important ;
      font-weight: bold !important ; 
    }

    img {
      max-width: 100%;
    }

    a:link {
      text-decoration: none;
    }

    h4 {
      font-family: 'Overpass', sans-serif;
    }

    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
      color: #ABB2B9 !important; 
      opacity: 1 !important; /* Firefox */
    }

    /* @media print {
      #printPageButton {
        display: none;
      }
    } */

    </style>
  </head>

<body>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row mb-2">
        <div class="col-md-2 text-center pr-0">
          <img src="<?php echo base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img mb-4" style="max-width: 70%;">
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
      <!-- ./Maklumat Pembeli -->
    </div> <!-- /.row -->
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
                MUTU : <?= $item['mutu'] ?>
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
          <td class="text-center"><?= $item['harga'] ?></td>
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
            Jumlah
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
          <td class="text-dark pb-0" colspan="1" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            <span>----------------------------------</span><span class="ml-5">----------------------------------</span><br>
            <span class="ml-4">Tandatangan Penjual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <span class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Staf </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</body>

</html>

<script>
window.print();
// w.close();
</script>