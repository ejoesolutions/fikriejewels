<?= $this->session->flashdata('upload'); ?>

<?php if ($this->agent->is_mobile()) { ?>
  <div class="container text-center"><video width="50%" id="preview"></video></div>
<?php } ?>

<input type="hidden" id="text">

<div class="col-md-12 mb-4">
  <h4>Semak</h4>
  <div class="card shadow">
    <div class="card-body">
      <div class="form-group row justify-content-center">
        <div class="col-md-5 col-xl-4">
          <select class="custom-select select2" id="variants" name="variants">
            <option selected>--Pilih--</option>
            <?php
              if(!empty($check))
              {
                foreach ($check as $key) { ?>
                  <option value="<?php echo $key['v_sn'] ?>"><?= $key['v_sn'] ?></option>
                <?php }
              }
            ?>
          </select>
        </div>
      </div>
      <div class="form-group row justify-content-center mb-1" id="button">
      </div>
    </div>
  </div>
</div>

<hr>

<div class="col-md-12 mb-4">
  <div class="row">
    <div class="col-md-6">
      <h4 id="tableTitle"><?= $dulang ?></h4>
      <h5   class="text-primary">Tarikh Set Semula : <?= $reset ? date('d-m-Y', strtotime($reset)).' | '.date('h:i a', strtotime($reset)) : '-' ?></h5>
    </div>
    <div class="col-md-6">
      <a href="<?= base_url('report/add_check_stok/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/2') ?>" class="btn btn-danger float-right mb-2 set"><i class="fe fe-refresh-cw"></i> Set Semula</a>
    </div>
  </div>
  
  <div id="result">
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table nowrap text-dark" id="dataTable-1">
            <thead>
              <tr class="uppercase">
                <th nowrap class="text-center">No.</th>
                <th nowrap class="text-center">No.Siri</th>
                <th nowrap class="text-center">Produk</th>
                <th nowrap class="text-center">Berat (g)</th>
                <th nowrap class="text-center">Status</th>
                <th nowrap class="text-center">Disemak Oleh</th>
                <th nowrap class="text-center">Tarikh Semak</th>
              </tr>
            </thead>
            <tbody>

              <?php if(($check)):

              $i=1;

              foreach ($check as $row) { ?>

                <tr>
                  <td class="text-center"><?= $i++; ?></td>
                  <td class="text-center">
                    <a class="text-dark" title="Lihat Produk" href="<?= base_url('catalog/product_edit/'.$row['product_id']) ?>"><?= $row['v_sn']; ?></a>
                  </td>
                  <td class="text-center">
                    <a class="text-dark" title="Lihat Produk" href="<?= base_url('catalog/product_edit/'.$row['product_id']) ?>"><?= $row['product_name']; ?></a>
                  </td>
                  <td class="text-center"><?= $row['v_weight']; ?></td>
                  <td class="text-center">
                    <?php if ($row['status'] == 1) {
                      echo '<span class="text-success"><i class="fe fe-check-square fe-20"></i></span>';
                    } ?>
                  </td>
                  <td class="text-center"><?= $row['username']; ?></td>
                  <td class="text-center">
                    <?php if ($row['date_checked']) { ?>
                      <?= date('Y-m-d', strtotime($row['date_checked'])) ?> | <?= date('h:i a', strtotime($row['date_checked'])) ?>
                    <?php } ?>
                  </td>
                </tr>

              <?php }

              endif; ?>

            </tbody>
            <tfoot>
              <tr class="text-center">
                <th></th>
                <th></th>
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
  </div>
</div>

<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script>

let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false,continuous: true, backgroundScan: true, scanPeriod: 1});
scanner.addListener('scan', function (content) {
  console.log(content);

  $('#variants').select2();

  $search = document.getElementById("text").value = content;

  $('#variants').val($search).trigger("change");

});
Instascan.Camera.getCameras().then(function (cameras) {
  if (cameras.length > 0) {
    scanner.start(cameras[1]);
  } else {
    console.error('No cameras found.');
  }
}).catch(function (e) {
  console.error(e);
});

$(document).ready(function() {

  $('.select2').select2('open');
// $(".select2-search__field")[0].focus();


  $('#example').dataTable( {
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

  if (carian == 1)  {

    document.getElementById('byDateAfter').style.display = null;
    document.getElementById('byDateBefore').style.display = null;
    document.getElementById('byYear').style.display = "none";
    document.getElementById('byMonth').style.display = "none";

  }else if (carian == 2) {

    document.getElementById('byYear').style.display = null;
    document.getElementById('byMonth').style.display = null;
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


$(document).ready(function () {

  var trigger = $('#trigger').val();
  var tri_date_min = $('#tri_date_min').val();
  var tri_date_max = $('#tri_date_max').val();
  var tri_date_month = $('#tri_date_month').val();
  var tri_date_year = $('#tri_date_year').val();

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


$('#variants').on('change', function (e) {
  var variants = $('#variants').val();
  if(variants!=''){
    $.ajax({
      url: '<?= base_url(); ?>report/check_stok',
      type: 'POST',
      dataType: "text",  
      cache: false,
      data: { variants : variants, id : <?= $this->uri->segment(4) ?>, cawangan_id :  <?= $this->uri->segment(3) ?>},
      success: 
      function(data){
        $("#result").html(data)
      },
    });
  }

  if ($('#variants').val()) {
    Swal.fire({
      icon: 'success',
      title: '<h4>Produk Ada</h4>',
      showConfirmButton: false,
      timer: 1100
    })
  }else {
    Swal.fire({
      icon: 'error',
      title: '<h4>Produk Tiada</h4>',
      showConfirmButton: false,
      timer: 1100
    })
  }
  
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