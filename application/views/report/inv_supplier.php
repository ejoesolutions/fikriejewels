<?php echo $this->session->flashdata('upload'); ?>

<?php echo form_open('', array('class'=>'')) ?>

<div class="col-md-12 mb-4">
  <h4>Carian</h4>
  <div class="card shadow">
    <div class="card-body">

      <div class="form-group row justify-content-center">
        <label class="col-md-4 col-xl-2 col-form-label">Jenis Carian</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control text-center" id="carian" name="carian">
            <option value="" selected>---Pilih---</option>
            <option value="1">Tarikh</option>
            <option value="2">Bulanan</option>
          </select>
        </div>
      </div>

      <!-- carian tarikh -->
      <div id="byDateAfter" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tarikh ( Selepas )</label>
        <div class="col-md-5 col-xl-3">
          <input type="text" name="date_min" id="date_min" class="form-control drgpicker">
        </div>
      </div>

      <div id="byDateBefore" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tarikh ( Sebelum )</label>
        <div class="col-md-5 col-xl-3">
          <input type="text" name="date_max" id="date_max" class="form-control drgpicker">
        </div>
      </div>
      <!-- ./carian tarikh -->

      <!-- carian bulan -->
      <div id="byMonth" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Bulan</label>
        <input type="hidden" id="date_num" value="<?= date('m') ?>">
        <div class="col-md-5 col-xl-3">
          <select class="form-control text-center" name="date_month" id="date_month">
            <option value="00">---Pilih---</option>
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Mac</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Jun</option>
            <option value="07">Julai</option>
            <option value="08">Ogos</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Disember</option>
          </select>
        </div>
      </div>

      <div id="byYear" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tahun</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control text-center" name="date_year" id="date_year"></select>
        </div>
      </div>
      <!-- ./carian bulan -->

      <div class="form-group row justify-content-center mb-1" id="button">
        <label class="col-md-4 col-xl-2 col-form-label"></label>
        <div class="col-md-5 col-xl-3">
          <button type="submit" class="btn btn-block btn-primary btn-sm">Cari</button>
        </div>
      </div>

      <?= form_close(); ?>

      <!-- <?= form_open('report/print_supplier', array('target' => 'blank_')) ?>

        <?php if ($trigger == 1) { ?>
          <input type="hidden" name="carian" id="trigger" value="<?= $trigger ?>">
          <input type="hidden" name="date_min" id="tri_date_min" value="<?= $date_min ?>">
          <input type="hidden" name="date_max" id="tri_date_max" value="<?= $date_max ?>">
        <?php }elseif ($trigger == 2) { ?>
          <input type="hidden" name="carian" id="trigger" value="<?= $trigger ?>">
          <input type="hidden" name="date_month" id="tri_date_month" value="<?= $date_month ?>">
          <input type="hidden" name="date_year" id="tri_date_year" value="<?= $date_year ?>">
        <?php } ?>

        <div class="form-group row justify-content-center" id="button">
        <label class="col-md-4 col-xl-2 col-form-label"></label>
        <div class="col-md-5 col-xl-3">
          <div class="row mt-0">
            <div class="col-md-6 mt-1">
              <button type="submit" class="btn btn-block btn-danger btn-sm"><i class="fas fa-file-pdf"></i> Cetak PDF</button> 
            </div>
            <div class="col-md-6 mt-1">
              <a href="<?= base_url('report/inv_supplier') ?>" class="btn btn-block btn-info btn-sm"><i class="fe fe-refresh-cw"></i> Reset</a> 
            </div>
          </div>
        </div>
      </div>

      <?= form_close(); ?> -->

    </div>
  </div>
</div>

<hr>

<div class="col-md-12">
  <h4><span id="tableTitle">Invoice Supplier</span> <a class="" data-toggle="modal" href="#addInv"><button class="btn btn-primary">+</button></a>
  </h4>
  <div class="card shadow">
    <div class="card-body">
    <div class="table-responsive">
      <table class="table nowrap text-dark" id="example">
        <thead>
          <th width="10%" class="text-center">No.</th>
          <!-- <th class="text-center">Cawangan</th> -->
          <th class="text-center">Invoice No.</th>
          <th width="15%">Supplier</th>
          <th class="text-center">Total Berat (g)</th>
          <th class="text-center">Total Upah (RM)</th>
          <th class="text-center">Total (RM)</th>
          <th class="text-center">Tarikh</th>
          <th class="text-center">#</th>
        </thead>
        <tbody>
          <?php 

          if ($supplier) {

          $i = 1;

          foreach ($supplier as $key) { ?>
          <tr>
            <td class="text-center">
              <?= $i++ ?>
            </td>
            <!-- <td class="text-center">
              <?= $key['tag'] ?>
            </td> -->
            <td class="text-center">
              <?= $key['inv_no'] ?>
            </td>
            <td>
              <span class="d-inline-block text-truncate" style="max-width: 250px;">
                <?= $key['supplier_name'] ?>
              </span>
            </td>
            <td class="text-center">
              <?= $key['berat'] ?>
            </td>
            <td class="text-center">
              <?= $key['total_upah'] ?>
            </td>
            <td class="text-center">
              <?= $key['total'] ?>
            </td>
            <td class="text-center">
              <?= date('Y-m-d ', strtotime($key['tarikh'])) ?>
            </td>
            <td class="text-center">
              <a class="" href="#editInv" data-role="editsupplier"

                data-id="<?= $key['inv_id'] ?>"
                data-tarikh="<?= $key['tarikh'] ?>"
                data-per_gram="<?= $key['per_gram'] ?>"
                data-attach="<?= $key['attach'] ?>"
                data-note="<?= $key['note'] ?>"
                data-inv_no="<?= $key['inv_no'] ?>"
                data-supplier="<?= $key['supplier'] ?>"
                data-cawangan="<?= $key['cawangan_id'] ?>"
                data-berat="<?= $key['berat'] ?>"
                data-total_upah="<?= $key['total_upah'] ?>"
                data-total="<?= $key['total'] ?>"

                data-toggle="modal" title="Kemaskini"><span class="fe fe-edit fe-20"></span>
              </a>
              |  
              <a class="text-danger padam" href="<?php echo base_url('report/del_invoice/'.$key['id']) ?>" title="Padam"><span
                class="fe fe-trash fe-20"></span></a>
            </td>
          </tr>
          <?php }  }?>
        </tbody>
          <tfoot>
            <tr>
              <th></th>
              <th></th>
              <!-- <th></th> -->
              <th class="text-center"></th>
              <th class="text-center"></th>
              <th class="text-center"></th>
              <th class="text-center"></th>
              <th></th>
              <th></th>
            </tr>
          </tfoot>
      </table>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addInv" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Invoice Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body text-dark">

        <?= form_open_multipart('report/insert_invoice',array('class'=>'form-horizontal','id'=>'insertForm')) ?>

        <div class="row">
          <!-- <div class="col-md-12">
            <div class="form-group">
              <label class="control-label col-md-6"><span class="text-danger">*</span> Cawangan : </label>
              <div class="col-md-12">
                <select name="cawangan" class="form-control" required>
                  <option value="">-Pilih-</option>
                  <?php foreach ($cawangan as $key) {
                    echo '<option value="'.$key['id'].'">'.$key['name'].'</option>';
                  } ?>
                </select>
              </div>
            </div>
          </div> -->
          <input type="hidden" name="cawangan" value="1">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6"><span class="text-danger">*</span> Supplier : </label>
              <div class="col-md-12">
                <select name="supplier" class="form-control" required>
                  <option value="">-Pilih-</option>
                  <?php if ($list_supplier) {
                    foreach ($list_supplier as $key) {
                      echo '<option value="'.$key['id'].'">'.$key['supplier_name'].'</option>';
                  } } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6"><span class="text-danger">*</span> Tarikh : </label>
              <div class="col-md-12">
                <div class="input-group">
                  <input type="text" class="form-control drgpicker" name="tarikh" id="date-input1"
                    aria-describedby="button-addon2">
                  <div class="input-group-append">
                    <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6"><span class="text-danger">*</span> Invoice No. : </label>
              <div class="col-md-12">
                <input type="text" name="inv_no" class="form-control uppercase" required>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6"><span class="text-danger">*</span> Harga Berat per gram (RM) : </label>
              <div class="col-md-12">
                <input type="text" name="per_gram" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Attach Resit <small>(PDF / PNG / JPG)</small> : </label>
              <div class="col-md-12">
                <input type="file" name="attach" class="form-control">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Total Berat (g) : </label>
              <div class="col-md-12">
                <input type="text" name="berat" class="form-control uppercase">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Total Upah (RM): </label>
              <div class="col-md-12">
                <input type="text" name="total_upah" class="form-control uppercase">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Total (RM): </label>
              <div class="col-md-12">
                <input type="text" name="total" class="form-control uppercase">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label col-md-6">Nota: </label>
              <div class="col-md-12">
                <textarea class="form-control" name="note" rows="3"></textarea>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
        <button type="submit" id="btnInsert" class="btn btn-primary">Simpan</button>
      </div>

      <?= form_close() ?>

    </div>
  </div>
</div>

<div class="modal fade" id="editInv" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Kemaskini Invoice Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <?= form_open_multipart('report/edit_invoice',array('class'=>'form-horizontal','id'=>'updateForm')) ?>

        <div class="row">
          <!-- <div class="col-md-12">
            <div class="form-group">
              <label class="control-label col-md-6">Cawangan : </label>
              <div class="col-md-12">
                <select name="cawangan" class="form-control" id="getCawangan" required>
                  <option value="">-Pilih-</option>
                  <?php foreach ($cawangan as $key) {
                    echo '<option value="'.$key['id'].'">'.$key['name'].'</option>';
                  } ?>
                </select>
              </div>
            </div>
          </div> -->
          <!-- <input type="hidden" name="cawangan" value="1"> -->
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6"><span class="text-danger">*</span> Supplier : </label>
              <div class="col-md-12">
                <select name="supplier" id="getSupplier" class="form-control" required>
                  <option value="">-Pilih-</option>
                  <?php if ($list_supplier) {
                    foreach ($list_supplier as $key) {
                      echo '<option value="'.$key['id'].'">'.$key['supplier_name'].'</option>';
                  } } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Tarikh : </label>
              <div class="col-md-12">
                <div class="input-group">
                  <input type="text" class="form-control drgpicker" name="tarikh" id="getDate"
                    aria-describedby="button-addon2">
                  <div class="input-group-append">
                    <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Invoice No. : </label>
              <div class="col-md-12">
                <input type="text" id="get_inv_no" name="inv_no" class="form-control uppercase" required>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6"><span class="text-danger">*</span> Harga Berat per gram (RM) : </label>
              <div class="col-md-12">
                <input type="text" id="get_per_gram" name="per_gram" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Attach Resit : <a id="getAttach" href="" target="_blank">Lihat Resit</a></label>
              <div class="col-md-12">
                <input type="file" name="attach" class="form-control">
                <input type="hidden" id="get_attach" name="old_attach">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Total Berat (g) : </label>
              <div class="col-md-12">
                <input type="text" id="get_berat" name="berat" class="form-control uppercase">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Total Upah (RM): </label>
              <div class="col-md-12">
                <input type="text" id="get_total_upah" name="total_upah" class="form-control uppercase">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-md-6">Total (RM): </label>
              <div class="col-md-12">
                <input type="text" id="get_total" name="total" class="form-control uppercase">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label col-md-6">Nota: </label>
              <div class="col-md-12">
                <textarea class="form-control" id="get_note" name="note" rows="3"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
        <input type="hidden" id="get_id" name="inv_id">
        <input type="submit" id="btnUpdate" class="btn btn-primary" value="Kemaskini">
      </div>

      <?= form_close() ?>

    </div>
  </div>
</div>


<script>

  $(document).ready(function() {
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
        totalTotal = api
        .column( 5 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        totalBerat = api
        .column( 3 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        totalUpah = api
        .column( 4 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        // Total over this page
        pageTotalTotal = api
        .column( 5, { page: 'current'} )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        pageTotalBerat = api
        .column( 3, { page: 'current'} )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        pageTotalUpah = api
        .column( 4, { page: 'current'} )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        // Update footer
        $( api.column( 4 ).footer() ).html(
          pageTotalUpah.toFixed(2)
        );
        $( api.column( 3 ).footer() ).html(
          pageTotalBerat.toFixed(2)
        );
        $( api.column( 5 ).footer() ).html(
          pageTotalTotal.toFixed(2)
        );
      },
      dom: "<'row'<'col-md-5'l><'col-md-3 mb-3'B><'col-md-4'f>>" +
          "<'row'<'col-md-12'tr>>" +
          "<'row'<'col-md-5'i><'col-md-7'p>>",
      buttons: [
        {footer: true, extend: 'copy', className: 'btn btn-secondary', text: '<i class="fas fa-copy fa-lg" title="Copy"></i>', title: function () { return $('#tableTitle').html(); } },
        {footer: true, extend: 'excel', className: 'btn btn-warning text-white', text: '<i class="fas fa-file-excel fa-lg" title="Download Excel"></i>', title: function () { return $('#tableTitle').html(); } },
        {footer: true, extend: 'csv', className: 'btn btn-info', text: '<i class="fas fa-file-csv fa-lg" title="Download CSV"></i>', title: function () { return $('#tableTitle').html(); } },
        {footer: true, extend: 'pdf', className: 'btn btn-danger', text: '<i class="fas fa-file-pdf fa-lg" title="Download Pdf"></i>', title: function () { return $('#tableTitle').html(); } },
      ],
    } );
  });

  $("#carian").change(function () {

    var carian = $("#carian").val();

    if (carian == 1) {

      document.getElementById('byDateAfter').style.display = null;
      document.getElementById('byDateBefore').style.display = null;
      document.getElementById('button').style.display = null;
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";

    } else if (carian == 2) {

      document.getElementById('byYear').style.display = null;
      document.getElementById('byMonth').style.display = null;
      document.getElementById('button').style.display = null;
      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";

    } 

  });

  $(document).ready(function () {

    var month = $('#date_num').val();
    var currentYear = new Date().getFullYear();

    $('#date_month').val(month).trigger("change");

    for (var i = currentYear; i > currentYear - 7; i--) {
      $("#date_year").append('<option value="' + i.toString() + '">' + i.toString() + '</option>');
    }
  });

  $(document).ready(function () {

    var trigger = $('#trigger').val();
    var tri_date_min = $('#tri_date_min').val();
    var tri_date_max = $('#tri_date_max').val();
    var tri_date_month = $('#tri_date_month').val();
    var tri_date_year = $('#tri_date_year').val();

    getCawangan

    if (trigger == 1) {
      $('#carian').val(trigger).trigger("change");
      $('#date_min').val(tri_date_min);
      $('#date_max').val(tri_date_max);
      
      document.getElementById('byDateAfter').style.display = null;
      document.getElementById('byDateBefore').style.display = null;
      document.getElementById('button').style.display = null;      
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";   
    }

    if (trigger == 2) {
      $('#carian').val(trigger).trigger("change");
      $('#date_month').val(tri_date_month);
      $('#date_year').val(tri_date_year);
      
      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";
      document.getElementById('button').style.display = null;      
      document.getElementById('byYear').style.display = null;
      document.getElementById('byMonth').style.display = null;
    }
  });

  //delete category button confirmation
  $('.padam').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Invoice?',
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

  $(document).on('click','a[data-role=editsupplier]', function(){

    var id = $(this).data('id');
    var tarikh = $(this).data('tarikh');
    var inv_no = $(this).data('inv_no');
    var per_gram = $(this).data('per_gram');
    var attach = $(this).data('attach');
    var note = $(this).data('note');
    var cawangan = $(this).data('cawangan');
    var supplier = $(this).data('supplier');
    var berat = $(this).data('berat');
    var total_upah = $(this).data('total_upah');
    var total = $(this).data('total');

    $('#get_id').val(id);
    $('#get_inv_no').val(inv_no);
    $('#get_per_gram').val(per_gram);
    $('#get_note').val(note);
    $('#get_attach').val(attach);
    $('#get_berat').val(berat);
    $('#get_total_upah').val(total_upah);
    $('#get_total').val(total);
    $('#getDate').val(tarikh);

    var link = '<?= base_url('attach/') ?>' + attach;
    $('#getCawangan').val(cawangan).trigger("change");
    $('#getSupplier').val(supplier).trigger("change");
    $("#getAttach").attr("href", link);

  });

  $('#insertForm').one('submit', function() {
    $('#btnInsert').attr('disabled','disabled');
    $("#btnInsert").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

  $('#updateForm').one('submit', function() {
    $('#btnUpdate').attr('disabled','disabled');
    $("#btnUpdate").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

</script>
