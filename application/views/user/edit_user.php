<?= $this->session->flashdata('upload'); ?>

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
          <div class="row align-items-center my-3">
            <div class="col">
              <h4 class="mb-0 page-title">Maklumat Pengguna</h4>
            </div>
          </div>
          <?= form_open('user/update_user', array('id' => 'updUser')) ?>
          <hr class="mb-3 mt-0">
          <div class="form-group">
            <label>Kategori Pengguna <span class="text-danger">*</span></label>
            <?php if ($detail['user_group'] == 1) {
                $group = "ADMIN";
              }elseif ($detail['user_group'] == 2) {
                $group = "STAF";
              }elseif ($detail['user_group'] == 3) {
                $group = "PENGURUS";
              }elseif ($detail['user_group'] == 0) {
                $group = "ADMIN";
              }
            ?>
            <input type="text" class="form-control" value="<?= $group ?>" readonly>
          </div>
          <div class="form-group">
            <label class="control-label">Nama Penuh <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="full_name" value="<?= $detail['full_name'] ?>" required>
          </div>
          <div class="form-group">
            <label class="control-label">Nama Pengguna <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="username" value="<?= $detail['username'] ?>" required>
            <span class="help-block"><small><strong>*Nota:</strong> Setiap pengguna perlu mempunyai nama pengguna yang berbeza/unik.</small></span>
          </div>
          <div class="form-row">
            <div class="form-group col-md-8">
              <label for="inputEmail4">Emel</label>
              <input type="text" class="form-control" name="email" value="<?= $detail['email'] ?>">
            </div>
            <div class="form-group col-md-4">
              <label for="inputPhone">No. Telefon</label>
              <input type="text" class="form-control" name="phone" value="<?= $detail['phone'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputAddress5">Alamat</label>
            <textarea name="address" class="form-control" cols="30" rows="3"><?= $detail['address'] ?></textarea>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="custom-zip">Poskod</label>
              <input type="text" class="form-control" name="postcode" value="<?= $detail['postcode'] ?>">
            </div>
            <div class="form-group col-md-4">
              <label for="inputState5">Bandar</label>
              <input type="text" class="form-control" name="town_area" value="<?= $detail['town_area'] ?>">
            </div>
            <div class="form-group col-md-4">
              <label for="inputState5">Negeri</label>
              <select class="form-control" name="state_id" id="state_select">
                <option value="">--Pilih--</option>
                <?php foreach ($state as $key) { 
                  echo '<option value="'.$key['state_id'].'">'.$key['state'].'</option>';
                } ?>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="custom-zip">Tukar Katalaluan</label>
              <input type="password" class="form-control" name="password">
            </div>
            <!-- <div class="form-group col-md-6">
              <label for="inputState5">Pengesahan Katalaluan</label>
              <?php echo form_input($password_confirm); ?>
              <?php echo form_error('password_confirm','<p class="text-danger">', '</p>'); ?>
            </div> -->
          </div>
          <?php if($user_profile['user_group'] != 2){ ?>
            <div class="col-md-12">
              <div class="form-group">
                <h3>Status</h3>
                <?php if($detail['active']=='1'){ ?>
                  <input type="radio" name="active" value="1" checked="checked"> Aktif<br>
                  <input type="radio" name="active" value="0"> Tak Aktif
                <?php }else{ ?>
                  <input type="radio" name="active" value="1"> Aktif<br>
                  <input type="radio" name="active" value="0" checked="checked"> Tak Aktif
                <?php } ?>
              </div>
            </div>
          <?php }else{
            echo form_hidden('active', 1);
          } ?>
          <hr class="my-4">
          <div class="text-right">

            <?= form_hidden('id', $detail['id']); ?>
            <?= form_hidden('user_group', $detail['user_group']); ?>
            <?= form_hidden('ori_username', $detail['username']); ?>

            <button type="submit" id="btnUpdUser" class="btn btn-primary">Kemaskini</button>
          </div>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  $(document).ready(function(){    
    $('#state_select').val(<?= $detail['state_id'] ?>).trigger("change");
  }); 

  $('#updUser').one('submit', function() {
    document.getElementById("btnUpdUser").disabled = true;
  });
</script>
