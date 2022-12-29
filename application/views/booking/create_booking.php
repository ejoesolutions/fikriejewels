<?= $this->session->flashdata('upload'); ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h4 class="page-title"><?= $title ?></h4>

      <?= form_open_multipart('booking/new_product',array('class'=>'form-horizontal','id'=>'addBookNew')); ?>

      <div class="card shadow" id="section-to-print">
        <div class="card-body p-5">
          <div class="row">

            <!-- add produk dibeli -->
            <div class="col-md-4">
              <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new img-thumbnail img-responsive">
                  <img src="https://via.placeholder.com/500">
                </div>

                <div class="fileinput-preview fileinput-exists img-thumbnail img-responsive"></div>

                <div>
                  <span class="btn default btn-file pl-0">
                    <span class="fileinput-new btn btn-info"><i class="fe fe-camera fe-16"></i>
                      <?php echo lang('form_button_image') ?></span>
                    <!-- <span class="fileinput-exists btn btn-info"><?php echo lang('form_button_image_change') ?></span> -->
                    <input type="file" name="userfile" id="userfile" required>
                  </span>
                </div>
                <a href="javascript:;" class="btn btn-danger fileinput-exists mb-2" data-dismiss="fileinput">
                  <?php echo lang('form_button_image_delete') ?> </a>

                <div class="clearfix margin-top-10">
                  <small><span class="text-danger">NOTE!</span> <?php echo lang('form_button_upload_note') ?></small>
                  <?php if (isset($error_image)): ?>
                  <?php echo '<p><small class="text-danger">'. $error_image .'</small></p>'; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="col-md-8">

              <div class="row">
                <div class="col-md-6  pr-0">
                  <div class="form-group">
                    <label class="control-label">Nama Produk : </label>
                    <input type="text" class="form-control" name="nama_produk" required>
                  </div>
                </div>
                <div class="col-md-6  pr-0">
                  <div class="form-group">
                  <label class="control-label">Kedai</label>
                  <select name="cawangan" id="cawangan" class="form-control" required>
                    <!-- <option value="">-Pilih Cawangan-</option> -->
                    <?php foreach ($cawangan as $key) { ?>
                      <option value="<?= $key['id'] ?>" name="<?= $key['cawangan_code'] ?>" selected><?= $key['name'] ?></option>
                    <?php } ?>
                  </select>
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-md-3 pr-0">
                  <div class="form-group">
                    <label class="control-label">Kategori : </label>
                    <select name="category" id="category" class="form-control" required>
                      <option value="">--Pilih--</option>
                      <?php
                    if(!empty($category))
                    {
                      foreach ($category as $key) {?>
                      <option value="<?php echo $key['cat_id'] ?>" name="<?php echo $key['category_code'] ?>" data-sn="<?= $key['category_code'] ?>">
                        <?php echo $key['category_name'] ?></option>
                      <?php }
                    }
                    ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 pr-0">
                  <div class="form-group">
                    <label class="control-label">Mutu : </label>
                    <select name="mutu_id" id="mutu_id" class="form-control" required>
                      <option value="">--Pilih--</option>
                      <?php
                      if(!empty($mutu))
                      {
                        foreach ($mutu as $key) {?>
                        <option value="<?php echo $key['row_id'] ?>" data-sb="<?php echo $key['setup_price'] ?>">
                          <?php echo $key['mutu'] ?></option>
                        <?php }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3 pr-0">
                  <label class="control-label">Kod Produk : </label>
                  <input type="text" id="product_code" name="product_code" class="form-control" readonly>
                </div>
                <div class="col-md-3 pr-0">
                  <div class="form-group">
                    <label class="control-label">Dulang : </label>
                    <input type="text" class="form-control" value="TEMPAHAN" readonly>
                  </div>
                  <!-- <select name="dulang" class="form-control selDiv">
                    <?php
                    if(!empty($dulang))
                    {
                      foreach ($dulang as $key) {?>
                      <option value="<?php echo $key['dulang_code'] ?>"><?php echo $key['dulang_name'] ?></option>
                      <?php }
                    }
                    ?>
                  </select> -->
                </div>
                <input type="hidden" id="sp">
                <div class="col-md-12 pr-0">
                  <div class="form-group">
                    <label class="control-label">Keterangan</label>
                    <textarea cols="30" rows="13" name="keterangan" id="keterangan" class="form-control"></textarea>
                  </div>
                </div>

              </div>

              <div id="calc" style="display:none">
                <div class="row">
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Berat Anggaran ( g ) :</label>
                      <input type="text" name="v_weight" id="v_weight" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Harga Upah Anggaran ( RM ) :</label>
                      <input type="text" name="v_pay" id="v_pay" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Harga Semasa Anggaran ( RM ) :</label>
                      <input type="text" name="gold_price" id="gold_price" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Harga Dasar Anggaran ( RM ) :</label>
                      <input type="text" name="base_price" id="base_price" class="form-control" readonly>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Margin ( % ) :</label>
                      <input type="text" name="v_margin" id="v_margin" value="45" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Margin Upah Anggaran ( RM ) :</label>
                      <input type="text" name="margin_pay" id="margin_pay" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Seriya Berat Anggaran :</label>
                      <input type="text" name="serial_berat" id="serial_berat" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Harga Kaunter Anggaran ( RM ) :</label>
                      <input type="text" name="counter_price" id="counter_price" class="form-control"
                        readonly>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Saiz :</label>
                      <input type="text" name="v_size" id="v_size" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-3  pr-0">
                    <div class="form-group">
                      <label class="control-label">Panjang ( cm ) :</label>
                      <input type="text" name="v_length" id="v_length" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-3  pr-0">
                    <div class="form-group">
                      <label class="control-label">Lebar ( cm ) :</label>
                      <input type="text" name="v_width" id="v_width" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-3 pr-0">
                    <div class="form-group">
                      <label class="control-label">Kod Jualan :</label>
                      <input type="text" name="v_kod" id="v_kod" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row float-right pr-0" id="btn" style="display:none">
            <button type="submit" id="btnAddBookNew" class="btn btn-primary float-right">Tambah</button>
          </div>

          <?= form_close(); ?>


<script>
  //upd serial number based on category 
  // $("#category").change(function () {

  //   var old_sn = $("#v_sn").val();
  //   var category = $(this).find(':selected').data('sn');

  //   new_sn = category;

  //   document.getElementById("new_sn").value = new_sn;

  // });

  //upd sb based on selected mutu
  $("#mutu_id").change(function () {

    var v_sp = $(this).find(':selected').data('sb');

    sp = parseFloat(v_sp);

    document.getElementById("sp").value = sp.toFixed(2);
    document.getElementById('btn').style.display = 'block';
    document.getElementById('calc').style.display = 'block';
    $('textarea').attr("rows","4");
  });

  $("#v_weight,#v_pay,#v_margin").keyup(function () {

    var berat = $("#v_weight").val();
    var sp = $("#sp").val();
    var pay = $("#v_pay").val();
    var margin = $('#v_margin').val();

    kaunter = parseFloat(berat) * parseFloat(sp); 

    base_price = parseFloat(kaunter) + parseFloat(pay);

    margin_pay =  (parseFloat(pay) / (1 - (margin/100)));

    a = margin_pay.toFixed(0);

    serial_berat =  berat / 2.72;

    total_kaunter = parseFloat(kaunter) + parseFloat(a) ;

    //------------------------------------------------------------------------------

    document.getElementById("gold_price").value = kaunter.toFixed(2);
    document.getElementById("base_price").value = base_price.toFixed(2);
    document.getElementById("margin_pay").value = margin_pay.toFixed(0);
    document.getElementById("serial_berat").value = serial_berat.toFixed(3);
    document.getElementById("counter_price").value = total_kaunter.toFixed(0);

  });

  $("#category, #cawangan").change(function () {

    var category =  $("#category option:selected").attr('name') ? $("#category option:selected").attr('name') : '';
    var cawangan =  $("#cawangan option:selected").attr('name') ? $("#cawangan option:selected").attr('name') : '';
  
    product_code = cawangan + category + "TP";

    document.getElementById("product_code").value = product_code;
  });

  $('#addBookNew').one('submit', function() {
    $('#btnAddBookNew').attr('disabled','disabled');
    $("#btnAddBookNew").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

</script>