<?php echo $this->session->flashdata('upload'); ?>

<div class="col-md-12 mb-4">
  <?php foreach ($cawangan as $caw) { ?>
    <h4 id="tableTitle">Check Stok</h4>
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table nowrap text-dark datatable">
              <thead>
                <tr class="uppercase">
                  <th nowrap class="text-center">Kod Dulang</th>
                  <th nowrap class="text-center">Dulang</th>
                  <th nowrap class="text-center">Jumlah Stok</th>
                  <th nowrap class="text-center">Disemak</th>
                  <th nowrap class="text-center">Tarikh Set Semula</th>
                  <th nowrap class="text-center">#</th>
                </tr>
              </thead>
              <tbody>


                <?php 
                
                $dulang = $this->report_model->get_by_dulang($caw['id']);
                
                if ($dulang) {

                  $i=1;

                  foreach ($dulang as $row) { ?>

                    <tr class="text-center">
                      <td><?= $row['dulang_code']; ?></td>
                      <td><?= $row['dulang_name'] ?></td>
                      <td>
                        <?= $this->report_model->get_stock_dulang($row['id'], $caw['id']) ?>
                      </td>
                      <td>
                        <?= $this->report_model->get_check_stok($row['id'], $caw['id']) ?>
                      </td>
                      <td class="text-center">
                        <?= $row['reset_at'] ? date('d-m-Y', strtotime($row['reset_at'])).' | '.date('h:i a', strtotime($row['reset_at'])) : '-' ?>
                      </td>
                      <td>
                        <a title="Semak" href="<?= base_url('report/check/'.$caw['id'].'/'.$row['id']) ?>"><i class="fe fe-search fe-20"></i></a>
                        |
                        <a class="set" title="Tambah / Set Semula" href="<?= base_url('report/add_check_stok/'.$caw['id'].'/'.$row['id'].'/1') ?>"><i class="text-danger fe fe-refresh-cw fe-20"></i></a>
                      </td>
                    </tr>
                <?php } } ?>

              </tbody> 
              <tfoot>
                <tr class="text-center">
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

</div>

<script>

$(document).ready(function() {
  $('.datatable').dataTable( {
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
        stok = api
        .column( 2 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        semak = api
        .column( 3 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        // Total over this page
        stokTotal = api
        .column( 2, { page: 'current'} )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        semakTotal = api
        .column( 3, { page: 'current'} )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        // Update footer
        $( api.column( 2 ).footer() ).html(
          stokTotal + '<br>( ' + stok + ' )'
        );

        $( api.column( 3 ).footer() ).html(
          semakTotal + '<br>( ' + semak + ' )'
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

//set semula button confirmation
$('.set').on('click', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');

  Swal.fire({
    title: 'Set Semula?',
    text: false,
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Set Semula',
    cancelButtonText: 'Tutup'
  }).then((result) => {
    if (result.value) {
      window.location.replace(url);
    }
  });
});

</script>