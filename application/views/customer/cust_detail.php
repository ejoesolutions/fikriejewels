<?= $this->session->flashdata('upload'); ?>

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
          <div class="row align-items-center my-3">
            <div class="col">
              <h4 class="mb-0 page-title">Maklumat Pelanggan</h4>
            </div>
          </div>
          <hr class="mb-3 mt-0">

          <?= form_open('user/upd_cust', array('class'=>'form-horizontal','id'=>'updCustomer')) ?>

          <div class="row col-12 pr-0">
            <div class="col-md-12 pr-0">
              <div class="form-group">
                <label class="control-label">Nama Penuh <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control uppercase" value="<?= $cust['name'] ?>" required>
              </div>
            </div>
          </div>
          <div class="row col-12 pr-0">
            <div class="col-md-6 pr-0">
              <div class="form-group">
                <label class="control-label">No Telefon <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="<?= $cust['phone'] ?>" required>
              </div>
            </div>
            <div class="col-md-6 pr-0">
              <div class="form-group">
                <label class="control-label">No K / P</label>
                <input type="text" name="kp" class="form-control" value="<?= $cust['kp'] ?>">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label">Alamat</label>
              <textarea class="form-control" name="address" rows="3"><?= $cust['address'] ?></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group mb-3">
              <label for="custom-select">Negeri</label>
              <select class="form-control" name="state" id="selectState">
                <option value="" selected>---Pilih---</option>
                <?php foreach ($state as $key) {
                  echo '<option value="'.$key['state_id'].'" selected>'.$key['state'].'</option>';
                } ?>
              </select>
            </div>
          </div>

            <div class="col-md-12">
              <input type="hidden" name="cust_id" value="<?= $cust['id'] ?>">
              <button type="submit" id="btnUpdCustomer" class="btn btn-primary float-right">Kemaskini</button>
            <div>

            <?= form_close() ?>

            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
    $(document).ready(function(){
      $('#selectState').val("<?= $cust['cust_state'] ?>").trigger("change");
    });

    $('#updCustomer').one('submit', function() {
      document.getElementById("btnUpdCustomer").disabled = true;
    });
    </script>