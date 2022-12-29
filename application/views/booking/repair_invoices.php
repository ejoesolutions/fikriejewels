<?= $this->session->flashdata('upload'); ?>

<!-- form for new user id -->
<?php if ($this->uri->segment(4)) { ?>
  <input type="hidden" id="reg_id" value="<?= $this->uri->segment(4) ?>">
<?php } ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10">
      <?= form_open('booking/add_repair', array('id'=>'addRepair')); ?>

      <div class="card shadow" id="section-to-print">
        <div class="card-body p-5">
          <div class="row mb-5">
            <div class="col-12 text-center mb-4">
              <h3 class="mb-0 text-uppercase">Resit Tempahan Baiki</h3>
            </div>
            <div class="col-md-6">
              <p class="small text-dark text-uppercase mb-2">Cawangan</p>
              <div class="form-group">
                <select class="form-control" id="getCawangan" disabled>
                  <option value="">--Pilih--</option>
                  <?php foreach ($cawangan as $key) {
                    echo '<option value="'.$key['id'].'">'.$key['name'].'</option>';
                  } ?>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <p class="small text-muted text-uppercase mb-2">Resit Kepada</p>
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
              <label for="">Bayaran Deposit ( RM )</label>
              <input type="text" class="form-control" name="deposit" required>
            </div>
          </div>

          <br>
          
          <table class="table datatables" id="example">
              <thead>
                <tr class="text-center">
                  <th width="15%">Produk</th>
                  <th width="15%">Maklumat Produk Asal</th>
                  <th width="10%">Maklumat Penambahan</th>
                  <th width="5%">Keterangan</th>
                  <th width="10%">Anggaran Harga <br> Semasa ( RM )</th>
                  <th width="10%">Anggaran Harga <br> Dasar ( RM )</th>
                  <th width="10%">Anggaran Harga <br> Kaunter ( RM )</th>
                </tr>
              </thead>
            <tbody>

            <?php 
            
            if ($variants) { ?>
              <input type="hidden" name="cawangan" id="cawangan" value="<?= $variants['cawangan_id'] ?>">
              <tr>
                <td class="text-center">
                  <p class="mb-0"><?= $variants['product_name'] ?></p>
                  <small class="mb-0">[ <?= $variants['v_sn'] ?> ]</small>
                </td>
                <td>
                  <div class="row justify-content-center">
                    <div>
                      <small>
                      B :    
                      <?php
                        if($variants['v_weight']!=0)
                        {
                          echo $variants['v_weight'].' g';
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      P :    
                      <?php
                        if($variants['v_length']!=0)
                        {
                          echo $variants['v_length'].' cm';
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      L :    
                      <?php
                        if($variants['v_width']!=0)
                        {
                          echo $variants['v_width'].' cm';
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
                        if($variants['v_size']!=0)
                        {
                          echo $variants['v_size'];
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      Sb :    
                      <?php
                        if($variants['v_sb']!='')
                        {
                          echo $variants['v_sb'];
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      M :    
                      <?php
                        if($variants['mutu']!='')
                        {
                          echo $variants['mutu'];
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
                        if($repair['add_berat']!=0)
                        {
                          echo $repair['add_berat'].' g';
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      P :    
                      <?php
                        if($repair['add_panjang']!=0)
                        {
                          echo $repair['add_panjang'].' cm';
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
                        if($repair['add_saiz']!=0)
                        {
                          echo $repair['add_saiz'];
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      L :    
                      <?php
                        if($repair['add_lebar']!=0)
                        {
                          echo $repair['add_lebar'].' cm';
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                    </div>
                  </div>
                </td>
                <td class="w-25 text-center">
                  <p class="mb-0"><?= $variants['description'] ?></p>
                </td>
                <td class="text-center">
                  <?= $variants['v_emas'] ?>
                  <br>
                  <small><?= $variants['setup_price'] ?> / g</small>
                </td>
                <td class="text-center">
                  <?= $variants['v_dasar'] ?>
                  <br>
                  <small>Up : <?= $variants['v_margin_pay'] ?></small> 

                </td>
                <td class="text-center"><?= $variants['v_kaunter'] ?></td>
              </tr>
              <input type="hidden" name="v_id" value="<?= $variants['variant_id'] ?>">
            <?php } ?>

            </tbody>
          </table>

          <br>

          <div class="float-left">
            <a href="<?= base_url('booking/create_repair') ?>" class="btn mb-3 btn-outline-dark"> <span class="fe fe-arrow-left fe-8"></span> Kembali</a><br>
            <!-- <small class="text-info">*Nota : Sila pastikan No siri produk yang dimasukkan adalah betul mengikut tag & maklumat pelanggan adalah tepat</small> -->
          </div>
        
          <div class="float-right" id="bottom" style="display:none">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="cara_bayaran" id="inlineRadio1" value="1">
              <label class="form-check-label" for="inlineRadio1">Tunai</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="cara_bayaran" id="inlineRadio2" value="2">
              <label class="form-check-label" for="inlineRadio2">Bank In</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="cara_bayaran" id="inlineRadio3" value="3">
              <label class="form-check-label" for="inlineRadio3">Debit/Credit</label>
            </div>
            <button type="submit" id="create_buy" class="btn btn-info text-light float-right" style="display:none">Cipta Bill</button>  
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
      
        <?= form_open('user/register_cust_repair',array('class'=>'form-horizontal','id'=>'regCustRepair')) ?>

        <input type="hidden" name="v_id" value="<?= $variants['variant_id'] ?>">

        <?php $this->load->view('customer/register_form'); ?>

        <?= form_close() ?>

    </div>
  </div>
</div>

<script>

  $(document).ready(function(){

    $('#getCawangan').val($('#cawangan').val()).trigger("change");

    <?php if ($this->uri->segment(4)) { ?>
      
      var id = $('#reg_id').val() ;

      $('#select_cust').val(id).trigger("change");

      document.getElementById("bottom").style.display="block";

    <?php } ?>

    $("#select_cust").change(function(){

      var full_name = $(this).find(':selected').data('full_name');
      var phone = $(this).find(':selected').data('phone');
      var address = $(this).find(':selected').data('address');
      var postcode = $(this).find(':selected').data('postcode');
      var town_area = $(this).find(':selected').data('town_area');
      var state = $(this).find(':selected').data('state');

      $('#cust_full_name').html(full_name + '<br>');
      $('#cust_phone').html(phone + '<br>');
      if (address) {
        $('#cust_address').html(address + ',');
        $('#cust_postcode').html(postcode + '<br>');
        $('#cust_town_area').html(town_area + ' ,');
        $('#cust_state').html(state + '<br>');  
      }else{
        $('#cust_address').html('');
        $('#cust_postcode').html('');
        $('#cust_town_area').html('');
        $('#cust_state').html(''); 
      }
      
      document.getElementById("btn_register").style.display="none";
      document.getElementById("bottom").style.display="block";
      // document.getElementById("calc1").style.display="";
      // document.getElementById("calc2").style.display="";
      // document.getElementById("calc3").style.display="";

    });

  }); 

  $(document).ready(function () {  
    $("#inlineRadio1, #inlineRadio2, #inlineRadio3").change(function () {
      if ($("#inlineRadio1").is(":checked")) {
        document.getElementById("create_buy").style.display="block";
      } else if ($("#inlineRadio2").is(":checked")) {
        document.getElementById("create_buy").style.display="block";
      } else if ($("#inlineRadio3").is(":checked")) {
        document.getElementById("create_buy").style.display="block";
      } else {
        document.getElementById("create_buy").style.display="none";
      }
    });        
  });

  $('#regCustRepair').one('submit', function() {
    document.getElementById("btn_upd").disabled = true;
  });

  $('#addRepair').one('submit', function() {
    document.getElementById("create_buy").disabled = true;
  });

</script>