
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/simplebar.css">
    <!-- Fonts CSS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="icon" href="<?php echo base_url('logo/'); ?><?= $logo['image_file'] ?>">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap"> -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/nunito.css">
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Overpass&display=swap">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/feather.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dropzone.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.css">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/fontawesome-free-6/css/all.css">

    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app-dark.css" id="darkTheme" disabled>
    <!-- File Input -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css">
    <!-- Jquery -->
    <!-- <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    
    
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <!-- <script>
      function RoundNum( num, precision ) {
        return (+(Math.round(+(num + 'e' + precision)) + 'e' + -precision)).toFixed(precision);
      }
    </script> -->

    <!-- <style>
      th {
        color: #001a4e !important ;
        font-weight: bold !important ; 
      }

      img {
        max-width: 100%;
      }

      a:link {
        text-decoration: none;
      }

      h4 {
        font-family: 'Overpass', sans-serif;
      }

      ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: #ABB2B9 !important; 
        opacity: 1 !important; /* Firefox */
      }

      .text-green {
        color: #239B56;
      }

      .fe-20 {
        font-size: 19px;
      }

      .fix-image-div {
        width:130px;
        height:130px;
      }

      .fit-image-contain {
        height: 100%;
        width: 100%;
        object-fit: contain;
      }
    </style> -->

    <?php echo $contents; ?>

    <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/simplebar.min.js"></script>
    <script src='<?php echo base_url(); ?>assets/js/daterangepicker.js'></script>
    <script src='<?php echo base_url(); ?>assets/js/jquery.stickOnScroll.js'></script>
    <script src="<?php echo base_url(); ?>assets/js/tinycolor-min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/config.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/d3.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/topojson.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datamaps.all.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datamaps-zoomto.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/datamaps.custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dropzone.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/print.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/js/instascan.min.js"></script> -->

    <script>
      /* defind global options */
      Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
      Chart.defaults.global.defaultFontColor = colors.mutedColor;
    </script>
    <script src="<?php echo base_url(); ?>assets/js/gauge.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/apexcharts.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/apexcharts.custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/apps.js"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>

    <!-- PDF BUTTON -->
    <script src="<?php echo base_url(); ?>assets/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/buttons.print.min.js"></script>
    
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>
    <script>
      $('.select2').select2(
      {
        theme: 'bootstrap4',
      });
      $('.select2-multi').select2(
      {
        multiple: true,
        theme: 'bootstrap4',
      });
      // $('#add_order').select2();
      $('#dataTable-1').DataTable(
      {
        "order": [],
        autoWidth: true,
        "lengthMenu": [
          [10, 20, 30, -1],
          [10, 20, 30, "All"]
        ],
          dom: "<'row'<'col-md-5'l><'col-md-3 mb-3'B><'col-md-4'f>>" +
          "<'row'<'col-md-12'tr>>" +
          "<'row'<'col-md-5'i><'col-md-7'p>>",
        buttons: [
          {footer: true, extend: 'copy', className: 'btn btn-secondary', text: '<i class="fas fa-copy fa-lg" title="Copy"></i>', title: function () { return $('#tableTitle').html(); } },
          {footer: true, extend: 'excel', className: 'btn btn-warning text-white', text: '<i class="fas fa-file-excel fa-lg" title="Download Excel"></i>', title: function () { return $('#tableTitle').html(); } },
          {footer: true, extend: 'csv', className: 'btn btn-info', text: '<i class="fas fa-file-csv fa-lg" title="Download CSV"></i>', title: function () { return $('#tableTitle').html(); } },
          {footer: true, extend: 'pdf', className: 'btn btn-danger', text: '<i class="fas fa-file-pdf fa-lg" title="Download Pdf"></i>', title: function () { return $('#tableTitle').html(); } },
        ],
      });

      $('#addCust').one('submit', function() {
        $('#submitBtn').attr('disabled','disabled');
        $("#submitBtn").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sila Tunggu...');
      });

      $('.drgpicker').daterangepicker(
      {
        singleDatePicker: true,
        timePicker: false,
        showDropdowns: true,
        locale:
        {
          format: 'YYYY-MM-DD'
          // format: 'DD-MM-YYYY'
        }
      });

      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      });

      //script utk elak double submission
      if (window.history.replaceState) {
        window.history.replaceState( null, null, window.location.href );
      }
      
    </script>