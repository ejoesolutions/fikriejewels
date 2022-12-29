<style>

.hide {
  border: 2px solid #ffffff;
  border-radius: 4px;
  color: #ffffff;
}

</style>
<?= $this->session->flashdata('upload'); ?>

<!-- form for new user id -->
<?php if ($this->uri->segment(3)) { ?>
  <input type="hidden" id="reg_id" value="<?= $this->uri->segment(3) ?>">
<?php } ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10">
      <?= form_open('buy/add_buy_product', array('id'=>'addBuy')); ?>

      <div class="card shadow" id="section-to-print">
        <div class="card-body p-5">
          <div class="row mb-5">
            <div class="col-12 text-center mb-4">
              <h2 class="mb-0 text-uppercase">Resit Belian</h2>
            </div>
            <div class="col-md-7">
              <p class="small text-dark text-uppercase mb-2">Invoise Daripada</p>
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
              <p class="small text-muted text-uppercase mb-2">Invois Kepada</p>
                <div class="form-group">
                  <select class="form-control select2" name="cust_id" id="select_cust" required>
                      <option value="">--Pilih--</option>
                      <?php if(!empty($cust)) {
                        foreach ($cust as $key) { ?>
                          <option value="<?php echo $key['id'] ?>"
                          
                            data-full_name="<?php echo $key['name'] ?>"
                            data-nic_no="<?php echo $key['kp'] ?>"
                            data-phone="<?php echo $key['phone'] ?>"
                            data-address="<?php echo $key['address'] ?>"
                            data-state="<?php echo $key['state'] ?>"

                          ><?= $key['name'] ?></option>
                      <?php } } ?>
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
                 
          <table class="table nowrap" id="example">
            <thead>
            <tr class="text-center">
              <th width="10%">Gambar</th>
              <th>Produk</th>
              <th>Maklumat Produk</th>
              <!-- <th>RM / Serial Berat</th> -->
              <th>Keterangan</th>
              <th>Harga ( RM )</th>
            </tr>
            </thead>
            <tbody>

            <?php 
            
            if ($item) {

            foreach ($item as $items) { ?>

              <tr>
                <td class="text-center" style="width:150px;height:150px">
                    <?php

                    if ($items['picture']) {
                      $image_properties = array(
                        'src'   => base_url().'images/thumbnail/'.$items['picture'],
                        'alt'   => $items['product_name'],
                        'class' => 'avatar-img',
                        'title' => $items['product_name'],
                        'style' => 'height: 100%; width: 100%; object-fit: contain',
                      );

                      echo img($image_properties);

                    } else {

                      $image_properties = array(
                        'src'   => 'https://dummyimage.com/75x75/d6c7d6/9b9dad.jpg&text=No+Image',
                        'alt'   => 'No image',
                        'class' => 'avatar-img',
                        'title' => 'No image',
                        'width' => '100%'
                      );

                      echo img($image_properties);
                    }

                    ?>
                </td>
                <td class="text-center">
                  <p class="mb-0"><?= $items['product_name'] ?></p>
                  <small class="mb-0">[ <?= $items['serial_number'] ?> ]</small>
                </td>
                <td>
                  <div class="row justify-content-center">
                    <div>
                      <small>
                      B :    
                      <?php
                        if($items['berat']!=0)
                        {
                          echo $items['berat'].' g';
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      P :    
                      <?php
                        if($items['panjang']!=0)
                        {
                          echo $items['panjang'].' cm';
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      L :    
                      <?php
                        if($items['lebar']!=0)
                        {
                          echo $items['lebar'].' cm';
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
                        if($items['saiz']!=0)
                        {
                          echo $items['saiz'];
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <!-- <br>
                      <small>
                      Sb :    
                      <?php
                        if($items['serial_berat']!='')
                        {
                          echo $items['serial_berat'];
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small> -->
                      <br>
                      <small>
                      M :    
                      <?php
                        if($items['mutu']!='')
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
                <!-- <td class="text-center">
                  <small>
                    RM : <?= $items['harga_semasa'] ?>
                    <br>
                    Sb : <?= $items['serial_berat'] ?>
                  </small>
                </td> -->
                <td class="text-center">
                  <small class="mb-0">
                    <?php if ($items['jenis'] == 1) {
                      echo "Jenis : Belian";
                    }elseif ($items['jenis'] == 2) {
                      echo "Jenis : Trade In";
                    } ?>
                    <br>
                    <?= $items['keterangan'] ?>
                  </small>
                </td>
                <td class="text-center"><?= $items['harga'] ?></td>
              </tr>

              <input type="text" class="hide" name="product_id[]" value="<?= $items['id'] ?>" readonly>


            <?php } } ?>

            </tbody>
            <tfoot>
              <tr>
                <th colspan="4" style="text-align:right">JUMLAH : </th>
                <th class="text-center"><input type="text" name="jumlah" id="jumlah" class="form-control text-center" readonly></th>
              </tr>
              <tr>
                <th colspan="4" style="text-align:right">BAKI : </th>
                <th class="text-center"><input type="text" name="baki" id="baki" class="form-control text-center" readonly></th>
              </tr>
                <tr id="showTunai" style="display:none">
                  <th colspan="4" style="text-align:right">Tunai : </th>
                  <th class="text-center"><input type="text" name="tunai" id="tunai" class="form-control text-center"></th>
                </tr>
                <tr id="showBank" style="display:none">
                  <th colspan="4" style="text-align:right">Bank In : </th>
                  <th class="text-center"><input type="text" name="bank" id="bank" class="form-control text-center"></th>
                </tr>
                <tr id="showCredit" style="display:none">
                  <th colspan="4" style="text-align:right">Debit / Credit : </th>
                  <th class="text-center"><input type="text" name="credit" id="credit" class="form-control text-center"></th>
                </tr>
            </tfoot>  
          </table>

          <br>          
          <div class="float-right" id="bottom" style="display:none">
            <button type="submit" id="create_buy" class="btn btn-info text-light float-right">Cipta Belian</button>  
          </div>
          <div class="float-left">
            <a href="<?= base_url('buy/create_buy') ?>" class="btn mb-3 btn-outline-dark"> <span class="fe fe-arrow-left fe-8"></span> Kembali</a><br>
            <!-- <small class="text-info">*Nota : Sila pastikan No siri produk yang dimasukkan adalah betul mengikut tag & maklumat pelanggan adalah tepat</small> -->
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
      
        <?= form_open('user/register_cust_buy',array('class'=>'form-horizontal','id'=>'regCustBuy')) ?>

        <?php $this->load->view('customer/register_form'); ?>

        <?= form_close() ?>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>

  $(document).ready(function(){

    //trigger new user into select cust    
    <?php if ($this->uri->segment(3)) { ?>
      
      var id = $('#reg_id').val() ;

      $('#select_cust').val(id).trigger("change");
      
      // document.getElementById("bottom").style.display="block";
      $("#showTunai").removeAttr("style");
      $("#showBank").removeAttr("style");
      $("#showCredit").removeAttr("style");

    <?php } ?>

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

      $("#showTunai").removeAttr("style");
      $("#showBank").removeAttr("style");
      $("#showCredit").removeAttr("style");

    });

    $('#example').dataTable( {
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
            i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        pageTotal = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        // $( api.column( 4 ).footer() ).html(
          total
        // );

        document.getElementById("jumlah").value=total.toFixed(2);
        document.getElementById("baki").value=total.toFixed(2);
      },

      "bPaginate": false,
      "bFilter": false,
      "bInfo": false
      
    } );

  }); 

  // $(document).ready(function () {  
  //   $("#inlineRadio1, #inlineRadio2, #inlineRadio3").change(function () {
  //     if ($("#inlineRadio1").is(":checked")) {
  //       document.getElementById("create_buy").style.display="block";
  //     } else if ($("#inlineRadio2").is(":checked")) {
  //       document.getElementById("create_buy").style.display="block";
  //     } else if ($("#inlineRadio3").is(":checked")) {
  //       document.getElementById("create_buy").style.display="block";
  //     } else {
  //       document.getElementById("create_buy").style.display="none";
  //     }
  //   });        
  // });

  $(document).ready(function () {  

    $("#tunai,#credit,#bank").keyup(function(){

      var jumlah = $('#jumlah').val();
      var tunai = $('#tunai').val();
      var credit = $('#credit').val();
      var bank = $('#bank').val();
      var baki = $('#baki').val();

      total_baki = jumlah - tunai - credit - bank;

      if (total_baki == 0) {
        document.getElementById("bottom").style.display="block";
      }else{
        document.getElementById("bottom").style.display="none";
      }

      document.getElementById("baki").value=total_baki.toFixed(2);
  
    });
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

  $('#addBuy').one('submit', function() {
    $('#create_buy').attr('disabled','disabled');
    $("#create_buy").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

  $('#regCustBuy').one('submit', function() {
    $('#btnRegCustBuy').attr('disabled','disabled');
    $("#btnRegCustBuy").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

</script>