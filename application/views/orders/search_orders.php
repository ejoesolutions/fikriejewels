<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="w-50 mx-auto text-center justify-content-center py-5 my-5">
        <h2 class="page-title mb-0">Masukkan Nombor Pesanan</h2>
        <p class="lead text-muted mb-4"></p>
        <?= form_open('', array('class'=>'searchform searchform-lg')) ?>
          <input class="form-control form-control-lg bg-white rounded-pill pl-5" type="search" placeholder="Carian"
            aria-label="Search" name="search">
          <p class="help-text mt-2 text-muted">Masukkan Nombor Pesanan Termasuk " # "</p>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>


<?php if (isset($_POST['search'])) { ?>

<div class="col-md-12">
  <div class="card shadow">
    <div class="card-body">
      <table class="table datatables text-dark" id="dataTable-search">
        <thead>
          <tr>
              <th width="50px" class="text-center">No.</th>
              <th class="text-center">No.Pesanan</th>
              <th>Nama Pelanggan</th>
              <th class="text-center">Staf</th>
              <th class="text-center">Cawangan</th>
              <th class="text-center">Bayaran ( RM )</th>
              <th class="text-center">Kategori</th>
              <th class="text-center">Tarikh</th>
              <th class="text-center">Status</th>
              <th class="text-center">#</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($orders):
          $n=1;

          foreach ($orders as $order) { ?>
          <tr>
            <td class="text-center"><?= $n++; ?></td>
            <td class="text-center"><?= $order['order_no'] ?></td>
            <td><?= $order['cust']; ?></td>
            <td class="text-center"><?= $order['staf']; ?></td>
            <td class="text-center"><?= $order['cawangan']; ?></td>
            <td class="text-center">
              <?php 
              if ($order['order_category'] == 9) {
                echo $order['subtotal'];
              }else {
                echo $order['paid_total'];
              }
              ?>
            </td>
            <td class="text-center">
              <?php if ($order['kategori'] == 1) {
                echo "Ikat Harga";
              }elseif ($order['kategori'] == 2) {
                echo "Harga Semasa";
              }elseif ($order['order_category'] == 9) {
                echo "Tempahan Baiki";
              } ?>
            </td>
            <td class="text-center"><?= date("d-m-Y",strtotime($order['created_date'])); ?></td>
            <td class="text-center">
              <?php if ($order['sold'] == 1 || $order['order_category'] == 9) {
                echo "<span class='text-green'>Selesai</span>";
              }elseif ($order['sold'] == 2) {
                $status = "<span class='text-danger'>Batal</span>";
              }else {
                echo "<span class='text-warning'>Deposit</span>"; 
              } ?>
            </td>
            <td class="text-center">
              <?php if ($order['order_category'] == 9) { ?>
                <a href="<?= base_url('booking/repair_detail/'.$order['repair_id']) ?>"  title="Lihat Invois" class="text-green"><span class="fe fe-file fe-20"></span></a>
              <?php }else { ?>
                <a href="<?= base_url('orders/detail/'.$order['order_id']) ?>"  title="Lihat Invois" class="text-green"><span class="fe fe-file fe-20"></span></a>
              <?php } ?>
              |
              <?php if ($order['order_category'] == 9) { ?>
                <a href="<?= base_url('booking/print_repair/'.$order['repair_id']) ?>" target="_blank" title="Cetak Invois" class=""><span class="fe fe-printer fe-20"></span></a>
              <?php }else { ?>
                <a href="<?= base_url('orders/print_order/'.$order['order_id']) ?>" target="_blank" title="Cetak Invois" class=""><span class="fe fe-printer fe-20"></span></a>
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

<?php } ?>


<script>

  $(document).ready(function() {
    $('#dataTable-search').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    } );
  } );

</script>