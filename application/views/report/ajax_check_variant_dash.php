<?php if ($result) { ?>

  <div class="table-responsive">
  <table class="table nowrap" id="example">
    <thead>
      <tr class="uppercase">
        <th width="10%" class="text-center">Gambar</th>
        <th nowrap class="text-center">Siri Nombor</th>
        <th nowrap class="text-center" width="18%">Maklumat</th>
        <th nowrap class="text-center">Berat ( g )</th>
        <th nowrap class="text-center">Harga Semasa ( RM )</th>
        <th nowrap class="text-center">Harga Dasar ( RM )</th>
        <th nowrap class="text-center">Harga Kaunter ( RM )</th>
        <th nowrap class="text-center">Tarikh</th>
      </tr>
    </thead>

    <tbody>

      <?php if(!empty($result)): ?>

      <?php

      $i=1;

      foreach ($result as $row) { ?>

        <?php if ($row['v_status']==6 && !$row['sta_cust']) {
          echo '<tr style="background-color:#FCF3CF">';
        }else {
          echo '<tr>';
        } ?>
        <td class="text-center" style="width:150px;height:150px">
          <a href="<?= base_url('catalog/product_edit/'.$row['product_id']) ?>">
            <?php
              if ($row['image']) {
                $image_properties = array(
                  'src'   => base_url().'images/thumbnail/'.$row['image'],
                  'alt'   => $row['product_name'],
                  'class' => 'avatar-img',
                  'title' => 'Lihat Perincian Produk',
                  'style' => 'height: 100%; width: 100%; object-fit: contain',
                );

                echo img($image_properties);

              } else {

                $image_properties = array(
                  'src'   => 'https://dummyimage.com/300x300/1C2833/9b9dad.jpg&text=No+Image',
                  'alt'   => 'No image',
                  'class' => 'avatar-img',
                  'title' => 'Lihat Perincian Produk',
                  'width' => '100%'
                );

                echo img($image_properties);
              }
            ?>
          </a>
        </td>
        <td class="text-center">
          <?php echo '<small class="">'.$row['tag'].'</small><br>
          <a class="text-dark" href="'.base_url("orders/print_tag/".$row['variant_id']).'" title="Cetak Tag" target="_blank">
          '.$row['v_sn'].'<br>
          <span class="h1 text-dark"><i class="fas fa-qrcode"></i></span><br>
          <small class="float-left mt-2 mr-1">sisemas.com</small>
          <small class="float-right mt-2">KJ :'. $row['v_kod'] .'</small></a>' ?>
        </td>
    
        <td>

          <small class="row text-dark justify-content-center mb-2"><?= $row['staf_name'] ?></small>
          <div class="row justify-content-center">
            <div>
              <small>
                B :
                <?php
                  if($row['v_weight']!='')
                  {
                    echo $row['v_weight'].' g';
                  }else{
                    echo '-';
                  }
                ?>
              </small>
              <br>
              <small>
                P :
                <?php
                  if($row['v_length']!='')
                  {
                    echo $row['v_length'].' cm';
                  }else{
                    echo '-';
                  }
                ?>
              </small>
              <br>
              <small>
                L :
                <?php
                  if($row['v_width']!='')
                  {
                    echo $row['v_width'].' cm';
                  }else{
                    echo '-';
                  }
                ?>
              </small>
              <br>
              <small>
                Sz :
                <?php
                  if($row['v_size']!='')
                  {
                    echo $row['v_size'];
                  }else{
                    echo '-';
                  }
                ?>
              </small>
            </div>

            <div class="ml-lg-3">
              <!-- <small>
                Sb :
                <?php
                  if($row['v_sb']!='')
                  {
                    echo $row['v_sb'];
                  }else{
                    echo '-';
                  }
                ?>
              </small>
              <br> -->
              <small>
                Up :
                <?php
                  if($row['v_margin_pay']!='')
                  {
                    echo $row['v_margin_pay'];
                  }else{
                    echo '-';
                  }
                ?>
              </small>
              <br>
              <small>
                M :
                <?php
                  if($row['mutu']!='')
                  {
                    echo $row['mutu'];
                  }else{
                    echo '-';
                  }
                ?>
              </small>
            </div>
          </div>
        </td>
        <td class="text-center">
        <?php
          if($row['v_weight']){
            echo $row['v_weight'];
          }
        ?>
        </td>
        <td class="text-center">
          <?= $current_v_emas = number_format($row['v_weight'] * $row['setup_price'], 2, '.', ''); ?>
          <br>
          <small class="text-secondary"><?php echo $row['setup_price'] ?> / g</small>
        </td>
        <td class="text-center">
          <?= $current_v_dasar = number_format($current_v_emas +  $row['v_pay'], 2, '.', ''); ?>
          <br>
          <small class="text-secondary">Up : <?php echo $row['v_pay'] ?></small>
        </td>
        <td class="text-center"><?= number_format($current_v_dasar + $row['v_margin_pay'], 2, '.', ''); ?></td>
        <td class="text-center">
          <?= date("Y-m-d", strtotime($row['insert_date'])); ?>
          <br>
          <?= date("h:i a", strtotime($row['insert_date'])); ?>
        </td>
      </tr>

      <?php } ?>

      <?php endif; ?>

    </tbody>
  </table>
  </div>
  <script>
    Swal.fire({
      icon: 'success',
      title: '<h4>Produk Ada</h4>',
      showConfirmButton: false,
      timer: 1100
    })
  </script>
<?php }else { ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: '<h4>Produk Tiada</h4>',
      showConfirmButton: false,
      timer: 1100
    })
  </script>
<?php } ?>