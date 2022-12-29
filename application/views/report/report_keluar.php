<?php echo $this->session->flashdata('upload'); ?>

<div class="col-md-12">
  <h4>Senarai Produk Keluar</h4>
  <div class="card shadow">
    <div class="card-body">
      <!-- table -->
      <table class="table datatables" id="dataTable-1">
      <!-- <table class="table datatables" id="example"> -->
      
        <thead>
          <th class="text-center">Bil</th>
          <th class="text-center">Pelanggan</th>
          <th class="text-center">Staff</th>
          <th class="text-center">Kategori</th>
          <th class="text-center">Bayaran ( RM )</th>
          <th class="text-center">Tarikh Bayaran</th>
          <th class="text-center">Maklumat Transaksi</th>
        </thead>
        <tbody>
          <?php

          if ($keluar) {
          
          $i=1;
  
          foreach ($keluar as $row){ ?>
          <tr class="text-center">
            <td class="text-center"><?php echo $i++;?></td>
            <td class="text-center">
              <?= $row['v_sn'] ?>
            </td>
            <td class="text-center">
              
            </td>
            <td class="text-center">
              
            </td>
            <td class="text-center">
              
            </td>
            <td class="text-center">
              
            </td>
            <td class="text-center">
       
            </td>
          </tr>
          <?php } } ?>

        </tbody>
      </table>
    </div>
  </div>
</div>
