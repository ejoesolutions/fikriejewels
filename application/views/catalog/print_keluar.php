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
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawesome-free/css/all.min.css" rel="stylesheet"
    type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dropzone.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.css">

  <!-- Date Range Picker CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css">
  <!-- App CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app-light.css" id="lightTheme">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app-dark.css" id="darkTheme" disabled>
  <!-- File Input -->
  <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"
    rel="stylesheet" type="text/css" />
  <!-- Jquery -->
  <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!-- <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> -->

  <style>
    th {
      color: #001a4e !important;
      font-weight: bold !important;
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

    ::placeholder {
      /* Chrome, Firefox, Opera, Safari 10.1+ */
      color: #ABB2B9 !important;
      opacity: 1 !important;
      /* Firefox */
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
          <!-- <img src="<?php echo base_url('images/'); ?>mygold-BLACK.png" class="navbar-brand-img mb-4" style="max-width: 60%;"> -->
          <img src="<?php echo base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img mb-4" style="max-width: 70%;">
        </div>
        <div class="col-md-3">
          <p class="h5 mb-0"><?= $variant['name'] ?></p>
          <?= $variant['nama_tambahan'] ? '<p class="mb-1 h6">'.$variant['nama_tambahan'].'</p>' : '-' ?>
          <small><?= $variant['pendaftaran'] ?></small>
          <p class="mb-4">
            <?= $variant['alamat'] ?>,
            <br> <?= $variant['poskod'] ?> <?= $variant['bandar'] ?>, <?= $variant['state'] ?>
            <br> Telefon : <?= $variant['telefon'] ?>
            <br> H/P : <?= $variant['hp1'] ?>
            <?= $variant['hp2'] ? ', '.$variant['hp2'] : '-' ?>
          </p>
        </div>
        <!-- Maklumat Pembeli -->
        <div class="col-md-3 text-dark">
          <h5 class="text-secondary">Maklumat Penjual</h5>
            <div class="row ml-0">
              <div class="mr-2">
                Nama : <?= $variant['cust_name'] ? $variant['cust_name'] : '-' ?>
                <br> 
                Telefon : <?= $variant['cust_phone'] ? $variant['cust_phone'] : '-' ?>
                <br>
                Alamat : <?= $variant['cust_address'] ? $variant['cust_address'].', '.$variant['cust_state'] : '-' ?>
                <br>
                No K/p : <?= $variant['cust_kp'] ? $variant['cust_kp'] : '-' ?>
                <br> 
              </div>
            </div>
        </div>
        <!-- ./Maklumat Pembeli -->
        <!-- Resit / Invois button and modal -->
        <div class="col-md-1"></div>
        <div class="col-md-3 text-left pr-5">
          <h4 class="text-secondary">Resit Keluar</h4>
          <p class="mb-4">
            <br>Tarikh Keluar : <?= date("d-m-Y", strtotime($variant['tarikh'])); ?>
          </p>
        </div>
        <!-- Resit / Invois button and modal -->
      </div> <!-- /.row -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" width="39%">Info Produk</th>
            <th class="text-center" width="15%">Berat</th>
            <th class="text-center" width="15%">Maklumat</th>
            <th class="text-center" width="15%">Harga Semasa (RM)</th>
            <th class="text-center" width="18%">Jumlah (RM)</th>
          </tr>
        </thead>
        <tbody>

        <tr>
          <td>
            <div class="row justify-content-center text-center">
              <div class="">
                <?= $variant['product_name'] ?>
                <br>
                <small>[ <?= $variant['v_sn'] ?> ]</small>
              </div>
              <div class="ml-3">
                MUTU : <?= $variant['mutu'] ?>
              </div>
            </div>
          </td>
          <td class="text-center">
            <?= $variant['v_weight'] ?> g
            <br>
            <?= $variant['v_sb'] ?> sb
          </td>
          <td>
          <div class="row justify-content-center">
            <div>
              <small>
                Up :
                <?php
                  if($variant['v_margin_pay']!='')
                  {
                    echo $variant['v_margin_pay'];
                  }else{
                    echo '-';
                  }
                ?>
              </small>
              <br>
              <small>
                P :
                <?php
                  if($variant['v_length']!='')
                  {
                    echo $variant['v_length'].' cm';
                  }else{
                    echo '-';
                  }
                ?>
              </small>
              <br>
              <small>
                L :
                <?php
                  if($variant['v_width']!='')
                  {
                    echo $variant['v_width'].' cm';
                  }else{
                    echo '-';
                  }
                ?>
              </small>
              <br>
              <small>
                Sz :
                <?php
                  if($variant['v_size']!='')
                  {
                    echo $variant['v_size'];
                  }else{
                    echo '-';
                  }
                ?>
              </small>
            </div>
          </td>

          <td class="text-center">
            <?= $variant['setup_price'] ?> / g
            <br>
            <!-- <?= $variant['serial_berat'] ?> / ya -->
          </td>
          
          <td class="text-center">
            <?php echo $subtotal = number_format(($variant['setup_price'] * $variant['v_weight']) + $variant['v_margin_pay'], 2, '.', ''); ?>
            <br>
            [ Deposit : RM <?= $variant['deposit'] ?> ]
          </td>
        </tr>

          <tr>
            <td colspan="3" class="text-dark test"
              style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;border-bottom-color: #ffffff !important; ">
              <?php if ($syarat_keluar) {

                $i = 1 ;

                foreach ($syarat_keluar as $key ) { ?>
                  <small><?= $i++ ?> . <?= $key['text'] ?></small><br>
                <?php }
              } ?>
            </td>
          </tr>
          
          <tr>
            <td colspan="3" class="text-dark test"
              style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;border-bottom-color: #ffffff !important; ">
              <br><br><br>
            </td>
          </tr>
          <tr class="pb-0">
            <td class="text-dark pb-0" colspan="3"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              <span>----------------------------------</span><span
                class="ml-5">----------------------------------</span><br>
              <span class="ml-4">Tandatangan Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <span class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Penjual </span>
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