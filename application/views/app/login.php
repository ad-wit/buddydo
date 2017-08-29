<html>
	<head>
		<title><?php echo( isset($title) ? $title : 'Buddy Todo' ); ?></title>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/semantic.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
		<script src="<?php echo base_url('assets/js/jquery-1.12.4.min.js'); ?>"></script>
	</head>
	<style>
		html, body, .container{
			padding: 0;
			margin: 0;
			height: 100%;
			width: 100%;
			overflow-y: auto;
		}
		.intro, .__form{
			height: 100%;
			display: inline-block;
			float: left;
		}
		.intro{
			text-align: center;
			width: calc( 100% - 400px );
			border-right: 1px solid #e3e3e3;
			box-sizing: border-box;
			position: relative;
		}
		.__form{
			width: 400px;
			position: relative;
			float: right;
			padding: 15px;
		}
		.intro h1{
			margin-top: 50px;
		}
		.signin-image{
			width: 100%;
    		max-width: 400px;
		}
		.__form .ui.form{
			/*position: absolute;
			width: 400px;
		    top: 0;
		    left: 0;
		    right: 0;
		    bottom: 0;
		    margin: auto;
		    height: 700px;*/
		}
		.about{
			font-size: 16px;
    		padding: 20px;
		}
		.message-wrapper{
			padding: 10px 20px;
		    border: 1px solid #e3e3e3;
		    margin: 10px 0;
		    border-radius: 3px;
		}
		.message-wrapper.error{
			background: #ffacac;
    		border: 2px solid #ec7171;
		}
		.message-wrapper.success{
			background: #57de94;
    		border: 2px solid #3a9c66;
		}
		.message{
			text-align: center;
		}
		.message-wrapper.error .message{
			color: #ce3131;
    		font-size: 16px;
		}
		.message-wrapper.success .message{
			color: #266b45;
			font-size: 16px;
		}
		.signin-options{
			margin: 20px 0;
			text-align: center;
			margin-top: 60px;
		}
		.signin-options .signin-btn{
			width: 200px;
		    display: inline-block;
		    text-align: center;
		    padding: 10px 40px;
		    font-size: 20px;
		    text-decoration: underline;
		}
		.ui.form .field {
		    clear: both;
		    margin: 0 0 1em;
		}
	</style>
	<body>
		<div class="container">
			<div class="intro">
				<div class="actual-content">
					<h1>Welcome to Buddy Todo </h1>
					<img class="signin-image" src="<?php echo base_url("assets/img/signin.jpg"); ?>" alt="">
					<p class="about"></p>
				</div>
			</div>
			<div class="__form">
				<?php
					if( $this->session->flashdata('formdata') == true ){
						$formdata = $this->session->flashdata('formdata');
					}else{
						$formdata = [];
					}
				?>
				<form class="ui form" method="POST" action="<?php echo $signinUrl; ?>">
					<h1 style="text-align:center;">Sign In</h1>
					<!-- <h3 style="text-align:center;">Sign In</h3> -->
					<?php if( $this->session->flashdata('form_error') == true ){ ?>
						<div class="message-wrapper error">
							<p class="message"><?php echo $this->session->flashdata('form_error') ?></p>
						</div>
					<?php } ?>
					<?php if( $this->session->flashdata('form_success') == true ){ ?>
						<div class="message-wrapper success">
							<p class="message"><?php echo $this->session->flashdata('form_success') ?></p>
						</div>
					<?php } ?>
				  	<div class="field">
				  		<label>Email</label>
				  		<input type="email" name="user_email" autocomplete="off" required value="<?php echo( isset($formdata['user_email']) ? $formdata['user_email'] : '' ); ?>" placeholder="Email">
				  	</div>
				    <div class="field">
				  		<label>Password</label>
				  		<input type="password" name="user_password" autocomplete="off" required placeholder="Password">
				  	</div>
				  	<input type="submit" class="ui button primary huge app-button" tabindex="0" value="Sign In" />
				</form>
			</div>
		</div>
	</body>
	<script>
		$(document).ready(function(e){
			fitLoginContent();
		});
		function fitLoginContent(){

			var padTop1 = $('.__form').height()/2 - $('.__form .ui.form').height()/2
			$('.__form .ui.form').css({
				'padding-top' : padTop1 - 15
			});

			var padTop2 = $('.intro').height()/2 - $('.actual-content').height()/2
			$('.actual-content').css({
				'padding-top' : padTop2 - 15
			});


		}

		window.onresize = function(event) {
		    fitLoginContent();
		};
	</script>
</html>