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
          data-whatever="@mdo">Surat Tempahan Kedai</button>
        <p class="mb-4">
          <br>Tarikh : <?= date("d-m-Y", strtotime($book['tarikh'])); ?>
          <br>Jurujual : <?= $book['staf_name'] ?>
          <br>
        </p>
      </div>
      <!-- Resit / Invois button and modal -->
    </div> <!-- /.row -->
    <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" width="33%">Info Produk</th>
            <th class="text-center">Nota</th>
            <th class="text-center" width="15%">Berat</th>
            <th class="text-center" width="18%">Deposit Tempahan ( RM )</th>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td>
              <div class="row justify-content-center text-center">
                <div class="">
                  <?= $book['product_name'] ?>
                  <br>
                  <small>[ <?= $book['v_sn'] ?> ]</small>
                </div>
                <div class="ml-3">
                  MUTU : <?= $book['mutu'] ?>
                </div>
              </div>
            </td>
            <td class="text-center"><?= $book['nota'] ?></td>
            <td class="text-center">
              <?= $book['v_weight'] ?> g
              <br>
              <?= $book['v_sb']; ?> sb
            </td>
            <td class="text-center"><?= $book['harga'] ?></td>
          </tr>


          <tr>
            <td colspan="2/" class="text-dark test"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important; ">
              <?php if ($syarat_kedai) {

                $i = 1 ;

                foreach ($syarat_kedai as $key ) { ?>
                  <small><?= $i++ ?> . <?= $key['text'] ?></small><br>
                <?php }
              } ?>
            </td>
            <td class="text-right pb-0"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              Jumlah
            </td>
            <td class="text-center pb-0"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              <input type="text" class="form-control text-center" style='' value="<?= $book['harga'] ?>" readonly>
            </td>
          </tr>
          <!-- <tr class="pb-0">
            <td class="text-dark pb-0" colspan="3"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              <br><br><br>
            </td>
          </tr> -->
          <!-- <tr class="pb-0">
            <td class="text-dark pb-0" colspan="3"
              style="border-left-color: #ffffff !important;border-bottom-color: #ffffff !important;border-right-color: #ffffff !important;">
              <span>----------------------------------</span><span
                class="ml-5">----------------------------------</span><br>
              <span class="ml-4">Tandatangan Pelanggan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <span
                class="ml-5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tandatangan
                Penjual </span>
            </td>
          </tr> -->
        </tbody>
      </table>
  </div>
</div>

<a href="<?= base_url('catalog/print_tempahan/'.$book['variant_id']) ?>" target="_blank" class="btn btn-info float-right text-light"><span class="fe fe-printer fe-16"></span> CETAK </a>

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
      <?= form_open('booking/deposit_booking_shop', array('id'=>'depoShop')); ?>
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
          <input type="hidden" name="c_id" value="<?= $book['cust_id'] ?>">
          <input type="hidden" name="cawangan" value="<?= $book['cawangan_id'] ?>">
          <button type="submit" id="btnDepoShop" class="btn mb-2 btn-primary">Tambah</button>
        </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>
<!-- ./Bayaran Deposit modal  -->

<script>
  $('#depoShop').one('submit', function() {
    $('#btnDepoShop').attr('disabled','disabled');
    $("#btnDepoShop").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });
</script>