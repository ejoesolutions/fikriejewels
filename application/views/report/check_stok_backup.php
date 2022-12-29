<?php echo $this->session->flashdata('upload'); ?>

<!-- <?php echo form_open('', array('class'=>'')) ?> -->

<div class="col-md-12 mb-4">
  <h4>Carian</h4>
  <div class="card shadow">
    <div class="card-body">
      <div class="form-group row justify-content-center">
        <div class="col-md-5 col-xl-4">
          <select class="custom-select select2" id="add_order" name="variants">
            <option selected>--Pilih--</option>
            <?php
              if(!empty($variants))
              {
                foreach ($variants as $key) { ?>
                  <option 

                  value="<?php echo $key['v_sn'] ?>"
                  data-v_id="<?php echo $key['variant_id'] ?>"
                  data-sn="<?php echo $key['v_sn'] ?>"

                  ><?= $key['v_sn'] ?></option>
                <?php }
              }
            ?>
          </select>
        </div>
      </div>
      <div class="form-group row justify-content-center mb-1" id="button">
        <div class="col-md-5 col-xl-4">
          <button type="submit" id="semak" class="btn btn-block btn-primary">Semak</button>
        </div>
      </div>
      <!-- <?php  echo form_close(); ?> -->
    </div>
  </div>
</div>

<hr>

<div class="col-md-12 mb-4">
  <h4>Check Stok In Hand</h4>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="col-md-12">
      <div class="table-responsive">
        <table class="table nowrap" id="example">
          <thead>
            <tr class="uppercase">
              <th nowrap class="text-center">Bil</th>
              <th nowrap class="text-center">No.Siri</th>
              <!-- <th nowrap class="text-center">Produk</th> -->
              <th nowrap class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>

            <?php if(($variants)):

            $i=1;

            foreach ($variants as $row) { ?>

              <tr>
                <td class="text-center"><?php echo $i++; ?></td>
                <td class="text-center"><?php echo $row['v_sn']; ?></td>
                <!-- <td class="text-center"><?php echo $row['product_name'] ?></td> -->
                <td class="text-center"><span class="text-success"><i class="fe fe-check-square fe-20"></i></span></td>
              </tr>

            <?php }

            endif; ?>

          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
</div>

<div id="display_detail"></div>
<!-- <form method="post"> -->
    <input id="textbox" type="text" name="textbox">
    <input id="nilai_pindahan" type="text" name="nilai_pindahan">
    <input id="send" type="submit" name="send" value="Send">
<!-- </form> -->

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

        kj = api
        .column( 2 )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        harga = api
        .column( 5 )
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

        kjTotal = api
        .column( 2, { page: 'current'} )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );
        
        hargaTotal = api
        .column( 5, { page: 'current'} )
        .data()
        .reduce( function (a, b) {
          return intVal(a) + intVal(b);
        }, 0 );

        // Update footer
        $( api.column( 4 ).footer() ).html(
          pageTotal.toFixed(2) + '<br>( ' + total.toFixed(2) + ' )'
        );

        $( api.column( 2 ).footer() ).html(
          kjTotal.toFixed(2) + '<br>( ' + kj.toFixed(2) + ' )'
        );

        $( api.column( 5 ).footer() ).html(
          kjTotal.toFixed(2) + '<br>( ' + kj.toFixed(2) + ' )'
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


// $.ajax({
//     url : "<?php echo base_url(); ?>welcome/login"
//     type : "POST",
//     dataType : "json",
//     data : {"account" : account, "passwd" : passwd},
//     success : function(data) {
//         // do something
//     },
//     error : function(data) {
//         // do something
//     }
// });

// $(document).ready(function(){   

// $("#send").click(function()
// {       
//  $.ajax({
//      type: "POST",
//      url: "<?php echo base_url(); ?>report/check_stok", 
//      data: {textbox: $("#textbox").val()},
//      dataType: "text",  
//      cache:false,
//      success: 
//           function(data){
//             alert(data);  //as a debugging message.
//           }
//       });// you have missed this bracket
//  return false;
// });
// });

$.ajaxSetup({
    headers: { "CustomHeader": "myValue" }
});

$('#send').click(function(){
  var textbox = $('#textbox').val();
    if(textbox!=''){
      $.ajax({
        url: '<?php echo site_url();?>report/check_stok',
        type: 'POST',
        dataType : 'json',
        // data: {
				// 	type: 1,
				// 	name: name,
				// 	email: email,
				// 	phone: phone,
				// 	city: city
				// },

        data: { textbox:textbox },
				// cache: false,

        // success : function(data){
        //   alert(data);

        // },
        // error :function (data) {
        //   alert(data);
        // }
      });
    }
    else{
      $('#display_detail').slideUp('slow');
    }
   
    // $('#something').click(function() {
    location.reload();
// });
});

// $(function(){
//     $.ajaxSetup({
//         data: {
//             <?php echo $this->config->item('csrf_token_name'); ?>: $.cookie('<?php echo $this->config->item('csrf_cookie_name'); ?>')
//         }
//     });
// });

// $(function() {
      // $('#send').click(function(){
      //   var nilai_pindahan = $('#nilai_pindahan').val();
      //   // var nama_penerima = $('#nama_penerima').val();
      //   // var acc_penerima = $('#acc_penerima').val();
      //   // var jenis_dompet = $('#jenis_dompet').val();
      //   // var cara_transaksi = $('#cara_transaksi').val();
      //   // var cek_penerima = $('#cek_penerima').val();
      //   // var total_tunai='';var total_berat='';
      //   var textbox=$('#textbox').val();
      
      //   if(nilai_pindahan!==''){
      //     $.ajax({
      //       url: '<?php echo base_url();?>report/check_stok',
      //       type: 'get',
      //       data: { nilai_pindahan:nilai_pindahan, textbox:textbox},
      //       success : function(data){
      //         // $('#tac_pindah').html(data);
      //         alert('TAC telah di hantar. Sila semak email anda.');
      //       },
      //       error : function (data) {
      //         alert('error');
      //       }
      //     });
      //   }else{
      //       alert('Sila isi semua maklumat dengan betul');
      //   }

      // });
    // });
</script>