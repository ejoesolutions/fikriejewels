<?php echo $this->session->flashdata('upload'); ?>

<?php echo form_open('', array('class'=>'')) ?>

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

      <!-- carian ketegori -->
      <div id="byCategory" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Kategori</label>
        <div class="col-md-5 col-xl-3">
          <select class="form-control text-center" name="category" id="category">
            <option>---Pilih---</option>
            <option value="7">Dalam Proses</option>
            <option value="10">Tempahan Siap</option>
            <option value="3">Deposit</option>
            <option value="1">Dijual</option>
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
  <h4 class="page-title"><?= $title ?></h4>
  <div class="card shadow">
    <div class="card-body">
      <div class="table-responsive">
      <table class="table nowrap text-dark" id="dataTable-1">
        <thead>
          <tr>
            <!-- <th width="50px" class="text-center">Bil</th> -->
            <th class="text-center">No Tempahan</th>
            <th>Nama Produk</th>
            <!-- <th class="text-center">Maklumat Produk</th>
            <th class="text-center">Maklumat Penambahan</th> -->
            <th>Nama Pelanggan</th>
            <th class="text-center">Staf</th>
            <th class="text-center">Bayaran Deposit</th>
            <th class="text-center">Harga ( RM )</th>
            <th class="text-center">Tarikh</th>
            <th class="text-center">#</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($book):
          $n=1;
          foreach ($book as $books) { ?>
          <tr>
            <!-- <td class="text-center"><?php echo $n++; ?></td> -->
            <td class="text-center"><?= $books['repair_id'] ?></td>
            <td>
              <span class="d-inline-block text-truncate" style="max-width: 250px;">
                <?= $books['product_name'] ?>
              </span>
              <br>
              <small><?= $books['v_sn'] ?></small>
            </td>
            <!-- <td>
              <div class="row justify-content-center">
                <div>
                  <small>
                  B :    
                  <?php
                    if($books['v_weight']!=0)
                    {
                      echo $books['v_weight'].' g';
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  P :    
                  <?php
                    if($books['v_length']!=0)
                    {
                      echo $books['v_length'].' cm';
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  L :    
                  <?php
                    if($books['v_width']!=0)
                    {
                      echo $books['v_width'].' cm';
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                </div>

                <div class="ml-3">
                  <small>
                  Sz :    
                  <?php
                    if($books['v_size']!=0)
                    {
                      echo $books['v_size'];
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  Sb :    
                  <?php
                    if($books['v_sb']!='')
                    {
                      echo $books['v_sb'];
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  M :    
                  <?php
                    if($books['mutu']!='')
                    {
                      echo $books['mutu'];
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                </div>
              </div>
            </td>
            <td>
              <div class="row justify-content-center">
                <div>
                  <small>
                  B :    
                  <?php
                    if($books['add_berat']!=0)
                    {
                      echo $books['add_berat'].' g';
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  P :    
                  <?php
                    if($books['add_panjang']!=0)
                    {
                      echo $books['add_panjang'].' cm';
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                </div>

                <div class="ml-3">
                  <small>
                  Sz :    
                  <?php
                    if($books['add_saiz']!=0)
                    {
                      echo $books['add_saiz'];
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                  <br>
                  <small>
                  L :    
                  <?php
                    if($books['add_lebar']!=0)
                    {
                      echo $books['add_lebar'].' cm';
                    }else{
                      echo '-';
                    }
                  ?>  
                  </small>
                </div>
              </div>
            </td> -->
            <td>
              <span class="d-inline-block text-truncate" style="max-width: 250px;">
                <?= $books['full_name'] ?>
              </span>
            </td>
            <td class="text-center">
              <!-- <?= $books['tag'] ?>
              <br> -->
              <?= $books['staf_name'] ?>
            </td>
            <td class="text-center"><?= $books['harga'] ?></td>
            <td class="text-center">
              <?php if ($books['bayaran']) { 
                echo $books['bayaran']."<br>";

                $bayar_baki = number_format($books['bayaran'] - $books['harga'], 2 , '.', '');

                if ($books['v_status']!=1) {
                  echo "<small>[ Baki : ". $bayar_baki ." ]</small>";
                }
                
              }else{
                echo "-";
              } ?>
            </td>
            <td class="text-center"><?= $books['tarikh'] ?></td>
            <td class="text-center">
              <?php if ($books['v_status']==1) { ?>
                <div class="text-success mb-1"><a href="<?= base_url('booking/repair_detail/'.$books['variant_id']) ?>" title="Lihat Invois" class="text-green">SELESAI</a></div>
              <?php }else { ?>
              
                <?php if ($books['v_status']==10) { ?>
                  <div class="text-info mb-1">TEMPAHAN BAIKI ( SIAP )</div>
                  <a data-toggle="modal" data-target="#payModal" title="Bayaran" class="text-info open-pay" data-id="<?= $books['variant_id'] ?>" data-p_id="<?= $books['product_id'] ?>" data-c_id="<?= $books['cust_id'] ?>" data-cawangan="<?= $books['cawangan_id'] ?>"
                    data-weight="<?= $books['add_berat'] ?>" data-width="<?= $books['add_lebar'] ?>" data-length="<?= $books['add_panjang'] ?>" data-size="<?= $books['add_saiz'] ?>" data-baki="<?= $bayar_baki ?>"  data-bayaran="<?= $books['bayaran'] ?>">
                    <span class="fe fe-dollar-sign fe-20"></span>
                  </a>
                  |
                <?php }else { ?>
                  <a data-toggle="modal" data-target="#varyModal" title="Produk Masuk" class="text-info open-updNewInfo" data-id="<?= $books['variant_id'] ?>" data-p_id="<?= $books['product_id'] ?>" data-c_id="<?= $books['cust_id'] ?>"
                    data-weight="<?= $books['add_berat'] ?>" data-width="<?= $books['add_lebar'] ?>" data-length="<?= $books['add_panjang'] ?>" data-size="<?= $books['add_saiz'] ?>" \>
                    <span class="fe fe-arrow-left-circle fe-20"></span>
                  </a>
                  |
                <?php } ?>
                <a href="<?= base_url('booking/repair_detail/'.$books['variant_id']) ?>" title="Lihat Invois" class="text-green"><span class="fe fe-file fe-20"></span></a>

                <?php if ($books['v_status']==10) { ?>
                  |
                  <a data-toggle="modal" data-target="#editModal" title="Kemaskini Masuk" class="text-primary open-editInfo" data-id="<?= $books['variant_id'] ?>" data-p_id="<?= $books['product_id'] ?>" data-c_id="<?= $books['cust_id'] ?>"
                    data-weight="<?= $books['add_berat'] ?>" data-width="<?= $books['add_lebar'] ?>" data-length="<?= $books['add_panjang'] ?>" data-size="<?= $books['add_saiz'] ?>" data-harga="<?= $books['bayaran'] ?>"\>
                    <span class="fe fe-edit fe-20"></span>
                  </a>
                <?php } ?>
                
                <!-- <a href="<?= base_url('booking/print_repair/'.$books['variant_id']) ?>" target="_blank" title="Cetak Invois" class=""><span class="fe fe-printer fe-20"></span></a> -->

              <?php } ?>
            </td>
          </tr>
          <?php } ?>
          <?php endif; ?>
        </tbody>
      </table>
      </div>
    </div>
  </div>
</div> <!-- simple table -->

<div class="modal fade" id="varyModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="varyModalLabel">Tempahan Baiki ( Siap )</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('booking/repair_done', array('id'=>'repairDone')); ?>

          <input type="hidden" id="v_id" name="v_id">
          <input type="hidden" id="p_id" name="p_id">
          <input type="hidden" id="c_id" name="c_id">
          <div class="row">
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Berat ( g ):</label>
              <input type="text" class="form-control" id="new_weight" name="new_weight" required>
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Panjang ( cm ):</label>
              <input type="text" class="form-control" id="new_length" name="new_length">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Lebar ( cm ):</label>
              <input type="text" class="form-control" id="new_width" name="new_width">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Saiz:</label>
              <input type="text" class="form-control" id="new_size" name="new_size">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-12">
              <label for="recipient-name" class="col-form-label">Harga ( RM ):</label>
              <input type="text" class="form-control" id="bayaran" name="bayaran" required>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn mb-2 btn-outline-dark" data-dismiss="modal">Tutup</button>
        <button type="submit" id="btnRepairDone" class="btn mb-2 btn-primary">Hantar</button>
      </div>

      <?= form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="varyModalLabel"> Bayar Tempahan Baiki</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('booking/repair_paid'); ?>

          <input type="hidden" id="pay_v_id" name="v_id">
          <input type="hidden" id="pay_p_id" name="p_id">
          <input type="hidden" id="pay_c_id" name="c_id">
          <input type="hidden" id="getCawangan" name="cawangan">

          <div class="row">
            <div class="form-group col-12">
              <label for="recipient-name" class="col-form-label">Harga ( RM ):</label>
              <input type="text" class="form-control" id="pay_bayaran" name="bayaran" readonly>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-12">
              <label for="recipient-name" class="col-form-label">Baki ( RM ):</label>
              <input type="text" class="form-control" id="pay_baki" name="baki" readonly>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-12">
              <label for="custom-select">Cara Bayaran</label>
              <select class="form-control" name="cara_bayaran" required>
                <option value="">--Pilih--</option>
                <option value="1">Tunai</option>
                <option value="2">Bank In</option>
                <option value="3">Debit/Credit Card</option>
              </select>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn mb-2 btn-outline-dark" data-dismiss="modal">Tutup</button>
        <button type="submit" onclick="this.disabled=true;this.value='Sila Tunggu';this.form.submit();" class="btn mb-2 btn-primary">Bayar</button>
      </div>

      <?= form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="varyModalLabel">Kemaskini Tempahan Baiki</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('booking/edit_repair_done', array('id' => 'editRepair')); ?>

          <input type="hidden" id="edit_v_id" name="v_id">
          <input type="hidden" id="edit_p_id" name="p_id">
          <input type="hidden" id="edit_c_id" name="c_id">
          <div class="row">
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Berat ( g ):</label>
              <input type="text" class="form-control" id="edit_new_weight" name="new_weight" required>
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Panjang ( cm ):</label>
              <input type="text" class="form-control" id="edit_new_length" name="new_length">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Lebar ( cm ):</label>
              <input type="text" class="form-control" id="edit_new_width" name="new_width">
            </div>
            <div class="form-group col-md-6">
              <label for="recipient-name" class="col-form-label">Saiz:</label>
              <input type="text" class="form-control" id="edit_new_size" name="new_size">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-12">
              <label for="recipient-name" class="col-form-label">Harga ( RM ):</label>
              <input type="text" class="form-control" id="edit_harga" name="new_harga" required>
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn mb-2 btn-outline-dark" data-dismiss="modal">Tutup</button>
        <button type="submit" id="btnEditRepair" class="btn mb-2 btn-primary">Kemaskini</button>
      </div>

      <?= form_close(); ?>
    </div>
  </div>
</div>

<script>

  $(document).on("click", ".open-updNewInfo", function (e) {

    e.preventDefault();

    var _self = $(this);

    var id = _self.data('id');
    var v_weight = _self.data('weight');
    var v_width = _self.data('width');
    var v_size = _self.data('size');
    var v_length = _self.data('length');
    var p_id = _self.data('p_id');
    var c_id = _self.data('c_id');
    
    $("#new_weight").val(v_weight);
    $("#new_width").val(v_width);
    $("#new_size").val(v_size);
    $("#new_length").val(v_length);
    $("#v_id").val(id);
    $("#c_id").val(c_id);
    $("#p_id").val(p_id);
    
  });

  $(document).on("click", ".open-editInfo", function (e) {

    e.preventDefault();

    var _self = $(this);

    var id = _self.data('id');
    var v_weight = _self.data('weight');
    var v_width = _self.data('width');
    var v_size = _self.data('size');
    var v_length = _self.data('length');
    var p_id = _self.data('p_id');
    var c_id = _self.data('c_id');
    var harga = _self.data('harga');

    $("#edit_new_weight").val(v_weight);
    $("#edit_new_width").val(v_width);
    $("#edit_new_size").val(v_size);
    $("#edit_new_length").val(v_length);
    $("#edit_v_id").val(id);
    $("#edit_c_id").val(c_id);
    $("#edit_p_id").val(p_id);
    $("#edit_harga").val(harga);

  });

  $(document).on("click", ".open-pay", function (e) {

    e.preventDefault();

    var _self = $(this);

    var id = _self.data('id');
    var v_weight = _self.data('weight');
    var v_width = _self.data('width');
    var v_size = _self.data('size');
    var v_length = _self.data('length');
    var p_id = _self.data('p_id');
    var c_id = _self.data('c_id');
    var bayaran = _self.data('bayaran');
    var baki = _self.data('baki');
    var cawangan = _self.data('cawangan');

    $("#pay_weight").val(v_weight);
    $("#pay_width").val(v_width);
    $("#pay_size").val(v_size);
    $("#pay_length").val(v_length);
    $("#pay_v_id").val(id);
    $("#pay_c_id").val(c_id);
    $("#pay_p_id").val(p_id);
    $("#pay_bayaran").val(bayaran);
    $("#pay_baki").val(baki);
    $("#getCawangan").val(cawangan);

  });

  //pay confirmation button
  $('.pay').on('click', function (e) {

    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Bayar Tempahan?',
      // text: "Pastikan Pesanan Terus Dibuat!",
      // html: "<span class='text-secondary'>Pastikan Pesanan Terus Dibuat!<span>",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Bayar',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });

  $("#carian").change(function () {

    var carian = $("#carian").val();

    if (carian == 1)  {

      document.getElementById('byDateAfter').style.display = null;
      document.getElementById('byDateBefore').style.display = null;
      document.getElementById('button').style.display = null;    
      document.getElementById('byCategory').style.display = null;  
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";

    }else if (carian == 2) {

      document.getElementById('byYear').style.display = null;
      document.getElementById('byMonth').style.display = null;
      document.getElementById('button').style.display = null;
      document.getElementById('byCategory').style.display = null;
      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";

    }else if (carian == 3) {

      document.getElementById('byDateAfter').style.display = "none";
      document.getElementById('byDateBefore').style.display = "none";
      document.getElementById('button').style.display = null;      
      document.getElementById('byCategory').style.display = null;      
      document.getElementById('byYear').style.display = "none";
      document.getElementById('byMonth').style.display = "none";

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

  $('#repairDone').one('submit', function() {
    $('#btnRepairDone').attr('disabled','disabled');
    $("#btnRepairDone").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

  $('#editRepair').one('submit', function() {
    $('#btnEditRepair').attr('disabled','disabled');
    $("#btnEditRepair").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

</script>