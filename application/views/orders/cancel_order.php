<?php echo $this->session->flashdata('upload'); ?>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-md-2 text-center pr-0">
        <img src="<?php echo base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img mb-4" style="max-width: 55%;">
      </div>
      <?php foreach ($maklumat as $key) { ?>
        <div class="col-md-3">
          <p class="h5 mb-0"><?= $key['nama'] ?></p>
          <?php if ($key['n_tambahan']) { ?>
            <p class="mb-1 h6"><?= $key['n_tambahan'] ?></p>
          <?php } ?>
          <small>(<?= $key['pendaftaran'] ?>)</small>
          <p class="mb-4">
            <?= $key['alamat'] ?>,
            <br> <?= $key['poskod'] ?> <?= $key['bandar'] ?>, <?= $key['state'] ?>
            <br> Telefon : <?= $key['telefon'] ?>
            <br> H/P : <?= $key['hp'] ?>
            <?php if ($key['hp2']) { ?>
              , <?= $key['hp2'] ?>
            <?php } ?>
          </p>
        </div>
      <?php } ?>
      <!-- Maklumat Pembeli -->
      <div class="col-md-5 text-dark">
        <h5 class="text-secondary">Maklumat Pembeli</h5>
          <div class="row ml-0">
            <div class="mr-2">
              Nama :   
              <?php if ($orders['full_name']) {
                echo $orders['full_name']; 
              }else {
                echo '-'; 
              } ?><br> 
              Telefon :
              <?php if ($orders['phone']) {
                echo $orders['phone']; 
              }else {
                echo '-'; 
              } ?><br>
              Alamat : 
              <?php if ($orders['address']) {
                echo $orders['address']; 
              }else {
                echo '-'; 
              } ?>
              <?php if ($orders['address']) { ?>
                <br>
                <span>
                <?php if ($orders['postcode']) {
                  echo $orders['postcode']; 
                }else {
                  echo '-'; 
                }
                if ($orders['town_area']) {
                  echo ', '.$orders['town_area']; 
                }else {
                  echo ', -'; 
                } 
                if ($orders['state']) {
                  echo ', '.$orders['state']; 
                }else {
                  echo ', -'; 
                } 
                ?>
                </span>
              <?php } ?>
              <?php if (!$orders['address']) { ?>
                <br>
              <?php } ?>
              <?php if ($orders['address']) { ?>
                &nbsp;  <br>
              <?php } ?>
              No K/p : 
              <?php if ($orders['nic_no']) {
                echo $orders['nic_no']; 
              }else {
                echo '-'; 
              } ?><br> 
            </div>
          </div>
      </div>
      <!-- ./Maklumat Pembeli -->
      <!-- Resit / Invois button and modal -->
      <div class="col-md-2 text-left pr-5">
        <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#varyModal" data-whatever="@mdo">Batal Jualan</button>
        <p class="mb-4">

          <?php if ($orders['vip'] == 1) { ?>
            <br>No : #<?= $orders['dn_no'] ?>A
          <?php }else { ?>
            <br>No : #<?= $orders['order_no'] ?>
          <?php } ?>

          <br>Tarikh : <?= date("d-m-Y", strtotime($orders['created_date'])); ?>
          <br>Jurujual : <?= $orders['staff'] ?>
          <br>No.Tracking :
          <?php if ($orders['tracking_num']) {
            echo $orders['tracking_num'];
          }else {
            echo "-";
          }?>
          <br>
        </p>
      </div>
      <!-- Resit / Invois button and modal -->
    </div> <!-- /.row -->
    <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th nowrap class="text-center" width="33%">Info Produk</th>
          <th nowrap class="text-center" width="16%">Nota</th>
          <th nowrap class="text-center" width="10%">Berat</th>
          <th nowrap class="text-center" width="12%">Upah ( RM )</th>
          <th nowrap class="text-center" width="17%">Harga Semasa ( RM )</th>
          <th nowrap class="text-center" width="18%">Jumlah ( RM )</th>
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
               <small>[ <?= $item['v_sn'] ?> ]</small> 
              </div>
              <div class="ml-3">
                MUTU : <?= $item['mutu'] ?>
              </div>
            </div>
          </td>
          <td class="text-center">
            <small><?= $item['nota'] ?></small>
          </td>
          <td class="text-center">
            <?= $item['ordered_weight'] ?> g
            <br>
            <?= $item['v_sb'] ?> sb
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

          <td class="text-center">
            <?php if ($orders['kategori'] == 1 || $orders['sold'] == 1) { 
              echo $item['ordered_price'];

              if ($item['diskaun'] > 0 ) {
                echo "<br><small>Diskaun : - RM".$item['diskaun']."</small>";
              }
            }elseif ($orders['kategori'] == 2) {
              $gold_price = number_format($item['per_gram_semasa'] * $item['ordered_weight'], 2, '.', '');

              echo $subtotal = number_format($gold_price + $item['ordered_margin_pay'], 2, '.', '');
              if ($item['diskaun'] > 0 ) {
                echo "<br><small>Diskaun : - RM".$item['diskaun']."</small>";
              }
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
          <td class="text-right">
            Tax ( <?= $orders['total_tax'] ?>% ) <br>
            Postage ( RM ) <br>
            Adjustment ( RM ) <br>
            Jumlah ( RM ) <br>
          </td>
          <td class="text-center">
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
          foreach ($resit as $resits){ ?>
            <tr class="pb-0">
              <td colspan="3" class="text-dark pb-1"
                style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              </td>
              <td class="text-dark pb-1 text-right" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              <small class="text-secondary"><?= $resits['nota'] ?></small> 
              </td>
              <td class="text-right pb-1" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;">
                <?php if ($resits['cara_bayaran'] == 1) {
                  echo "Tunai";
                }elseif ($resits['cara_bayaran'] == 2) {
                  echo "Bank In";
                }elseif ($resits['cara_bayaran'] == 3) {
                  echo "Debit/CC";
                }elseif ($resits['cara_bayaran'] == 4) {
                  echo "Deposit";
                } ?> 

                <?php if ($resits['cara_bayaran'] != 4) { ?>
                  : <?= date("d-m-Y", strtotime($resits['tarikh_bayaran'])); ?>
                <?php } ?>
                <br>
              </td>
              <td class="text-center pb-1" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;"><?= $resits['jumlah'] ?></td>
            </tr>
          <?php }  } ?>

        <tr class="pb-0">
          <td class="text-dark pb-0" colspan="4" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            <span>----------------------------------</span><span class="ml-5">----------------------------------</span><br>
            <span class="ml-4">Tandatangan Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <span class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Penjual </span>
          </td>
          <td class="text-right pb-0"
            style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            Baki Bayaran
          </td>
          <td class="text-center pb-0" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
          <?php if ($orders['kategori'] == 1 || $orders['sold'] == 1) { ?>
            <input type="text" class="form-control text-center" value="<?= $orders['balance_total'] ?>" readonly>
          <?php }elseif ($orders['kategori'] == 2) { ?>
            <input type="text" class="form-control text-center" value="<?=  number_format($total_all_semasa - $orders['paid_total'], 2, '.', '') ?>" readonly>
          <?php } ?>
          </td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</div>

<a href="<?= base_url('orders/print_order/'.$orders['order_id']) ?>" target="_blank" class="btn btn-info float-right text-light"><span class="fe fe-printer fe-16"></span> CETAK </a>

<!-- Resit / Invoice modal  -->
<div class="modal fade" id="varyModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="varyModalLabel">Resit / Invois</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open('orders/refund_item/'.$orders['order_id']); ?>

      <div class="modal-body">
      <table class="table table-striped table-hover">
          <thead>
            <tr class="text-center">
              <th></th>
              <th>Produk</th>
              <th>Harga Jual ( RM )</th>
              <th width="20%">Bayar Balik ( RM )</th>
              <th>Nota</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $i = 0;
              foreach ($items as $item){  ?>
            <tr class="text-center">
              <td>
                <input type="checkbox" name="check[]">
              </td>
              <td>
                <?= $item['product_name'] ?>
                <br>
                <small>[ <?= $item['v_sn'] ?> ]</small>
              </td>
              <td>
              <?php 
                echo $item['ordered_price'];

                if ($item['diskaun'] > 0 ) {
                  echo "<br><small>Diskaun : - RM".$item['diskaun']."</small>";
                }
              ?>
              </td>
              <td>
                <input type="text" class="form-control" name="bayar_balik[]">
              </td>
              <td>
                <input type="text" class="form-control" name="nota[]">
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        
        <?php foreach ($items as $item){  ?>
          <input type="hidden" value="<?= $item['variant_id'] ?>" name="v_id[]">
        <?php } ?>
      </div>
      <div class="modal-footer">
      <input type="hidden" name="kategori" value="<?= $orders['kategori'] ?>">
        <input type="submit" onclick="this.disabled=true;this.value='Sila Tunggu';this.form.submit();" class="btn mb-2 btn-primary" value="Simpan">
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- ./Resit / Invoice modal  -->

<!-- <script type="text/javaScript">
    // $(function() {
    //     $('input[type="checkbox"]').on('change', function() {
    //         $(this).closest('fieldset').find('.show').toggle(!this.checked);
    //     });
    // });

$(document).ready(function() {
  $(":checkbox").click(function(event) {
    if ($(this).is(":checked"))
      // $(".show").show();
      document.getElementById("bb").style.display="inline-block";
    else
    document.getElementById("bb").style.display="none";

  });
});
</script> -->