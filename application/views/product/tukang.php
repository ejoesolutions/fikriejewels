<?= form_open('', array('class'=>'')) ?>

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
            <!-- <option value="3">Status</option> -->
          </select>
        </div>
      </div>

      <!-- carian tarikh -->
      <div id="byDateAfter" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tarikh ( Selepas )</label>
        <div class="col-md-5 col-xl-3">
          <input type="text" name="date_min" class="form-control drgpicker">
        </div>
      </div>

      <div id="byDateBefore" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tarikh ( Sebelum )</label>
        <div class="col-md-5 col-xl-3">
          <input type="text" name="date_max" class="form-control drgpicker">
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

      <!-- <div id="status" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Status</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control text-center" name="status">
            <option value="" selected>---Pilih---</option>
            <option value="1">Kerat</option>
            <option value="2">Tambah</option>
          </select>
        </div>
      </div> -->

      <div class="form-group row justify-content-center" id="button" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label"></label>
        <div class="col-md-5 col-xl-3">
          <button type="submit" class="btn btn-block btn-primary">Cari</button>
        </div>
      </div>

    </div>
  </div>
</div>

<?= form_close(); ?>

<hr>

<!-- Small table -->
<div class="col-md-12">
    <h4 class="page-title" id="tableTitle"><?= $title ?></h4>
    <div class="card shadow">
        <div class="card-body">
            <!-- table -->
            <div class="table-responsive">
            <table class="table nowrap text-dark" id="example">
                <thead>
                  <tr class="uppercase">
                    <th nowrap class="text-center">No.</th>
                    <th nowrap class="text-center">Produk</th>
                    <th nowrap class="text-center">Cawangan</th>
                    <th class="text-center">Baki Berat ( g )</th>
                    <th class="text-center">Harga ( RM )</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Tarikh</th>
                  </tr>
                </thead>

                <tbody>

                <?php if(!empty($variants)): 

                $i=1;

                foreach ($variants as $row) {

                ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td class="text-center">
                          <?php echo $row['product_name'] ?><br>
                          <small> [ <?php echo $row['v_sn'] ?> ]</small>
                        </td>
                        <td class="text-center">
                          <?= $row['tag'] ?>
                        </td>
                        <td class="text-center">
                        <?php if ($row['v_status']!=6) { ?>
                            <?php echo $row['baki_berat'] ?>
                        <?php }else {
                            echo "-";
                        } ?>
                        </td>
                        <td class="text-center">
                        <?php if ($row['v_status']!=6) { ?>
                            <?php echo number_format($row['baki_berat'] * $row['setup_price'], 2, '.', ''); ?>
                            <br>
                            <small>[ <?php echo 'RM '.$row['setup_price'] ?> / g ]</small>
                        <?php }else{ 
                            echo "-";
                        } ?>
                            
                        </td>
                        <td class="text-center">
                            <?php if ($row['baki_berat'] > 0) {
                                echo "Kerat";
                            }elseif ($row['baki_berat'] < 0) {
                                echo "Tambah";
                            } ?>
                        </td>
                        <td class="text-center"><?php echo $row['tukang_date'] ?></td>
                    </tr>
                    <?php
                }
                
                endif; 

                ?>

                </tbody>
                <tfoot>
                    <tr>
                    <th></th>
                    <th colspan="2" style="text-align:right">JUMLAH : </th>
                    <th class="text-center"></th>
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
          .column( 3 )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          // Total over this page
          pageTotal = api
          .column( 3, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          // Update footer
          $( api.column( 3 ).footer() ).html(
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
        "order": [] 
    } );
} );

$("#carian").change(function () {

var carian = $("#carian").val();

if (carian == 1)  {

  document.getElementById('byDateAfter').style.display = null;
  document.getElementById('byDateBefore').style.display = null;
//   document.getElementById('status').style.display = null;
  document.getElementById('button').style.display = null;
  document.getElementById('byYear').style.display = "none";
  document.getElementById('byMonth').style.display = "none";

}else if (carian == 2) {

  document.getElementById('byYear').style.display = null;
  document.getElementById('byMonth').style.display = null;
//   document.getElementById('status').style.display = null;
  document.getElementById('button').style.display = null;      
  document.getElementById('byDateAfter').style.display = "none";
  document.getElementById('byDateBefore').style.display = "none";

}else if (carian == 3) {

  document.getElementById('byYear').style.display = "none";
  document.getElementById('byMonth').style.display = "none";
//   document.getElementById('status').style.display = null;
  document.getElementById('button').style.display = null;      
  document.getElementById('byDateAfter').style.display = "none";
  document.getElementById('byDateBefore').style.display = "none";

}
});

$(document).ready(function () {

 var month = $('#date_num').val();
 var currentYear = new Date().getFullYear();

 $('#date_month').val(month).trigger("change");

 for (var i = currentYear;i > currentYear - 7 ; i--)
 {
  $("#date_year").append('<option value="'+ i.toString() +'">' +i.toString() +'</option>');
 }
});

// $(document).ready(function () {

// var trigger = $('#trigger').val();
// var tri_status = $('#tri_status').val();
// var tri_date_min = $('#tri_date_min').val();
// var tri_date_max = $('#tri_date_max').val();
// var tri_date_month = $('#tri_date_month').val();
// var tri_date_year = $('#tri_date_year').val();

// if (trigger == 1) {
//   $('#carian').val(trigger).trigger("change");
//   $('#status').val(tri_status).trigger("change");
//   $('#date_min').val(tri_date_min);
//   $('#date_max').val(tri_date_max);
  
//   document.getElementById('byDateAfter').style.display = null;
//   document.getElementById('byDateBefore').style.display = null;
//   document.getElementById('button').style.display = null;      
//   document.getElementById('byYear').style.display = "none";
//   document.getElementById('byMonth').style.display = "none";
//   document.getElementById('status').style.display = null;    
// }

// if (trigger == 2) {
//   $('#carian').val(trigger).trigger("change");
//   $('#status').val(tri_status).trigger("change");
//   $('#date_month').val(tri_date_month);
//   $('#date_year').val(tri_date_year);
  
//   document.getElementById('byDateAfter').style.display = "none";
//   document.getElementById('byDateBefore').style.display = "none";
//   document.getElementById('button').style.display = null;      
//   document.getElementById('byYear').style.display = null;
//   document.getElementById('byMonth').style.display = null;
//   document.getElementById('status').style.display = null;    
// }
// });

</script>