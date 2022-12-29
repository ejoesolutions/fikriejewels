<div class="card shadow mb-4">
  <div class="card-body">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table nowrap text-dark" id="dataTable-1">
          <thead>
            <tr class="uppercase">
              <th nowrap class="text-center">No.</th>
              <th nowrap class="text-center">No.Siri</th>
              <th nowrap class="text-center">Status</th>
              <th nowrap class="text-center">Disemak Oleh</th>
              <th nowrap class="text-center">Tarikh Semak</th>
            </tr>
          </thead>
          <tbody>

            <?php if(($check)):

            $i=1;

            foreach ($check as $row) { ?>

              <tr>
                <td class="text-center"><?= $i++; ?></td>
                <td class="text-center"><?= $row['v_sn']; ?></td>
                <td class="text-center">
                  <a class="text-dark" title="Lihat Produk" href="<?= base_url('catalog/product_edit/'.$row['product_id']) ?>"><?= $row['product_name']; ?></a>
                </td>
                <td class="text-center"><?= $row['v_weight']; ?></td>
                <td class="text-center">
                  <?php if ($row['status'] == 1) {
                    echo '<span class="text-success"><i class="fe fe-check-square fe-20"></i></span>';
                  } ?>
                </td>
                <td class="text-center"><?= $row['username']; ?></td>
                <td class="text-center">
                  <?php if ($row['date_checked']) { ?>
                    <?= date('Y-m-d', strtotime($row['date_checked'])) ?> | <?= date('h:i a', strtotime($row['date_checked'])) ?>
                  <?php } ?>
                </td>
              </tr>

            <?php }

            endif; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>$('.select2').select2('open');</script>