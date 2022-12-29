<h4><?= $title ?></h4>
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="row">
      <!-- <div class="col-md-2">&nbsp;</div> -->
      <div class="col-md-4">

      <?php

        if ($p_detail['product_image'] != '') {

          $info = pathinfo( $p_detail['product_image'] );
          $no_extension =  basename( $p_detail['product_image'], '.'.$info['extension'] );
          $thumb_image = $no_extension.'_thumb.'.$info['extension'];
          $image_properties = array(
            'src'   => base_url().'images/thumbnail/'.$thumb_image,
            'alt'   => $p_detail['product_name'],
            'class' => 'avatar-img',
            'title' => $p_detail['product_name'],
            'width' => '100%'
          );

          // echo img($image_properties);

        } else {

          $image_properties = array(
            'src'   => 'https://dummyimage.com/500x500/f0daf0/27272b',
            'alt'   => $p_detail['product_name'],
            'class' => 'avatar-img',
            'title' => $p_detail['product_name'],
          );
        }

        echo img($image_properties);

      ?>

      </div>

      <div class="col-md-7">

        <div class="form-horizontal" role="form">
          <div class="form-body margin-top-20">
            <div class="row">

              <div class="col-md-12"><br>
                <!-- Stok Semasa -->
                <h5 class="mb-0">
                  <label class="control-label col-md-12">Jumlah Stok Semasa : 
                  <?php if ($p_detail['stock'] < 1) {
                    echo "0";
                  }else {
                    echo "<span class='text-primary'>" . $p_detail['stock'] . "</span>";
                  } ?>
                  / 
                  <?= $p_detail['all_stock'] ?>
                  </label>
                </h5>
                <!-- ./Stok Semasa -->
              </div>

              <div class="col-md-12">
              <hr class="mt-0">
                <div class="form-group">
                  <label class="control-label col-md-3"><strong>PRODUK : </strong></label>
                  <div class="col-md-8">
                    <p class="form-control-static"> <?php echo $p_detail['product_name'] ?> </p>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label col-md-3"><strong>MUTU :</strong></label>
                  <div class="col-md-8">
                    <p class="form-control-static">
                      <?php echo $p_detail['mutu_grade']; ?>
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label col-md-3"><strong>KATEGORI : </strong></label>
                  <div class="col-md-8">
                    <p class="form-control-static">
                      <?php echo $p_detail['category_name']; ?>
                    </p>
                  </div>
                </div>
              </div>

              <?php if ($p_detail['description']) { ?>
                <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label col-md-3"><strong>KETERANGAN :</strong></label>
                  <div class="col-md-8">
                    <p class="form-control-static">
                      <?php echo $p_detail['description']; ?>
                    </p>
                  </div>
                </div>
              </div>
              <?php } ?>

              <?php if($p_detail['has_variant']!=1): ?>

              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label col-md-3"><strong>BERAT : </strong></label>
                  <div class="col-md-8">
                    <p class="form-control-static">
                      <?php echo number_format($p_detail['weight'],2).' g'; ?>
                    </p>
                  </div>
                </div>
              </div>

              <?php endif; ?>

              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-md-8">

                    <?php if ($this->uri->segment(2)=="product_detail"): ?>

                    <?php echo anchor('catalog/product_edit/'.$p_detail['product_id'], '&nbsp;<i class="fe fe-edit fe-16"></i>  Kemaskini&nbsp;', array('class'=>'btn btn-primary')) ?>

                    <?php endif; ?>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <br>

    <div class="row">
      <div class="col-md-12">
        <!-- <table class="table table-bordered">
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Imej Tambahan</th>
            <th width="30%" class="text-center"><a class="" data-toggle="modal" href="#addImage"><button
              class="btn btn-primary">+ Imej Tambahan</button></a></th>
          </tr>

          <?php

          if(!empty($imej)){

            $j=1;

            foreach ($imej as $row2) { ?>

          <tr>

            <td class="text-center"><?php echo $j++; ?></td>
            <td class="text-center">

              <?php

              $image_properties = array(
                'src'   => base_url().'images/'.$row2['image_add_file'],
                'alt'   => $row2['image_add_file'],
                'class' => 'img-thumbnail',
                'width' => '100',
                'height'=> '100',
                'style'=>'border:0',
                'title' => $row2['image_add_file'],
              );

              echo img($image_properties);

              ?>

            </td>
            <td class="text-center">
              <?php echo anchor('catalog/del_other_image/'.$row2['image_add_id'].'/'.$row2['image_add_file'].'/'.$row2['product_id'], '<span class="fe fe-trash fe-24 text-danger"></span>') ;?>
            </td>
          </tr>

          <?php

            }

          }

          ?>

        </table> -->

        <div class="modal fade bd-example-modal-lg" id="addImage" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title">Tambah Imej Tambahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">

                <?php echo form_open_multipart('catalog/store_other_image',array('class'=>'form-horizontal')) ?>

                <div class="form-group">
                  <div class="col-md-12">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-new">
                        <img class=" img-thumbnail rounded float-right" src="https://www.placehold.it/400x400/EFEFEF/AAAAAA&amp;text=<?php echo lang('form_button_image_non') ?>" alt="" />
                      </div>

                      <div class="fileinput-preview fileinput-exists img-thumbnail img-responsive"></div>

                      <div>
                        <span class="btn default btn-file pl-0">
                          <span class="fileinput-new btn btn-info"> <i class="fe fe-camera fe-16"></i>
                            <?php echo lang('form_button_image') ?> </span>
                          <!-- <span class="fileinput-exists btn btn-info"> <?php echo lang('form_button_image_change') ?></span> -->
                          <input type="file" name="imej_tambahan" required>
                        </span>

                      </div>
                      <a href="javascript:;" class="btn btn-danger fileinput-exists mb-2" data-dismiss="fileinput"><?php echo lang('form_button_image_delete') ?></a>

                      <div class="clearfix margin-top-10">
                        <small><span class="text-danger">NOTE!</span> <?php echo lang('form_button_upload_note') ?> | Size < 250KB</small> <?php if (isset($error_image)): ?>
                          <?php echo '<p><small class="text-danger">'. $error_image .'</small></p>'; ?>
                          <?php endif; ?> </div> </div> </div> </div> </div> <div class="modal-footer">

                          <?php echo form_hidden('product_id',$p_detail['product_id']) ?>

                          <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                      <?php echo form_close() ?>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>

              </div>
            </div>
          </div>
        </div>

