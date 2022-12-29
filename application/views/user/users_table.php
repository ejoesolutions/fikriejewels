<?php echo $this->session->flashdata('upload'); ?>
  
<div class="col-md-12">
  <h4>Senarai Pengguna</h4>
  <div class="card shadow">
    <div class="card-body">
      <div class="table-responsive">
      <table class="table nowrap text-dark" id="dataTable-1">
      <thead>
        <th class="text-center">No.</th>
        <th>Nama Pengguna</th>
        <th>Nama Penuh</th>
        <!-- <th class="text-center">Cawangan</th> -->
        <th class="text-center">Kategori</th>
        <th class="text-center">Status</th>
        <th class="text-center">Diakses</th>
        <th class="text-center">#</th>
      </thead>
      <tbody>
        <?php

        if ($users) {

        $i=1;
     
          foreach ($users as $user){ ?>
            <tr>
              <td class="text-center"><?= $i++;?></td>
              <td><?= $user['username'] ?></td>
              <td><?= $user['full_name'] ?></td>
              <!-- <td class="text-center"><?= $user['tag'] ?></td> -->
              <td class="text-center">
                <?php if($user['user_group']== 0){
                  echo '<span>Admin</span>';
                }else if($user['user_group']== 1){
                  echo '<span>Admin</span>';
                }else if($user['user_group']== 2){
                  echo '<span>Staf</span>';
                }else if($user['user_group']== 3){
                  echo '<span>Pengurus</span>';
                } ?>
              </td>
              <td class="text-center">
                <?php if($user['active']) {
                  echo '<span>Aktif</span>';
                }else{
                  echo '<span class="text-danger">Tak Aktif</span>';
                } ?>
              </td>
              <td class="text-center">
                <?php if ($user['last_login']) {
                  echo date('d-m-Y', strtotime($user['last_login']));
                } else {
                  echo '<span class="text-danger">Tiada Rekod</span>';
                } ?>
              </td>
              <td class="text-center">
                <a href="<?= base_url('user/detail_user/'.$user['id']) ?>"><i class="fe fe-search fe-20"></i></a>
                <?php if ($user_profile['user_group'] == 0 || $user_profile['user_group'] == 1) { ?>
                  | <a class="delete_user" href="<?= base_url('user/delete_user/'.$user['id']) ?>"><i class="fe fe-trash fe-20 text-danger"></i></a>
                <?php } ?>
              </td>
            </tr>
          <?php } } ?>
 
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div> 


<script>
  //delete user button confirmation
  $('.delete_user').on('click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    Swal.fire({
      title: 'Padam Pengguna ini?',
      text: false,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Padam!',
      cancelButtonText: 'Tutup'
    }).then((result) => {
      if (result.value) {
        window.location.replace(url);
      }
    });
  });
</script>