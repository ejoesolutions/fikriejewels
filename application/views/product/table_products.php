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
            <option value="3">Dulang / Pembekal</option>
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

      <div id="pembekal" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Pembekal</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control" name="pembekal">
            <option value="" selected>---Pilih---</option>
            <?php
            if(!empty($pembekal))
            {
              foreach ($pembekal as $key) { ?>
                <option value="<?php echo $key['id'] ?>"><?php echo $key['supplier_name'] ?></option>
              <?php }
            } 
            ?>
          </select>
        </div>
      </div>

      <div id="dulang" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Dulang</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control" name="dulang">
            <option value="" selected>---Pilih---</option>
            <?php
            if(!empty($dulang))
            {
              foreach ($dulang as $key) { ?>
                <option value="<?php echo $key['id'] ?>"><?php echo $key['dulang_name'] ?></option>
              <?php }
            }
            ?>
          </select>
        </div>
      </div>

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

<div class="col-md-12">
  <h4 class="page-title" id="tableTitle">Senarai Produk</h4>
  <div class="card shadow">
    <div class="card-body">
    <div class="table-responsive">
      <table class="table nowrap text-dark" id="example">
      <thead>
        <tr>
          <th class="text-center">No.</th>
          <th class="text-center">Gambar</th>
          <th>Nama Produk</th>
          <!-- <th class="text-center">Cawangan</th> -->
          <th class="text-center">Maklumat</th>
          <!-- <th class="text-center">Pembekal</th>
          <th class="text-center">Dulang</th> -->
          <th class="text-center">Stok</th>
          <th class="text-center">Keluar</th>
          <th class="text-center">Dijual</th>
          <th class="text-center">Jumlah</th>
          <th class="text-center">Tarikh</th>
          <th class="text-center" width="5%">#</th>
        </tr>
      </thead>

      <tbody>
        <?php if ($products): ?>

          <?php

          $i=1;

          foreach ($products as $row): ?>

            <tr>
              <td class="text-center"><?= $i++ ?></td>
              <td style="vertical-align: middle !important;width:150px;height:150px">
              <?php

              if ($row['product_image']) {

                // $info = pathinfo( $row['product_image'] );
                // $no_extension =  basename( $row['product_image'], '.'.$info['extension'] );
                // $thumb_image = $no_extension.'_thumb.'.$info['extension'];
                $image_properties = array(
                  'src'   => base_url().'images/thumbnail/'.$row['product_image'],
                  'class' => 'avatar-img',
                  'style' => 'height: 100%; width: 100%; object-fit: contain',
                );

                echo img($image_properties);

              } else {

                $image_properties = array(
                  'src'   => 'https://dummyimage.com/300x300/1C2833/9b9dad.jpg&text=No+Image',
                  'alt'   => 'No image',
                  'class' => 'avatar-img',
                  'title' => 'No image',
                  'width' => '100%'
                );

                echo img($image_properties);
              }

              ?>
              </td>
              <td>
                <a class="text-dark" href="<?= base_url('catalog/product_edit/'.$row["product_id"].'') ?>">
                  <span class="d-inline-block text-truncate" style="max-width: 300px;">
                    <?= $row['product_name'] ?>
                  </span>
                </a>
              </td>
              <!-- <td class="text-center">
                <span class="d-inline-block text-truncate" style="max-width: 300px;">
                  <?= $row['nama_cwgn'] ?>
                </span>
              </td> -->
              <td>
                <small class="mb-0">
                  Code : <?= $row['product_code']; ?>
                  <br>
                  Mutu : <?= $row['mutu_grade']; ?>
                  <br>
                  Kategori : <?= $row['category_name']; ?>
                  <br>
                  Pembekal : <?= $row['supplier_name']; ?>
                  <br>
                  Dulang : <?= $row['dulang_name']; ?>
                  <?php if ($row['description']) { ?>
                    <br>Keterangan : <br><?php echo $row['description']; ?>
                  <?php } ?>
                  <br>
                </small>
              </td>

              <!-- <td class="text-center">
                <?php echo $row['supplier_name'] ?><br>
                <small>[ <?php echo $row['supplier_code'] ?> ]</small>
              </td>
              <td class='text-center'>
                <?php echo $row['dulang_name'] ?><br>
                <small>[ <?php echo $row['dulang_code'] ?> ]</small>
              </td> -->

              <td class="text-center h5">
                <?php if ($row['stock']) {
                  echo $row['stock'];
                }else {
                  echo "0";
                } ?>
              </td>
              <td class="text-center h5" style="color:#eea303">
                <?php if ($row['out_stock']) {
                  echo $row['out_stock'];
                }else {
                  echo "0";
                } ?>
              </td>
              <td class="text-center h5" style="color:#1E8449">
                <?php if ($row['sold_stock']) {
                  echo $row['sold_stock'];
                }else {
                  echo "0";
                } ?>
              </td>
              <td class="text-center h5 text-primary">
                  <?php if ($row['all_stock'] < 1) {
                    echo "0";
                  }else {
                    echo $row['all_stock'];
                  } ?>
              </td>
              <td>
              <?= date('d-m-Y',strtotime($row['created_date'])) ?>
              </td>
              <td style="vertical-align: middle !important;" class="text-center">
                  <?php
                    // echo anchor('catalog/product_detail/'.$row['product_id'], '<span class="fe fe-search fe-20"></span>',array('title'=>'Lihat'));
                    echo anchor('catalog/product_edit/'.$row['product_id'], '<span class="fe fe-search fe-20"></span>',array('title'=>'Lihat'));
                    
                    // echo ' | '.anchor('catalog/product_delete/'.$row['product_id'], ' <span class="fe fe-trash fe-20 text-danger"></span>',array('title'=>'Hapus','onclick'=>"return confirm('Adakah anda pasti untuk hapus produk ini?')"));
                  ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>

      </tbody>
      <tfoot>
        <tr>
          <th colspan="4" style="text-align:right">JUMLAH : </th>
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

<script>

$(document).ready(function() {
    $('#example').DataTable( {
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
          stock = api
          .column( 4 )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          sold = api
          .column( 5 )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          total = api
          .column( 6 )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          total2 = api
          .column( 7 )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          // Total over this page
          pageStock = api
          .column( 4, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          pageSold = api
          .column( 5, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          pageTotal = api
          .column( 6, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          pageTotal2 = api
          .column( 7, { page: 'current'} )
          .data()
          .reduce( function (a, b) {
              return intVal(a) + intVal(b);
          }, 0 );

          // Update footer
          $( api.column( 4 ).footer() ).html(
            pageStock + '<br>( ' + stock + ' )'
          );

          $( api.column( 5 ).footer() ).html(
            pageSold + '<br>( ' + sold + ' )'
          );

          $( api.column( 6 ).footer() ).html(
            pageTotal + '<br>( ' + total + ' )'
          );

          $( api.column( 7 ).footer() ).html(
            pageTotal2 + '<br>( ' + total2 + ' )'
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
} );


$("#carian").change(function () {

  var carian = $("#carian").val();

  if (carian == 1)  {

    document.getElementById('byDateAfter').style.display = null;
    document.getElementById('byDateBefore').style.display = null;
    document.getElementById('pembekal').style.display = null;
    document.getElementById('button').style.display = null;      
    document.getElementById('dulang').style.display = null;      
    document.getElementById('byYear').style.display = "none";
    document.getElementById('byMonth').style.display = "none";

  }else if (carian == 2) {

    document.getElementById('byYear').style.display = null;
    document.getElementById('byMonth').style.display = null;
    document.getElementById('pembekal').style.display = null;
    document.getElementById('button').style.display = null;
    document.getElementById('dulang').style.display = null;      
    document.getElementById('byDateAfter').style.display = "none";
    document.getElementById('byDateBefore').style.display = "none";

  }else if (carian == 3) {

    document.getElementById('byYear').style.display = "none";
    document.getElementById('byMonth').style.display = "none";
    document.getElementById('pembekal').style.display = null;
    document.getElementById('button').style.display = null;
    document.getElementById('dulang').style.display = null;      
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

</script>