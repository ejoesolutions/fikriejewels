<?php echo $this->session->flashdata('upload'); ?>

<input type="hidden" value="<?= $a ?>" id="get_id"> 

<!-- new weight -->
<?php if ($this->uri->segment(4)) { ?>
  <input type="hidden" id="new_weight" value="<?= $this->uri->segment(4) ?>">
<?php } ?>

<!-- new length -->
<?php if ($this->uri->segment(5)) { ?>
  <input type="hidden" id="new_length" value="<?= $this->uri->segment(5) ?>">
<?php } ?>

<!-- new width -->
<?php if ($this->uri->segment(6)) { ?>
  <input type="hidden" id="new_width" value="<?= $this->uri->segment(6) ?>">
<?php } ?>

<!-- new size -->
<?php if ($this->uri->segment(7)) { ?>
  <input type="hidden" id="new_size" value="<?= $this->uri->segment(7) ?>">
<?php } ?>

<?php  // echo bcdiv(100, 4.44, 0); ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10">

      <?php echo form_open('cart/add', array('id'=>'addCart')); ?>

      <div class="card shadow" id="section-to-print">
        <div class="card-body p-5">
          <div class="row mb-5">
            <div class="col-12 text-center mb-4">
              <h2 class="mb-0 text-uppercase">Pesanan</h2>
            </div>
          </div> <!-- /.row -->

          <?php if ($this->agent->is_mobile()) { ?>
            <video width="100%" id="preview" ></video>
            <!-- <video id="preview" playsinline controls="true" ></video> -->
            <!-- <video id="preview" playsinline controls="true" width="100%"></video> -->
          <?php } ?>
          
          <input type="hidden" id="text">

          <div class="row">
            <div class="input-group mb-3 col-md-12">
              <select class="custom-select select2" id="add_order" name="variants">
                <option value=''>Tambah Pesanan...</option>
                <?php
                  if(!empty($variants))
                  {
                    foreach ($variants as $key) { ?>
                      <option 

                      value="<?php echo $key['v_sn'] ?>"
                      data-v_id="<?php echo $key['variant_id'] ?>"
                      data-sn="<?php echo $key['v_sn'] ?>"
                      data-price="<?php echo $key['v_kaunter'] ?>"
                      data-size="<?php echo $key['v_size'] ?>"
                      data-length="<?php echo $key['v_length'] ?>"
                      data-width="<?php echo $key['v_width'] ?>"
                      data-weight="<?php echo $key['v_weight'] ?>"
                      data-sb="<?php echo $key['v_sb'] ?>"
                      data-pay="<?php echo $key['v_pay'] ?>"
                      data-margin="<?php echo $key['v_margin'] ?>"
                      data-margin_pay="<?php echo $key['v_margin_pay'] ?>"
                      data-mutu="<?php echo $key['mutu'] ?>"
                      data-setup_price="<?php echo $key['setup_price'] ?>"
                      data-serial_berat_price="<?php echo $key['serial_berat'] ?>"
                      data-product_name="<?php echo $key['product_name'] ?>"
                      data-product_id="<?php echo $key['product_id'] ?>"
                      data-deposit="<?php echo $key['harga'] ?>"
                      data-nota="<?php echo $key['nota'] ?>"

                      ><?= $key['v_sn'] ?></option>
                    <?php }
                  }
                ?>
              </select>
            </div>
            <input type="hidden" id="sn_select" name="sn">
            <input type="hidden" id="v_id_select" name="id">
            <!-- <input type="hidden" id="price_select" name="price"> -->
            <input type="hidden" id="product_name_select" name="product_name">
            <input type="hidden" id="product_id_select" name="product_id">
            <input type="hidden" id="size_select" name="size">
            <input type="hidden" id="length_select" name="length">
            <input type="hidden" id="width_select" name="width">
            <input type="hidden" id="weight_asal_select" name="weight_asal">
            <!-- <input type="hidden" id="sb_select_asal" name="sb"> -->
            <input type="hidden" id="pay_select" name="pay">
            <!-- <input type="hidden" id="margin_pay_select" name="margin_pay"> -->
            <input type="hidden" id="mutu_select" name="mutu">
            <!-- <input type="hidden" id="setup_price_select" name="setup_price"> -->
            <!-- <input type="hidden" id="serial_berat_price_select" name="serial_berat_price"> -->

            <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Per Gram ( RM )</span>
                </div>
                <input type="text" class="form-control text-center" id="setup_price_select" name="setup_price" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Harga ( RM )</span>
                </div>
                <input type="hidden" class="form-control text-center" id="price_select" name="price" readonly>
                <input type="text" class="form-control text-center" id="subtotal" readonly>
              </div>
            </div>

            <!-- <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Serial Berat</span>
                </div> -->
                <input type="text" class="form-control text-center" id="sb_select" name="sb" readonly style="display:none">
              <!-- </div>
            </div> -->

            <!-- <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Per Serial Berat ( RM )</span>
                </div> -->
                <input type="text" class="form-control text-center" id="serial_berat_price_select" name="serial_berat_price" readonly  style="display:none">
              <!-- </div>
            </div> -->

            <!-- <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Serial Berat ( RM )</span>
                </div> -->
                <input type="text" class="form-control text-center" id="rm_sb" readonly  style="display:none">
              <!-- </div>
            </div> -->

            <!-- <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Deposit ( RM )</span>
                </div> -->
                <input type="hidden" class="form-control text-center" value="0" id="deposit" name="deposit" readonly>
              <!-- </div>
            </div> -->

            <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Berat ( g )</span>
                </div>
                <input type="text" class="form-control text-center" id="weight_select" name="weight" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Upah ( RM )</span>
                </div>
                <input type="text" class="form-control text-center" id="margin_pay_select" name="margin_pay" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Diskaun ( RM )</span>
                </div>
                <input type="text" class="form-control text-center" id="diskaun" name="diskaun" value="0" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">Nota</span>
                </div>
                <input type="text" class="form-control text-center" id="nota" name="nota" maxlength="30" placeholder="max 30 aksara">
              </div>
            </div>

            <div class="col-md-12">
              <button type="submit" id="btnAddCart" class="btn btn-primary">Tambah</button>
              <!-- <input type="submit" class="btn btn-primary" value="Tambah"> -->
            </div>

          </div>

          <br>
          <div class="table-responsive">
          <table class="table nowrap table-bordered text-dark">

          <tr>
            <th nowrap class="text-center" width="5%">Padam</th>
            <th nowrap class="text-center">Nama Produk</th>
            <th nowrap class="text-center" width="20%">Maklumat</th>
            <th nowrap class="text-center" width="15%">Nota</th>
            <th nowrap class="text-center" width="20%">Harga Kaunter ( RM )</th>
            <th nowrap class="text-center" width="16%">Harga ( RM )</th>
          </tr>

          <?php $i = 1; ?>

          <?php foreach ($this->cart->contents() as $items): ?>

          <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>

          <tr>
            <td class="text-center"><a class="text-danger del" href="<?= base_url('cart/remove_cart/'.$items['rowid']) ?>"><span class="fe fe-trash fe-16"></span></a></td>
            <td>
              <?php echo $items['name']; ?>
              <br>
              <small><?php echo $items['sn']; ?></small>

              <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>

              <p>
                <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
                  <strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />
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
            <td class="text-center"><?= $items['nota']?>
            <td class="text-center"><?php echo $this->cart->format_number($items['price']); ?>
            <!-- <?php if ($items['deposit'] != "0") {
              echo "<br><small>[ Deposit : - RM ".$items['deposit']." ]</small>"; 
            } ?> -->
            <?php if ($items['diskaun'] != "0") {
              echo "<br><small>[ Diskaun : - RM ".$items['diskaun']." ]</small>"; 
            } ?>
            </>
            <td class="text-center"><?php echo $this->cart->format_number($items['subtotal']); ?></td>
          </tr>

          <?php $i++; ?>

          <?php endforeach; ?>

          <tr>
            <td colspan="4"></td>
            <td class="text-center"><strong>Jumlah ( RM )</strong></td>
            <td class="text-center">
              <input type="text" name="tax" class="form-control text-center" value="<?php echo $this->cart->format_number($this->cart->total()); ?>" readonly>
            </td>
          </tr>

          </table>
          </div>
          <?php echo form_close(); ?>

          <?php if ($this->cart->contents()) { ?>
            <a href="<?= base_url('orders/checkout') ?>" class="btn btn-info float-right text-light">Semak Keluar</a>
            <a href="<?= base_url('cart/reset_cart') ?>" class="btn btn-outline-dark float-left reset"><span class="fe fe-refresh-ccw fe-8"></span></a>
          <?php } ?>
       
        </div> <!-- /.card-body -->
        
      </div> <!-- /.card -->

      <?php echo form_close(); ?>
      
    </div> <!-- /.col-12 -->
  </div> <!-- .row -->
</div> <!-- .container-fluid -->


<!-- <script src="<?php echo base_url(); ?>assets/js/instascan.min.js"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/js/instascan_lastest.min.js"></script> -->

<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript" src="https://webrtc.github.io/adapter/adapter-latest.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/1.1.28/howler.js"></script> -->

<script type="text/javascript">

  let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false,continuous: true, backgroundScan: true, scanPeriod: 1});
  scanner.addListener('scan', function (content) {
    console.log(content);

    $('#add_order').select2();

    $search = document.getElementById("text").value=content;
    $('#add_order').val($search).trigger("change");

  });
  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      scanner.start(cameras[1]);
    } else {
      console.error('No cameras found.');
    }
  }).catch(function (e) {
    console.error(e);
  });

</script>

<script type="text/javascript">

  $(document).ready(function(){

    $id = document.getElementById("get_id").value;

    if ($id) {
      $('#add_order').val($id).trigger("change");

      // jQuery('#inputid').remove();
    }
    
  });

  $('#addCart').one('submit', function() {
    document.getElementById("create_buy").disabled = true;
  });

  $(document).ready(function(){

    $("#add_order").change(function(){

      // var deposit = $('#deposit').val() ;
      var deposit = $(this).find(':selected').data('deposit');
      var v_id = $(this).find(':selected').data('v_id');
      var sn = $(this).find(':selected').data('sn');
      var price = $(this).find(':selected').data('price');
      var name = $(this).find(':selected').data('product_name');
      var id = $(this).find(':selected').data('product_id');
      var size = $(this).find(':selected').data('size');
      var length = $(this).find(':selected').data('length');
      var width = $(this).find(':selected').data('width');
      var weight = $(this).find(':selected').data('weight');
      var sb = $(this).find(':selected').data('sb');
      var pay = $(this).find(':selected').data('pay');
      var margin = $(this).find(':selected').data('margin');
      var margin_pay = $(this).find(':selected').data('margin_pay');
      var mutu = $(this).find(':selected').data('mutu');
      var setup_price = $(this).find(':selected').data('setup_price');
      var serial_berat_price = $(this).find(':selected').data('serial_berat_price');
      var nota = $(this).find(':selected').data('nota');

      rm_sb = parseFloat(serial_berat_price) * parseFloat(sb);
      //calc current price
      gold_price = parseFloat(setup_price) * parseFloat(weight);
      x = RoundNum(gold_price,2);
      current_margin_pay =  (parseFloat(pay) / (1 - (margin/100)));
      // a = current_margin_pay.toFixed(0);
      a = RoundNum(current_margin_pay,0);

      current_price =  parseFloat(x) + parseFloat(a);
      subtotal = parseFloat(current_price) - parseFloat(deposit);

      //------------------

      $('#v_id_select').val(v_id);
      $('#sn_select').val(sn);
      $('#deposit').val(deposit);
      document.getElementById("price_select").value=RoundNum(current_price,2);
      document.getElementById("subtotal").value=RoundNum(subtotal,2);
      document.getElementById("rm_sb").value=RoundNum(rm_sb,2)  ;
      // document.getElementById("deposit").value=deposit.toFixed(2);
      // $('#price_select').val(current_price);
      $('#product_name_select').val(name);
      $('#product_id_select').val(id);
      $('#size_select').val(size);
      $('#length_select').val(length);
      $('#width_select').val(width);
      $('#weight_select').val(weight);
      $('#weight_asal_select').val(weight);
      $('#sb_select').val(sb);
      $('#pay_select').val(pay);
      $('#margin_pay_select').val(a);
      // $('#margin_pay_select').val(current_margin_pay);
      $('#mutu_select').val(mutu);
      $('#setup_price_select').val(setup_price);
      $('#serial_berat_price_select').val(serial_berat_price);
      $('#nota').val(nota);

      // document.getElementById("semak").style.display="block";

    }); 

    $("#add_order").val(function(){ 

      // var deposit = $('#deposit').val() ;
      var deposit = $(this).find(':selected').data('deposit');
      var sn = $(this).find(':selected').data('sn');
      var v_id = $(this).find(':selected').data('v_id');
      var price = $(this).find(':selected').data('price');
      var name = $(this).find(':selected').data('product_name');
      var id = $(this).find(':selected').data('product_id');
      var size = $(this).find(':selected').data('size');
      var length = $(this).find(':selected').data('length');
      var width = $(this).find(':selected').data('width');
      var pay = $(this).find(':selected').data('pay');
      var margin = $(this).find(':selected').data('margin');
      var margin_pay = $(this).find(':selected').data('margin_pay');
      var mutu = $(this).find(':selected').data('mutu');
      var setup_price = $(this).find(':selected').data('setup_price');
      var serial_berat_price = $(this).find(':selected').data('serial_berat_price');
      var nota = $(this).find(':selected').data('nota');
      

      if ($('#new_weight').val()) {
        var weight = $('#new_weight').val();
        new_sb = parseFloat(weight)  / 2.720;
        // alert((2.5655).toFixed(3));
        var sb = RoundNum(new_sb,3);
        var weight_asal = $(this).find(':selected').data('weight'); //berat mula2 masuk
      }else {
        var weight_asal = $(this).find(':selected').data('weight'); //berat mula2 masuk
        var sb = $(this).find(':selected').data('sb');
      }

      if ($('#new_length').val()) {
        var length = $('#new_length').val();
      }else {
        var length = $(this).find(':selected').data('length');
      }

      if ($('#new_width').val()) {
        var width = $('#new_width').val();
      }else {
        var width = $(this).find(':selected').data('width');
      }

      if ($('#new_size').val()) {
        var size = $('#new_size').val();
      }else {
        var size = $(this).find(':selected').data('size');
      }

      //calc current price
      rm_sb = parseFloat(serial_berat_price) * parseFloat(sb);

      gold_price = parseFloat(setup_price) * parseFloat(weight);
      // x = gold_price.toFixed(2);
      x = RoundNum(gold_price,2);
      current_margin_pay =  (parseFloat(pay) / (1 - (margin/100)));
      a = RoundNum(current_margin_pay,0);

      current_price =  parseFloat(x) + parseFloat(a);
      subtotal = parseFloat(current_price) - parseFloat(deposit);

      //------------------

      $('#v_id_select').val(v_id);
      $('#sn_select').val(sn);
      $('#price_select').val(current_price);
      document.getElementById("subtotal").value= RoundNum(subtotal,2);
      // document.getElementById("deposit").value=deposit.toFixed(2);
      $('#deposit').val(deposit);
      // $('#price_select').val(current_price);
      $('#product_name_select').val(name);
      $('#product_id_select').val(id);
      $('#size_select').val(size);
      $('#length_select').val(length);
      $('#width_select').val(width);
      $('#weight_select').val(weight);
      $('#weight_asal_select').val(weight_asal);
      $('#sb_select').val(sb);
      $('#pay_select').val(pay);
      $('#margin_pay_select').val(a);
      $('#mutu_select').val(mutu);
      $('#setup_price_select').val(setup_price);
      $('#serial_berat_price_select').val(serial_berat_price);
      document.getElementById("rm_sb").value= RoundNum(rm_sb,2);

      $('#nota').val(nota);

      // document.getElementById("semak").style.display="block";

    }); 
  }); 


  $(document).ready(function(){

    $("#weight_select,#margin_pay_select,#diskaun,#deposit").keyup(function(){

      var new_weight = $('#weight_select').val();
      var setup_price = $('#setup_price_select').val() ;
      var new_pay = $('#margin_pay_select').val() ;
      var diskaun = $('#diskaun').val() ;
      var deposit = $('#deposit').val() ;
      var serial_berat_price_select = $('#serial_berat_price_select').val() ;
      
      gold_price = parseFloat(new_weight) * parseFloat(setup_price);
      price = parseFloat(RoundNum(gold_price,2)) + parseFloat(new_pay);
      
      total = parseFloat(price) - parseFloat(deposit) - parseFloat(diskaun);

      new_sb = parseFloat(new_weight) / 2.72;

      new_price_sb = parseFloat(RoundNum(new_sb,3)) * parseFloat(serial_berat_price_select);

      document.getElementById("subtotal").value= RoundNum(total,2);
      document.getElementById("price_select").value= RoundNum(price,2);
      document.getElementById("rm_sb").value= RoundNum(new_price_sb,2);
      document.getElementById("sb_select").value= RoundNum(new_sb,3);

    });

  }); 

  //delete product button confirmation
  $('.del').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Produk?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
        cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
      window.location.replace(url);
      }
    });
  });

  //reset cart button confirmation
  $('.reset').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Set Semula Pesanan?',
      text: "Semua Produk Akan Dipadam!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Tutup',
      confirmButtonText: 'Ya, Set Semula!'
    }).then((result) => {
      if (result.value) {
      window.location.replace(url);
      }
    });
  });

</script>
