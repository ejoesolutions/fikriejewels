<?php echo $this->session->flashdata('upload'); ?>

<div class="col-md-12">
  <h4 class="page-title">Senarai Pelanggan <button type="button" class="btn mb-0 btn-primary" id="btn_register" data-toggle="modal" data-target="#modal_updVariant">+ Pelanggan Baru </button></h4>
  <div class="card shadow">
    <div class="card-body">
      <!-- table -->
      <div class="table-responsive">
      <table class="table nowrap text-dark" id="dataTable-1">
        <thead>
          <th class="text-center">No.</th>
          <th>Nama</th>
          <th class="text-center">No Telefon</th>
          <th class="text-center">#</th>
        </thead>
        <tbody>
          <?php if ($cust) {

            $i=1;

            foreach ($cust as $row){ ?>
            <tr>
              <td class="text-center"><?= $i++;?></td>
              <td><?= $row['name'] ?></td>
              <td class="text-center"><?= $row['phone'] ?></td>
              <td class="text-center">
                <?= anchor('user/detail_cust/'.$row['id'], '<i class="fe fe-search fe-20"></i>',['title'=>'Lihat']) ;?>
              </td>
            </tr>
          <?php } } ?>
        </tbody>
      </table>
    </div>
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
      
        <?= form_open('user/register_cust_all',array('class'=>'form-horizontal','id'=>'addCustomer')) ?>

        <?php $this->load->view('customer/register_form'); ?>

        <?= form_close() ?>

    </div>
  </div>
</div>

<script>
  $('#addCustomer').one('submit', function() {
    document.getElementById("btnAddCustomer").disabled = true;
  });
</script>