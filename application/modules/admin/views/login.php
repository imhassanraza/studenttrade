<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login | Student Trade</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Phoenixcoded">
    <meta name="keywords" content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="Phoenixcoded">
    <!-- Favicon icon -->

    <link rel="icon" href="<?php echo base_url(); ?>admin_assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/icon/icofont/css/icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/css/color/color-1.css" id="color" />
</head>

<body class="menu-static">
    <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <div class="login-card card-block auth-body">
                        <form class="md-float-material" method="post" action="<?php echo admin_url(); ?>login/login_verify">

                            <div class="auth-box">
                                <div class="text-center">
                                    <img class="img-fluid" src="<?php echo base_url(); ?>assets/images/header-logo-default.png" style="width: 300px;" alt="Student Trade" />
                                </div>
                                <hr/>
                                <div class="row m-b-20">

                                    <div class="col-md-12">
                                        <h3 class="text-left txt-primary">Sign In</h3>
                                    </div>
                                </div>
                                <hr/>
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Your Email Address" name="email" value="<?php echo $this->session->flashdata('email');?>">
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                    <span class="md-line"></span>
                                </div>
                                <div class="row m-t-25 text-left">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" value="">
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse">Remember me</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 forgot-phone text-right">
                                        <a href="<?php echo admin_url(); ?>recover_password" class="text-right f-w-600 text-inverse"> Forgot Your Password?</a>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign in</button>
                                    </div>
                                </div>

                                <?php if($this->session->flashdata('login_error')) { ?>
                                <div class="alert alert-danger">
                                    <?php echo $this->session->flashdata('login_error'); ?>
                                </div>
                                <?php } ?>

                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>

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
    <!-- i18next.min.js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/i18next/i18next.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/bower_components/jquery-i18next/jquery-i18next.min.js"></script>
    <!-- Custom js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/js/script.js"></script>
</body>

</html>