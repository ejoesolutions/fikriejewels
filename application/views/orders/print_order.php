<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Fikrie Jewels</title>
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

<div class="card shadow pt-4">
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-md-2 text-center pr-0">
        <!-- <img src="<?php echo base_url('images/'); ?>mygold-BLACK.png" class="navbar-brand-img mb-4" style="max-width: 60%;"> -->
        <img src="<?php echo base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img mb-4" style="max-width: 70%;">
      </div>
      <div class="col-md-3">
        <p class="h5 mb-0"><?= $orders['name'] ?></p>
        <?= $orders['nama_tambahan'] ? '<p class="mb-1 h6">'.$orders['nama_tambahan'].'</p>' : '-' ?>
        <small><?= $orders['pendaftaran'] ?></small>
        <p class="mb-4">
          <?= $orders['alamat'] ?>,
          <br> <?= $orders['poskod'] ?> <?= $orders['bandar'] ?>, <?= $orders['state'] ?>
          <br> Telefon : <?= $orders['telefon'] ?>
          <br> H/P : <?= $orders['hp1'] ?>
          <?= $orders['hp2'] ? ', '.$orders['hp2'] : '-' ?>
        </p>
      </div>
      <!-- Maklumat Pembeli -->
      <div class="col-md-5 text-dark">
        <h5 class="text-secondary">Maklumat Pembeli</h5>
          <div class="row ml-0">
            <div class="mr-2">
              Nama : <?= $orders['cust_name'] ? $orders['cust_name'] : '-' ?>
              <br> 
              Telefon : <?= $orders['cust_phone'] ? $orders['cust_phone'] : '-' ?>
              <br>
              Alamat : <?= $orders['cust_address'] ? $orders['cust_address'].', '.$orders['cust_state'] : '-' ?>
              <br>
              No K/p : <?= $orders['cust_kp'] ? $orders['cust_kp'] : '-' ?>
              <br> 
            </div>
          </div>
      </div>
      <!-- ./Maklumat Pembeli -->
      <!-- Resit / Invois button and modal -->
      <div class="col-md-2 text-left pr-5">
        <?php if ($orders['sold'] == 1 && ($user_profile['user_group'] == 1 || $user_profile['user_group'] == 0)) { ?>
          <button type="button" class="btn btn-secondary btn-lg" disabled>Resit / Invois</button>
        <?php }elseif ($orders['sold'] == 2) { ?>
          <button type="button" class="btn btn-secondary btn-lg" disabled>Resit / Invois</button>
        <?php }else { ?>
          <button type="button" class="btn btn-secondary btn-lg" disabled>Resit / Invois</button>
        <?php } ?>
        <p class="mb-4">
          <br>No : <?= $orders['order_no'] ?>
          <br>Tarikh : <?= date("d-m-Y", strtotime($orders['created_date'])); ?>
          <br>Jurujual : <?= $orders['staff'] ?>
          <?= $orders['tracking_num'] ? '<br>No.Tracking : '.$orders['tracking_num'] : '' ?>
          <br>
        </p>
      </div>
      <!-- Resit / Invois button and modal -->
    </div> <!-- /.row -->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th nowrap class="text-center" width="33%">Info Produk</th>
          <th nowrap class="text-center" width="14%">Nota</th>
          <th nowrap class="text-center" width="18%">Maklumat</th>
          <th nowrap class="text-center" width="9%">Upah ( RM )</th>
          <th nowrap class="text-center" width="14%">Harga Semasa ( RM )</th>
          <th nowrap class="text-center" width="15%">Jumlah ( RM )</th>
        </tr>
      </thead>
      <tbody>

      <?php foreach ($items as $item){ ?>
        <tr>
          <td>
            <div class="row justify-content-center text-center" style="font-weight: bold;">
              <div class="">
                <?= $item['product_name'] ?>
                <br>
               <small style="font-weight: bold;">[ <?= $item['v_sn'] ?> ]</small>
               <br>
               <small style="font-weight: bold;">KJ : <?= $item['v_kod'] ? $item['v_kod'] : '-' ?></small>
              </div>
            </div>
          </td>
          <td class="text-center">
            <?= $item['nota'] ?>
          </td>
          <td>
            <!-- <?= $item['ordered_weight'] ?> g
            <br>
            <?= number_format($item['ordered_weight'] / 2.72, 3, '.', ''); ?> sb -->
            <div class="row justify-content-center">
              <div>
                <small>
                  B :
                  <?php
                    if($item['ordered_weight']!='')
                    {
                      echo $item['ordered_weight'].' g';
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
                <br>
                <small>
                  P :
                  <?php
                    if($item['v_length']!='')
                    {
                      echo $item['v_length'].' cm';
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
                <br>
                <small>
                  L :
                  <?php
                    if($item['v_width']!='')
                    {
                      echo $item['v_width'].' cm';
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
                <br>
                <small>
                  Sz :
                  <?php
                    if($item['v_size']!='')
                    {
                      echo $item['v_size'];
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
              </div>

              <div class="ml-3">
                <small>
                  M :
                  <?php
                    if($item['mutu']!='')
                    {
                      echo $item['mutu'];
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
                <br>
                <small>
                  Sb : <?= number_format($item['ordered_weight'] / 2.72, 3, '.', ''); ?>
                </small>
              </div>
            </div>
          </td>
          <td class="text-center"><?= $item['ordered_margin_pay'] ?></td>

          <?php if ($orders['kategori'] == 1 || $orders['sold'] == 1 ) { ?>
          <td class="text-center">
            <?= $item['setup_price'] ?> / g
            <br>
            <?= $item['sb_price'] ?> / sb
          </td>
          <?php }elseif ($orders['kategori'] == 2) { ?>
          <td class="text-center">
            <?= $item['per_gram_semasa'] ?> / g
            <br>
            <?= $item['sb_price_semasa'] ?> / sb
          </td>
          <?php } ?>

          
          <td class="text-center" style="font-size:17px;font-weight: bold;">

          <?php if ($item['order_category'] == 99) { echo "<del>";} ?>

            <?php if ($orders['kategori'] == 1 || $orders['sold'] == 1) { 
              echo $item['ordered_price'];

              if ($item['diskaun'] > 0 ) {
                echo "<br><small>Diskaun : - RM".$item['diskaun']."</small>";
              }
            }elseif ($orders['kategori'] == 2) {
              // echo $subtotal = number_format(($item['per_gram_semasa'] * $item['ordered_weight']) + $item['ordered_margin_pay'], 2, '.', '');
              $gold_price = number_format($item['per_gram_semasa'] * $item['ordered_weight'], 2, '.', '');

              echo $subtotal = number_format($gold_price + $item['ordered_margin_pay'], 2, '.', '');
              if ($item['diskaun'] > 0 ) {
                echo "<br><small>Diskaun : - RM".$item['diskaun']."</small>";
              }
            } ?>
          <?php if ($item['order_category'] == 99) { echo "</del>";} ?>
          
          <!-- harga duit refund balik -->
          <?php if ($item['refund']) {
            echo '<br>'.$item['refund'].'';
          } ?>

          </td>
        </tr>
      <?php } ?>

        <tr>
          <td colspan="4" class="text-dark test" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important; ">

          <?php if ($syarat_ikat && $orders['kategori'] == 1) {

            $i = 1 ;

            foreach ($syarat_ikat as $key ) { ?>
              <small><?= $i++ ?> . <?= $key['text'] ?></small><br>
            <?php }
          } ?>

          <?php if ($syarat_semasa && $orders['kategori'] == 2) {

            $i = 1 ;

            foreach ($syarat_semasa as $key ) { ?>
            <small><?= $i++ ?> . <?= $key['text'] ?></small><br>
            <?php }
          } ?>

            <span style="font-size: 90%;">
            <?php if ($orders['kategori'] == 1) { ?>
              <i>*Nota : Ikat Harga</i>
            <?php }elseif ($orders['kategori'] == 2) { ?>
              <i>*Nota : Harga Semasa</i>
            <?php } ?>
            </span>
          </td>
          <td class="text-right" style="font-weight: bold;">
            Tax ( <?= $orders['total_tax'] ?>% ) <br>
            Postage ( RM ) <br>
            Adjustment ( RM ) <br>
            Jumlah ( RM ) <br>
          </td>
          <td class="text-center" style="font-size:17px;font-weight: bold;">
            <?php if ($orders['total_tax_rm'] > 0) {
              echo $orders['total_tax_rm'];
            }else {
              echo "0.00";
            } ?>
            <br>
            <?php if ($orders['total_shipping'] > 0) {
              echo $orders['total_shipping'];
            }else {
              echo "0.00";
            } ?>
            <br>
            <?php if ($orders['total_adjustment'] > 0) {
              echo '-'.$orders['total_adjustment'];
            }else {
              echo "0.00";
            } ?>
            <br>
            <!-- <?php if ($orders['kategori'] == 1) {
              echo $orders['total_all'];
            }elseif ($orders['kategori'] == 2) {
              echo $total_semasa = number_format(($item['per_gram_semasa'] * $item['ordered_weight']) + $item['ordered_margin_pay'], 2, '.', '');
            } ?> -->
            <?php if ($orders['kategori'] == 1 || $orders['sold'] == 1) {
              echo $orders['total_all'];

              $total_semasa = 0;
              foreach ($items as $item){  
               $total_semasa += number_format((($item['per_gram_semasa'] * $item['ordered_weight']) + $item['ordered_margin_pay']) - $item['deposit'] - $item['diskaun'], 2, '.', '');
              }

              // $total_all_semasa = $total_semasa + $orders['total_tax_rm'] + $orders['total_shipping'] - $orders['total_adjustment'];
              $total_all_semasa = $orders['total_all'];

            }elseif ($orders['kategori'] == 2) {

              $total_semasa = 0;
              foreach ($items as $item){  
              //  $total_semasa += number_format((($item['per_gram_semasa'] * $item['ordered_weight']) + $item['ordered_margin_pay']) - $item['diskaun'], 2, '.', '');
               $total_semasa += number_format(($item['per_gram_semasa'] * $item['ordered_weight']) , 2, '.', '') + number_format($item['ordered_margin_pay'] , 2, '.', '') - number_format($item['diskaun'] , 2, '.', '');   
              }

              $total_all_semasa = $total_semasa + $orders['total_tax_rm'] + $orders['total_shipping'] - $orders['total_adjustment'];

              echo number_format($total_all_semasa, 2, '.', '');
            } ?>
            
          </td>
        </tr>
        <?php
        if ($resit) {
          foreach ($resit as $test){ ?>
            <tr class="pb-0">
              <td colspan="3" class="text-dark pb-1"
                style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              </td>
              <td class="text-dark pb-1 text-right" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              <small class="text-secondary"><?= $test['nota'] ?></small> 
              </td>
              <td class="text-right pb-1" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;">
                <?php if ($test['cara_bayaran'] == 1) {
                  echo "Tunai";
                }elseif ($test['cara_bayaran'] == 2) {
                  echo "Bank In";
                }elseif ($test['cara_bayaran'] == 3) {
                  echo "Debit/CC";
                }elseif ($test['cara_bayaran'] == 4) {
                  echo "Deposit";
                } ?> 

                <?php if ($test['cara_bayaran'] != 4) { ?>
                  : <?= date("d-m-Y", strtotime($test['tarikh_bayaran'])); ?>
                <?php } ?>
                
                <br>
              </td>
              <td class="text-center pb-1" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;font-size:17px;font-weight: bold;"><?= $test['jumlah'] ?></td>
            </tr>
          <?php }  } ?>
        
        <tr class="pb-0">
          <td class="text-dark pb-0" colspan="4" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            <span>----------------------------------</span><span class="ml-5">----------------------------------</span><br>
            <span class="ml-4">Tandatangan Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   </span>
            <span class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Penjual </span>
          </td>
          <td class="text-right pb-0"
            style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            Baki Bayaran
          </td>
          <td class="text-center pb-0" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
          <?php if ($orders['kategori'] == 1 || $orders['sold'] == 1) { ?>
            <input type="text" class="form-control text-center" value="<?= $orders['balance_total'] ?>" readonly style="font-size:17px;font-weight: bold;">
          <?php }elseif ($orders['kategori'] == 2) { ?>
            <input type="text" class="form-control text-center" value="<?= number_format($total_all_semasa - $orders['paid_total'], 2, '.', '') ?>" readonly style="font-size:17px;font-weight: bold;">
          <?php } ?>
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