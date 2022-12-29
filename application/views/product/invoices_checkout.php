<?php echo $this->session->flashdata('upload'); ?>

<?php if ($this->uri->segment(3)) { ?>
  <input type="hidden" id="reg_id" value="<?= $this->uri->segment(3) ?>">
<?php } ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10">
      <?= form_open('orders/store_order', array('id'=>'addOrder')); ?>
      <div class="card shadow" id="section-to-print">
        <div class="card-body p-5">
          <div class="row mb-5">
            <div class="col-12 text-center mb-4">
              <h2 class="mb-0 text-uppercase">Invois</h2>
            </div>
            <div class="col-md-7">
              <p class="small text-dark text-uppercase mb-2">Invois Daripada</p>
              <div class="form-group">
                <select class="form-control" id="cawangan" name="cawangan" required>
                  <!-- <option value="">--Pilih--</option> -->
                  <?php foreach ($cawangan as $key) {
                    echo '<option value="'.$key['id'].'" selected>'.$key['name'].'</option>';
                  } ?>
                </select>
              </div>
            </div>
            <div class="col-md-5">
              <p class="small text-dark text-uppercase mb-2">Invois Kepada</p>
                <div class="form-group">
                  <select class="form-control select2" name="cust_id" id="select_cust" required>
                    <option value="">--Pilih--</option>
                    <?php

                    if(!empty($cust))
                    {
                      foreach ($cust as $key) { ?>
                        <option value="<?php echo $key['id'] ?>"
                        
                          data-full_name="<?php echo $key['name'] ?>"
                          data-nic_no="<?php echo $key['kp'] ?>"
                          data-phone="<?php echo $key['phone'] ?>"
                          data-address="<?php echo $key['address'] ?>"
                          data-state="<?php echo $key['state'] ?>"

                        ><?= $key['name'] ?></option>
                      <?php } ?>

                    <?php }  ?>
                  </select>
                </div>
              <button type="button" class="btn mb-2 btn-primary" id="btn_register" data-toggle="modal" data-target="#modal_updVariant" style="display:block"> Pelanggan Baru </button>
              <p class="mb-4">
                <strong id="cust_nic_no"></strong>
                <strong id="cust_nic_no"></strong>
                <strong id="cust_address"></strong>
                <strong id="cust_postcode"></strong>
                <strong id="cust_town_area"></strong>
                <strong id="cust_state"></strong>
                <strong id="cust_phone"></strong>
              </p>
              <p>
                <small class="small text-muted text-uppercase">Tarikh</small><br />
                <strong><?= date("j F Y"); ?></strong>
              </p>
            </div>
          </div>

          <br>
          <div class="table-responsive">
          <table class="table table-bordered">

          <tr>
            <th nowrap class="text-center">Nama Produk</th>
            <th nowrap class="text-center" width="18%">Maklumat</th>
            <th nowrap class="text-center" width="15%">Nota</th>
            <th nowrap class="text-center" width="20%">Harga Kaunter ( RM )</th>
            <th nowrap class="text-center" width="16%">Harga ( RM )</th>
          </tr>

          <?php $i = 1; ?>

          <?php foreach ($this->cart->contents() as $items): ?>

          <?= form_hidden($i.'[rowid]', $items['rowid']); ?>

          <tr>
            <td class="text-center">
              <?= $items['name']; ?>
              <br>
              <small>[ <?= $items['sn']; ?> ]</small>

              <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

              <p>
                <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                  <strong><?= $option_name; ?>:</strong> <?= $option_value; ?><br />
                <?php endforeach; ?>
              </p>

              <?php endif; ?>
            </td>
            <td>   
              <div class="row justify-content-center">
                <div>
                  <small>
                  B :    
                  <?php
                    if($this->cart->format_number($items['weight']))
                    {
                      echo $this->cart->format_number($items['weight']).' g';
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  P :    
                  <?php
                    if($this->cart->format_number($items['length']))
                    {
                      echo $this->cart->format_number($items['length']).' cm';
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  L :    
                  <?php
                    if($this->cart->format_number($items['width']))
                    {
                      echo $this->cart->format_number($items['width']).' cm';
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  Sz :     
                  <?php
                    if($items['size'])
                    {
                      echo $items['size'];
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                </div>

                <div class="ml-3">
                  <!-- <small>
                  Sb :    
                  <?php
                    if($this->cart->format_number3($items['sb']))
                    {
                      echo $this->cart->format_number3($items['sb']);
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br> -->
                  <small>
                  Up :    
                  <?php
                    if($this->cart->format_number($items['margin_pay']))
                    {
                      echo $this->cart->format_number($items['margin_pay']);
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  M :    
                  <?php
                    if($items['mutu'])
                    {
                      echo $items['mutu'];
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                </div>
              </div>
            </td>
            <td class="text-center"><small><?= $items['nota'] ?></small></td>
            <td class="text-center">
            <?php echo $this->cart->format_number($items['price']); ?>
            <!-- <?php if ($items['deposit'] != "0") {
              echo "<br><small>[ Deposit : - RM".$items['deposit']." ]</small>"; 
            } ?> -->
            <?php if ($items['diskaun'] != "0") {
              echo "<br><small>[ Diskaun : - RM".$items['diskaun']." ]</small>"; 
            } ?>
            </td>
            <td class="text-center"><?php echo $this->cart->format_number($items['subtotal']); ?></td>
          </tr>

          <?php 
          echo form_hidden('item_id[]', $items['id']);
          echo form_hidden('item_name[]', $items['name']);
          echo form_hidden('item_product_id[]', $items['product_id']);
          echo form_hidden('item_dis[]', $items['diskaun']);
          echo form_hidden('item_depo[]', $items['deposit']);
          echo form_hidden('item_setup_price[]', $items['setup_price']);
          echo form_hidden('item_weight[]', $items['weight']);
          echo form_hidden('item_weight_asal[]', $items['weight_asal']);
          echo form_hidden('item_margin_pay[]', $items['margin_pay']);
          echo form_hidden('item_price[]', $items['price']);
          echo form_hidden('item_subtotal[]', $items['subtotal']);
          echo form_hidden('item_sb_price[]', $items['sb_price']);
          echo form_hidden('item_nota[]', $items['nota']);
          ?>

          <?php $i++; ?>

          <?php endforeach; ?>

          <tr style="display:none;" id="calc1">
            <td colspan="3"></td>
            <td class="text-center"><strong>Tax ( % )</strong></td>
            <td class="text-center"><input type="text" name="tax" id="tax" class="form-control text-center" value="0"></td>
            <input type="hidden" name="tax_rm" id="tax_rm">
          </tr>
          <tr style="display:none;" id="calc2">
            <td colspan="3"><input type="text" name="tracking_num" class="form-control text-center" placeholder="Masukkan No Tracking Jika Ada"></td>
            <td class="text-center"><strong>Postage ( RM )</strong></td>
            <td class="text-center"><input type="text" name="postage" id="postage" class="form-control text-center" value="0"></td>
          </tr>
          <tr style="display:none;" id="calc3">
            <td colspan="3"></td>
            <td class="text-center"><strong>Adjustment ( RM )</strong></td>
            <td class="text-center"><input type="text" name="adjustment" id="adjustment" class="form-control text-center" value="0"></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td class="text-center"><strong>Jumlah ( RM )</strong></td>
            <td class="text-center">
              <!-- <input type="text" class="form-control text-center" readonly name="upd_total_all" id="upd_total_all" value="<?php echo $this->cart->format_number($this->cart->total()); ?>"> -->
              <input type="text" class="form-control text-center" readonly name="upd_total_all" id="upd_total_all" value="<?php echo $this->cart->total(); ?>">
            </td>
          </tr>
          <input type="hidden" name="total_all" id="total_all" value="<?php echo $this->cart->total(); ?>">
          </table>
          </div>
          <div class="float-left">
            <a href="<?= base_url('catalog/create_order') ?>" class="btn mb-3 btn-outline-dark"> <span class="fe fe-arrow-left fe-8"></span> Kembali</a><br>
            <!-- <small class="text-info">*Nota : Sila pastikan No siri produk yang dimasukkan adalah betul mengikut tag & maklumat pelanggan adalah tepat</small> -->
          </div>
          <div class="float-left">
            <div class="form-check form-check-inline">
            <!-- <?php foreach ($maklumat as $key) { ?>
              <input class="form-check-input" type="checkbox" name="vip" id="vipradio" value="1" <?php if ($key['vip']==1) {echo "checked"; } ?>>
              <label class="form-check-label" for="inlineRadio1">VIP</label>
            <?php } ?> -->
              <input type="hidden" name="dn" value="<?= $count_dn['dn_last']+1 ?>">
            </div>
          </div>
          <div class="float-right">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="kategori" id="inlineRadio1" value="1" <?php if ($maklumat['pesanan']==1) {echo "checked"; } ?>>
              <label class="form-check-label" for="inlineRadio1">Ikat Harga</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="kategori" id="inlineRadio2" value="2" <?php if ($maklumat['pesanan']==2) {echo "checked"; } ?>>
              <label class="form-check-label" for="inlineRadio2">Harga Semasa</label>
            </div>
            <input type="submit" id="create_order" class="btn btn-info text-light float-right" value="Cipta Pesanan">
          </div>

        </div>
      </div>
   
      <?= form_close(); ?>
      
    </div>
  </div>
</div>


<!-- modal register pelanggan baru -->
<div class="modal fade bd-example-modal-lg" id="modal_updVariant" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Daftar Pelanggan Baru </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
      
        <?= form_open('user/register_cust_checkout',array('class'=>'form-horizontal','id'=>'regCustCheck')) ?>

        <?php $this->load->view('customer/register_form'); ?>

        <?= form_close() ?>

    </div>
  </div>
</div>



<script>

  $(document).ready(function(){

    <?php if ($this->uri->segment(3)) { ?>
      
      var id = $('#reg_id').val() ;

      $('#select_cust').val(id).trigger("change");

      document.getElementById("calc1").style.display="";
      document.getElementById("calc2").style.display="";
      document.getElementById("calc3").style.display="";

    <?php } ?>

    //add a new row after find sn number 
    $("#select_cust").change(function(){

      var full_name = $(this).find(':selected').data('full_name');
      var phone = $(this).find(':selected').data('phone');
      var address = $(this).find(':selected').data('address');
      var state = $(this).find(':selected').data('state');

      $('#cust_full_name').html(full_name + '<br>');
      $('#cust_phone').html(phone + '<br>');
      if (address) {
        $('#cust_address').html(address + ',');
        $('#cust_state').html(state + '<br>');  
      }else{
        $('#cust_address').html('');
        $('#cust_postcode').html('');
        $('#cust_town_area').html('');
        $('#cust_state').html(''); 
      }
      
      document.getElementById("btn_register").style.display="none";
      document.getElementById("calc1").style.display="";
      document.getElementById("calc2").style.display="";
      document.getElementById("calc3").style.display="";

    });
  }); 

  $("#tax,#adjustment,#postage").keyup(function(){

    var total_all       = $('#total_all').val() ;
    var tax             = $('#tax').val() ;
    var adjustment      = $('#adjustment').val();
    var postage         = $('#postage').val();

    jumlah = parseFloat(total_all) + ((tax/100) * total_all) + parseFloat(postage) - parseFloat(adjustment); 
    tax_rm = (tax/100) * parseFloat(total_all);

    // -------------------------------------------------------------------

    document.getElementById("upd_total_all").value=jumlah.toFixed(2);
    document.getElementById("tax_rm").value=tax_rm.toFixed(2);

  });    

  $('#addOrder').one('submit', function() {
    document.getElementById("create_order").disabled = true;
  });

  $('#regCustCheck').one('submit', function() {
    document.getElementById("btnRegCustCheck").disabled = true;
  });

</script>