<?php if ($check) { ?>
  <span class="badge bg-danger text-light pt-1">Produk Sudah Wujud, Sila Tukar Jenis</span>

  <script>
    document.getElementById("btnAddPro").disabled = true;
  </script>
<?php }else { ?>
  <script>
    document.getElementById("btnAddPro").disabled = false;
  </script>
<?php } ?>