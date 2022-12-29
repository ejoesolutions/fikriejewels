<?= $this->session->flashdata('upload'); ?>

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
          </select>
        </div>
      </div>

      <!-- carian tarikh -->
      <div id="byDateAfter" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tarikh ( Selepas )</label>
        <div class="col-md-5 col-xl-3">
          <input type="text" name="date_min" id="date_min" class="form-control drgpicker">
        </div>
      </div>

      <div id="byDateBefore" class="form-group row justify-content-center" style="display:none">
        <label class="col-md-4 col-xl-2 col-form-label">Tarikh ( Sebelum )</label>
        <div class="col-md-5 col-xl-3">
          <input type="text" name="date_max" id="date_max" class="form-control drgpicker">
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

      <div class="form-group row justify-content-center mb-1" id="button">
        <label class="col-md-4 col-xl-2 col-form-label"></label>
        <div class="col-md-5 col-xl-3">
          <button type="submit" class="btn btn-block btn-primary btn-sm">Cari</button>
        </div>
      </div>

      <?= form_close(); ?>

    </div>
  </div>
</div>

<hr>

<div class="col-md-12">
  <?php foreach ($cawangan as $row) { ?>
    <h4><?= $row['name'] ?></h4>
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table text-dark" id="example">
            <thead class="text-center">
              <th>Laporan</th>
              <th>Jumlah</th>
              <th>#</th>
            </thead>
            <tbody class="text-center">
              <tr>
                <td>Pesanan</td>
                <td>
                  RM <?= $order['total'] ? number_format($order['total'], 2, '.', ',') : '0.00' ?>
                </td>
                <td>
                  <a href="<?= base_url('orders/list_orders') ?>">Lihat Perincian</a>
                </td>
              </tr>
              <tr>
                <td>Jualan</td>
                <td>
                  RM <?= $jualan['total'] ? number_format($jualan['total'], 2, '.', ',') : '0.00' ?>
                </td>
                <td>
                  <a href="<?= base_url('report/variants_out') ?>">Lihat Perincian</a>
                </td>
              </tr>
              <tr>
                <td>Transaksi</td>
                <td>
                  RM <?= $this->report_model->get_trans_by_month(NULL, $row['id']) ? number_format($this->report_model->get_trans_by_month(NULL, $row['id']), 2, '.', ',') : '0.00'; ?>
                </td>
                <td>
                  <a href="<?= base_url('report/get_report') ?>">Lihat Perincian</a>
                </td>
              </tr>
              <tr>
                <td>Belian</td>
                <td>
                  RM <?= $belian['total'] ? number_format($belian['total'], 2, '.', ',') : '0.00' ?>
                </td>
                <td>
                  <a href="<?= base_url('buy/list_buy') ?>">Lihat Perincian</a>
                </td>
              </tr>
              <!-- <tr>
                <td>Deposit</td>
                <td>
                  RM <?= $deposit['total'] ?>
                </td>
                <td>
                  <a href="<?= base_url('report/get_report') ?>">Lihat Perincian</a>
                </td>
              </tr> -->
              <!-- <tr>
                <td>Cash In</td>
                <td>
                  RM <?= $cash_in['total'] ?>
                </td>
                <td>
                  <a href="<?= base_url('report/cash_in_out') ?>">Lihat Perincian</a>
                </td>
              </tr>
              <tr>
                <td>Cash Out</td>
                <td>
                  RM <?= $cash_out['total'] ?>
                </td>
                <td>
                  <a href="<?= base_url('report/cash_in_out') ?>">Lihat Perincian</a>
                </td>
              </tr>
              <tr>
                <td>Expenses</td>
                <td>
                  RM <?= $expenses['total'] ?>
                </td>
                <td>
                  <a href="<?= base_url('report/cash_in_out') ?>">Lihat Perincian</a>
                </td>
              </tr> -->
              <!-- <tr>
                <td>Upah ( Jualan )</td>
                <td>
                  RM <?= $upah['total'] ?>
                </td>
                <td>
                  <a href="<?= base_url('report/variants_out') ?>">Lihat Perincian</a>
                </td>
              </tr> -->
              <!-- <tr>
                <td>Upah ( Untung )</td>
                <td>
                  RM 
                  
                  <?php

                  $x = number_format($untung['total_kod'] / 3,2,'.','');

                  echo $total = number_format($upah['total'] - $x , 2, '.', ',')  ?>
                </td>
                <td>
                  <a href="<?= base_url('report/variants_out') ?>">Lihat Perincian</a>
                </td>
              </tr> -->
              <tr>
                <td>Stok In Hand</td>
                <td><?= $this->product_model->list_variant_in_stock($row['id']) ? count($this->product_model->list_variant_in_stock($row['id'])) : 0 ?> item</td>
                <td><a href="<?= base_url('report/stok_in_hand') ?>">Lihat Perincian</a></td>
              </tr>
              <tr>
                <td>Berat Stok In Hand</td>
                <td><?= $weight['total'] ? number_format($weight['total'], 2, '.', ',') : 0 ?> gram</td>
                <td><a href="<?= base_url('report/stok_in_hand') ?>">Lihat Perincian</a></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>

</div>


<script>

$("#carian").change(function () {

  var carian = $("#carian").val();

  if (carian == 1)  {

    document.getElementById('byDateAfter').style.display = null;
    document.getElementById('byDateBefore').style.display = null;
    document.getElementById('button').style.display = null;      
    document.getElementById('byYear').style.display = "none";
    document.getElementById('byMonth').style.display = "none";

  }else if (carian == 2) {

    document.getElementById('byYear').style.display = null;
    document.getElementById('byMonth').style.display = null;
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

</script>