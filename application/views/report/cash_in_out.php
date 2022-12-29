<?= $this->session->flashdata('upload'); ?>

<?= form_open('', array('id'=>'')) ?>

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
            <option value="3">Kategori Sahaja</option>
          </select>
        </div>
      </div>

      <!-- carian staf -->
      <div class="form-group row justify-content-center" id="byStaf" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Staf</label>
          <div class="col-md-5 col-xl-3">
            <select name="staf_id" id="staf_id" class="form-control">
              <option value="">---Pilih---</option>
              <?php if(!empty($staf)) {
                foreach ($staf as $key) { ?>
                  <option value="<?php echo $key['id'] ?>"><?php echo $key['full_name'] ?></option>
              <?php } } ?>
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

      <div id="byKategori" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Kategori</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control text-center" id="kategori" name="kategori">
            <option value="" selected>---Pilih---</option>
            <option value="1">Cash In</option>
            <option value="2">Cash Out</option>
            <option value="3">Expenses</option>
            <option value="4">Cash In Hand</option>
          </select>
        </div>
      </div>

      <div class="form-group row justify-content-center mb-1" id="button">
        <label class="col-md-4 col-xl-2 col-form-label"></label>
        <div class="col-md-5 col-xl-3">
          <button type="submit" class="btn btn-block btn-primary btn-sm">Cari</button>
        </div>
      </div>

      <?= form_close(); ?>

    </div>
  </div>
</div>

<hr>

<div class="col-md-12">
  <h4  id="tableTitle">Cash In / Cash Out <a class="" data-toggle="modal" href="#addCash"><button class="btn btn-primary">+</button></a>
  </h4>
  <div class="card shadow">
    <div class="card-body">
    <div class="table-responsive">
      <table class="table nowrap text-dark" id="example">
        <thead>
          <th class="text-center">No.</th>
          <th class="text-center">Staf</th>
          <th class="text-center">Kategori</th>
          <th class="text-center">Jumlah ( RM )</th>
          <th class="text-center">Perincian</th>
          <th class="text-center">Tarikh</th>
          <th class="text-center">Nota</th>
          <th class="text-center">#</th>
        </thead>
        <tbody>
          <?php 

          if ($cash) {

          $i = 1;

          foreach ($cash as $key) { ?>
          <tr>
            <td class="text-center"><?= $i++ ?></td>
            <td class="text-center">
              <?= $key['username'] ?>
              <!-- <br>
              <?= $key['tag'] ?> -->
            </td>
            <td class="text-center">
              <?php if ($key['category'] ==  1) {
                  echo "Cash In";
                }elseif ($key['category'] ==  2) {
                  echo "Cash Out";
                }elseif ($key['category'] ==  3) {
                  echo "Expenses";
                }elseif ($key['category'] ==  4) {
                  echo "Transaksi";
                } ?>
            </td>
            <td class="text-center"><?= $key['total'] ?></td>
            <td class="text-center">
            <?php if ($key['buy_id']) { 
              echo '<a href="'.base_url('buy/buy_detail/'.$key['buy_id']).'">'.$key['perincian'].'</a>';
            }elseif ($key['order_id']) {
              echo '<a href="'.base_url('orders/detail/'.$key['order_id']).'">'.$key['perincian'].'</a>';
            }elseif ($key['v_id'] && $key['status']==3) {
              echo '<a href="'.base_url('booking/tempahan_detail/'.$key['v_id']).'">'.$key['perincian'].'</a>';
            }elseif ($key['v_id'] && $key['status']==4) {
              echo '<a href="'.base_url('catalog/print_keluar/'.$key['v_id']).'">'.$key['perincian'].'</a>';
            }elseif ($key['v_id'] && $key['status']==5) {
              echo '<a href="'.base_url('booking/booking_detail/'.$key['v_id']).'">'.$key['perincian'].'</a>';
            }elseif ($key['v_id'] && $key['status']==6) {
              echo '<a href="'.base_url('booking/repair_detail/'.$key['v_id']).'">'.$key['perincian'].'</a>';
            } ?>
            <br>
            <?php if ($key['cara_bayaran']==1) {
              echo "( tunai )";
            }elseif ($key['cara_bayaran']==2) {
              echo "( bank in )";
            }elseif ($key['cara_bayaran']==3) {
              echo "( card debit / credit )";
            } ?>
            </td>
            <td class="text-center">
              <?= date('Y-m-d ', strtotime($key['tarikh'])) ?>
              <br>
              <?= date('h:i a ', strtotime($key['tarikh'])) ?>
            </td>
            <td class="text-center"><?= $key['note'] ?></td>
            <td class="text-center">
              <a class="" href='#' data-role="editCategory" data-id="<?php echo $key['c_id'] ?>"
                data-cat="<?php echo $key['category'] ?>" data-total="<?php echo $key['total'] ?>"
                data-note="<?php echo $key['note'] ?>" data-toggle="modal" title="Kemaskini"><span
                  class="fe fe-edit fe-20"></span></a>
              <?php if ($user_profile['user_group'] == 0 || $user_profile['user_group'] == 1 || $user_profile['user_group'] == -1) { ?>
                | <a class="text-danger cash" href="<?php echo base_url('report/del_cash_in/'.$key['id']) ?>" title="Padam"><span class="fe fe-trash fe-20"></span></a>
              <?php } ?>
              
              
            </td>
          </tr>
          <?php }  }?>
        </tbody>
        <tfoot>
          <tr>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th style="text-align:right">JUMLAH : </th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
          </tr>
        </tfoot>
      </table>
    </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addCash" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Cash In / Out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <?= form_open('report/insert_cash_admin',array('class'=>'form-horizontal','id'=>'cashInOut')) ?>

        <div class="form-group">
          <label class="control-label col-md-4 pl-0">Kategori : </label>
          <select name="category" id="category" class="form-control" required>
            <option value="" selected>-Pilih-</option>
            <?php if ($user_profile['user_group'] == 0 || $user_profile['user_group'] == 1 || $user_profile['user_group'] == 3) { ?>
              <option value="1">Cash In</option>
              <option value="3">Expenses</option>
            <?php }elseif ($user_profile['user_group'] == 2) { ?>
              <option value="2">Cash Out</option>
            <?php } ?>
          </select>
        </div>

        <div id="setCaw"></div>

        <div class="form-group" id="list_staf" style="display:none">
          <label class="control-label col-md-4 pl-0">Staf : </label>
          <select name="staf_id" id="staf_id" class="form-control">
            <option value="">-Pilih-</option>
            <?php
            if(!empty($staf))
            {
              foreach ($staf as $key) { ?>
              <option value="<?php echo $key['id'] ?>"><?php echo $key['full_name'] ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>

        <!-- <div class="form-group" id="id_form" > -->
        <input type="hidden" id="id_form" name="staf_id" style="display:none" value="<?= $user_profile['user_id'] ?>">
        <!-- </div> -->

        <div class="form-group">
          <label class="control-label col-md-4 pl-0">Jumlah ( RM ) : </label>
          <input type="text" class="form-control" name="jumlah" required>
          </select>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 pl-0">Nota : </label>
          <input type="text" class="form-control" name="note">
          </select>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
        <button type="submit" id="btnCashInOut" class="btn btn-primary">Simpan</button>
      </div>

      <?= form_close() ?>

    </div>
  </div>
</div>

<div class="modal fade" id="modal_editCategory" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Kemaskini <span id="title"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <?= form_open('report/update_cash_admin',array('class'=>'form-horizontal','id'=>'')) ?>

        <input type="hidden" id="upd_id" name="id">
        <input type="hidden" id="upd_category" name="category">

        <div class="form-group">
          <label class="control-label col-md-4 pl-0">Jumlah ( RM ) : </label>
          <input type="text" class="form-control" name="upd_total" id="upd_total" <?php if ($user_profile['user_group'] == 2 || $user_profile['user_group'] == 3) { echo "readonly"; } ?>>
        </div>
        <div class="form-group">
          <label class="control-label col-md-4 pl-0">Nota : </label>
          <input type="text" class="form-control" name="upd_note" id="upd_note">
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
        <input type="submit" onclick="this.disabled=true;this.value='Sila Tunggu';this.form.submit();" id="btn_category" class="btn btn-primary" value="Simpan">
      </div>

      <?= form_close() ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#example').DataTable({
      "footerCallback": function (row, data, start, end, display) {
        var api = this.api(),
          data;

        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === 'string' ?
            i.replace(/[\$,]/g, '') * 1 :
            typeof i === 'number' ?
            i : 0;
        };

        // Total over all pages
        total = api
          .column(3)
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Total over this page
        pageTotal = api
          .column(3, {
            page: 'current'
          })
          .data()
          .reduce(function (a, b) {
            return intVal(a) + intVal(b);
          }, 0);

        // Update footer
        $(api.column(3).footer()).html(
          pageTotal.toFixed(2) + '<br>( ' + total.toFixed(2) + ' )'
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
    });
  });


  $("#carian").change(function () {

    var carian = $("#carian").val();

    if (carian == 1) {

      document.getElementById('byDateAfter').style.display = null;
      document.getElementById('byDateBefore').style.display = null;
      document.getElementById('button').style.display = null;
      document.getElementById('byKategori').style.display = null;
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";
      document.getElementById('byStaf').style.display = null;

    } else if (carian == 2) {

      document.getElementById('byYear').style.display = null;
      document.getElementById('byMonth').style.display = null;
      document.getElementById('button').style.display = null;
      document.getElementById('byKategori').style.display = null;
      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";
      document.getElementById('byStaf').style.display = null;

    } else if (carian == 3) {

      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";
      document.getElementById('button').style.display = null;
      document.getElementById('byKategori').style.display = null;
      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";
      document.getElementById('byStaf').style.display = null;

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

  $("#category").change(function () {

    var category = $("#category").val();

    if (category == 2) {

      document.getElementById('id_form').style.display = null;
      document.getElementById('list_staf').style.display = "none";
      $('#staf_id').attr('disabled', 'disabled');
      $("#id_form").removeAttr("disabled");
      $("#setCawSet").remove();

    } else if (category == 3) {

      document.getElementById('id_form').style.display = null;
      document.getElementById('list_staf').style.display = "none";
      $('#staf_id').attr('disabled', 'disabled');
      $("#id_form").removeAttr("disabled");
      $("#setCaw").append('<div id="setCawSet"><div class="form-group"><label>Cawangan</label><select name="cawangan" class="form-control" required><option value="">-Pilih-</option><?php foreach ($cawangan as $key) { echo '<option value="'.$key['id'].'">'.$key['name'].'</option>'; } ?></select></div></div>');

    } else if (category == 1) {

      document.getElementById('list_staf').style.display = null;
      document.getElementById('id_form').style.display = "none";
      $('#id_form').attr('disabled', 'disabled');
      $("#staf_id").removeAttr("disabled");
      $("#setCawSet").remove();

    }
  });

  $(document).on('click','a[data-role=editCategory]', function(){

    var id  = $(this).data('id');
    var category  = $(this).data('cat');
    var total  = $(this).data('total');
    var note  = $(this).data('note');

    if (category == 1) {
      $keterangan = "Cash In"
    }
    
    if (category == 2) {
      $keterangan = "Cash Out"
    }

    if (category == 3) {
      $keterangan = "Expenses"
    }

    if (category == 4) {
      $keterangan = "Transaksi"
    }
    
    $('#upd_id').val(id);
    $('#upd_total').val(total);
    $('#upd_note').val(note);
    $('#upd_category').val(category);
    $("#title").text($keterangan);
    $('#modal_editCategory').modal("toggle");

  });

  $(document).ready(function () {

    var trigger = $('#trigger').val();
    var tri_date_min = $('#tri_date_min').val();
    var tri_date_max = $('#tri_date_max').val();
    var tri_date_month = $('#tri_date_month').val();
    var tri_date_year = $('#tri_date_year').val();
    var tri_kategori = $('#tri_kategori').val();
    var tri_get_staf = $('#tri_get_staf').val();

    if (trigger == 1) {
      $('#carian').val(trigger).trigger("change");
      $('#date_min').val(tri_date_min);
      $('#date_max').val(tri_date_max);
      $('#kategori').val(tri_kategori);
      $('#staf_id').val(tri_get_staf);
      
      document.getElementById('byDateAfter').style.display = null;
      document.getElementById('byDateBefore').style.display = null;
      document.getElementById('button').style.display = null;      
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";
      document.getElementById('byKategori').style.display = null;
      document.getElementById('byStaf').style.display = null;
    }

    if (trigger == 2) {
      $('#carian').val(trigger).trigger("change");
      $('#date_month').val(tri_date_month);
      $('#date_year').val(tri_date_year);
      $('#kategori').val(tri_kategori);
      $('#staf_id').val(tri_get_staf);

      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";
      document.getElementById('button').style.display = null;      
      document.getElementById('byYear').style.display = null;
      document.getElementById('byMonth').style.display = null;
      document.getElementById('byKategori').style.display = null;
      document.getElementById('byStaf').style.display = null;
    }

    if (trigger == 3) {
      $('#carian').val(trigger).trigger("change");
      $('#kategori').val(tri_kategori);
      $('#staf_id').val(tri_get_staf);
      
      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";
      document.getElementById('button').style.display = null;      
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";
      document.getElementById('byKategori').style.display = null;
      document.getElementById('byStaf').style.display = null;
    }
  });

  //delete category button confirmation
  $('.cash').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam ?',
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

  $('#cashInOut').one('submit', function() {
    $('#btnCashInOut').attr('disabled','disabled');
    $("#btnCashInOut").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });
</script>