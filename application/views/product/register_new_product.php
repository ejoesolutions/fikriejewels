<?= $this->session->flashdata('upload'); ?>

<h4 class="page-title">Daftar Produk</h4>
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 margin-top-20">

    <?= form_open_multipart('', array('id'=>'addProduct')); ?>

    <input type="hidden" id="check_sn">
    <div class="form-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group margin-top-20">
            <div class="fileinput fileinput-new" data-provides="fileinput">
              <div class="fileinput-new img-thumbnail img-responsive">
                <img src="https://via.placeholder.com/500">
              </div>

              <div class="fileinput-preview fileinput-exists img-thumbnail img-responsive"></div>

              <div>
                <span class="btn default btn-file pl-0">
                  <span class="fileinput-new btn btn-info"><i class="fe fe-camera fe-16"></i> <?php echo lang('form_button_image') ?></span>
                  <!-- <span class="fileinput-exists btn btn-info"><?php echo lang('form_button_image_change') ?></span> -->
                  <input type="file" name="userfile" id="userfile" required>
                </span>
              </div>
              <a href="javascript:;" class="btn btn-danger fileinput-exists mb-2" data-dismiss="fileinput"> <?php echo lang('form_button_image_delete') ?> </a>

              <div class="clearfix margin-top-10">
                <small><span class="text-danger">NOTE!</span> <?php echo lang('form_button_upload_note') ?></small>
                <?php if (isset($error_image)): ?>
                  <?php echo '<p><small class="text-danger">'. $error_image .'</small></p>'; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-8">
        
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
              <label class="control-label">Nama Produk</label>
                <?php echo form_input($product_name);?>
                <?php echo form_error('product_name', '<p class="text-danger">', '</p>'); ?>
              </div>
            </div>
            <div class="col-md-6">
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
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Kategori</label>
                <select name="category" id="category" class="form-control" required>
                <option value="">-Pilih Kategori-</option>
                <?php if(!empty($category)) {
                  foreach ($category as $key) { ?>
                    <option value="<?php echo $key['cat_id'] ?>" name="<?php echo $key['category_code'] ?>"><?php echo $key['category_name'] ?></option>
                    <?php
                  }
                } ?>
               </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Dulang</label>
                  <select name="dulang" id="dulang" class="form-control" required>
                  <option value="">-Pilih Dulang-</option>
                  <?php
                  if(!empty($dulang))
                  {
                    foreach ($dulang as $key) { ?>
                      <option value="<?php echo $key['id'] ?>" name="<?php echo $key['dulang_code'] ?>"><?php echo $key['dulang_name'] ?></option>
                    <?php }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Pembekal</label>

                <select name="pembekal" id="pembekal" class="form-control" required>
                  <option value="">-Pilih Pembekal-</option>
                  <?php if(!empty($pembekal)) {
                    foreach ($pembekal as $key) { ?>
                      <option value="<?php echo $key['id'] ?>" name="<?php echo $key['supplier_code'] ?>"><?php echo $key['supplier_name'] ?></option>
                    <?php }
                  } ?>
               </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Jenis</label>
                <select name="type" id="type" class="form-control" required>
                  <option selected value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                  <option value="F">F</option>
                  <option value="G">G</option>
                  <option value="H">H</option>
                  <option value="I">I</option>
                  <option value="J">J</option>
                  <option value="K">K</option>
                  <option value="L">L</option>
                  <option value="M">M</option>
                  <option value="N">N</option>
                  <option value="O">O</option>
                  <option value="P">P</option>
                  <option value="Q">Q</option>
                  <option value="R">R</option>
                  <option value="S">S</option>
                  <option value="T">T</option>
                  <option value="U">U</option>
                  <option value="V">V</option>
                  <option value="W">W</option>
                  <option value="X">X</option>
                  <option value="Y">Y</option>
                  <option value="Z">Z</option>
                  <option value="A1">A1</option>
                  <option value="B1">B1</option>
                  <option value="C1">C1</option>
                  <option value="D1">D1</option>
                  <option value="E1">E1</option>
                  <option value="F1">F1</option>
                  <option value="G1">G1</option>
                  <option value="H1">H1</option>
                  <option value="I1">I1</option>
                  <option value="J1">J1</option>
                  <option value="K1">K1</option>
                  <option value="L1">L1</option>
                  <option value="M1">M1</option>
                  <option value="N1">N1</option>
                  <option value="O1">O1</option>
                  <option value="P1">P1</option>
                  <option value="Q1">Q1</option>
                  <option value="R1">R1</option>
                  <option value="S1">S1</option>
                  <option value="T1">T1</option>
                  <option value="U1">U1</option>
                  <option value="V1">V1</option>
                  <option value="W1">W1</option>
                  <option value="X1">X1</option>
                  <option value="Y1">Y1</option>
                  <option value="Z1">Z1</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Mutu</label>
                <select name="mutu" id="mutu" class="form-control" required>
                <?php
                if(!empty($mutu))
                {
                  foreach ($mutu as $key) {

                    if($key['mutu']=='916') { ?>
                      <option value="<?php echo $key['row_id'] ?>" selected><?php echo $key['mutu'] ?></option>
                    <?php }else{ ?>
                      <option value="<?php echo $key['row_id'] ?>"><?php echo $key['mutu'] ?></option>
                    <?php
                    }
                  }
                } 
                ?>
               </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Kod Produk <span id="check"></span></label>
                <?php echo form_input($product_code);?>
                <?php echo form_error('product_code', '<p class="text-danger">', '</p>'); ?>
              </div>
            </div>
         
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Keterangan</label>
                <?php echo form_textarea($description);?>
                <?php echo form_error('description', '<p class="text-danger">', '</p>'); ?>
              </div>
            </div>
            
        </div>

        <div class="row">
        <div class="col-md-9">
          &nbsp;
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <button type="submit" id="btnAddPro" class="btn btn-primary btn-block">Tambah</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?= form_close() ?>

  </div>
</div>

<script>

  $("#cawangan,#category,#type,#dulang,#pembekal").change(function () {

    var cawangan =  $("#cawangan option:selected").attr('name') ? $("#cawangan option:selected").attr('name') : '';
    var category =  $("#category option:selected").attr('name') ? $("#category option:selected").attr('name') : '';
    var dulang =  $("#dulang option:selected").attr('name') ? $("#dulang option:selected").attr('name') : '';
    var pembekal =  $("#pembekal option:selected").attr('name') ? $("#pembekal option:selected").attr('name') : '';
    var type = $("#type").val() ? $("#type").val() : '';
    
    product_code = category + dulang + pembekal + type;

    document.getElementById("product_code").value = product_code;

    $.ajax({
      type: "POST",
      url: "<?= base_url('catalog/check_p_code') ?>",
      data: { product_code : product_code},
      dataType: "text",
      cache: false,
      success:
      function(data){
        $("#check").html(data);
      }
    });
    return false;

  });

  $('#addProduct').one('submit', function() {
    $('#btnAddPro').attr('disabled','disabled');
    $("#btnAddPro").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
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

</script>

