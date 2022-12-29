<?php echo $this->session->flashdata('upload'); ?>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-md-2 text-center pr-0">
        <img src="<?php echo base_url('images/'); ?>mygold-BLACK.png" class="navbar-brand-img mb-4"
          style="max-width: 55%;">
      </div>
      <div class="col-md-3">
        <p class="mb-2 h5">MYGOLD JEWELLERY <small>( KT041196-U )</small></p>
        <p class="mb-4">
          349D JALAN TEMENGGONG,
          <br> 15000 KOTA BHARU, KELANTAN
          <br> Phone : 09-7406545 <span class="ml-2">H/P : 01155092962</span>
          <br>
        </p>
      </div>
      <!-- Maklumat Pembeli -->
      <div class="col-md-5 text-dark">
        <h5 class="text-secondary">Maklumat Pembeli</h5>
          <div class="row ml-0">
            <div class="mr-2">
              Nama : <br> 
              Telefon : <br> 
              Alamat : <br> 
              &nbsp;  <br>
              No K/p : <br> 
            </div>
            <div>
              <?php if ($orders['full_name']) {
                echo $orders['full_name']; 
              }else {
                echo '-'; 
              } ?>
              <br> 
              <?php if ($orders['phone']) {
                echo $orders['phone']; 
              }else {
                echo '-'; 
              } ?>
              <br>
              <?php if ($orders['address']) {
                echo $orders['address']; 
              }else {
                echo '-'; 
              } ?>
              <br>
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
              <br>
              <?php if ($orders['nic_no']) {
                echo $orders['nic_no']; 
              }else {
                echo '-'; 
              } ?>
            </div>
          </div>
      </div>
      <!-- ./Maklumat Pembeli -->
      <!-- Resit / Invois button and modal -->
      <div class="col-md-2 text-left pr-5">
        <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#varyModal"
          data-whatever="@mdo">Resit / Invois</button>
        <div class="modal fade" id="varyModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="varyModalLabel">Resit / Invois</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?php echo form_open('orders/add_resit/'.$orders['order_id']); ?>

              <div class="modal-body">
              <small>* Rekod bayaran untuk Resit / Invois ini dalam bentuk tunai,bank in,atau debit / credit card</small><br><br>
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
                    <input class="form-control" id="message-text" name="jumlah_bayaran" value="<?= $orders['balance_total'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="custom-select">Cara Bayaran</label>
                    <select class="form-control" name="cara_bayaran">
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

                  <?php foreach ($items as $item){  ?>
                    <input type="hidden" value="<?= $item['variant_id'] ?>" name="v_id[]">
                  <?php } ?>

              </div>
              <div class="modal-footer">
                <button type="submit" class="btn mb-2 btn-primary">Simpan</button>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
        <p class="mb-4">
          <br>No : #<?= $orders['order_no'] ?>
          <br>Tarikh : <?= date("d-m-Y", strtotime($orders['created_date'])); ?>
          <br>Jurujual : <?= $orders['seller'] ?>
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
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="text-center" width="33%">Info Produk</th>
          <th class="text-center" width="15%">Berat</th>
          <th class="text-center" width="15%">Upah ( RM )</th>
          <th class="text-center" width="20%">Harga Semasa ( RM )</th>
          <!-- <th class="text-center" width="15%">Harga ( RM )</th> -->
          <th class="text-center" width="18%">Jumlah ( RM )</th>
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
          <!-- <?= $item['v_weight'] ?> g -->
            <?= $item['ordered_weight'] ?> g
            <br>
            <?= $item['v_sb'] ?> ya
          </td>
          <td class="text-center"><?= $item['ordered_margin_pay'] ?></td>
          <td class="text-center">
          <?= $item['setup_price'] ?> / g
            <br>
            <?= $item['sb_price'] ?> / ya
          </td>
          <!-- <td class="text-center">
            <?= $item['ordered_price'] ?>
            <br>
            ( Dis : <?= $item['ordered_dis'] ?>% )
          </td> -->
          <td class="text-center"><?= $item['subtotal'] ?></td>
        </tr>
      <?php } ?>

        <tr>
          <td colspan="3" class="text-dark test" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important; ">
            <small>1. Pelanggan mengesahkan barangan dibeli ini diterima dalam keadaan dan kualiti yang baik</small>
            <br>
            <span class="ml-3" style="font-size: 90%;">The customer acknowledge that the item purchased here is received in good and acceptable quality</span>
            <br>
            <small>2. Barangan yang dijual tidak boleh dikembalikan untuk tunai</small>
            <br>
            <span class="ml-3" style="font-size: 90%;">Any item sold cannot be returned for cash</span><br>
            <span class="ml-3" style="font-size: 90%;"><i>*Nota : Ikat Harga</i></span>
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
            <?php if ($orders['total_all'] > 0) {
              echo $orders['total_all'];
            }else {
              echo "0.00";
            } ?>
          </td>
        </tr>
        <?php
        if ($resit) {
          foreach ($resit as $test){ ?>
            <tr class="pb-0">
              <td colspan="2" class="text-dark pb-1"
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
                } ?> 
                : <?= date("d-m-Y", strtotime($test['tarikh_bayaran'])); ?>
                <br>
              </td>
              <td class="text-center pb-1" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;"><?= $test['jumlah'] ?></td>
            </tr>
          <?php }  } ?>
        

        <tr class="pb-0">
          <td class="text-dark pb-0" colspan="3" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            <span>----------------------------------</span><span class="ml-5">----------------------------------</span><br>
            <span class="ml-4">Tandatangan Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   </span>
            <span class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Penjual </span>
          </td>
            <!-- <td class="text-dark pb-0" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;"> -->
            <!-- <span>----------------------------------</span><br>
            <span class="ml-4">Tandatangan Penjual </span> -->
          <!-- </td> -->
          <!-- <td colspan="2" class="text-dark pb-0"
            style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
          </td>   -->
          <td class="text-right pb-0"
            style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            Baki Bayaran
          </td>
          <td class="text-center pb-0" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            <input type="text" class="form-control text-center" value="<?= $orders['balance_total'] ?>" readonly>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<a href="<?= base_url('orders/print_order/'.$orders['order_id']) ?>" target="_blank" class="btn btn-info float-right text-light"><span class="fe fe-printer fe-16"></span> CETAK </a>
<!-- <a href="javascript: w=window.open('http://yoursite.com/LinkToThePDF.pdf'); w.print(); w.close(); ">​​​​​​​​​​​​​​​​​print pdf</a> -->

