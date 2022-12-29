<?= $this->session->flashdata('upload'); ?>

<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-md-2 text-center pr-0">
        <img src="<?= base_url('logo/'); ?><?= $logo['image_file'] ?>" class="navbar-brand-img mb-4" style="max-width: 55%;">
      </div>
      <div class="col-md-3">
        <p class="h5 mb-0"><?= $book['name'] ?></p>
        <?= $book['nama_tambahan'] ? '<p class="mb-1 h6">'.$book['nama_tambahan'].'</p>' : '-' ?>
        <small><?= $book['pendaftaran'] ?></small>
        <p class="mb-4">
          <?= $book['alamat'] ?>,
          <br> <?= $book['poskod'] ?> <?= $book['bandar'] ?>, <?= $book['state'] ?>
          <br> Telefon : <?= $book['telefon'] ?>
          <br> H/P : <?= $book['hp1'] ?>
          <?= $book['hp2'] ? ', '.$book['hp2'] : '-' ?>
        </p>
      </div>
      <!-- Maklumat Pelanggan -->
      <div class="col-md-5 text-dark">
        <h5 class="text-secondary">Maklumat Pelanggan</h5>
          <div class="row ml-0">
            <div class="mr-2">
              Nama : <?= $book['cust_name'] ? $book['cust_name'] : '-' ?>
              <br> 
              Telefon : <?= $book['cust_phone'] ? $book['cust_phone'] : '-' ?>
              <br>
              Alamat : <?= $book['cust_address'] ? $book['cust_address'].', '.$book['cust_state'] : '-' ?>
              <br>
              No K/p : <?= $book['cust_kp'] ? $book['cust_kp'] : '-' ?>
              <br> 
            </div>
          </div>
      </div>
      <!-- ./Maklumat Pelanggan -->
      <!-- Resit / Invois button and modal -->
      <div class="col-md-2 text-left pr-5">
        <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#varyModal"
          data-whatever="@mdo">Surat Tempahan Baru</button>
        <p class="mb-4">
          <br>No : #<?= $book['book_no'] ?>
          <br>Tarikh : <?= date("d-m-Y", strtotime($book['tarikh'])); ?>
          <br>Jurujual : <?= $book['staf_name']; ?>
          <br>
        </p>
      </div>
      <!-- Resit / Invois button and modal -->
    </div> <!-- /.row -->
    <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr class="text-center">
          <th nowrap width="18%">Produk</th>
          <th nowrap width="18%">Maklumat Produk</th>
          <th nowrap width="15%">Keterangan</th>
          <!-- <th nowrap width="15%">Anggaran Harga <br> Semasa ( RM )</th>
          <th nowrap width="15%">Anggaran Harga <br> Dasar ( RM )</th> -->
          <th nowrap width="15%">Anggaran Harga ( RM )</th>
        </tr>
      </thead>
      <tbody>
      <tr>
          <td class="text-center">
            <p class="mb-0"><?= $book['product_name'] ?></p>
            <small class="mb-0">[ <?= $book['v_sn'] ?> ]</small>
          </td>
          <td>
            <div class="row justify-content-center">
              <div>
                <small>
                B :    
                <?php
                  if($book['v_weight']!=0)
                  {
                    echo $book['v_weight'].' g';
                  }else{
                    echo '-';
                  }
                ?>  
                </small>
                <br>
                <small>
                P :    
                <?php
                  if($book['v_length']!=0)
                  {
                    echo $book['v_length'].' cm';
                  }else{
                    echo '-';
                  }
                ?>  
                </small>
                <br>
                <small>
                L :    
                <?php
                  if($book['v_width']!=0)
                  {
                    echo $book['v_width'].' cm';
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
                  if($book['v_size']!=0)
                  {
                    echo $book['v_size'];
                  }else{
                    echo '-';
                  }
                ?>  
                </small>
                <br>
                <small>
                Sb :    
                <?php
                  if($book['v_sb']!='')
                  {
                    echo $book['v_sb'];
                  }else{
                    echo '-';
                  }
                ?>  
                </small>
                <br>
                <small>
                M :    
                <?php
                  if($book['mutu']!='')
                  {
                    echo $book['mutu'];
                  }else{
                    echo '-';
                  }
                ?>  
                </small>
              </div>
            </div>
          </td>
          <td class="w-25 text-center">
            <p class="mb-0"><?= $book['description'] ?></p>
          </td>
          <!-- <td class="text-center">
            <?= $book['v_emas'] ?>
            <br>
            <small><?= $book['setup_price'] ?> / g</small>
          </td>
          <td class="text-center">
            <?= $book['v_dasar'] ?>
            <br>
            <small>Up : <?= $book['v_margin_pay'] ?></small> 

          </td> -->
          <td class="text-center"><?= $book['v_kaunter'] ?></td>
        </tr>

        <tr>
          <td colspan="2" class="text-dark test" style="border-left-color: #ffffff !important;border-right-color: #ffffff !important;border-bottom-color: #ffffff !important; ">
          <?php if ($syarat_baru) {

            $i = 1 ;

            foreach ($syarat_baru as $key ) { ?>
              <small><?= $i++ ?> . <?= $key['text'] ?></small><br>
            <?php }
          } ?>
          </td>
          <td style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important; ">
            <label class="float-right">Jumlah Deposit ( RM ) :</label>
          </td>
          <td colspan="1" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important; ">
            <input type="text" class="form-control text-center" value="<?= $book['deposit'] ?>" readonly>
          </td>
        </tr>
  
        <!-- <tr class="pb-0">
          <td class="text-dark pb-0" colspan="3" style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
            <br><br>
            <span>----------------------------------</span><span class="ml-5">----------------------------------</span><br>
            <span class="ml-4">Tandatangan Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   </span>
            <span class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan Penjual </span>
          </td>
        </tr> -->
      </tbody>
    </table>
    </div>
  </div>
</div>

<a href="<?= base_url('booking/print_booking/'.$book['variant_id']) ?>" target="_blank" class="btn btn-info float-right text-light"><span class="fe fe-printer fe-16"></span> CETAK </a>

<!-- Bayaran Deposit modal  -->
<div class="modal fade" id="varyModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="varyModalLabel">Tambah Bayaran Deposit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('booking/deposit_booking', array('id'=>'depoBook')); ?>
        <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Bayaran Deposit ( RM ):</label>
            <input class="form-control" id="message-text" name="deposit" value="<?= $book['deposit'] ?>" readonly>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Tambah Deposit ( RM ):</label>
            <input class="form-control" id="message-text" name="tambah" required>
          </div>
          <div class="form-group">
            <label for="custom-select">Cara Bayaran</label>
            <select class="form-control" name="cara_bayaran" required>
              <option value="">-Pilih-</option>
              <option value="1">Tunai</option>
              <option value="2">Bank In</option>
              <option value="3">Debit/Credit Card</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="v_id" value="<?= $book['variant_id'] ?>">
          <input type="hidden" name="cawangan_id" value="<?= $book['cawangan_id'] ?>">
          <input type="hidden" name="c_id" value="<?= $book['cust_id'] ?>">
          <button type="submit" id="btnDepoBook" class="btn mb-2 btn-primary">Tambah</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>
<!-- ./Bayaran Deposit modal  -->

<script>
  $('#depoBook').one('submit', function() {
    $('#btnDepoBook').attr('disabled','disabled');
    $("#btnDepoBook").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });
</script>