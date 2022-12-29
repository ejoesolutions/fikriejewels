<?php $state = $this->admin_model->get_state(); ?>

<div class="row col-12 pr-0">
  <div class="col-md-12 pr-0">
    <div class="form-group">
      <label class="control-label">Nama Penuh <span class="text-danger">*</span></label>
      <input type="text" name="full_name" class="form-control uppercase" required>
    </div>
  </div>
</div>
<div class="row col-12 pr-0">
  <div class="col-md-6 pr-0">
    <div class="form-group">
      <label class="control-label">No Telefon <span class="text-danger">*</span></label>
      <input type="text" name="phone" class="form-control" required>
    </div>
  </div>
  <div class="col-md-6 pr-0">
    <div class="form-group">
      <label class="control-label">No K / P</label>
      <input type="text" name="kp" class="form-control">
    </div>
  </div>
</div>
<div class="col-md-12">
  <div class="form-group">
    <label class="control-label">Alamat</label>
      <textarea class="form-control" name="address" rows="3"></textarea>
  </div>
</div>
<!-- <div class="row col-12 pr-0">
  <div class="col-md-6  pr-0">
    <div class="form-group">
      <label class="control-label">Poskod</label>
        <input type="text" name="postcode" class="form-control uppercase">
    </div>
  </div>
  <div class="col-md-6 pr-0">
    <div class="form-group">
      <label class="control-label">Bandar</label>
        <input type="text" name="town_area" class="form-control uppercase">
    </div>
  </div>
</div> -->
<div class="col-md-12">
  <div class="form-group mb-3">
    <label for="custom-select">Negeri</label>
    <select class="form-control" name="state" id="custom-select">
      <option value="">---Pilih---</option>
      <?php foreach ($state as $key) {
        echo '<option value="'.$key['state_id'].'">'.$key['state'].'</option>';
      } ?>
    </select>
  </div>        
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Tutup</button>
  <input type="submit" id="btnAddCustomer" class="btn btn-primary" value="Daftar">
</div>