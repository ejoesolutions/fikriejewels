<?php echo $this->session->flashdata('upload'); ?>

<div class="col-md-12 mb-4">
  <h4 id="tableTitle">Variasi Dipadam</h4>

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="col-md-12">
      <div class="table-responsive">
        <table class="table nowrap" id="example">
          <thead>
            <tr class="uppercase">
              <th nowrap class="text-center">No.</th>
              <!-- <th nowrap class="text-center">Cawangan</th> -->
              <th nowrap class="text-center">No.Siri</th>
              <th nowrap class="text-center">Kod Jualan</th>
              <th nowrap class="text-center">Berat ( g )</th>
              <th nowrap class="text-center">Tarikh Masuk</th>
              <th nowrap class="text-center">Tarikh Padam</th>
              <th nowrap class="text-center">Nota</th>
            </tr>
          </thead>

          <tbody>

            <?php if($deleted): ?>

            <?php

            $i=1;

            foreach ($deleted as $row) { ?>

            <tr>
              <td class="text-center"><?= $i++; ?></td>
              <!-- <td class="text-center"><?= $row['tag']; ?></td> -->
              <td class="text-center">
                <?= $row['v_sn']; ?>
                <br>
                <small>id : <?= $row['variant_id']; ?></small>
              </td>
              <td class="text-center"><?= $row['v_kod']; ?></td>
              <td class="text-center"><?= $row['v_weight']; ?></td>
              <td class="text-center">
                <?= date("d-m-Y", strtotime($row['insert_date'])); ?>
                <br>
                <?= date("h:i a", strtotime($row['insert_date'])); ?>
              </td>
              <td class="text-center">
              <?php if ($row['delete_date']) {
                echo date("d-m-Y", strtotime($row['delete_date']))
                ."<br>"
                .date("h:i a", strtotime($row['delete_date']));
              } ?>
              </td>
              <td class="text-center"><?= $row['nota']; ?></td>
            </tr>

            <?php } ?>

            <?php endif; ?>

          </tbody>
      
        </table>
      </div>
      </div>
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
        $( api.column( 4 ).footer() ).html(
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
  } );
});


</script>