<?= $this->session->flashdata('upload'); ?>
<h4 class="page-title"><?= $title ?></h4>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 margin-top-20">
        
    <div class="table-responsive">
      <table class="table nowrap table-bordered">
        <thead>
          <tr class="text-dark">
            <th nowrap colspan="3" class="text-center text-dark">Harga Kapital Emas / Perak</th>
            <!-- <th nowrap class="text-center text-dark" rowspan="2">Serial Berat ( g )</th> -->
            <th nowrap class="text-center text-dark">Harga ( RM )</th>
            <th nowrap class="text-center text-dark" rowspan="2">#</th>
          </tr>
          <tr>
            <th nowrap class="text-center text-dark">Bil</th>
            <th nowrap class="text-center text-dark">Mutu</th>
            <th nowrap class="text-center text-dark">Karat</th>
            <th nowrap class="text-center text-dark">Gram</th>
            <!-- <th nowrap class="text-center text-dark">Serial Berat</th> -->
          </tr>
        </thead>
        <tbody>

          <?php

          $n=1;

          if(!empty($capital))
          {
            foreach ($capital as $key) { ?>

              <tr>
                <td class="text-center"><?= $n++ ?></td>
                <td class="text-center"><?= $key['mutu'] ?></td>
                <td class="text-center"><?= $key['karat'] ?></td>
                <!-- <td class="text-center"><?= $key['base_weight'] ?></td> -->
                <td class="text-center"><?= $key['setup_price'] ?></td>
                <!-- <td class="text-center"><?= $key['serial_berat'] ?></td> -->
                <td class="text-center" colspan="2"><a href='#' data-role="btn_edit_capital" data-id="<?= $key['row_id']?>" data-weight="<?= $key['base_weight']?>" data-sb_price="<?= $key['serial_berat']?>" data-mutu="<?= $key['mutu'] ?>" data-price="<?= $key['setup_price'] ?>" data-toggle="modal"><i class="fe fe-edit fe-20"></i></a></td>
              </tr>

              <?php
            }
          } ?>

        </tbody>
      </table>
    </div>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_edit_capital" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Kemaskini Harga Kapital</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <?= form_open('catalog/update_capital', array('class'=>'')); ?>

      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="control-label col-md-4">Mutu :</label>
            <div class="col-md-12">
              <input type="hidden" name="capital_id" id="captal_id">
              <input type="text" name="mutu" id="mutu" class="form-control" readonly>
            </div>
          </div>
          
          <!-- <div class="form-group px-3">
            <label for="custom-select">Harga mengikut :</label>
            <select class="form-control" id="method-select" name="select">
              <option selected>--Pilih--</option>
              <option value="1">Serial Berat</option>
              <option value="2">Per Gram</option>
            </select>
          </div> -->

          <div class="form-group" id="sb_price_form" style="display:none">
            <label class="control-label col-md-5">Serial Berat ( RM ) :</label>
            <div class="col-md-12 ">
              <input type="text" name="sb_price" id="sb_price" class="form-control" required>
            </div>
          </div>

          <div class="form-group" id="per_gram_form">
            <label class="control-label col-md-5">Harga ( RM ) :</label>
            <div class="col-md-12 ">
              <input type="text" name="price" id="price" class="form-control" required>
            </div>
          </div>
          <input type="hidden" name="base_weight" id="base_weight" class="form-control" required>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>

      <?= form_close() ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<script>

$(document).ready(function(){

  $(document).on('click','a[data-role=btn_edit_capital]', function(){

   var capital_id  = $(this).data('id');
   var mutu  = $(this).data('mutu');
   var price  = $(this).data('price');
   var weight  = $(this).data('weight');
   var weight  = $(this).data('weight');
   var sb_price  = $(this).data('sb_price');

   // alert($(this).data('id'));

    $('#captal_id').val(capital_id);
    $('#mutu').val(mutu);
    $('#price').val(price);
    $('#base_weight').val(weight);
    $('#sb_price').val(sb_price);
    $('#modal_edit_capital').modal("toggle");

  });

  $("#method-select").change(function(){

    var method = $( "#method-select" ).val();

    if (method == 1) {
      document.getElementById("per_gram_form").style.display="none";  
      document.getElementById("sb_price_form").style.display="block";  
    }else{
      document.getElementById("per_gram_form").style.display="block";  
      document.getElementById("sb_price_form").style.display="none";  
    }

  });

  $(document).on('click','a[data-role=btn_edit_parameter]', function(){

   var parameter_id  = $(this).data('id');
   $.ajax({
      url: '<?= site_url();?>catalog/ajax_edit_parameter',
      type: 'POST',
      dataType: 'json',
      data: {parameter_id:parameter_id},

      success:function(r)
      {
        // alert(JSON.stringify(r));
        $('#parameter_id').val(r.parameter_id);
        $('#pakej_id').val(r.pakej_id);
        $('#pakej_name').val(r.pakej_name);
        $('#upah').val(r.upah);
        $('#unit_measure').val(r.unit_measure);
        $('#margin').val(r.margin);
        $('#ejen').val(r.ejen);
        $('#ahli').val(r.ahli);
        $('#komisyen').val(r.komisyen);
        $('#mutu_sel').val(r.mutu_id);
        // alert(r.mutu_id);
        $('#modal_edit_parameter').modal("toggle");
      }
    });
  });
});

</script>

