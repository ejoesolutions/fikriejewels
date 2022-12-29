<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="icon" href="favicon.ico">
    <title><?= $maklumat['sistem'] ?></title>
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

    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app-dark.css" id="darkTheme" disabled>
    <!-- File Input -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css">
    <!-- Jquery -->
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    
    <!-- Sweet Alert -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/sweetalert.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->

    <!-- Chart.js api-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>

    <script>
      // $.ajaxSetup({
      //       headers: {
      //         'X_CSRF-TOKEN' : $('meta[name="_token"]').attr('content')
      //       }
      //   });
    </script>

      <script>
      // function RoundNum(num, length) { 
      //   var number = Math.round(num * Math.pow(10, length)) / Math.pow(10, length);
      //   return number;
      // }

      function RoundNum( num, precision ) {
        return (+(Math.round(+(num + 'e' + precision)) + 'e' + -precision)).toFixed(precision);
      }
    </script>

    <style>
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

      .bg-dark-success {
        background-color:#27AE60;
        color:#fff;
      }
    </style>
  </head>
  <body class="vertical light" style="font-family: 'Nunito', sans-serif;">
    <div class="wrapper">

      <!-- NAVBAR -->
      <?php $this->load->view('includes/top_menu'); ?>
      
      <!-- SIDEMENU -->
      <?php $this->load->view('includes/side_menu'); ?>

      <!-- MAIN -->
      <main role="main" class="main-content" style="font-size: 104%;">
        <?php if ($this->uri->segment(2) != 'detail' && $this->uri->segment(2) != 'buy_detail' && $this->uri->segment(2) != 'new_product' && $this->uri->segment(2) != 'create_order' && $this->uri->segment(2) != 'checkout' && $this->uri->segment(2) != 'register' && $this->uri->segment(2) != 'detail_user' && $this->uri->segment(2) != 'setting') { ?>
          <div class="d-flex justify-content-end mr-3">
            <button class="btn btn-outline-secondary" onClick="scrollSmoothToBottom()">Scroll to Bottom <i class="fe fe-arrow-down" style="font-size: 15px;"></i></button>
          </div>
        <?php } ?>

        <?php echo $contents; ?>

        <?php if ($this->uri->segment(2) != 'detail' && $this->uri->segment(2) != 'buy_detail' && $this->uri->segment(2) != 'new_product' && $this->uri->segment(2) != 'create_order' && $this->uri->segment(2) != 'checkout' && $this->uri->segment(2) != 'register' && $this->uri->segment(2) != 'detail_user' && $this->uri->segment(2) != 'setting') { ?>
          <div class="d-flex justify-content-end mr-3 mt-2">
            <button class="btn btn-outline-secondary" onClick="scrollSmoothToTop()">Scroll to Top <i class="fe fe-arrow-up" style="font-size: 15px;"></i></button>
          </div>
        <?php } ?>
      </main>

    </div>

    <!-- Core plugin JavaScript-->
    <!-- <script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script> -->
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
    <!-- <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script> -->
    
    <script>
      <?php if ($user_profile['user_group'] == 2) { ?>
        $('#cawangan').val(<?= $user_profile['cawangan_id'] ?>).trigger("change");
      <?php } ?>

      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');

      const scrollingElement = (document.scrollingElement || document.body);

      const scrollToBottom = () => {
        scrollingElement.scrollTop = scrollingElement.scrollHeight;
      }

      const scrollToTop = () => {
        scrollingElement.scrollTop = 0;
      }

      // Require jQuery
      const scrollSmoothToBottom = () => {
        $(scrollingElement).animate({
          scrollTop: document.body.scrollHeight,
        }, 300);
      }

      // Require jQuery
      const scrollSmoothToTop = () => {
        $(scrollingElement).animate({
          scrollTop: 0,
        }, 300);
      }

      $('.select2').select2(
      {
        theme: 'bootstrap4',
      });
      // $('.select2').select2({
      //   dropdownParent: $('#addBookDialog')
      // });
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
          {extend: 'copy', className: 'btn btn-secondary', text: '<i class="fas fa-copy fa-lg" title="Copy"></i>' },
          {extend: 'excel', className: 'btn btn-warning text-white', text: '<i class="fas fa-file-excel fa-lg" title="Download Excel"></i>' },
          {extend: 'csv', className: 'btn btn-info', text: '<i class="fas fa-file-csv fa-lg" title="Download CSV"></i>' },
          {extend: 'pdf', className: 'btn btn-danger', text: '<i class="fas fa-file-pdf fa-lg" title="Download Pdf"></i>' },
        ]
      });

    
      // $('#example').DataTable( {
        
      //   dom: "<'row'<'col-md-4'l><'col-md-4 mb-3'B><'col-md-4'f>>" +
      //   "<'row'<'col-md-12'tr>>" +
      //   "<'row'<'col-md-5'i><'col-md-7'p>>",
      //   buttons: [
      //     'copy','csv', 'excel', 'pdf'
      //   ]
          
      // } );
      $('.drgpicker').daterangepicker(
      {
        singleDatePicker : true,
        timePicker : false,
        showDropdowns : true,
        autoApply : true,
        locale:
        {
          format: 'YYYY-MM-DD'
          // format: 'DD-MM-YYYY'
        }
      });

      //script utk elak double submission
      if (window.history.replaceState) {
        window.history.replaceState( null, null, window.location.href );
      }

      // Enable tooltips everywhere
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      });
      
    </script>
  </body>
</html>