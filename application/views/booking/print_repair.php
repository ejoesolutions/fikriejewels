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
          <h5 class="text-secondary">Maklumat Pembeli</h5>
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
        <!-- Resit / Invois button and modal -->
        <div class="col-md-2 text-left pr-5">
          <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#varyModal"
            data-whatever="@mdo">Surat Tempahan Baiki</button>
          <p class="mb-4">
            <br>No : <?= $book['repair_id'] ?>
            <br>Tarikh : <?= date("d-m-Y", strtotime($book['tarikh'])); ?>
            <br>Jurujual : <?= $book['staf_name'] ?>
            <br>
          </p>
        </div>
        <!-- Resit / Invois button and modal -->
      </div> <!-- /.row -->
      <!-- ./Maklumat Pelanggan -->
    </div> <!-- /.row -->
    <table class="table table-bordered">
      <thead>
        <tr class="text-center">
          <th width="15%">Produk</th>
          <th width="12%">Maklumat Produk</th>
          <th width="12%">Maklumat Penambahan</th>
          <th width="10%">Keterangan</th>
          <!-- <th width="10%">Anggaran Harga <br> Semasa ( RM )</th> -->
          <th width="13%">Anggaran Harga <br> Upah ( RM )</th>
          <th width="10%">Deposit ( RM )</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center">
            <p class="mb-0"><?= $book['product_name'] ?></p>
            <small class="mb-0">[ <?= $book['v_sn'] ?> ]</small>
          </td>
          <td>
            <div class="row justify-content-center">
              <div>
                <small>
                  B :
                  <?php
                    if($book['v_weight']!=0)
                    {
                      echo $book['v_weight'].' g';
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
                <br>
                <small>
                  P :
                  <?php
                    if($book['v_length']!=0)
                    {
                      echo $book['v_length'].' cm';
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
                <br>
                <small>
                  L :
                  <?php
                    if($book['v_width']!=0)
                    {
                      echo $book['v_width'].' cm';
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
              </div>

              <div class="ml-3">
                <small>
                  Sz :
                  <?php
                    if($book['v_size']!=0)
                    {
                      echo $book['v_size'];
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
                <br>
                <small>
                  Sb :
                  <?php
                    if($book['v_sb']!='')
                    {
                      echo $book['v_sb'];
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
                <br>
                <small>
                  M :
                  <?php
                    if($book['mutu']!='')
                    {
                      echo $book['mutu'];
                    }else{
                      echo '-';
                    }
                  ?>
                </small>
              </div>
            </div>
          </td>
          <td>
            <div class="row justify-content-center">
              <div>
                <small>
                B :    
                <?php
                  if($book['add_berat']!=0)
                  {
                    echo $book['add_berat'].' g';
                  }else{
                    echo '-';
                  }
                ?>  
                </small>
                <br>
                <small>
                P :    
                <?php
                  if($book['add_panjang']!=0)
                  {
                    echo $book['add_panjang'].' cm';
                  }else{
                    echo '-';
                  }
                ?>  
                </small>
              </div>

              <div class="ml-3">
                <small>
                Sz :    
                <?php
                  if($book['add_saiz']!=0)
                  {
                    echo $book['add_saiz'];
                  }else{
                    echo '-';
                  }
                ?>  
                </small>
                <br>
                <small>
                L :    
                <?php
                  if($book['add_lebar']!=0)
                  {
                    echo $book['add_lebar'].' cm';
                  }else{
                    echo '-';
                  }
                ?>  
                </small>
              </div>
            </div>
          </td>
          <td class="w-25 text-center">
            <p class="mb-0"><?= $book['description'] ?></p>
          </td>
          <!-- <td class="text-center">
            <?= $book['v_emas'] ?>
            <br>
            <small><?= $book['setup_price'] ?> / g</small>
          </td> -->
          <td class="text-center">
            <?= $book['v_margin_pay'] ?>
          </td>
          <td class="text-center">
            <?= $book['harga'] ?>
          </td>
        </tr>

        <tr>
          <td colspan="4" class="text-dark test"
            style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;border-bottom-color: #ffffff !important; ">
            <?php if ($syarat_baiki) {

            $i = 1 ;

            foreach ($syarat_baiki as $key ) { ?>
            <small><?= $i++ ?> . <?= $key['text'] ?></small><br>
            <?php }
          } ?>
          </td>
          <td style="border-left-color: #ffffff !important;border-right-color: #ffffff !important; ">
            <label class="float-right mb-1">Harga ( RM ) :</label>
            <!-- <label class="float-right mt-4">Bayaran Baki ( RM ) :</label> -->
          </td>
          <td colspan="1" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;">
            <input type="text" class="form-control text-center mb-1" value="<?= $book['bayaran'] ?>" readonly>
          </td>
        </tr>
        <tr>
          <td colspan="4" class="text-dark test" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;border-bottom-color: #ffffff !important; "></td>
          <td
            style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important; ">
            <label class="float-right">Baki ( RM ) :</label>
          </td>
          <td colspan="1"
            style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important; ">
            <?php if ($book['bayaran'] && $book['v_status'] != 1) { ?>
              <input type="text" class="form-control text-center mb-3" value="<?= number_format($book['bayaran'] - $book['harga'], 2, '.', ' '); ?>" readonly>
            <?php }else if ($book['v_status']==1) { ?>
              <input type="text" class="form-control text-center mb-3" value="0.00" readonly>
            <?php }else { ?>
              <input type="text" class="form-control text-center mb-3" readonly>
            <?php } ?>
          </td>
        </tr>

        <tr class="pb-0">
          <td class="text-dark pb-0" colspan="3"
            style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            <span>----------------------------------</span><span
              class="ml-5">----------------------------------</span><br>
            <span class="ml-4">Tandatangan Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
            <span class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Penjual </span>
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