<?= $this->session->flashdata('upload'); ?>

<h4 class="page-title">Keterangan Produk</h4>
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12 margin-top-20">

      <?= form_open_multipart('catalog/store_product_update', array('id'=>'updateProduct')); ?>

    <input type="hidden" name="product_id" id="product_id" value="<?= $product['product_id']; ?>">

    <div class="form-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group margin-top-20">
            <div class="fileinput fileinput-new" data-provides="fileinput">
              <div class="fileinput-new thumbnail img-fluid">

                <?php

                if ($product['product_image'] != '') {

                  // $info = pathinfo( $product['product_image'] );
                  // $no_extension =  basename( $product['product_image'], '.'.$info['extension'] );
                  // $thumb_image = $no_extension.'_thumb.'.$info['extension'];
                  $image_properties = array(
                    'src'   => base_url().'images/thumbnail/'.$product['product_image'],
                    'alt'   => $product['product_name'],
                    'class' => 'avatar-img',
                    'title' => $product['product_name'],
                    'width' => '100%'
                  );

                } else {

                  $image_properties = array(
                    'src'   => 'https://via.placeholder.com/500',
                    'alt'   => $product['product_name'],
                    'class' => 'img-thumbnail',
                    'title' => $product['product_name'],
                  );
                }

                echo img($image_properties);

                ?>

              </div>
              <div class="fileinput-preview fileinput-exists img-thumbnail img-responsive"></div>
              <div>
                <span class="btn default btn-file pl-0 pr-0">
                  <span class="fileinput-new btn btn-info"><i class="fe fe-camera fe-16"></i> <?php echo lang('form_button_image') ?> </span>
                  <!-- <span class="fileinput-exists btn btn-info"> <?php echo lang('form_button_image_change') ?> </span> -->
                  <input type="file" name="userfile">
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
        </div>

        <div class="col-md-8">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Nama Produk</label>
                <input type="text" name="product_name" value="<?= $product['product_name'] ?>" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Kedai</label>
                <?php if (!empty($variants)) { ?>
                  <select id="cawangan" class="form-control" disabled>
                <?php }else { ?>
                  <select id="cawangan" class="form-control" name="cawangan">
                <?php } ?>
                  <?php foreach ($cawangan as $key) { 
                    if ($product['cawangan_id'] == $key['id']) { ?>
                      <option value="<?= $key['id'] ?>" name="<?= $key['cawangan_code'] ?>" selected><?= $key['name'] ?></option>
                    <?php }else { ?>
                      <option value="<?= $key['id'] ?>" name="<?= $key['cawangan_code'] ?>" selected><?= $key['name'] ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Kategori</label>

                <?php if (!empty($variants)) { ?>
                  <select id="category" class="form-control" disabled>
                <?php }else { ?>
                  <select id="category" class="form-control" name="category">
                <?php } ?>

                <?php
                if(!empty($category))
                {
                  foreach ($category as $row) {
                    if($product['cat_id']==$row['cat_id']) { ?>
                      <option value="<?php echo $row['cat_id'] ?>" name="<?= $row['category_code'] ?>" selected><?= $row['category_name'] ?></option>
                      <?php
                    }else{ ?>
                      <option value="<?php echo $row['cat_id'] ?>" name="<?php echo $row['category_code'] ?>" ><?php echo $row['category_name'] ?></option>
                    <?php
                    }
                  }
                } ?>
               </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Dulang</label>
                <?php if (!empty($variants)) { ?>
                  <select id="dulang" class="form-control" disabled>
                <?php }else { ?>
                  <select id="dulang" class="form-control" name="dulang">
                <?php } ?>
                  <?php
                  if(!empty($dulang))
                  {
                    foreach ($dulang as $key) { 
                      if ($product['dulang_id']==$key['id']) { ?>
                        <option value="<?= $key['id'] ?>" name="<?= $key['dulang_code'] ?>" selected><?= $key['dulang_name'] ?></option>
                      <?php }else { ?>
                        <option value="<?= $key['id'] ?>" name="<?= $key['dulang_code'] ?>" ><?= $key['dulang_name'] ?></option>
                      <?php } ?>
                    <?php }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Pembekal</label>
                <?php if (!empty($variants)) { ?>
                  <select id="pembekal" class="form-control" disabled>
                <?php }else { ?>
                  <select id="pembekal" class="form-control" name="pembekal">
                <?php } ?>
                <?php
                  if(!empty($pembekal))
                  {
                    foreach ($pembekal as $key) {
                      if ($product['supplier_id']==$key['id']) { ?>
                        <option value="<?php echo $key['id'] ?>" name="<?php echo $key['supplier_code'] ?>" selected><?php echo $key['supplier_name'] ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $key['id'] ?>" name="<?php echo $key['supplier_code'] ?>" ><?php echo $key['supplier_name'] ?></option>
                    <?php }
                    }
                  } 
                ?>
               </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Jenis</label>
                <?php if (!empty($variants)) { ?>
                  <select name="type" id="type" class="form-control" disabled>
                  <option value="<?php echo $product['jenis'] ?>" selected><?php echo $product['jenis'] ?></option>
                  </select>
                <?php }else { ?>
                  <select name="type" id="type" class="form-control">
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                  <option value="F">F</option>
                  <option value="G">G</option>
                  <option value="H">H</option>
                  <option value="I">I</option>
                  <option value="J">J</option>
                  <option value="K">K</option>
                  <option value="L">L</option>
                  <option value="M">M</option>
                  <option value="N">N</option>
                  <option value="O">O</option>
                  <option value="P">P</option>
                  <option value="Q">Q</option>
                  <option value="R">R</option>
                  <option value="S">S</option>
                  <option value="T">T</option>
                  <option value="U">U</option>
                  <option value="V">V</option>
                  <option value="W">W</option>
                  <option value="X">X</option>
                  <option value="Y">Y</option>
                  <option value="Z">Z</option>
                  <option value="A1">A1</option>
                  <option value="B1">B1</option>
                  <option value="C1">C1</option>
                  <option value="D1">D1</option>
                  <option value="E1">E1</option>
                  <option value="F1">F1</option>
                  <option value="G1">G1</option>
                  <option value="H1">H1</option>
                  <option value="I1">I1</option>
                  <option value="J1">J1</option>
                  <option value="K1">K1</option>
                  <option value="L1">L1</option>
                  <option value="M1">M1</option>
                  <option value="N1">N1</option>
                  <option value="O1">O1</option>
                  <option value="P1">P1</option>
                  <option value="Q1">Q1</option>
                  <option value="R1">R1</option>
                  <option value="S1">S1</option>
                  <option value="T1">T1</option>
                  <option value="U1">U1</option>
                  <option value="V1">V1</option>
                  <option value="W1">W1</option>
                  <option value="X1">X1</option>
                  <option value="Y1">Y1</option>
                  <option value="Z1">Z1</option>
                  </select>
                  <script>$('#type').val("<?php echo $product['jenis'] ?>").trigger("change");</script>
                <?php } ?>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Mutu</label>
                <?php if (!empty($variants)) { ?>
                  <select id="mutu" class="form-control" disabled>
                <?php }else { ?>
                  <select id="mutu" class="form-control" name="mutu">
                <?php } ?>

                <?php if(!empty($mutu)) {
                  foreach ($mutu as $key) {
                    if($key['row_id']==$product['mutu_id'])
                    { ?>
                      <option value="<?php echo $key['row_id'] ?>" selected><?php echo $key['mutu'] ?></option>
                    <?php }else{ ?>
                      <option value="<?php echo $key['row_id'] ?>"><?php echo $key['mutu'] ?></option>
                    <?php
                    }
                  }
                } ?>

               </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Kod Produk <span id="check"></span></label>
                <input type="text" class="form-control" id="product_code" name="product_code" value="<?= $product['product_code'] ?>" readonly>
                <!-- <input type="hidden" id="old_product_code" value="<?= $product['product_code'] ?>"> -->
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Keterangan</label>
                <?= form_textarea($description);?>
                <?= form_error('description', '<p class="text-danger">', '</p>'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">

        <input type="hidden" name='image_id' value='<?php echo $product['image_id'];?>'>
        <input type="hidden" name='temp_image' value='<?php echo $product['product_image'];?>'>
        <hr>

        <div class="col-md-offset-8 col-md-2">
          <!-- <div class="form-group">
            <?php echo anchor('catalog/product_detail/'.$product['product_id'], 'Kembali', array('class'=>'btn btn-outline-dark btn-block')) ?>
          </div> -->
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <button type="submit" id="btnAddPro" class="btn btn-primary btn-block">Kemaskini</button>
          </div>
        </div>
      </div>

      <?= form_close() ?>

      <hr>
      <div class="row">
        <div class="col-md-12">
          <?php if ($product['supplier_id'] != 1) { ?>
            <h4><b>Variasi Produk </b><a class="" data-toggle="modal" href="#addVariation" title="Tambah variasi produk"><button class="btn btn-sm btn-primary"> + </button></a></h4><br>
          <?php } ?>
          <div class="table-responsive">
          <table class="table nowrap" id="dataTable-1">
            <thead>
              <tr class="uppercase">
                <th nowrap class="text-center">Bil</th>
                <th nowrap class="text-center">Nombor Siri</th>
                <th class="text-center">Maklumat</th>
                <th nowrap class="text-center">Harga Semasa ( RM )</th>
                <th nowrap class="text-center">Harga Dasar ( RM )</th>
                <th nowrap class="text-center">Harga Kaunter ( RM )</th>
                <th nowrap class="text-center">Tarikh</th>
                <th class="text-center">#</th>
              </tr>
            </thead>

            <tbody>

              <?php if(!empty($variants)): ?>

                <?php

                $i=1;

                  foreach ($variants as $row) { ?>

                    <tr>
                      <td class="text-center"><?php echo $i++; ?></td>
                      <td class="text-center">
                      <!-- <?php $generator = new Picqer\Barcode\BarcodeGeneratorPNG(); ?> -->

                      <?php echo '<a class="text-dark" href="'.base_url("orders/print_tag/".$row['variant_id']).'" title="Cetak Tag" target="_blank">
                      '.$row['v_sn'].'<br>
                      <span class="h1 text-dark"><i class="fas fa-qrcode"></i></span><br>
                      <small class="float-left mt-2">sisemas.com</small>
                      <small class="float-right mt-2">KJ :'. $row['v_kod'] .'</small></a>' ?>
                      </td>

                      <td class="">

                        <span class="row text-dark justify-content-center"><?= $row['tag'] ?></span>

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

                          <div class="ml-3">
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
                         <?= $current_v_emas = number_format($row['v_weight'] * $row['setup_price'], 2, '.', ''); ?>
                         <br>
                         <small class="text-secondary"><?= $row['setup_price'] ?> / g</small>
                        </td>
                        <td class="text-center">
                        <?= $current_v_dasar = number_format($current_v_emas +  $row['v_pay'], 2, '.', ''); ?>
                        <br>
                        <small class="text-secondary">Up : <?= $row['v_pay'] ?></small>
                      </td>
                      <td class="text-center"><?= number_format($current_v_emas + $row['v_margin_pay'], 2, '.', ''); ?></td>
            
                      <td class="text-center">
                        <?= date('Y-m-d',strtotime($row['insert_date'])) ?>
                        <br>
                        <?= date('h:i a',strtotime($row['insert_date'])) ?>
                      </td>

                      <td class="text-center">

                      <?php if($row['v_status']==2 || $row['v_status']==5 || $row['v_status']==0){

                        if ($row['v_status']==2) {
                          echo '<span class="text-warning">KELUAR</span><br>';
                        }elseif ($row['v_status']==5) {
                          echo '<span class="text-warning">TEMPAHAN</span><br>';
                        }
                        ?>

                        <a class="" href='#' data-role="editvariant"

                        data-sn="<?php echo $row['v_sn'] ?>"
                        data-id="<?php echo $row['variant_id'] ?>"
                        data-weight="<?php echo $row['v_weight'] ?>"
                        data-kaunter="<?php echo $row['v_kaunter'] ?>"
                        data-emas="<?php echo $row['v_emas'] ?>"
                        data-dasar="<?php echo $row['v_dasar'] ?>"
                        data-pay="<?php echo $row['v_pay'] ?>"
                        data-sb="<?php echo $row['v_sb'] ?>"
                        data-date="<?php echo $row['insert_date'] ?>"
                        data-margin="<?php echo $row['v_margin'] ?>"
                        data-margin_pay="<?php echo $row['v_margin_pay'] ?>"
                        data-kod="<?php echo $row['v_kod'] ?>"
                        data-size="<?php echo $row['v_size'] ?>"
                        data-length="<?php echo $row['v_length'] ?>"
                        data-width="<?php echo $row['v_width'] ?>"

                        data-toggle="modal" title="Kemaskini"><span class="fe fe-edit fe-20"></span></a>

                        <?php if ( $row['v_status']==0 && ($this->data['user_profile']['user_group'] == 0 || $this->data['user_profile']['user_group'] == 1)) { ?>
                          | 
                          <a class="text-danger" data-toggle="modal" href="#modal_delete" title="Padam"

                          data-sn="<?php echo $row['v_sn'] ?>"
                          data-id="<?php echo $row['variant_id'] ?>"
                          
                          data-role="modal_delete"><span class="fe fe-trash fe-20"></span></a>
                        <?php } ?>
                         
                      <?php }else if($row['v_status']==1){
                        echo '<span class="text-success">DIJUAL</span>';
                      }elseif ($row['v_status']==3) {
                        echo '<span class="text-warning">DEPOSIT</span>';
                      }elseif ($row['v_status']==5) {
                        echo '<span class="text-warning">TEMPAHAN KEDAI</span><br>';
                      }elseif ($row['v_status']==6) {
                        echo '<span class="text-warning">TEMPAHAN BARU</span><br>';
                      }elseif ($row['v_status']==7) {
                        echo '<span class="text-warning">TEMPAHAN BAIKI</span><br>';
                      }elseif ($row['v_status']==8) {
                        echo '<span class="text-warning">TEMPAHAN KEDAI ( SIAP )</span><br>';
                      }  
                      ?>

                      </td>
                    </tr>

                    <?php

                  }

                 ?>

              <?php endif; ?>

            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- modal add variation -->

<div class="modal fade bd-example-modal-lg" id="addVariation" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Variasi Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body text-dark">

        <?= form_open('catalog/store_variant',array('class'=>'form-horizontal','id'=>'addVar')) ?>
        <?= form_hidden('product_id',$product['product_id']); ?>
        <?= form_hidden('product_code',$product['product_code']); ?>
        <!-- <input type="text" value="<?= substr($siri['v_sn'], -4) + 1; ?>"> -->

        <div class="form-group">
          <div class="row col-12 pr-0">
            <label class="control-label col-md-4">Siri Nombor :</label>
            <label class="control-label col-md-8 text-right pr-0">RM <?= $product['setup_price'] ?> / Gram ( <?= $product['mutu_grade']; ?> )</label>
          </div>
          <div class="col-md-12">
            <input type="text" class="form-control uppercase" readonly value="<?= $product['product_code'] ?>">
          </div>
        </div>

        <div class="row col-12 pr-0">
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Berat ( g ) :</label>
                <input type="text" name="v_weight" id="v_weight" class="form-control uppercase" required>
            </div>
          </div>
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">Harga Semasa ( RM ) :</label>
                <input type="text" name="gold_price" id="gold_price" class="form-control uppercase" readonly>
            </div>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Harga Upah ( RM ) :</label>
                <input type="text" name="v_pay" id="v_pay" class="form-control uppercase" required>
            </div>
          </div>
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">Harga Dasar ( RM ) :</label>
                <input type="text" name="base_price" id="base_price" class="form-control uppercase" readonly>
            </div>
          </div>
        </div>
        <div class="row col-12 pr-0">
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Margin ( % ) :</label>
                <input type="text" name="v_margin" id="v_margin" value="<?= $maklumat['margin_upah'] ?>" class="form-control uppercase" required>
            </div>
          </div>
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">Margin Upah ( RM ) <i>( workmanship )</i> :</label>
                <input type="text" name="margin_pay" id="margin_pay" class="form-control uppercase" readonly>
            </div>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <!-- <div class="col-md-6 pr-0"> -->
            <!-- <div class="form-group"> -->
                <!-- <label class="control-label">Seriya Berat :</label> -->
                <input type="text" name="serial_berat" id="serial_berat" class="form-control uppercase" readonly style="display:none">
            <!-- </div> -->
          <!-- </div> -->
          <div class="col-md-12 pr-0">
            <div class="form-group">
              <label class="control-label">Harga Kaunter ( RM ) :</label>
                <input type="text" name="counter_price" id="counter_price" class="form-control uppercase" readonly>
            </div>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <div class="col-md-4 pr-0">
            <div class="form-group">
              <label class="control-label">Saiz :</label>
                <input type="text" name="v_size" id="v_size" class="form-control uppercase">
            </div>
          </div>
          <div class="col-md-4  pr-0">
            <div class="form-group">
              <label class="control-label">Panjang ( cm ) :</label>
                <input type="text" name="v_length" id="v_length" class="form-control uppercase">
            </div>
          </div>
          <div class="col-md-4  pr-0">
            <div class="form-group">
              <label class="control-label">Lebar ( cm ) :</label>
                <input type="text" name="v_width" id="v_width" class="form-control uppercase">
            </div>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Kod Jualan :</label>
                <input type="text" name="v_kod" id="v_kod" class="form-control uppercase">
            </div>
          </div>
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">Tarikh :</label>
              <div class="input-group">
                <input type="text" class="form-control drgpicker" name="insert_date" id="date-input1" aria-describedby="button-addon2" disabled>
                <div class="input-group-append">
                  <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span></div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
        <button type="submit" id="btnAddVar" class="btn btn-primary">Simpan</button>
      </div>

      <?= form_close() ?>

    </div>
  </div>
</div>

<!-- modal edit weight variant -->

<div class="modal fade bd-example-modal-lg" id="modal_updVariant" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Kemaskini Variasi Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body text-dark">

        <?= form_open('catalog/upd_variant',array('class'=>'form-horizontal','id'=>'updVar')) ?>

        <?= form_hidden('product_id',$product['product_id']); ?>

        <div class="form-group">
          <div class="row col-12 pr-0">
            <label class="control-label col-md-4">Siri Nombor :</label>
            <label class="control-label col-md-8 text-right pr-0">RM <?= $product['setup_price'] ?> / Gram ( <?php echo $product['mutu_grade']; ?> )</label>
          </div>
          <div class="col-md-12">
            <input type="text" name="upd_v_sn" id="upd_v_sn" class="form-control uppercase" readonly>
            <input type="hidden" name="upd_v_id" id="upd_v_id" class="form-control uppercase" readonly>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Berat ( g ) :</label>
                <input type="text" name="upd_v_weight" id="upd_v_weight" class="form-control uppercase" required>
            </div>
          </div>
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">Harga Semasa ( RM ) :</label>
                <input type="text" name="upd_gold_price" id="upd_gold_price" class="form-control uppercase" readonly>
            </div>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Harga Upah ( RM ) :</label>
                <input type="text" name="upd_v_pay" id="upd_v_pay" class="form-control uppercase" required>
            </div>
          </div>
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">Harga Dasar ( RM ) :</label>
                <input type="text" name="upd_base_price" id="upd_base_price" class="form-control uppercase" readonly>
            </div>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Margin ( % )  :</label>
                <input type="text" name="upd_v_margin" id="upd_v_margin" value="45" class="form-control uppercase" required>
            </div>
          </div>
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">Margin Upah ( RM ) <i>( workmanship )</i> :</label>
                <input type="text" name="upd_margin_pay" id="upd_margin_pay" class="form-control uppercase" readonly>
            </div>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <!-- <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Seriya Berat :</label> -->
                <input type="text" name="upd_serial_berat" id="upd_serial_berat" class="form-control uppercase" readonly style="display:none">
            <!-- </div>
          </div> -->
          <div class="col-md-12 pr-0">
            <div class="form-group">
              <label class="control-label">Harga Kaunter ( RM ) :</label>
                <input type="text" name="upd_v_kaunter" id="upd_v_kaunter" class="form-control uppercase" readonly>
            </div>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <div class="col-md-4 pr-0">
            <div class="form-group">
              <label class="control-label">Saiz :</label>
                <input type="text" name="upd_v_size" id="upd_v_size" class="form-control uppercase">
            </div>
          </div>
          <div class="col-md-4  pr-0">
            <div class="form-group">
              <label class="control-label">Panjang ( cm ) :</label>
                <input type="text" name="upd_v_length" id="upd_v_length" class="form-control uppercase">
            </div>
          </div>
          <div class="col-md-4  pr-0">
            <div class="form-group">
              <label class="control-label">Lebar ( cm ) :</label>
                <input type="text" name="upd_v_width" id="upd_v_width" class="form-control uppercase">
            </div>
          </div>
        </div>

        <div class="row col-12 pr-0">
          <div class="col-md-6 pr-0">
            <div class="form-group">
              <label class="control-label">Kod Jualan :</label>
                <input type="text" name="upd_v_kod" id="upd_v_kod" class="form-control uppercase">
            </div>
          </div>
          <div class="col-md-6  pr-0">
            <div class="form-group">
              <label class="control-label">Tarikh :</label>
              <div class="input-group">
                <input type="text" class="form-control drgpicker" name="upd_insert_date" id="upd_insert_date" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16"></span></div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
        <button id="btnUpdVar" type="submit" class="btn btn-primary">Simpan</button>
      </div>

      <?php echo form_close() ?>

    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal_delete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Padam Variasi Ini ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <?php echo form_open('catalog/delete_variant',array('class'=>'form-horizontal','id'=>'')) ?>

        <div class="form-group">
          <div class="row col-12 pr-0">
            <label class="control-label col-md-4">Siri Nombor :</label>
          </div>
          <div class="col-md-12">
            <input type="text" id="get_v_sn" class="form-control uppercase" readonly>
            <input type="hidden" id="get_v_id" name="v_id">
            <input type="hidden" name="p_id" value="<?= $product['product_id'] ?>">
          </div>
        </div>

        <div class="form-group">
          <div class="row col-12 pr-0">
            <label class="control-label col-md-4">Nota :</label>
          </div>
          <div class="col-md-12">
            <input type="text" name="nota" class="form-control">
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
        <input type="submit" onclick="this.disabled=true;this.value='Sila Tunggu';this.form.submit();" id="btn_upd" class="btn btn-danger" value="Padam">
      </div>

      <?php echo form_close() ?>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<?php if (!empty($variants)) {  ?>

  <script>

  $(document).ready(function(){

    var cawangan = $('#cawangan').val();
    var category = $('#category').val();
    var dulang = $('#dulang').val();
    var pembekal = $('#pembekal').val();
    var mutu = $('#mutu').val();
    var type = $('#type').val();
    
    $('#cawangan').attr('disabled', 'disabled');
    $('#category').attr('disabled', 'disabled');
    $('#dulang').attr('disabled', 'disabled');
    $('#pembekal').attr('disabled', 'disabled');
    $('#mutu').attr('disabled', 'disabled');
    $('#type').attr('disabled', 'disabled');

    $('<input>').attr({
      type: 'hidden',
      name: 'cawangan',
      value: cawangan
    }).appendTo('form');

    $('<input>').attr({
      type: 'hidden',
      name: 'category',
      value: category
    }).appendTo('form');

    $('<input>').attr({
      type: 'hidden',
      name: 'dulang',
      value: dulang
    }).appendTo('form');

    $('<input>').attr({
      type: 'hidden',
      name: 'pembekal',
      value: pembekal
    }).appendTo('form');

    $('<input>').attr({
      type: 'hidden',
      name: 'mutu',
      value: mutu
    }).appendTo('form');

    $('<input>').attr({
      type: 'hidden',
      name: 'type',
      value: type
    }).appendTo('form');

  }); 

  </script>

<?php } ?>



<script>

$("#cawangan,#category,#type,#dulang,#pembekal").change(function () {
 
 var cawangan =  $("#cawangan option:selected").attr('name');
 var category =  $("#category option:selected").attr('name');
 var dulang =  $("#dulang option:selected").attr('name');
 var pembekal =  $("#pembekal option:selected").attr('name');
 var type = $("#type").val();

 product_code = category + dulang + pembekal + type;

 document.getElementById("product_code").value = product_code;

 $.ajax({
    type: "POST",
    url: "<?= base_url('catalog/check_p_code') ?>",
    data: { product_code : product_code, old_product_code : '<?= $product['product_code'] ?>'},
    dataType: "text",
    cache: false,
    success:
    function(data){
      $("#check").html(data);
    }
  });
  return false;

});

</script>

<script>

$(document).on('click','a[data-role=editvariant]', function(){

  var variant_id    = $(this).data('id');
  var v_sn          = $(this).data('sn');
  var v_weight      = $(this).data('weight');
  var v_kaunter     = $(this).data('kaunter');
  var v_dasar       = $(this).data('dasar');
  var v_emas        = $(this).data('emas');
  var v_pay         = $(this).data('pay');
  var v_margin_pay  = $(this).data('margin_pay');
  var v_margin      = $(this).data('margin');
  var v_sb          = $(this).data('sb');
  var v_kod         = $(this).data('kod');
  var v_date        = $(this).data('date');
  var v_size        = $(this).data('size');
  var v_length      = $(this).data('length');
  var v_width       = $(this).data('width');

  var setup_price     = <?php echo $product['setup_price'] ?> ;

  // calc current price
 
  current_v_emas  = v_weight * parseFloat(setup_price);
  current_v_dasar = parseFloat(current_v_emas) + parseFloat(v_pay);
  current_v_kaunter = parseFloat(current_v_emas) + parseFloat(v_margin_pay);

  //------------------------

  document.getElementById("upd_gold_price").value=current_v_emas.toFixed(2);
  document.getElementById("upd_base_price").value=current_v_dasar.toFixed(2);
  document.getElementById("upd_v_kaunter").value=current_v_kaunter.toFixed(2);

  $('#upd_v_id').val(variant_id);
  $('#upd_v_sn').val(v_sn);
  $('#upd_v_weight').val(v_weight);
  // $('#upd_v_kaunter').val(v_kaunter);
  $('#upd_v_pay').val(v_pay);
  $('#upd_margin_pay').val(v_margin_pay);
  $('#upd_v_margin').val(v_margin);
  $('#upd_serial_berat').val(v_sb);
  $('#upd_insert_date').val(v_date);
  $('#upd_v_size').val(v_size);
  $('#upd_v_kod').val(v_kod);
  $('#upd_v_width').val(v_width);
  $('#upd_v_length').val(v_length);

  $('#modal_updVariant').modal("toggle");

});

  // calculation insert variations

  $("#v_margin,#v_pay,#v_weight").keyup(function(){

    var weight          = $('#v_weight').val();
    var pay             = $('#v_pay').val();
    var margin          = $('#v_margin').val();
    var setup_price     = <?php echo $product['setup_price'] ?>;
    var d_serial_berat  = <?php echo $product['serial_berat'] ?>;

    kaunter = setup_price * weight; 

    base_price = parseFloat(kaunter) + parseFloat(pay);

    margin_pay =  (parseFloat(pay) / (1 - (margin/100)));

    a = margin_pay.toFixed(0);

    serial_berat =  weight/2.72;

    total_kaunter = parseFloat(kaunter) + parseFloat(a) ;

    // -------------------------------------------------------------------

    document.getElementById("gold_price").value=kaunter.toFixed(2);
    document.getElementById("base_price").value=base_price.toFixed(2);
    document.getElementById("margin_pay").value=margin_pay.toFixed(0);
    document.getElementById("serial_berat").value=serial_berat.toFixed(3);
    document.getElementById("counter_price").value=total_kaunter.toFixed(2);
    document.getElementById("btn_save").style.display="inline-block";

  });

  // ./calculation insert variations

  // calculation edit variations

  $("#upd_v_weight,#upd_v_pay,#upd_v_margin").keyup(function(){

    var weight          = $('#upd_v_weight').val() ;
    var pay             = $('#upd_v_pay').val() ;
    var margin          = $('#upd_v_margin').val() ;
    var setup_price     = <?php echo $product['setup_price'] ?> ;
    var d_serial_berat  = <?php echo $product['serial_berat'] ?> ;

    kaunter = setup_price * weight; 

    base_price = parseFloat(kaunter) + parseFloat(pay);

    margin_pay =  (parseFloat(pay) / (1 - (margin/100)));

    a = margin_pay.toFixed(0);

    serial_berat =  weight/2.72;

    total_kaunter = parseFloat(kaunter) + parseFloat(a) ;

    // -------------------------------------------------------------------

    document.getElementById("upd_gold_price").value=kaunter.toFixed(2);
    document.getElementById("upd_base_price").value=base_price.toFixed(2);
    document.getElementById("upd_margin_pay").value=margin_pay.toFixed(0);
    document.getElementById("upd_serial_berat").value=serial_berat.toFixed(3);
    document.getElementById("upd_v_kaunter").value=total_kaunter.toFixed(2);
    document.getElementById("btn_upd").style.display="inline-block";

  });

  // ./calculation edit variations

  //delete variants button confirmation
  // $('.delete_variant').on('click', function (e) {
  //   e.preventDefault();
  //   var url = $(this).attr('href');

  //   Swal.fire({
  //     title: 'Padam Variasi ini?',
  //     text: false,
  //     type: 'warning',
  //     showCancelButton: true,
  //     confirmButtonColor: '#3085d6',
  //     cancelButtonColor: '#d33',
  //     confirmButtonText: 'Ya, Padam!',
  //     cancelButtonText: 'Tutup'
  //   }).then((result) => {
  //     if (result.value) {
  //       window.location.replace(url);
  //     }
  //   });
  // });

  $(document).on('click','a[data-role=modal_delete]', function(){

    var variant_id    = $(this).data('id');
    var v_sn          = $(this).data('sn');

    $('#get_v_id').val(variant_id);
    $('#get_v_sn').val(v_sn);

  });

  $('#updateProduct').one('submit', function() {
    $('#btnAddPro').attr('disabled','disabled');
    $("#btnAddPro").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

  $('#addVar').one('submit', function() {
    $('#btnAddVar').attr('disabled','disabled');
    $("#btnAddVar").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

  $('#updVar').one('submit', function() {
    $('#btnUpdVar').attr('disabled','disabled');
    $("#btnUpdVar").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
  });

</script>





