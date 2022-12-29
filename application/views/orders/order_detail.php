<style>
  .modal-body {
    overflow : auto !important;
  }
</style>

<?= $this->session->flashdata('upload'); ?>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-md-2 text-center pr-0">
        <img src="<?= base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img mb-4" style="max-width: 55%;">
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
          <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#refundModal" data-whatever="@mdo">Batal Jualan</button>
        <?php }elseif ($orders['sold'] == 1 && $user_profile['user_group'] == 2) { ?>
          <button type="button" class="btn btn-secondary btn-lg" disabled>Batal Jualan</button>
        <?php }elseif ($orders['sold'] == 2) { ?>
          <button type="button" class="btn btn-secondary btn-lg" disabled>Batal Jualan</button>
        <?php }else { ?>
          <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#varyModal" data-whatever="@mdo">Resit / Invois</button>
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
    <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th nowrap class="text-center" width="33%">Info Produk</th>
          <th nowrap class="text-center" width="16%">Nota</th>
          <th nowrap class="text-center" width="15%">Maklumat</th>
          <th nowrap class="text-center" width="9%">Upah ( RM )</th>
          <th nowrap class="text-center" width="17%">Harga Semasa ( RM )</th>
          <th nowrap class="text-center" width="18%">Jumlah ( RM )</th>
        </tr>
      </thead>
      <tbody>

      <?php

      foreach ($items as $item){  ?>
        
        <?php if ($item['order_category'] == 99) { 
          echo '<tr style="background-color:#FADBD8">';
        }else {
          echo '<tr>';
        } ?>
          <td>
            <div class="row justify-content-center text-center">
              <div class="">
                <?= $item['product_name'] ?>
                <br>
               <small>[ <?= $item['v_sn'] ?> ]</small>
               <br>
               <small>KJ : <?= $item['v_kod'] ? $item['v_kod'] : '-' ?></small>
              </div>
            </div>
          </td>
          <td class="text-center">
            <small><?= $item['nota'] ?></small>
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
            <!-- <?= $item['sb_price'] ?> / sb -->
          </td>
          <?php }elseif ($orders['kategori'] == 2) { ?>
          <td class="text-center">
            <?= $item['per_gram_semasa'] ?> / g
            <!-- <br>
            <?= $item['sb_price_semasa'] ?> / sb -->
          </td>
          <?php } ?>

          <td class="text-center">
          <?php if ($item['order_category'] == 99) { echo "<del>";} ?>

            <?php if ($orders['kategori'] == 1 || $orders['sold'] == 1) { 
              echo $item['subtotal'];

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

          <?php if ($item['order_category'] == 99) { echo "</del>";} ?>
          
          <!-- harga duit refund balik -->
          <?php if ($item['refund']) {
            echo '<br><small>'.$item['refund'].'</small>';
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

              $total_all_semasa = $orders['total_all'];

            }elseif ($orders['kategori'] == 2) {

              $total_semasa = 0;
              foreach ($items as $item){  
                $total_semasa += number_format(($item['per_gram_semasa'] * $item['ordered_weight']) , 2, '.', '') + number_format($item['ordered_margin_pay'] , 2, '.', '') - number_format($item['diskaun'] , 2, '.', '');   
              }

              $total_all_semasa = number_format($total_semasa + $orders['total_tax_rm'] + $orders['total_shipping'] - $orders['total_adjustment'], 2, '.', '');

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
            <!-- <span>----------------------------------</span><span class="ml-5">----------------------------------</span><br>
            <span class="ml-4">Tandatangan Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <span class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Penjual </span> -->
          </td>
          <td class="text-right pb-0"
            style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            Baki Bayaran
          </td>
          <td class="text-center pb-0" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
          <?php if ($orders['kategori'] == 1 || $orders['sold'] == 1) { ?>
            <input type="text" class="form-control text-center" value="<?= $orders['balance_total'] ?>" readonly>
          <?php }elseif ($orders['kategori'] == 2) { ?>
            <input type="text" class="form-control text-center" value="<?= number_format($total_all_semasa - $orders['paid_total'], 2, '.', '') ?>" readonly>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="varyModalLabel">Resit / Invois</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('orders/add_resit/'.$orders['order_id'].'/'.$orders['cust_id'], array('id'=>'addResit')); ?>

      <div class="modal-body">
        <!-- <small>* Rekod bayaran untuk Resit / Invois ini dalam bentuk tunai,bank in,atau debit / credit card</small><br><br> -->
        <div class="form-group">
          <label for="recipient-name" class="col-form-label">Tarikh Bayaran:</label>
          <div class="input-group">
            <input type="text" class="form-control drgpicker" name="tarikh_bayaran" id="date-input1" aria-describedby="button-addon2">
            <div class="input-group-append">
              <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span></div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Jumlah ( RM ) :</label>
          <?php if ($orders['kategori'] == 1 || $orders['sold'] == 1) { ?>
            <input type="text" class="form-control" name="jumlah_bayaran" value="<?= $orders['balance_total'] ?>" required>
          <?php }elseif ($orders['kategori'] == 2) { ?>
            <input type="text" class="form-control" name="jumlah_bayaran" value="<?= $total_all_semasa - $orders['paid_total'] ?>" required>
          <?php } ?>
        </div>
        <div class="form-group">
          <label for="custom-select">Cara Bayaran</label>
          <select class="form-control" name="cara_bayaran" required>
            <option value="">-Pilih-</option>
            <option value="1">Tunai</option>
            <option value="2">Bank In</option>
            <option value="3">Debit/Credit Card</option>
          </select>
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Nota:</label>
          <textarea class="form-control" maxlength="30" name="nota_bayaran" id="message-text" rows="3" placeholder="Maksimum 30 aksara huruf"></textarea>
        </div>
        <input type="hidden" name="balance_total" value="<?= $orders['balance_total'] ?>">
        <input type="hidden" name="kategori" value="<?= $orders['kategori'] ?>">
        <input type="hidden" name="paid_total" value="<?= $orders['paid_total'] ?>">
        <!-- <input type="hidden" name="vip" value="<?= $orders['vip'] ?>"> -->
        <input type="hidden" name="total_semasa" value="<?= $total_all_semasa ?>">

        <?php foreach ($items as $item){  ?>
          <input type="hidden" value="<?= $item['variant_id'] ?>" name="v_id[]">
          <input type="hidden" value="<?= $item['per_gram_semasa'] ?>" name="per_gram_semasa[]">
          <input type="hidden" value="<?= $item['sb_price_semasa'] ?>" name="sb_price_semasa[]">
          <?php
            $subtotal = number_format($item['per_gram_semasa'] * $item['ordered_weight'], 2, '.', '') + $item['ordered_margin_pay'];
            echo '<input type="hidden" value="'.$subtotal.'" name="subtotal[]">';
          ?>
        <?php } ?>
      </div>
      <div class="modal-footer">
      <input type="hidden" name="kategori" value="<?= $orders['kategori'] ?>">
      <input type="hidden" name="cawangan_id" value="<?= $orders['cawangan_id'] ?>">
      <button type="submit" id="btnAddResit" class="btn mb-2 btn-primary">Simpan</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>
<!-- ./Resit / Invoice modal  -->


<!-- Refund modal  -->
<div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="refundModalLabel">Batal Jualan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('orders/refund_item/'.$orders['order_id'].'/'.$orders['cust_id'], array('id'=>'formReturn')); ?>

      <div class="modal-body">
        <table class="table table-striped table-hover nowrap">
          <thead>
            <tr class="text-center">
              <th>Produk</th>
              <th>Harga Jual ( RM )</th>
              <th width="20%">Bayar Balik ( RM )</th>
              <th>Nota</th>
            </tr>
          </thead>
          <tbody>
            <?php

            if ($items) {

            $i = 0;
            
            foreach ($items as $item){  ?>
              <tr class="text-center">
                <td>
                  <?= $item['product_name'] ?>
                  <br>
                  <small>[ <?= $item['v_sn'] ?> ]</small>
                </td>
                <td>
                <?php 
                  echo $item['subtotal'];

                  if ($item['diskaun'] > 0 ) {
                    echo "<br><small>Diskaun : - RM".$item['diskaun']."</small>";
                  }
                ?>
                <br>
                <span class="text-danger">* Tidak termasuk adjustment</span>
                </td>
                <td>
                  <input type="text" class="form-control text-center price" name="bayar_balik[]">
                </td>
                <td>
                  <input type="text" class="form-control" name="nota[]">
                </td>
              </tr>
            <?php } 
            }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <th class="text-center"></th>
              <th class="text-center">Jumlah : </th>
              <th class="text-center"><input type="text" class="form-control text-center" id="total_refund" readonly><input type="hidden" id="sum_refund"></th>
              <th></th>
            </tr>
            <tr>
              <th class="text-center">Cara Bayaran</th>
              <th class="text-center">Tunai : </th>
              <th class="text-center"><input type="text" name="refund_tunai" class="form-control text-center" id="refund_tunai"></th>
              <th></th>
            </tr>
            <tr>
              <th class="text-center"></th>
              <th class="text-center">Bank In : </th>
              <th class="text-center"><input type="text" name="refund_bank" class="form-control text-center" id="refund_bank"></th>
              <th></th>
            </tr>
            <tr>
              <th class="text-center"></th>
              <th class="text-center">Credit/Debit : </th>
              <th class="text-center"><input type="text" name="refund_credit" class="form-control text-center" id="refund_credit"></th>
              <th></th>
            </tr>
          </tfoot>
        </table>
        
        <?php foreach ($items as $item){  ?>
          <input type="hidden" value="<?= $item['variant_id'] ?>" name="v_id[]">
          <input type="hidden" value="<?= $item['subtotal'] ?>" name="ordered_price[]">
        <?php } ?>
      </div>
      
      <div class="modal-footer">
        <input type="hidden" name="cawangan" value="<?= $orders['cawangan_id'] ?>">
        <input type="hidden" name="kategori" value="<?= $orders['kategori'] ?>">
        <input type="hidden" name="total_all" value="<?= $orders['total_all'] ?>">
        <input type="hidden" name="paid_total" value="<?= $orders['paid_total'] ?>">
        <button type="submit" id="submitReturn" class="btn mb-2 btn-primary" style="display:none">Bayar Balik</button>
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<script>

$(document).on("keyup", ".price", function() {
    var sum = 0;
    $(".price").each(function(){
      sum += +$(this).val();
    });
    document.getElementById("total_refund").value=RoundNum(sum,2);
    document.getElementById("sum_refund").value= RoundNum(sum,2);
});


$("#refund_tunai,#refund_bank,#refund_credit").keyup(function(){

  var refund_tunai = $('#refund_tunai').val();
  var refund_bank  = $('#refund_bank').val();
  var refund_credit = $('#refund_credit').val();
  var total_refund = $('#total_refund').val();
  var sum_refund = $('#sum_refund').val();
  
  total = sum_refund - refund_tunai - refund_bank - refund_credit; 

  document.getElementById("total_refund").value=RoundNum(total,2);

  if(total < 0.01 ){
    document.getElementById("submitReturn").style.display="inline-block";
  }
});

  //user xleh tekan enter 
  $(document).ready(function() {
    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });
  });

  //user xleh tekan tab
  $(document).ready(function() {
    $(window).keydown(function(event){
      if(event.keyCode == 9) {
        event.preventDefault();
        return false;
      }
    });
  });

  $('#addResit').one('submit', function() {
    $('#btnAddResit').attr('disabled','disabled');
    $("#btnAddResit").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

  $('#formReturn').one('submit', function() {
    $('#submitReturn').attr('disabled','disabled');
    $("#submitReturn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });
</script>