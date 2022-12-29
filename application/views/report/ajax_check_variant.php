<?php if ($result) { ?>
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