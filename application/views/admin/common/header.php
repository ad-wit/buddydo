<html>
	<head>
		<title><?php echo( $title ? $title : "Dashboard" ); ?></title>
		<!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"> -->
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">

		<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/semantic.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/all.css'); ?>">
		<script src="<?php echo base_url('assets/js/jquery-1.12.4.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/perfect-scrollbar.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/semantic.min.js'); ?>"></script>
		<?php
			if( isset($assets) ){
				foreach ($assets as $key => $value) {
					echo $value;
				}
			}
		?>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/perfect-scrollbar.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
	</head>
	<body>
		<div class="container">
