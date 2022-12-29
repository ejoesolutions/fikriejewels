<?= $this->session->flashdata('upload'); ?>

<div class="col-md-12 mb-4">
  <h4>Carian</h4>
  <div class="card shadow">
    <div class="card-body">

      <div class="form-group row justify-content-center">
        <label class="col-md-4 col-xl-2 col-form-label">Jenis Carian</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control" id="choose">
            <option value="" selected>---Pilih---</option>
            <?php if ($user_profile['user_group'] == 0 || $user_profile['user_group'] == 1 || $user_profile['user_group'] == 3) { ?>
              <option value="4">Staf</option>
            <?php } ?>
            <option value="1">Tarikh</option>
            <option value="2">Bulanan</option>
            <option value="3">Kategori Sahaja</option>
            <option value="5">Cara Bayaran Sahaja</option>
          </select>
        </div>
      </div>

      <!-- carian cawangan -->
      <!-- <div id="byCawangan" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Cawangan</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control" id="cawangan">
            <option value="">---Pilih---</option>
            <?php foreach ($cawangan as $row) {
              echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            } ?>
          </select>
        </div>
      </div> -->

      <!-- carian staf -->
      <div class="form-group row justify-content-center" id="byStaf" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Staf</label>
        <div class="col-md-5 col-xl-3">
          <select id="staf_id" class="form-control">
            <option value="">---Pilih---</option>
            <?php foreach ($staf as $key) {
              echo '<option value="'.$key['id'].'">'.$key['full_name'].'</option>';
            } ?>
          </select>
        </div>
      </div>

      <!-- carian tarikh -->
      <div id="byDateAfter" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tarikh ( Selepas )</label>
        <div class="col-md-5 col-xl-3">
          <input type="text" id="dateStart" class="form-control drgpicker">
        </div>
      </div>

      <div id="byDateBefore" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tarikh ( Sebelum )</label>
        <div class="col-md-5 col-xl-3">
          <input type="text" id="dateEnd" class="form-control drgpicker">
        </div>
      </div>
      <!-- ./carian tarikh -->

      <!-- carian bulan -->
      <div id="byMonth" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Bulan</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control" id="months">
            <option value="">---Pilih---</option>
            <?php foreach ($month as $row) {
              echo '<option value="'.$row['month_value'].'">'.$row['month_name'].'</option>';
            } ?>
          </select>
        </div>
      </div>

      <div id="byYear" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tahun</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control" id="years"></select>
        </div>
      </div>
      <!-- ./carian bulan -->

      <div id="byCategory" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Kategori</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control" id="category">
            <option value="" selected>---Pilih---</option>
            <option value="Bayaran Pesanan">Bayaran Pesanan</option>
            <option value="Bayaran Belian">Bayaran Belian</option>
            <option value="Bayar Tempahan Baiki">Bayar Tempahan Baiki</option>
            <option value="Deposit Tempahan Kedai">Deposit Tempahan Kedai</option>
            <option value="Deposit Keluar">Deposit Keluar</option>
            <option value="Deposit Tempahan Baru">Deposit Tempahan Baru</option>
            <option value="Deposit Tempahan Baiki">Deposit Tempahan Baiki</option>
            <option value="Cash In">Cash In</option>
            <option value="Cash Out">Cash Out</option>
            <option value="Expenses">Expenses</option>
          </select>
        </div>
      </div>

      <div id="byCara" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Cara Bayaran</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control" id="cara_bayaran">
            <option value="" selected>---Pilih---</option>
            <option value="1">Tunai</option>
            <option value="2">Bank In</option>
            <option value="3">Debit/Credit</option>
          </select>
        </div>
      </div>

      <div class="form-group row justify-content-center mb-1" id="button">
        <label class="col-md-4 col-xl-2 col-form-label"></label>
        <div class="col-md-5 col-xl-3">
          <button type="submit" id="searchButton" class="btn btn-block btn-primary btn-sm">Cari</button>
          <a href="" class="btn btn-block btn-danger btn-sm">Set Semula</a>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>

<div class="col-md-12">
  <h4 id="tableTitle">Senarai Transaksi</h4>
  <div class="card shadow">
    <div class="card-body">
      <div class="table-responsive container-fluid">
        <table class="table nowrap text-dark" id="queryTable">
          <thead>
            <th class="text-center">No.</th>
            <th width="250px">Pelanggan</th>
            <th class="text-center">Staf</th>
            <!-- <th class="text-center">Cawangan</th> -->
            <th class="text-center">Kategori</th>
            <th class="text-center">Cara Bayaran</th>
            <th class="text-center">Bayaran ( RM )</th>
            <th class="text-center">Tarikh Bayaran</th>
            <th class="text-center">Maklumat Transaksi</th>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center"></th>
              <th class="text-center"></th>
              <th class="text-center"></th>
              <th class="text-center"></th>
              <th style="text-align:right">JUMLAH :</th>
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


<script>

$(document).ready(function(){

  //load table auto
  trans_table();

  function trans_table() {

    $('#queryTable').dataTable({
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
        .column(5)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Total over this page
      pageTotal = api
        .column(5, {
          page: 'current'
        })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(5).footer()).html(
        RoundNum(pageTotal, 2)
      );
    },
      aLengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      // Processing indicator
      "processing": true,
      // DataTables server-side processing mode
      "serverSide": true,
      // Initial no order.
      "order": [],
      // Load data from an Ajax source
      "ajax": {
        url : "<?= base_url('report/query_report'); ?>",
        data: { 
          choose : $("#choose").val(), 
          cawangan : $("#cawangan").val(), 
          dateStart : $("#dateStart").val(), 
          dateEnd : $("#dateEnd").val(), 
          months : $("#months").val(), 
          years : $("#years").val(), 
          staf_id : $("#staf_id").val(),
          category : $("#category").val(),
          cara_bayaran : $("#cara_bayaran").val(),
        },
        type : "POST",
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
      //Set column definition initialisation properties
      "columnDefs": [
        { "className": "text-center", "targets": [0], "orderable": true },
        { "className": "", "targets": [1], "orderable": true },
        { "className": "text-center", "targets": [2], "orderable": true },
        { "className": "text-center", "targets": [3], "orderable": true },
        { "className": "text-center", "targets": [4], "orderable": true },
        { "className": "text-center", "targets": [5], "orderable": true },
        { "className": "text-center", "targets": [6], "orderable": true },
        { "className": "text-center", "targets": [7], "orderable": false },
      ]
    });
  }


  $("#searchButton").click(function() { 

    $('#queryTable').DataTable().destroy();

    trans_table();
  });

});

  $("#choose").change(function () {

    var choose = $("#choose").val();

    if (choose == 1)  {

      // document.getElementById('byCawangan').style.display = null;
      document.getElementById('byDateAfter').style.display = null;
      document.getElementById('byDateBefore').style.display = null;
      document.getElementById('byCategory').style.display = null;
      document.getElementById('button').style.display = null;      
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";
      document.getElementById('byStaf').style.display = "none";
      document.getElementById('byCara').style.display = null;

    }else if (choose == 2) {

      // document.getElementById('byCawangan').style.display = null;
      document.getElementById('byYear').style.display = null;
      document.getElementById('byMonth').style.display = null;
      document.getElementById('byCategory').style.display = null;
      document.getElementById('button').style.display = null;
      document.getElementById('byStaf').style.display = "none";
      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";
      document.getElementById('byCara').style.display = null;

    }else if (choose == 3) {

      // document.getElementById('byCawangan').style.display = null;
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";
      document.getElementById('byCategory').style.display = null;
      document.getElementById('button').style.display = null;
      document.getElementById('byStaf').style.display = "none";
      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";
      document.getElementById('byCara').style.display = "none";

    }else if (choose == 4) {

      // document.getElementById('byCawangan').style.display = null;
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";
      document.getElementById('byCategory').style.display = null;
      document.getElementById('button').style.display = null;
      document.getElementById('byStaf').style.display = null;
      document.getElementById('byDateAfter').style.display = null;
      document.getElementById('byDateBefore').style.display = null;
      document.getElementById('byCara').style.display = null;

    }else if (choose == 5) {

      // document.getElementById('byCawangan').style.display = null;
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";
      document.getElementById('byCategory').style.display = "none";
      document.getElementById('button').style.display = null;
      document.getElementById('byStaf').style.display = "none";
      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";
      document.getElementById('byCara').style.display = null;
      
    }
  });

  $(document).ready(function () {

    var currentYear = new Date().getFullYear();

    $('#months').val('<?= date('m') ?>').trigger("change");

    for (var i = currentYear;i > currentYear - 7 ; i--)
    {
      $("#years").append('<option value="'+ i.toString() +'">' +i.toString() +'</option>');
    }
  });

</script>