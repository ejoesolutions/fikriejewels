<?php echo $this->session->flashdata('upload'); ?>

<div class="card shadow mb-4">  
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 mt-3 mb-3">
        <a class="" data-toggle="modal" href="#addCategory"><button class="btn btn-primary">+ Kategori</button></a>
      </div>
      <div class="col-md-12 margin-top-20">
        <div class="table-responsive">
          <table class="table table-bordered " id="">
            <thead>
              <th class="text-center">No.</th>
              <th class="text-center">Kategori</th>
              <th class="text-center">Kod Kategori</th>
              <th class="text-center">#</th>
            </thead>

            <tbody>

            <?php

            $new_array=array();

            if(!empty($category))
            {
              $i=1;
              foreach ($category as $key) { ?>

              <tr>
                <td class="text-center"><?php echo $i++ ?></td>
                <td class="text-center"><?php echo $key['category_name'] ?></td>
                <td class="text-center"><?php echo $key['category_code'] ?></td>
                <td class="text-center">
                  <a class="" href='#' data-role="editCategory" data-id="<?php echo $key['cat_id'] ?>"
                    data-cat="<?php echo $key['category_name'] ?>" data-cat_code="<?php echo $key['category_code'] ?>"
                    data-toggle="modal" title="Kemaskini"><span class="fe fe-edit fe-20"></span></a>
                  | 
                  <a class="text-danger category" href="<?php echo base_url('catalog/del_category/'.$key['cat_id']) ?>" title="Padam"><span class="fe fe-trash fe-20"></span></a>
                </td>
              </tr>

              <?php

                $new_array4[$i-2]=array('id'=>$key['cat_id'],'code'=>$key['category_code']);

              }
            }

            $data_category = json_encode($new_array4); ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 margin-top-20">
        <div class="row margin-bottom-10">
          <div class="col-md-12">
            <a class="" data-toggle="modal" href="#adddulang"><button class="btn btn-primary">+ Dulang</button></a>
          </div>
        </div>
        <br>
        <div class="table-responsive">
          <table class="table table-bordered" id="">
            <thead>
              <th class="text-center">No.</th>
              <th class="text-center">Dulang</th>
              <th class="text-center">Kod Dulang</th>
              <th class="text-center">#</th>
            </thead>

            <tbody>

              <?php

              $new_array=array();

               if(!empty($list_dulang))
               {
                $i=1;
                foreach ($list_dulang as $key) { ?>

                <tr>
                  <td class="text-center"><?php echo $i++ ?></td>
                  <td class="text-center"><?php echo $key['dulang_name'] ?></td>
                  <td class="text-center"><?php echo $key['dulang_code'] ?></td>
                  <td class="text-center">
                  <a class="" href='#' data-role="editdulang" data-id="<?php echo $key['id'] ?>"
                      data-cat="<?php echo $key['dulang_name'] ?>" 
                      data-cat_code="<?php echo $key['dulang_code'] ?>"
                      data-toggle="modal" title="Kemaskini"><span class="fe fe-edit fe-20"></span></a>

                  | <a class="text-danger dulang" href="<?php echo base_url('catalog/del_dulang/'.$key['id']) ?>" title="Padam"><span
                      class="fe fe-trash fe-20"></span></a>
                  </td>
                </tr>

                <?php $new_array[$i-2]=array('id'=>$key['id'],'code'=>$key['dulang_code']);

                }
              }

                $data = json_encode($new_array);?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 margin-top-20">
        <div class="row margin-bottom-10">
            <div class="col-md-12">
              <a class="" data-toggle="modal" href="#addsupplier"><button class="btn btn-primary">+ Pembekal</button></a>
            </div>
        </div>
        <br>
        <div class="table-responsive">
          <table class="table table-bordered" id="">
            <thead>
              <th class="text-center">No.</th>
              <th class="text-center">Pembekal</th>
              <th class="text-center">Kod Pembekal</th>
              <th class="text-center">#</th>
            </thead>

            <tbody>

              <?php

              $new_array=array();

               if(!empty($list_supplier))
               {
                $i=1;
                foreach ($list_supplier as $key2) { ?>

                <tr>
                  <td class="text-center"><?php echo $i++ ?></td>
                  <td class="text-center"><?php echo $key2['supplier_name'] ?></td>
                  <td class="text-center"><?php echo $key2['supplier_code'] ?></td>
                  <td class="text-center">
                  <a class="" href='#' data-role="editsupplier" data-id="<?php echo $key2['id'] ?>"
                      data-cat="<?php echo $key2['supplier_name'] ?>" 
                      data-cat_code="<?php echo $key2['supplier_code'] ?>"
                      data-toggle="modal" title="Kemaskini"><span class="fe fe-edit fe-20"></span></a>

                  | <a class="text-danger supplier" href="<?php echo base_url('catalog/del_supplier/'.$key2['id']) ?>" title="Padam"><span
                      class="fe fe-trash fe-20"></span></a>
                  </td>
                </tr>

                <?php $new_array1[$i-2]=array('id'=>$key2['id'],'code'=>$key2['supplier_code']);

                }

                }

                $data_supplier = json_encode($new_array1);?>

            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" id="adddulang" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Dulang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

          <?php echo form_open('catalog/store_dulang',array('class'=>'form-horizontal','id'=>'addDul')) ?>

          <div class="form-group">
            <label class="control-label col-md-12">Dulang:</label>
            <div class="col-md-12">
              <input type="text" name="dulang_name" class="form-control uppercase" required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-12">Kod Dulang: <small class="text-info">* ( Maksimum 3 Huruf )</small></label>
            <div class="col-md-12">
              <input type="text" name="dulang_code" class="form-control uppercase" id="dulang_code" maxlength="3" required>
              <p id="inp_dulang_same" class="text-danger mt-2" style="display:none"></p>
            </div>
          </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
            <input type="submit" id="btn_dulang" class="btn btn-primary" value="Simpan">
          </div>

          <?php echo form_close() ?>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="addsupplier" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Pembekal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

            <div class="modal-body">

            <?php echo form_open('catalog/store_supplier',array('class'=>'form-horizontal','id'=>'addSup')) ?>

            <div class="form-group">
              <label class="control-label col-md-12">Pembekal:</label>
              <div class="col-md-12">
                <input type="text" name="supplier_name" class="form-control uppercase" required>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-12">Kod Pembekal: <small class="text-info">* ( Maksimum 3 Huruf )</small></label>
              <div class="col-md-12">
                <input type="text" name="supplier_code" class="form-control uppercase" id="supplier_code" maxlength="3" required>
                <p id="inp_supplier_same" class="text-danger mt-2" style="display:none"></p>
              </div>
            </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
              <input type="submit" id="btn_supplier" class="btn btn-primary" value="Simpan">
            </div>

            <?php echo form_close() ?>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal_editdulang" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Kemaskini Dulang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <?php echo form_open('catalog/upd_dulang',array('class'=>'form-horizontal','id'=>'updDul')) ?>

            <div class="form-group">
              <label class="control-label col-md-12">Dulang:</label>
              <div class="col-md-12">
                <input type="hidden" name="dulang_id" id="dulang_id" class="form-control" required>
                <input type="text" name="dulang_name" id="dulang_name" class="form-control uppercase" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-12">Kod Dulang: <small class="text-info">* ( Maksimum 3 Huruf )</small></label>
              <div class="col-md-12">
                <input type="text" name="upd_dulang_code" id="upd_dulang_code" class="form-control uppercase" maxlength="3" required>
                <p id="upd_same_dulang" class="text-danger mt-2" style="display:none"></p>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
            <input type="submit" id="btn_upd_dulang" class="btn btn-primary" value="Simpan">
          </div>

          <?php echo form_close() ?>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal_editsupplier" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Kemaskini Pembekal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
          <?php echo form_open('catalog/upd_supplier',array('class'=>'form-horizontal','id'=>'updSup')) ?>

          <div class="form-group">
            <label class="control-label col-md-12">Pembekal:</label>
            <div class="col-md-12">
              <input type="hidden" name="supplier_id" id="supplier_id" class="form-control" required>
              <input type="text" name="supplier_name" id="supplier_name" class="form-control uppercase" required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-12">Kod Pembekal: <small class="text-info">* ( Maksimum 3 Huruf )</small></label>
            <div class="col-md-12">
              <input type="text" name="upd_supplier_code" id="upd_supplier_code" class="form-control uppercase" maxlength="3" required>
              <p id="upd_same_supplier" class="text-danger mt-2" style="display:none"></p>
            </div>
          </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
            <input type="submit" id="btn_upd_supplier" class="btn btn-primary" value="Simpan">
          </div>

          <?php echo form_close() ?>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <?php echo form_open('catalog/store_category',array('class'=>'form-horizontal','id'=>'addCat')) ?>

            <div class="form-group">
              <label class="control-label col-md-12">Kategori:</label>
              <div class="col-md-12">
                <input type="text" name="category_name" class="form-control uppercase" required>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-12">Kod Kategori: <small class="text-info">* ( Maksimum 3 Huruf )</small></label>
              <div class="col-md-12">
                <input type="text" name="category_code" class="form-control uppercase" id="category_code" maxlength="3" required>
                <p id="inp_category_same" class="text-danger mt-2" style="display:none"></p>
              </div>
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
            <input type="submit" id="btn_category" class="btn btn-primary" value="Simpan">
          </div>

          <?php echo form_close() ?>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal_editCategory" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Kemaskini Kategori</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <?php echo form_open('catalog/upd_category',array('class'=>'form-horizontal','id'=>'updCat')) ?>

            <div class="form-group">
              <label class="control-label col-md-12">Kategori:</label>
              <div class="col-md-12">
                <input type="hidden" name="category_id" id="category_id" class="form-control" required>
                <input type="text" name="category_name" id="category_name" class="form-control uppercase" required>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-12">Kod Kategori:  <small class="text-info">* ( Maksimum 3 Huruf )</small></label>
              <div class="col-md-12">
                <input type="text" name="category_code" id="upd_category_code" class="form-control uppercase" maxlength="3" required>
                <p id="upd_same_category" class="text-danger mt-2" style="display:none"></p>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
            <input type="submit" id="btn_upd_category" class="btn btn-primary" value="Simpan">
          </div>

          <?php echo form_close() ?>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

<script>

var data  = <?php echo $data ?>;
var length = data.length;

$(document).ready(function(){

  $(document).on('click','a[data-role=editdulang]', function(){

    var id  = $(this).data('id');
    var name  = $(this).data('cat');
    var code  = $(this).data('cat_code');

    // alert($(this).data('id'));
    $('#dulang_id').val(id);
    $('#dulang_name').val(name);
    $('#upd_dulang_code').val(code);
    $('#modal_editdulang').modal("toggle");

  });

  $('#dulang_code').on('keyup', function(){

    var code  = $('#dulang_code').val().toUpperCase();
    var f=0;

    if(length > 0)
    {
      for(var i=0;i<length;i++)
      {
        if(code == data[i]['code'])
        {
          f++;
        }
      }
    }

    if(f > 0)
    {
      document.getElementById("inp_dulang_same").innerHTML = "Maaf, kod ini sudah didaftarkan. Sila masukkan kod berbeza.";
      document.getElementById("inp_dulang_same").style.display="block";
      document.getElementById("btn_dulang").style.display="none";
    }else{
      document.getElementById("inp_dulang_same").style.display="none";
      document.getElementById("btn_dulang").style.display="inline-block";
    }
    // alert(code);
  });

  $('#upd_dulang_code').on('keyup', function(){

   var code  = $('#upd_dulang_code').val().toUpperCase();
   var id = $('#dulang_id').val();
   var f=0;

   if(length > 0)
   {
     for(var i=0;i<length;i++)
     {
       if(code == data[i]['code'] && id!=data[i]['id'])
       {
         f++;
       }
     }
   }

   if(f > 0)
   {
     document.getElementById("upd_same_dulang").innerHTML = "Maaf, kod ini sudah didaftarkan. Sila masukkan kod berbeza.";
     document.getElementById("upd_same_dulang").style.display="block";
     document.getElementById("btn_upd_dulang").style.display="none";
   }else{
     document.getElementById("upd_same_dulang").style.display="none";
     document.getElementById("btn_upd_dulang").style.display="inline-block";
   }
  //  alert(code);
  });

});

</script>

<script>

var data_supplier  = <?php echo $data_supplier ?>;
var length_supplier = data_supplier.length;

$(document).ready(function(){

  $(document).on('click','a[data-role=editsupplier]', function(){


    var id  = $(this).data('id');
    var name  = $(this).data('cat');
    var code  = $(this).data('cat_code');

    // alert($(this).data('id'));
    $('#supplier_id').val(id);
    $('#supplier_name').val(name);
    $('#upd_supplier_code').val(code);
    $('#modal_editsupplier').modal("toggle");

  });

  $('#supplier_code').on('keyup', function(){

    var code  = $('#supplier_code').val().toUpperCase();
    var f=0;

    if(length_supplier > 0)
    {
      for(var i=0;i<length_supplier;i++)
      {
        if(code == data_supplier[i]['code'])
        {
          f++;
        }
      }
    }
    
    if(f > 0)
    {
      document.getElementById("inp_supplier_same").innerHTML = "Maaf, kod ini sudah didaftarkan. Sila masukkan kod berbeza.";
      document.getElementById("inp_supplier_same").style.display="block";
      document.getElementById("btn_supplier").style.display="none";
    }else{
      document.getElementById("inp_supplier_same").style.display="none";
      document.getElementById("btn_supplier").style.display="inline-block";
    }
    // alert(code);
  });

  $('#upd_supplier_code').on('keyup', function(){

   var code  = $('#upd_supplier_code').val().toUpperCase();
   var id = $('#supplier_id').val();
   var f=0;

   if(length_supplier > 0)
   {
    for(var i=0;i<length_supplier;i++)
    {
      if(code == data_supplier[i]['code'] && id!=data_supplier[i]['id'])
      {
        f++;
      }
    }
   }

   if(f > 0)
   {
    document.getElementById("upd_same_supplier").innerHTML = "Maaf, kod ini sudah didaftarkan. Sila masukkan kod berbeza.";
    document.getElementById("upd_same_supplier").style.display="block";
    document.getElementById("btn_upd_supplier").style.display="none";
   }else{
    document.getElementById("upd_same_supplier").style.display="none";
    document.getElementById("btn_upd_supplier").style.display="inline-block";
   }
   // alert(code);
  });

});

// category

var data_category  = <?php echo $data_category ?>;
var category_length = data_category.length;

$(document).ready(function(){

  $(document).on('click','a[data-role=editCategory]', function(){

   var cat_id  = $(this).data('id');
   var cat_name  = $(this).data('cat');
   var cat_code  = $(this).data('cat_code');

   // alert($(this).data('id'));
    $('#category_id').val(cat_id);
    $('#category_name').val(cat_name);
    $('#upd_category_code').val(cat_code);
    $('#modal_editCategory').modal("toggle");

  });

  $('#category_code').on('keyup', function(){

   var cat_code  = $('#category_code').val().toUpperCase();
   var f=0;

   if(category_length > 0)
   {
    for(var i=0;i<category_length;i++)

    {
      if(cat_code == data_category[i]['code'])
      {
        f++;
      }
    }
   }

   if(f > 0)
   {
    document.getElementById("inp_category_same").innerHTML = "Maaf, kod ini sudah didaftarkan. Sila masukkan kod berbeza.";
    document.getElementById("inp_category_same").style.display="block";
    document.getElementById("btn_category").style.display="none";
   }else{
    document.getElementById("inp_category_same").style.display="none";
    document.getElementById("btn_category").style.display="inline-block";
   }
   // alert(cat_code);
  });

  $('#upd_category_code').on('keyup', function(){

   var cat_code  = $('#upd_category_code').val().toUpperCase();
   var cat_id = $('#category_id').val();
   var f=0;

   if(category_length > 0)
   {
     for(var i=0;i<category_length;i++)
     {
       if(cat_code == data_category[i]['code'] && cat_id!=data_category[i]['id'])
       {
         f++;
       }
     }
   }

   if(f > 0)
   {
     document.getElementById("upd_same_category").innerHTML = "Maaf, kod ini sudah didaftarkan. Sila masukkan kod berbeza.";
     document.getElementById("upd_same_category").style.display="block";
     document.getElementById("btn_upd_category").style.display="none";
   }else{
     document.getElementById("upd_same_category").style.display="none";
     document.getElementById("btn_upd_category").style.display="inline-block";
   }
   // alert(cat_code);
  });

});

</script>

<script>

//delete category button confirmation
$('.category').on('click',function(e){
  e.preventDefault();
  var url = $(this).attr('href');

  Swal.fire({
    title: 'Padam Kategori?',
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

//delete dulang button confirmation
$('.dulang').on('click',function(e){
  e.preventDefault();
  var url = $(this).attr('href');

  Swal.fire({
    title: 'Padam Dulang?',
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

//delete supplier button confirmation
$('.supplier').on('click',function(e){
  e.preventDefault();
  var url = $(this).attr('href');

  Swal.fire({
    title: 'Padam Pembekal?',
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

  $('#addCat').one('submit', function() {
    document.getElementById("btn_category").disabled = true;
  });

  $('#updCat').one('submit', function() {
    document.getElementById("btn_upd_category").disabled = true;
  });

  $('#addDul').one('submit', function() {
    document.getElementById("btn_dulang").disabled = true;
  });

  $('#updDul').one('submit', function() {
    document.getElementById("btn_upd_dulang").disabled = true;
  });

  $('#addSup').one('submit', function() {
    document.getElementById("btn_supplier").disabled = true;
  });

  $('#updSup').one('submit', function() {
    document.getElementById("btn_upd_supplier").disabled = true;
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