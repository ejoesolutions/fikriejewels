<?= $this->session->flashdata('upload'); ?>

<div class="container-fluid">
  <?php if ($this->product_model->get_item()) { ?>
    <div class="alert alert-danger" role="alert">
      <?= count($this->product_model->get_item()) ?> item belian belum selesai
    </div>
  <?php } ?>
  
  <div class="row justify-content-center">
    <div class="col-12">
      <h4 class="page-title">Tambah Belian / Trade In</h4>

      <?= form_open_multipart('buy/insert_item',array('class'=>'form-horizontal','id'=>'buyItem')); ?>

      <div class="card shadow" id="section-to-print">
        <div class="card-body">

          <div class="row">

          <!-- add produk dibeli -->
          <div class="col-md-4">
            <div class="fileinput fileinput-new" data-provides="fileinput">
              <div class="fileinput-new img-thumbnail img-responsive">
                <img src="https://via.placeholder.com/500">
              </div>

              <div class="fileinput-preview fileinput-exists img-thumbnail img-responsive"></div>

              <div>
                <span class="btn default btn-file pl-0">
                  <span class="fileinput-new btn btn-info"><i class="fe fe-camera fe-16"></i> <?php echo lang('form_button_image') ?></span>
                  <!-- <span class="fileinput-exists btn btn-info"><?php echo lang('form_button_image_change') ?></span> -->
                  <input type="file" name="userfile" id="userfile" required>
                </span>
              </div>
              <a href="javascript:;" class="btn btn-danger fileinput-exists mb-2" data-dismiss="fileinput"> <?php echo lang('form_button_image_delete') ?> </a>

              <div class="clearfix margin-top-10">
                <small><span class="text-danger">NOTE!</span> <?php echo lang('form_button_upload_note') ?></small>
                <?php if (isset($error_image)): ?>
                  <?php echo '<p><small class="text-danger">'. $error_image .'</small></p>'; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="form-group">
              <label class="control-label">Nama Produk</label>
              <input type="text" class="form-control" name="nama_produk" required>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Harga Produk ( RM )</label>
                  <input type="text" class="form-control" name="harga" required>
                </div>
              </div>
                
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Dulang</label>
                  <input type="text" class="form-control" value="Belian" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Mutu</label>
                  <select name="mutu_id" class="form-control" required>
                    <?php if(!empty($mutu)) {
                      echo '<option value="">-Pilih-</option>';
                      foreach ($mutu as $key) { ?>
                        <option value="<?= $key['row_id'] ?>"><?= $key['mutu'] ?></option>
                    <?php } } ?>
                  </select>
                </div>
              </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Jenis</label>
                    <select name="jenis" class="form-control" required>
                      <option value="">-Pilih-</option>
                      <option value="1">Belian</option>
                      <option value="2">Trade In</option>
                    </select>
                  </div>
                </div>
                <!-- <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">RM</label>
                    <input type="text" class="form-control" id="harga_semasa" name="harga_semasa" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Serial Berat ( RM )</label>
                    <input type="text" class="form-control" name="serial_berat" id="serial_berat" required>
                  </div>
                </div> -->
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label">Keterangan</label>
                    <textarea cols="30" rows="4" name="keterangan" class="form-control"></textarea>
                  </div>
                </div>
                <div class="col-md-12 row pr-0">
                  <div class="col-md-3 pr-0">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Berat (g)</span>
                      </div>
                      <input type="text" class="form-control text-center" id="berat" name="berat" required>
                  </div>
                </div>
                <div class="col-md-3 pr-0">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Saiz</span>
                    </div>
                    <input type="text" class="form-control text-center" name="saiz">
                  </div>
                </div>
                <div class="col-md-3 pr-0">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Panjang (cm)</span>
                    </div>
                    <input type="text" class="form-control text-center" name="panjang">
                  </div>
                </div>
                <div class="col-md-3 pr-0">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">Lebar (cm)</span>
                    </div>
                    <input type="text" class="form-control text-center" name="lebar">
                  </div>
                </div>
              </div>
            </div>

            <div class="float-right mb-5">
              <button type="submit" id="btnBuyItem" class="btn btn-primary">Tambah</button>
            </div>
          </div>
            
          </div>
          <?= form_close(); ?>
          
          <br>
          <div class="table-responsive">
          <table class="table nowrap" id="example">
            <thead>
            <tr class="text-center">
              <th width="10%">Gambar</th>
              <th>Produk</th>
              <th>Maklumat Produk</th>
              <!-- <th>RM / Serial Berat</th> -->
              <th>Keterangan</th>
              <th>Harga ( RM )</th>
            </tr>
            </thead>
            <tbody>

            <?php 
            
            if ($item) {

            foreach ($item as $items) { ?>

              <tr>
                <td class="text-center" style="width:150px;height:150px">
                    <?php

                    if ($items['picture']) {
                      $image_properties = array(
                        'src'   => base_url().'images/thumbnail/'.$items['picture'],
                        'alt'   => $items['product_name'],
                        'class' => 'avatar-img',
                        'title' => $items['product_name'],
                        'style' => 'height: 100%; width: 100%; object-fit: contain',
                      );

                      echo img($image_properties);

                    } else {

                      $image_properties = array(
                        'src'   => 'https://dummyimage.com/75x75/d6c7d6/9b9dad.jpg&text=No+Image',
                        'alt'   => 'No image',
                        'class' => 'avatar-img',
                        'title' => 'No image',
                        'width' => '100%'
                      );

                      echo img($image_properties);
                    }

                    ?>
                </td>
                <td class="text-center">
                  <p class="mb-0"><?= $items['product_name'] ?></p>
                  <small class="mb-0">[ <?= $items['serial_number'] ?> ]</small>
                </td>
                <td>
                  <div class="row justify-content-center">
                    <div>
                      <small>
                      B :    
                      <?php
                        if($items['berat']!=0)
                        {
                          echo $items['berat'].' g';
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      P :    
                      <?php
                        if($items['panjang']!=0)
                        {
                          echo $items['panjang'].' cm';
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <br>
                      <small>
                      L :    
                      <?php
                        if($items['lebar']!=0)
                        {
                          echo $items['lebar'].' cm';
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
                        if($items['saiz']!=0)
                        {
                          echo $items['saiz'];
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                      <!-- <br>
                      <small>
                      Sb :    
                      <?php
                        if($items['serial_berat']!='')
                        {
                          echo $items['serial_berat'];
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small> -->
                      <br>
                      <small>
                      M :    
                      <?php
                        if($items['mutu']!='')
                        {
                          echo $items['mutu'];
                        }else{
                          echo '-';
                        }
                      ?>  
                      </small>
                    </div>
                  </div>
                </td>
                <!-- <td class="text-center">
                  <small>
                    RM : <?= $items['harga_semasa'] ?>
                    <br>
                    Sb : <?= $items['serial_berat'] ?>
                  </small>
                </td> -->
                <td class="text-center">
                  <small class="mb-0">
                    <?php if ($items['jenis'] == 1) {
                      echo "Jenis : Belian";
                    }elseif ($items['jenis'] == 2) {
                      echo "Jenis : Trade In";
                    } ?>
                    <br>
                    <?= $items['keterangan'] ?>
                  </small>
                </td>
                <td class="text-center"><?= $items['harga'] ?></td>
              </tr>

            <?php } } ?>

            </tbody>
            <tfoot>
              <tr>
                <?php if ($item) { ?>
                  <th class="text-center"><a href="<?= base_url('buy/delete_buy/'.$items['id']) ?>" class="text-danger reset"><span class="fe fe-trash fe-16"></span></a></th>
                <?php }else { ?>
                  <th class="text-center"></th>
                <?php } ?>
                <th colspan="3" style="text-align:right">JUMLAH : </th>
                <th class="text-center"><input type="text" id="jumlah" class="form-control text-center" readonly></th>
              </tr>
            </tfoot>  
          </table>
          </div>
          <br>
          <?php if ($item) { ?>
            <a href="<?= base_url('buy/buy_checkout') ?>" class="btn btn-info float-right">Semak Keluar</a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- modal register pelanggan baru -->
<div class="modal fade bd-example-modal-lg" id="modal_updVariant" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Daftar Pelanggan Baru </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
      
        <?php echo form_open('user/register_cust_buy',array('class'=>'form-horizontal','id'=>'')) ?>

        <div class="col-md-12">
          <div class="form-group">
            <label class="control-label">Nama Penuh</label>
              <input type="text" name="full_name" class="form-control uppercase" placeholder="Nama Penuh" required>
          </div>
        </div>
        <div class="row col-12 pr-0">
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">No K/P</label>
                <input type="text" name="nic_no" class="form-control uppercase" placeholder="No K/P">
            </div>
          </div>
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">No Telefon</label>
                <input type="text" name="phone" class="form-control" placeholder="No Telefon">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label class="control-label">Alamat</label>
              <textarea class="form-control" id="example-textarea" name="address" rows="3" placeholder="Alamat"></textarea>
          </div>
        </div>
        <div class="row col-12 pr-0">
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">Poskod</label>
                <input type="text" name="postcode" class="form-control uppercase" placeholder="Poskod">
            </div>
          </div>
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Bandar</label>
                <input type="text" name="town_area" class="form-control uppercase" placeholder="Bandar">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group mb-3">
            <label for="custom-select">Negeri</label>
            <select class="custom-select select2" name="state_id" id="custom-select">
              <option value="17" selected>---Pilih---</option>
              <option value="1">SELANGOR</option>
              <option value="2">KUALA LUMPUR</option>
              <option value="3">JOHOR</option>
              <option value="4">PERAK</option>
              <option value="5">PENANG</option>
              <option value="6">KEDAH</option>
              <option value="7">PAHANG</option>
              <option value="8">NEGERI SEMBILAM</option>
              <option value="9">KELANTAN</option>
              <option value="10">TERENGGANU</option>
              <option value="11">MELAKA</option>
              <option value="12">PUTRAJAYA</option>
              <option value="13">PERLIS</option>
              <option value="14">LABUAN</option>
              <option value="15">SABAH</option>
              <option value="16">SARAWAK</option>
            </select>
          </div>        
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
          <input type="submit" onclick="this.disabled=true;this.value='Sila Tunggu';this.form.submit();" id="btn_upd" class="btn btn-primary" value="Daftar">
        </div>

        <?= form_close() ?>

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
        // $( api.column( 4 ).footer() ).html(
          total
        // );

        document.getElementById("jumlah").value=total.toFixed(2);
      },

      "bPaginate": false,
      "bFilter": false,
      "bInfo": false
      
    } );
  });
  
  $("#harga_semasa").keyup(function(){

    var harga_semasa = $("#harga_semasa").val();

    sb = parseFloat(harga_semasa) * 2.72 ; //tukar ke RM serial berat

    document.getElementById("serial_berat").value=sb.toFixed(2);

  });

  //reset cart button confirmation
  $('.reset').on('click',function(e){
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Set Semula Pesanan?',
      text: "Semua Produk Akan Dipadam!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Tutup',
      confirmButtonText: 'Ya, Set Semula!'
    }).then((result) => {
      if (result.value) {
      window.location.replace(url);
      }
    });
  });

  $('#buyItem').one('submit', function() {
    $('#btnBuyItem').attr('disabled','disabled');
    $("#btnBuyItem").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

</script>