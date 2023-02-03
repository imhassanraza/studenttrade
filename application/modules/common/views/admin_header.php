<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard | Student Trade</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Phoenixcoded">
    <meta name="keywords" content=", Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="Phoenixcoded">
    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo base_url(); ?>admin_assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">


    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">




    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/pages/advance-elements/css/bootstrap-datetimepicker.css">
    <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- Date-Dropper css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/bower_components/datedropper/datedropper.min.css">
    <!-- jquery file upload Frame work -->
    <link href="<?php echo base_url(); ?>admin_assets/bower_components/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>admin_assets/bower_components/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
    <!-- animation nifty modal window effects css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/css/component.css">

    <!-- sweet alert framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/bower_components/sweetalert/dist/sweetalert.css">


    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/icon/icofont/css/icofont.css">
    <!-- flag icon framework css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/pages/flag-icon/flag-icon.min.css">
    <!-- Menu-Search css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/pages/menu-search/css/component.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/css/fontawesome-stars-o.css">


    <!--color css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/css/color/color-1.css" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

</head>

<body class="horizontal-static">
<!-- <body class="menu-expanded"> -->
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div></div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <!-- Menu header start -->
    <nav class="navbar header-navbar">
        <div class="navbar-wrapper">
            <div class="navbar-logo">
                <a class="mobile-menu" id="mobile-collapse" href="javascript:void(0)">
                    <i class="ti-menu"></i>
                </a>
                <a href="<?php echo admin_url(); ?>dashboard">
                    <img class="img-fluid" src="<?php echo base_url(); ?>admin_assets/images/logo.png" alt="Student Trade" />
                </a>
                <a class="mobile-options">
                    <i class="ti-more"></i>
                </a>
            </div>
            <div class="navbar-container container-fluid">
                <div>
                    <ul class="nav-left">
                        <li>
                            <a id="collapse-menu" href="javascript:void(0)">
                                <i class="ti-menu"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right">
                        <li class="user-profile header-notification">
                            <a href="javascript:void(0)">
                                <img src="<?php echo base_url(); ?>admin_assets/images/user.png" alt="User-Profile-Image">
                                <span><?php echo get_session('admin_username'); ?></span>
                                <i class="ti-angle-down"></i>
                            </a>
                            <ul class="show-notification profile-notification">
                                <li>
                                    <a href="<?php echo admin_url(); ?>change_password">
                                        <i class="ti-settings"></i> Change password
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url(); ?>logout">
                                        <i class="ti-layout-sidebar-left"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Menu header end -->