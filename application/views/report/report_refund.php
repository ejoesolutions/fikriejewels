<?php echo $this->session->flashdata('upload'); ?>

<div class="col-md-12">
  <h4 id="tableTitle">Batal Jualan</h4>
  <div class="card shadow">
    <div class="card-body">
    <div class="table-responsive">
      <table class="table nowrap text-dark" id="example">
        <thead>
          <th class="text-center">No.</th>
          <th>Produk</th>
          <!-- <th class="text-center">Cawangan</th> -->
          <th class="text-center">Harga Asal ( RM )</th>
          <th class="text-center">Bayar Balik ( RM )</th>
          <th class="text-center">Nota</th>
          <th class="text-center">Tarikh</th>
        </thead>
        <tbody>
          <?php 

          if ($refund) {

          $i = 1;

          foreach ($refund as $key) { ?>
            <tr>
              <td class="text-center"><?= $i++ ?></td>
              <td>
                <span class="d-inline-block text-truncate" style="max-width: 300px;">
                  <?= $key['product_name'] ?>
                </span>
                <br>
                <small><?= $key['v_sn'] ?></small>
              </td>
              <!-- <td class="text-center"><?= $key['tag'] ?></td> -->
              <td class="text-center"><?= $key['harga_jual'] ?></td>
              <td class="text-center"><?= $key['bayar_balik'] ?></td>
              <td class="text-center"><?= $key['nota'] ?></td>
              <td class="text-center">
                <?= date('d-m-Y ', strtotime($key['tarikh'])) ?>
                <br>
                <?= date('h:i a ', strtotime($key['tarikh'])) ?>
              </td>
            </tr>
          <?php }  }?>
        </tbody>
      </table>
    </div>
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

</script>