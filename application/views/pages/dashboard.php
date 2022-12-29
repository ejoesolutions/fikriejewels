<?php if ($this->agent->is_mobile()) { ?>
  <div class="container text-center mb-4"><video width="50%" id="preview"></video></div>

  <div id="result"></div>
<?php }else { ?>
  <div class="col-md-12 mb-4">
    <h4>Semak Produk</h4>
    <div class="card shadow">
      <div class="card-body">
        <div class="form-group row justify-content-center">
          <div class="col-md-5 col-xl-4">
            <select class="custom-select select2" id="variants">
              <option selected>--Pilih--</option>
              <?php
                if(!empty($variants))
                {
                  foreach ($variants as $key) { ?>
                    <option value="<?php echo $key['v_sn'] ?>"><?= $key['v_sn'] ?></option>
                  <?php }
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row justify-content-center mb-1" id="button">
        </div>
        <div id="result"></div>
      </div>
    </div>
  </div>
<?php } ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <?php foreach ($cawangan as $row) { ?>
          <div class="col-md-12">
            <!-- <h5><?= $row['name'] ?></h5> -->
            <div class="row">
              <div class="col-lg-6 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <a href="<?= base_url('orders/list_orders/2') ?>">
                      <div class="row align-items-center">
                        <div class="col-3 text-center">
                          <span class="circle circle-sm bg-primary">
                            <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                          </span>
                        </div>
                        <div class="col pr-0">
                          <p class="small text-muted mb-0">Pesanan Bulan Ini ( <?= $this->order_model->count_orders($row['id']) ?> )</p>
                          <span class="h4 mb-0">
                            RM <?= $this->order_model->payment_orders($row['id']) + $this->order_model->get_payment_repair($row['id']) ? number_format($this->order_model->payment_orders($row['id']) + $this->order_model->get_payment_repair($row['id']), 2, '.', ',') : '0.00' ?>
                          </span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="card shadow">
                  <div class="card-body">
                    <a href="<?= base_url('report/stok_in_hand') ?>">
                      <div class="row align-items-center">
                        <div class="col-3 text-center">
                          <span class="circle circle-sm bg-primary">
                            <i class="fe fe-16 fe-box text-white mb-0"></i>
                          </span>
                        </div>
                        <div class="col">
                          <p class="small text-muted mb-0">Stok Terkini</p>
                          <div class="row align-items-center no-gutters">
                            <div class="col-auto">
                              <span class="h4 mr-2 mb-0"><?= $this->product_model->list_variant_in_stock($row['id']) ? count($this->product_model->list_variant_in_stock($row['id'])) : 0 ?></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <!-- widgets -->
      <div class="mb-2 align-items-center overflow-auto">
        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="row">
              <canvas id="myChart" width="400" height="115"></canvas>
            </div>
          </div>
        </div>
      </div>
    <!-- linechart -->
    <div class="row">
      <div class="col-md-8">
        <div class="card shadow eq-card">
          <div class="card-header">
            <strong class="card-title">Transaksi Terbaru</strong>
            <a class="float-right small text-muted" href="<?= base_url('report/get_report') ?>">Lihat Semua</a>
          </div>
          <div class="card-body">
            <table class="table table-hover table-borderless table-striped mt-n3 mb-n1">
              <thead>
                <tr>
                  <th nowrap>Pelanggan</th>
                  <th nowrap>Staf</th>
                  <th nowrap>Kategori</th>
                  <th nowrap>Bayaran ( RM )</th>
                  <th nowrap>#</th>
                </tr>
              </thead>
              <tbody>
              <?php if ($transaksi) {
                foreach ($transaksi as $row) { ?>
                <tr>
                  <td>
                    <?php if ($row['status']==8 || $row['status']==9) { ?>
                      -
                    <?php }else { ?>
                      <span class="d-inline-block text-truncate small" style="max-width: 170px;">
                        <?= $row['cust'] ?>
                      </span>
                    <?php } ?>
                  </td>
                  <td><?= $row['staff'] ?></td>
                  <td><?= $row['keterangan'] ?></td>
                  <td>
                    <?= number_format($row['bayaran'], 2, '.', ''); ?>
                  </td>
                  <td class="text-primary">
                    <?php if ($row['order_id']) { ?>
                      <a href="<?= base_url('orders/detail/'.$row['order_id']) ?>"><i class="fe fe-search fe-20"></i></a>
                    <?php }else {
                      echo '-';
                    } ?>
                  </td>
                </tr>
              <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow eq-card">
          <div class="card-header">
            <strong class="card-title">Pesanan Terbaru</strong>
            <a class="float-right small text-muted" href="<?= base_url('orders/list_orders') ?>">Lihat Semua</a>
          </div>
          <div class="card-body">
            <table class="table table-hover table-borderless table-striped mt-n3 mb-n1">
              <thead>
                <tr>
                  <th nowrap>No.Pesanan</th>
                  <th nowrap>Jumlah ( RM )</th>
                  <th nowrap>Status</th>
                  <th nowrap>#</th>
                </tr>
              </thead>
              <tbody>
              <?php if ($order) {
                foreach ($order as $orders) { ?>
                <tr>
                  <td><?= $orders['order_no'] ?></td>
                  <td>
                    <?php if ($orders['order_category'] == 9) {
                      echo $orders['subtotal'];
                    }else {
                      echo $orders['paid_total'];
                    } ?>
                  </td>
                  <td>
                    <?php if ($orders['sold'] == 1 || $orders['order_category'] == 9) {
                      echo "<span class='text-green'>Selesai</span>";
                    }elseif ($orders['sold'] == 2) {
                      echo "<span class='text-danger'>Batal</span>"; 
                    }else {
                      echo "<span class='text-warning'>Deposit</span>"; 
                    } ?>
                  </td>
                  <td>
                  <?php if ($orders['order_category'] == 9) {
                    echo '<a href="'.base_url('booking/repair_detail/'.$orders['repair_id']).'"  title="Lihat Invois" class="text-green"><span class="fe fe-file fe-20"></span></a>';
                  }else {
                    echo '<a href="'.base_url('orders/detail/'.$orders['order_id']).'"  title="Lihat Invois" class="text-green"><span class="fe fe-file fe-20"></span></a>';
                  } ?>
                  </td>
                </tr>
              <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->

<script>
  const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun','Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'],
      datasets: [
      <?php foreach ($cawangan as $row) { ?>
        {
          label: `Transaksi <?= $row['name'] ?>`,
          data:
          [
            <?php for ($i=1; $i < 13; $i++) { ?>
              <?= $this->report_model->get_trans_by_month($i, $row['id']) ? $this->report_model->get_trans_by_month($i, $row['id']) : '0.00'; ?>,
            <?php } ?>
          ],
          backgroundColor: [
            'rgba(<?= $row['bg_color'] ? $row['bg_color'] : "52, 152, 219" ?>, 0.2)'
          ],
          borderColor: [
            'rgba(<?= $row['bg_color'] ? $row['bg_color'] : "125, 60, 152" ?>, 1)'
          ],
          borderWidth: 3
        },
      <?php } ?>
    ]
    },
    labels: ['Red', 'Blue', 'Purple', 'Yellow'],
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // qrscanner section 

  let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false,continuous: true, backgroundScan: true, scanPeriod: 1});
  scanner.addListener('scan', function (content) {
      // console.log(content);

      // var oTable = $('#example').dataTable();

      // $search = document.getElementById("text").value = content;

      // oTable.fnFilter($search);
      

      $.ajax({
        url: '<?= base_url(); ?>report/check_list_variants_dash',
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

  $('#variants').on('change', function (e) {
    var variants = $('#variants').val();
    if(variants!=''){
      $.ajax({
        url: '<?= base_url(); ?>report/check_list_variants_dash',
        type: 'POST',
        dataType: "text",  
        cache: false,
        data: { sn : variants},
        success: 
        function(data){
          $("#result").html(data)
        },
      });
    }

    // if ($('#variants').val()) {
    //   Swal.fire({
    //     icon: 'success',
    //     title: '<h4>Produk Ada</h4>',
    //     showConfirmButton: false,
    //     timer: 1100
    //   })
    // }else {
    //   Swal.fire({
    //     icon: 'error',
    //     title: '<h4>Produk Tiada</h4>',
    //     showConfirmButton: false,
    //     timer: 1100
    //   })
    // }
    
  });
</script>