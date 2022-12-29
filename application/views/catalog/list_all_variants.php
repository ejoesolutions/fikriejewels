<?php echo $this->session->flashdata('upload'); ?>

<!-- form for new user id -->
<?php if ($this->uri->segment(3)) { ?>
  <input type="hidden" id="reg_id" value="<?= $this->uri->segment(3) ?>">
<?php } ?>

<?php if ($this->uri->segment(3)) { ?>
  <input type="hidden" id="search" value="<?= $this->uri->segment(3) ?>">
<?php } ?>

<?php if ($this->uri->segment(4)) { ?>
  <input type="hidden" id="get_show_id" value="<?= $this->uri->segment(4) ?>">
<?php } ?>

<?php if ($this->uri->segment(5)) { ?>
  <input type="hidden" id="get_show_sn" value="<?= $this->uri->segment(5) ?>">
<?php } ?>

<!-- QRscanner -->
<?php if ($this->agent->is_mobile()) { ?>
  <div class="container text-center"><video width="50%" id="preview"></video></div>
  <!-- <video id="preview" playsinline controls="true" ></video> -->
  <!-- <video id="preview" playsinline controls="true" width="100%"></video> -->
<?php } ?>

<input type="hidden" id="text">
<!-- ./QRscanner -->

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
            <option value="3">Status</option>
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

      <div id="status" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Status</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control text-center" name="status">
            <option value="" selected>---Pilih---</option>
            <option value="11">Stok Kedai</option>
            <option value="2">Keluar</option>
            <option value="5">Tempahan Kedai</option>
            <option value="6">Tempahan Baru</option>
            <option value="7">Tempahan Baiki</option>
            <option value="8">Tempahan Kedai ( Siap )</option>
            <option value="9">Tempahan Baru ( Siap )</option>
            <option value="10">Tempahan Baiki ( Siap )</option>
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

<div class="col-md-12 mb-4">
  <h4>
    <b id="tableTitle">Status Variasi</b>
    <div class="d-block d-sm-none"><span class="ml-4"></span></div>
    <a class="btn btn-primary" href="<?= base_url('booking/create_booking') ?>" title="Tambah variasi produk">+ Tempahan Baru</a>
    <a class="btn btn-info ml-2" href="<?= base_url('booking/create_repair') ?>" title="Tambah variasi produk">+ Tempahan Baiki</a><br>
  </h4>

  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="col-md-12">
      <div class="table-responsive">
        <table class="table nowrap" id="example">
          <thead>
            <tr class="uppercase">
              <th nowrap class="text-center">No.</th>
              <th width="10%" class="text-center">Gambar</th>
              <th nowrap class="text-center">Siri Nombor</th>
              <th nowrap class="text-center" width="18%">Maklumat</th>
              <th nowrap class="text-center">Berat ( g )</th>
              <th nowrap class="text-center">Harga Semasa ( RM )</th>
              <th nowrap class="text-center">Harga Dasar ( RM )</th>
              <th nowrap class="text-center">Harga Kaunter ( RM )</th>
              <th nowrap class="text-center">Tarikh</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>

          <tbody>

            <?php if(!empty($variants)): ?>

            <?php

            $i=1;

            foreach ($variants as $row) { ?>

              <?php if ($row['v_status']==6 && !$row['sta_cust']) {
                echo '<tr style="background-color:#FCF3CF">';
              }else {
                echo '<tr>';
              } ?>
              <td class="text-center"><?php echo $i++; ?></td>
              <td class="text-center" style="width:150px;height:150px">
                <a href="<?= base_url('catalog/product_edit/'.$row['product_id']) ?>">
                  <?php
                    if ($row['image']) {

                      // $info = pathinfo( $row['image'] );
                      // $no_extension =  basename( $row['image'], '.'.$info['extension'] );
                      // $thumb_image = $no_extension.'_thumb.'.$info['extension'];
                      $image_properties = array(
                        'src'   => base_url().'images/thumbnail/'.$row['image'],
                        'alt'   => $row['product_name'],
                        'class' => 'avatar-img',
                        'title' => 'Lihat Perincian Produk',
                        'style' => 'height: 100%; width: 100%; object-fit: contain',
                      );

                      echo img($image_properties);

                    } else {

                      $image_properties = array(
                        'src'   => 'https://dummyimage.com/300x300/1C2833/9b9dad.jpg&text=No+Image',
                        'alt'   => 'No image',
                        'class' => 'avatar-img',
                        'title' => 'Lihat Perincian Produk',
                        'width' => '100%'
                      );

                      echo img($image_properties);
                    }
                  ?>
                </a>
              </td>
              <td class="text-center">
                <?php echo '<small class="">'.$row['tag'].'</small><br>
                <a class="text-dark" href="'.base_url("orders/print_tag/".$row['variant_id']).'" title="Cetak Tag" target="_blank">
                '.$row['v_sn'].'<br>
                <span class="h1 text-dark"><i class="fas fa-qrcode"></i></span><br>
                <small class="float-left mt-2 mr-1">sisemas.com</small>
                <small class="float-right mt-2">KJ :'. $row['v_kod'] .'</small></a>' ?>
              </td>
          
              <td>

                <small class="row text-dark justify-content-center mb-2"><?= $row['staf_name'] ?></small>
                <div class="row justify-content-center">
                  <div>
                    <small>
                      B :
                      <?php
                        if($row['v_weight']!='')
                        {
                          echo $row['v_weight'].' g';
                        }else{
                          echo '-';
                        }
                      ?>
                    </small>
                    <br>
                    <small>
                      P :
                      <?php
                        if($row['v_length']!='')
                        {
                          echo $row['v_length'].' cm';
                        }else{
                          echo '-';
                        }
                      ?>
                    </small>
                    <br>
                    <small>
                      L :
                      <?php
                        if($row['v_width']!='')
                        {
                          echo $row['v_width'].' cm';
                        }else{
                          echo '-';
                        }
                      ?>
                    </small>
                    <br>
                    <small>
                      Sz :
                      <?php
                        if($row['v_size']!='')
                        {
                          echo $row['v_size'];
                        }else{
                          echo '-';
                        }
                      ?>
                    </small>
                  </div>

                  <div class="ml-lg-3">
                    <small>
                      Sb :
                      <?php
                        if($row['v_sb']!='')
                        {
                          echo $row['v_sb'];
                        }else{
                          echo '-';
                        }
                      ?>
                    </small>
                    <br>
                    <small>
                      Up :
                      <?php
                        if($row['v_margin_pay']!='')
                        {
                          echo $row['v_margin_pay'];
                        }else{
                          echo '-';
                        }
                      ?>
                    </small>
                    <br>
                    <small>
                      M :
                      <?php
                        if($row['mutu']!='')
                        {
                          echo $row['mutu'];
                        }else{
                          echo '-';
                        }
                      ?>
                    </small>
                  </div>
                </div>
              </td>
              <td class="text-center">
              <?php
                if($row['v_weight']){
                  echo $row['v_weight'];
                }
              ?>
              </td>
              <td class="text-center">
                <?= $current_v_emas = number_format($row['v_weight'] * $row['setup_price'], 2, '.', ''); ?>
                <br>
                <small class="text-secondary"><?php echo $row['setup_price'] ?> / g</small>
              </td>
              <td class="text-center">
                <?= $current_v_dasar = number_format($current_v_emas +  $row['v_pay'], 2, '.', ''); ?>
                <br>
                <small class="text-secondary">Up : <?php echo $row['v_pay'] ?></small>
              </td>
              <td class="text-center"><?= number_format($current_v_dasar + $row['v_margin_pay'], 2, '.', ''); ?></td>
              <td class="text-center">
                <?= date("Y-m-d", strtotime($row['insert_date'])); ?>
                <br>
                <?= date("h:i a", strtotime($row['insert_date'])); ?>
              </td>

              <td class="text-center">
                <?php if ($row['v_status']==0) { ?>
                <a data-id="<?= $row['variant_id'] ?>" data-status="<?= $row['v_status'] ?>" data-cawangan = "<?= $row['cawangan_id'] ?>"
                  data-sn="<?= $row['v_sn'] ?>" title="Add this item" class="open-AddBookDialog"
                  href="#addBookDialog"><span class="fe fe-edit fe-20"></span></a>
                <?php }elseif ($row['v_status']==3) {
                  echo '<span class="badge badge-warning">deposit</span><br>';
                }elseif ($row['v_status']==8) {
                  echo '<span class="badge bg-dark-success">tempahan kedai <br>(siap)</span><br>';
                }elseif ($row['v_status']==9) {
                  echo '<span class="badge bg-dark-success">tempahan baru <br>(siap)</span><br>';
                }elseif ($row['v_status']==10) {
                  echo '<span class="badge bg-dark-success">tempahan baiki <br>(siap)</span><br>';
                }else { ?>

                <!-- tempahan baru yang pending -->
                <?php if ($row['v_status']==6 && !$row['sta_cust']) {
                  echo '<a href="'.base_url('booking/booking_invoices/'.$row['variant_id']).'" class="text-primary">PENDING</a>'; 
                }else { ?>
                <a data-id="<?php echo $row['variant_id'] ?>" data-sta_harga="<?php echo $row['sta_harga'] ?>"
                  data-sta_nota="<?php echo $row['sta_nota'] ?>" data-sta_status="<?php echo $row['v_status'] ?>"
                  data-sta_tarikh="<?php echo date("Y/m/d", strtotime($row['sta_tarikh'])); ?>"
                  data-sta_cust="<?php echo $row['full_name'] ?>" data-sta_sn="<?php echo $row['v_sn'] ?>" 
                  title="Add this item" class="open-updBookDialog" href="#updBookDialog">

                  <?php if ($row['v_status']==2) {
                    echo '<span class="badge badge-dark">keluar</span><br>';
                  }elseif ($row['v_status']==5) {
                    echo '<span class="badge badge-info">tempahan kedai</span><br>';
                  }elseif ($row['v_status']==6) {
                    echo '<span class="badge badge-info">tempahan baru</span><br>';
                  }elseif ($row['v_status']==7) {
                    echo '<span class="badge badge-info">tempahan baiki</span><br>';
                  } ?>

                  <?= '<span class="fe fe-edit fe-20"></span>'; ?>
                </a>

                <?php } ?>
       
                <?php } ?>

                <?php if ($row['v_status']==2) { ?>
                | <a href="<?= base_url('catalog/print_keluar/'.$row['variant_id']) ?>" target="_blank"
                  title="Cetak Invois" class=""><span class="fe fe-printer fe-20"></span></a>
                <?php } ?>

              </td>
            </tr>

            <?php } ?>

            <?php endif; ?>

          </tbody>
          <?php if ($user_profile['user_group'] == 1 || $user_profile['user_group'] == 0) { ?>
          <tfoot>
            <tr>
              <th colspan="4" style="text-align:right">JUMLAH : </th>
              <th class="text-center"></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </tfoot>
          <?php } ?>
      
        </table>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addBookDialog" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="varyModalLabel">Tambah Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('catalog/status_variants', array('id' => 'addStatus')); ?>

      <input type="hidden" name="v_id" id="v_id">
      <input type="hidden" name="in_v_sn" id="in_v_sn">
      <input type="hidden" name="cawangan" id="cawangan_id">
      
      <div class="modal-body">
        <div class="form-group">
          <label for="custom-select">Pelanggan : </label>
          <div class="row col-12 pr-0 m-0 pl-0">
            <div class="col-11 pl-0">
              <select class="select2" name="customer" id="select_cust" required>
                <option value="">--Pilih--</option>
                <?php  if(!empty($cust)) {
                  foreach ($cust as $key) { ?>
                  <option value="<?= $key['id'] ?>"><?= $key['name'] ?></option>
                <?php } } ?>
              </select>
            </div>
            <button type="button" class="btn mb-2 btn-info col-1 add" id="btn_register" data-toggle="modal"
              data-target="#modal_updVariant" data-v_sn=v data-add_id=t>+</button>
          </div>
        </div>

        <div class="form-group">
          <label for="custom-select">Status : </label>
          <select class="form-control" name="status" required>
            <option value="">-Pilih-</option>
            <option value="5">Tempahan Kedai</option>
            <option value="2">Keluar</option>
          </select>
        </div>

        <div class="form-group">
          <label for="recipient-name" class="col-form-label">Tarikh :</label>
          <div class="input-group">
            <input type="text" class="form-control drgpicker" name="tarikh" id="date-input1"
              aria-describedby="button-addon2">
            <div class="input-group-append">
              <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-20"></span></div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Deposit ( RM ) :</label>
          <input type="text" class="form-control" name="harga" value="">
        </div>
        <div class="form-group">
          <label for="custom-select">Cara Bayaran : </label>
          <select class="form-control" name="cara_bayaran" id="c_bayaran" required>
            <option value="">--Pilih--</option>
            <option value="1">Tunai</option>
            <option value="2">Bank In</option>
            <option value="3">Debit/Credit</option>
          </select>
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Nota :</label>
          <textarea class="form-control" name="nota_status" id="message-text" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="btnAddStatus" class="btn mb-2 btn-primary">Simpan</button>
      </div>

      <?= form_close(); ?>
    </div>
  </div>
</div>


<div class="modal fade" id="updBookDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="varyModalLabel">Tukar Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('catalog/upd_status_variants', array('id' => 'updStatus')); ?>

      <input type="hidden" name="upd_v_id" id="upd_v_id">
      <input type="hidden" name="up_sta_sn" id="up_sta_sn">
      <input type="hidden" name="status_sn" id="status_sn">
      
      <div class="modal-body">
      
        <div class="form-group">
          <label for="custom-select">Pelanggan : </label>
          <input type="text" id="up_sta_cust" class="form-control" readonly>
        </div>

        <div class="form-group">
          <label for="custom-select">Status : </label>
          <select class="form-control ct" id="up_sta_status" name="up_sta_status">
            <option value="2">Keluar</option>
            <option value="0">Masuk</option>
            <option value="5">Tempahan Kedai</option>
            <option value="6">Tempahan Baru</option>
            <option value="7">Tempahan Baiki</option>
          </select>
        </div>

        <div class="form-group">
          <label for="recipient-name" class="col-form-label">Tarikh :</label>
          <div class="input-group">
            <input type="text" class="form-control drgpicker" name="up_sta_tarikh" id="up_sta_tarikh"
              aria-describedby="button-addon2">
            <div class="input-group-append">
              <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-20"></span></div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Deposit Tempahan ( RM ) :</label>
          <input type="text" class="form-control" id="up_sta_harga" name="up_sta_harga" readonly>
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Nota :</label>
          <textarea class="form-control" name="up_sta_nota" id="up_sta_nota" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="btnUpdStatus" class="btn mb-2 btn-primary">Simpan</button>
      </div>

      <?= form_close(); ?>
    </div>
  </div>
</div>


<!-- modal register pelanggan baru -->
<div class="modal fade bd-example-modal-lg" id="modal_updVariant" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Daftar Pelanggan Baru </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <?= form_open('user/register_cust_variants',array('class'=>'form-horizontal','id'=>'')) ?>

        <input type="hidden" id="show_id" name="show_id">
        <input type="hidden" id="v_sn_2" name="v_sn_2">

        <?php $this->load->view('customer/register_form'); ?>

        <?= form_close() ?>

      </div>
    </div>
  </div>
  <div id="result"></div>
  <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

  <script>

$(document).ready(function() {

  // alertScan();
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
} );

  $(document).ready(function(){

    //trigger new user into select cust    
    <?php if ($this->uri->segment(3)) { ?>

      var modal = '#addBookDialog';
      var cust_id = $('#reg_id').val();
      var search = $('#search').val();
      
      $('#select_cust').val(cust_id).trigger("change");

      if($.isNumeric($('#search').val())) {
        $(modal).modal('show');  
      }

      //auto search selepas masukkan status
      if(!$.isNumeric($('#search').val())) {
        
        var search = $('#search').val();
        var oTable = $('#example').dataTable();
        
        oTable.fnFilter(search);
      }   
      
    <?php } ?>

    <?php if ($this->uri->segment(5)) { ?>

      var get_sn = $('#get_show_sn').val();
      var oTable = $('#example').dataTable();

      $("#in_v_sn").val(get_sn);
        
      //oTable.fnFilter(get_sn);

    <?php } ?>

    <?php if ($this->uri->segment(4)) { ?>

      var get_id = $('#get_show_id').val();

      $("#v_id").val(get_id);

    <?php } ?>

  }); 

  $(document).on("click", ".open-AddBookDialog", function (e) {

    e.preventDefault();

    var _self = $(this);

    var myBookId = _self.data('id');
    var sn = _self.data('sn');
    var cawangan = _self.data('cawangan');

    $("#v_id").val(myBookId);
    $("#in_v_sn").val(sn);
    $("#cawangan_id").val(cawangan);

    $("button").attr("data-add_id",myBookId);
    $("button").attr("data-v_sn",sn);

    $(_self.attr('href')).modal('show');
  });

    
  $(document).on("click", ".add", function (e) {
    
    e.preventDefault();

    var _self = $(this);

    var id = _self.data('add_id');
    var v_sn_2 = _self.data('v_sn');

    $("#show_id").val(id);
    $("#v_sn_2").val(v_sn_2);
    
  });

    $(document).on("click", ".open-updBookDialog", function (e) {

      e.preventDefault();

      var _self = $(this);

      var myBookId = _self.data('id');
      var sta_harga = _self.data('sta_harga');
      var sta_nota = _self.data('sta_nota');
      var sta_status = _self.data('sta_status');
      var sta_tarikh = _self.data('sta_tarikh');
      var sta_cust = _self.data('sta_cust');
      var sta_sn = _self.data('sta_sn');
      // var staf_name = _self.data('staf_name');

      if ((sta_status == 6) || (sta_status == 7)) {
        $('#up_sta_status').attr('disabled', 'disabled');

        $('<input>').attr({
          type: 'hidden',
          id: 'foo',
          name: 'up_sta_status',
          value: sta_status
        }).appendTo('form');

      }else{
        $('#up_sta_status').removeAttr('disabled');
        $(".ct option[value='6']").remove();
        $(".ct option[value='7']").remove();
      }
      
      $("#upd_v_id").val(myBookId);
      $("#up_sta_harga").val(sta_harga);
      $("#up_sta_nota").val(sta_nota);
      $("#up_sta_sn").val(sta_sn);
      $("#status_sn").val(sta_status);
      $("#up_sta_status").val(sta_status);
      $('#up_sta_status').val(sta_status).trigger("change"); //trigger jenis status 
      $("#up_sta_tarikh").val(sta_tarikh);
      $("#up_sta_cust").val(sta_cust);
      // $("#up_staf_name").val(staf_name);

      $(_self.attr('href')).modal('show');
    });

    //close edit modal when click add cust button
    $("#btn_register").click(function () {
      $('#addBookDialog').modal('hide');
    });

    // qrscanner section 

    let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false,continuous: true, backgroundScan: true, scanPeriod: 1});
    scanner.addListener('scan', function (content) {
        console.log(content);

        var oTable = $('#example').dataTable();

        $search = document.getElementById("text").value = content;

        oTable.fnFilter($search);
        

        $.ajax({
          url: '<?= base_url(); ?>report/check_list_variants',
          type: 'POST',
          dataType: "text",  
          cache: false,
          data: { sn : content},
          success: 
          function(data){
            $("#result").html(data)
          },
        });
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

    //./ qrscanner section 

    $("#carian").change(function () {

      var carian = $("#carian").val();

      if (carian == 1)  {

        document.getElementById('byDateAfter').style.display = null;
        document.getElementById('byDateBefore').style.display = null;
        document.getElementById('button').style.display = null;      
        document.getElementById('status').style.display = null;      
        document.getElementById('byYear').style.display = "none";
        document.getElementById('byMonth').style.display = "none";

      }else if (carian == 2) {

        document.getElementById('byYear').style.display = null;
        document.getElementById('byMonth').style.display = null;
        document.getElementById('button').style.display = null;
        document.getElementById('status').style.display = null;      
        document.getElementById('byDateAfter').style.display = "none";
        document.getElementById('byDateBefore').style.display = "none";

      }else if (carian == 3) {

        document.getElementById('byYear').style.display = "none";
        document.getElementById('byMonth').style.display = "none";
        document.getElementById('button').style.display = null;
        document.getElementById('status').style.display = null;      
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

    //delete variants button confirmation
    $('.delete_variant').on('click', function (e) {
      e.preventDefault();
      var url = $(this).attr('href');

      Swal.fire({
        title: 'Padam Tempahan ini?',
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

    $('#addStatus').one('submit', function() {
      $('#btnAddStatus').attr('disabled','disabled');
      $("#btnAddStatus").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
    });

    $('#updStatus').one('submit', function() {
      $('#btnUpdStatus').attr('disabled','disabled');
      $("#btnUpdStatus").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
    });
  </script>
