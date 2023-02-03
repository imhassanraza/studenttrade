<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="euc-jp">
	<?php
	$uri = $_SERVER['REQUEST_URI'];
	if($this->session->userdata('site_lang') == 'german'){

		if($uri=='/'){
			?>
			<title>Gebrauchte  und neue Schulbücher Schweiz | günstigste Bücher für Studium | schnelle Lieferung | Für jedes verkaufte Buch wird ein Baum gepflanzt- Student Trade</title>
			<meta name="description" content="Studenttrade ist ein Startup aus Zürich, welches sich das Ziel gesetzt hat, den Studenten die günstigste und einfachste Variante zu bieten, um Bücher zu kaufen." >
			<?php
		}
		elseif($uri=='/buy/university'){
			?>
			<title>Bücher günstig Kaufen | Zhaw, Eth, Universität Zürich, HSG und andere Universitäten Bücher kaufen | Student Trade</title>
			<meta name="description" content="Finde für deine Universität oder Schule die richtigen Bücher. Zur Auswahl stehen die grössten Universitäten und Schulen der Schweiz, wie ETH, HSG, UZH und viele mehr." >
			<?php
		}
		elseif($uri=='/sell/university'){
			?>
			<title>Bücher verkaufen - Student Trade</title>
			<meta name="description" content="Wollen Sie Ihre Bücher verkaufen? Bitte geben Sie hier Ihre Daten ein, um ihre Bücher mit wenigen Klicks zu verkaufen. Starten Sie noch heute und besuchen Studenttrade.ch!" >
			<?php
		}
		else {
			?>
			<title><?php echo lang('student_trade'); ?></title>
			<meta name="description" content="" >
			<?php
		}
	}
	else {
		?>
		<title><?php echo lang('student_trade'); ?></title>
		<meta name="description" content="" >
		<?php
	}
	?>
	<?php
	if($uri=='/' || $uri=='/index.php'){
		?>
		<link rel="canonical" href="https://www.studenttrade.ch/" />
		<?php
	}
	else {
		?>
		<link rel="canonical" href="https://www.studenttrade.ch<?php echo $uri; ?>" />
		<?php
	}
	?>
	<link rel="shortcut icon" type='image/x-icon' href="<?php echo base_url(); ?>assets/images/favicon.ico">
	<meta name="viewport" content="initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,700,800" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.gritter.min.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/gritter.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/bower_components/sweetalert/dist/sweetalert.css">
	<meta name="google-site-verification" content="51nEfV5WH176uwnyY3MkV-WPFY3QxzRYrKus1CZ2UT8" />

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-PZ9J3T1FMX"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-PZ9J3T1FMX');
	</script>
</head>
<body class="header-1 page-header-1">
	<div id="mySidenav" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<?php if(get_session('user_logged_in') == true){ ?>
			<a href="<?php echo base_url(); ?>user/profile" class="visible-xs">
				<img class="usr" src="<?php echo base_url(); ?>assets/profile_pictures/<?php echo get_session('profile_pic'); ?>" alt="user"> <?php echo get_session('username'); ?>
			</a>
			<!-- <a class="visible-xs" href="<?php // echo base_url(); ?>user/dashboard"><?php // echo lang('dashboard') ?></a> -->
		<?php } ?>
		<a href="<?php echo base_url(); ?>trade"><?php echo lang('lets_trade') ?></a>
		<a href="<?php echo base_url(); ?>about_us"><?php echo lang('about_us') ?></a>
		<a href="<?php echo base_url(); ?>charity"><?php echo lang('charity') ?></a>
		<a href="<?php echo base_url(); ?>contact_us"><?php echo lang('contact_footer') ?></a>
		<?php if(get_session('user_logged_in') !== true){ ?>
			<a class="mb-signup-btn" href="javascript:void(0)" data-toggle="modal" data-target="#signModal"><i class="fa fa-user"></i> <?php echo lang('sign_up'); ?></a>
			<a class="mb-signin-btn" href="javascript:void(0)" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in"></i> <?php echo lang('login'); ?></a>
		<?php }else{ ?>
			<a class="visible-xs" href="<?php echo base_url(); ?>logout"><?php echo lang('logout'); ?></a>
		<?php } ?>
	</div>
	<header id="header">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a href="<?php echo base_url(); ?>" id="navbar-brand" class="navbar-brand"><img src="<?php echo base_url(); ?>assets/images/header-logo-default.png" alt="Student Trade"></a>
					<button type="button" onclick="openNav()" class="open-nav navbar-toggle collapsed" aria-controls="navbar">
						<span class="sr-only"><?php echo lang('toggle_navigation'); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<nav id="navbar" class="navbar navbar-right navbar-collapse collapse site-navbar">
					<a href="<?php echo base_url(); ?>trade" class="btn btn-primary navbar-btn host-btn trade-btn"><?php echo lang('lets_trade') ?></a>
					<?php if(get_session('user_logged_in') !== true){ ?>
						<button class="btn btn-primary navbar-btn border-btns" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in"></i>&nbsp;<?php echo lang('login'); ?></button>
						<button class="btn btn-primary navbar-btn border-btns" data-toggle="modal" data-target="#signModal"><i class="fa fa-user"></i>&nbsp;<?php echo lang('sign_up'); ?></button>
					<?php } ?>
					<ul class="nav navbar-nav pull-right my-18-sm">
						<?php if(get_session('user_logged_in') == true){ ?>
							<li class="dropdown user-dropdown">
								<a href="javascript:void(0)"><img class="usr" src="<?php echo base_url(); ?>assets/profile_pictures/<?php echo get_session('profile_pic'); ?>" alt="user"></a>
								<ul class="dropdown-menu">
									<!-- <li><a href="<?php // echo base_url(); ?>user/dashboard"><i class="fa fa-tachometer"></i> <?php // echo lang('dashboard') ?></a></li> -->
									<li><a href="<?php echo base_url(); ?>user/profile"><i class="fa fa-user"></i> <?php echo lang('profile'); ?></a></li>
									<li><a href="<?php echo base_url(); ?>user/buyer_orders"><i class="fa fa-cart-arrow-down"></i> <?php echo lang('orders'); ?></a></li>
									<li><a href="<?php echo base_url(); ?>user/settings"><i class="fa fa-wrench"></i> <?php echo lang('account_setting'); ?></a></li>
									<li><a href="<?php echo base_url(); ?>user/books"><i class="fa fa-book"></i> <?php echo lang('books'); ?></a></li>
									<li><a href="<?php echo base_url(); ?>logout"><i class="fa fa-power-off"></i> <?php echo lang('logout'); ?></a></li>
								</ul>
							</li>
						<?php } ?>
						<!--- <li id="main">
							<a class="open-nav" style="font-size:30px; cursor:pointer" onclick="openNav()">&#9776; </a>
						</li> -->
					</ul>
					<a href="<?php echo base_url(); ?>shopping_cart" class="cart-btn"> <i class="fa fa-shopping-cart"></i> <span id="cart_items"><?php echo count($this->cart->contents()); ?></span></a>
					<?php if($this->session->userdata('site_lang') == 'english'){ ?>
						<a href="<?php echo base_url('languageswitcher/switchlang/german') ?>" class="lang-btn" style="padding: 2px 5px;" title="Klicken Sie hier, um auf Deutsch zu übersetzen">
							<img src="<?php echo base_url(); ?>assets/images/flag-uk.png">
						</a>
					<?php }else{ ?>
						<a href="<?php echo base_url('languageswitcher/switchlang/english') ?>" class="lang-btn" style="padding: 2px 5px;" title="Click here to translate in English">
							<img src="<?php echo base_url(); ?>assets/images/flag-de.png">
						</a>
					<?php } ?>
				</nav>
			</div>
		</nav>
	</header>