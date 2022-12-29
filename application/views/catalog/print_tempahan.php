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
          <img src="<?= base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img mb-4"
            style="max-width: 60%;">
        </div>
        <div class="col-md-3">
          <p class="h5 mb-0"><?= $book['name'] ?></p>
          <?= $book['nama_tambahan'] ? '<p class="mb-1 h6">'.$book['nama_tambahan'].'</p>' : '-' ?>
          <small><?= $book['pendaftaran'] ?></small>
          <p class="mb-4">
            <?= $book['alamat'] ?>,
            <br> <?= $book['poskod'] ?> <?= $book['bandar'] ?>, <?= $book['state'] ?>
            <br> Telefon : <?= $book['telefon'] ?>
            <br> H/P : <?= $book['hp1'] ?>
            <?= $book['hp2'] ? ', '.$book['hp2'] : '-' ?>
          </p>
        </div>
        <!-- Maklumat Pelanggan -->
        <div class="col-md-5 text-dark">
          <h5 class="text-secondary">Maklumat Pelanggan</h5>
            <div class="row ml-0">
              <div class="mr-2">
                Nama : <?= $book['cust_name'] ? $book['cust_name'] : '-' ?>
                <br> 
                Telefon : <?= $book['cust_phone'] ? $book['cust_phone'] : '-' ?>
                <br>
                Alamat : <?= $book['cust_address'] ? $book['cust_address'].', '.$book['cust_state'] : '-' ?>
                <br>
                No K/p : <?= $book['cust_kp'] ? $book['cust_kp'] : '-' ?>
                <br> 
              </div>
            </div>
        </div>
        <!-- ./Maklumat Pelanggan -->
        <!-- Resit / Invois button and modal -->
        <div class="col-md-2 text-left pr-5">
          <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#varyModal"
            data-whatever="@mdo">Surat Tempahan Kedai</button>
          <p class="mb-4">
            <br>Tarikh : <?= date("d-m-Y", strtotime($book['tarikh'])); ?>
            <br>Jurujual : <?= $book['staf_name'] ?>
            <br>
          </p>
        </div>
        <!-- Resit / Invois button and modal -->
      </div> <!-- /.row -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" width="33%">Info Produk</th>
            <th class="text-center">Nota</th>
            <th class="text-center" width="15%">Berat</th>
            <th class="text-center" width="18%">Deposit Tempahan ( RM )</th>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td>
              <div class="row justify-content-center text-center">
                <div class="">
                  <?= $book['product_name'] ?>
                  <br>
                  <small>[ <?= $book['v_sn'] ?> ]</small>
                </div>
                <div class="ml-3">
                  MUTU : <?= $book['mutu'] ?>
                </div>
              </div>
            </td>
            <td class="text-center"><?= $book['nota'] ?></td>
            <td class="text-center">
              <?= $book['v_weight'] ?> g
              <br>
              <?= $book['v_sb'] ?> sb
            </td>
            <td class="text-center"><?= $book['harga'] ?></td>
          </tr>


          <tr>
            <td colspan="2" class="text-dark test"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important; ">
              <?php if ($syarat_kedai) {

                $i = 1 ;

                foreach ($syarat_kedai as $key ) { ?>
                  <small><?= $i++ ?> . <?= $key['text'] ?></small><br>
                <?php }
              } ?>
            </td>
            <td class="text-right pb-0"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              Jumlah
            </td>
            <td class="text-center pb-0"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              <input type="text" class="form-control text-center" style='' value="<?= $book['harga'] ?>" readonly>
            </td>
          </tr>
          <tr class="pb-0">
            <td class="text-dark pb-0" colspan="3"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              <br><br><br>
            </td>
          </tr>
          <tr class="pb-0">
            <td class="text-dark pb-0" colspan="3"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              <span>----------------------------------</span><span
                class="ml-5">----------------------------------</span><br>
              <span class="ml-4">Tandatangan Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <span
                class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Penjual </span>
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