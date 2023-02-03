    <!-- Required Jquery -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/tether/dist/js/tether.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/modernizr/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>

    <!-- notification js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/js/bootstrap-growl.min.js"></script>

    <!-- sweet alert js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/sweetalert/dist/sweetalert.min.js"></script>

    <!-- classie js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/classie/classie.js"></script>
    <!-- datatable js -->
    <script src="<?php echo base_url(); ?>admin_assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Bootstrap date-time-picker js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/pages/advance-elements/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>
    <!-- Date-range picker js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Date-dropper js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/datedropper/datedropper.min.js"></script>
    <!-- jquery file upload js -->
    <script src="<?php echo base_url(); ?>admin_assets/bower_components/jquery.filer/js/jquery.filer.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/js/jquery.barrating.min.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/pages/filer/custom-filer.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>admin_assets/pages/filer/jquery.fileuploads.init.js" type="text/javascript"></script>
    <!-- Model animation js -->
    <script src="<?php echo base_url(); ?>admin_assets/js/classie.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/js/modalEffects.js"></script>
    <!-- product list js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/pages/crm-contact/crm-contact.js"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/i18next/i18next.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/jquery-i18next/jquery-i18next.min.js"></script>
    <!-- Custom js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/js/script.js"></script>

</body>

</html>

<script type="text/javascript">

    function notify(title, message, type){
        $.growl({
            title : title,
            message: message
        },{
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'top',
                align: 'right'
            },
            delay: 2500,
            animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
            },
            offset: {
                x: 30,
                y: 30
            }
        });
    }

</script>
