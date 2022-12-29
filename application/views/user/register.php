<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
          <div class="row align-items-center my-3">
            <div class="col">
              <h4 class="mb-0 page-title">Daftar Pengguna</h4>
            </div>
          </div>
          <?= form_open('', array('id' => 'addUser')) ?>
            <hr class="mb-3 mt-0">
            <div class="form-group">
              <label>Kategori Pengguna <span class="text-danger">*</span></label>
              <?php if ($user_profile['user_group'] == 0 || $user_profile['user_group'] == 1) {
                echo form_dropdown('user_group', array(''=>'-Pilih-','0'=>'ADMIN', '2'=>'STAF'), set_value('user_group'), array('id'=>'userGroup','class'=>'form-control','required'=>'required'));
              }else {
                echo form_dropdown('user_group', array(''=>'-Pilih-','2'=>'STAF'), set_value('user_group'), array('id'=>'userGroup','class'=>'form-control','required'=>'required'));
              } ?>
            </div>
            <div id="setCaw"></div>
            <div class="form-group">
              <label class="control-label">Nama Penuh <span class="text-danger">*</span></label>
              <?= form_input($full_name); ?>
              <?= form_error('full_name', '<p class="text-danger">', '</p>'); ?>
            </div>
            <div class="form-group">
              <label class="control-label">Nama Pengguna (<i>Tanpa Space</i> ) <span class="text-danger">*</span></label>
              <?= form_input($identity); ?>
              <?= form_error('identity','<p class="text-danger">', '</p>'); ?>
              <span class="help-block"><small><strong>*Nota:</strong> Setiap pengguna perlu mempunyai nama pengguna yang berbeza/unik.</small></span>
            </div>
            <div class="form-row">
              <div class="form-group col-md-8">
                <label>Emel</label>
                <?= form_input($email); ?>
                <?= form_error('email', '<p class="text-danger">', '</p>'); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="inputPhone">No. Telefon</label>
                <?= form_input($phone); ?>
                <?= form_error('phone', '<p class="text-danger">', '</p>'); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="inputAddress5">Alamat</label>
              <?= form_textarea($address); ?>
              <?= form_error('address', '<p class="text-danger">', '</p>'); ?>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="custom-zip">Poskod</label>
                <?= form_input($postcode) ?>
                <?= form_error('postcode', '<p class="text-danger">', '</p>'); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="inputState5">Bandar</label>
                <?= form_input($town_area) ?>
                <?= form_error('town_area', '<p class="text-danger">', '</p>'); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="inputState5">Negeri</label>
                <select class="form-control" name="state_id" id="custom-select">
                  <option value="">-Pilih-</option>
                  <?php foreach ($state as $key) {
                    echo '<option value="'.$key['state_id'].'">'.$key['state'].'</option>';
                  } ?>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="custom-zip">Katalaluan <span class="text-danger">*</span></label>
                <?= form_input($password); ?>
                <?= form_error('password','<p class="text-danger">', '</p>'); ?>
              </div>
              <div class="form-group col-md-6">
                <label for="inputState5">Pengesahan Katalaluan <span class="text-danger">*</span></label>
                <?= form_input($password_confirm); ?>
                <?= form_error('password_confirm','<p class="text-danger">', '</p>'); ?>
              </div>
            </div>
            <hr class="my-4">
            <div class="text-right">
              <input type="hidden" name="active" value="1">
              <button type="submit" id="register-submit-btn" class="btn btn-primary">Daftar</button>
            </div>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('#addUser').one('submit', function() {
    document.getElementById("register-submit-btn").disabled = true;
  });

  $('#userGroup').on('change', function() {
    if (this.value == 2) {
      // $("#setCaw").append('<div id="setCawSet"><div class="form-group"><label>Cawangan <span class="text-danger">*</span></label><select name="cawangan" class="form-control" required><option value="">-Pilih-</option><?php foreach ($cawangan as $key) { echo '<option value="'.$key['id'].'">'.$key['name'].'</option>'; } ?></select></div></div>');
      $("#setCaw").append('<div id="setCawSet"><input type="hidden" name="cawangan" value="1"></div>');
    }else {
      $("#setCawSet").remove();
    }
  });

  $(document).on('keydown', '#identity', function(e) {
    if (e.keyCode == 32) return false;
  });
</script>

