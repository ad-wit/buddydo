<html>
	<head>
		<title><?php echo( isset($title) ? $title : "" ); ?></title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo( base_url("assets/app/dashboard/css/modal.css") ); ?>">
		<link rel="stylesheet" href="<?php echo( base_url("assets/app/dashboard/css/overwrite.css") ); ?>">
		<link rel="stylesheet" href="<?php echo( base_url("assets/app/dashboard/css/form.css") ); ?>">
		<link rel="stylesheet" href="<?php echo( base_url("assets/app/dashboard/css/app.css") ); ?>">
		<!-- <link rel="stylesheet" href="<?php echo( base_url("assets/app/dashboard/css/jquery.mCustomScrollbar.min.css") ); ?>"> -->
		<script src="<?php echo base_url("assets/app/dashboard/js/jquery.js"); ?>"></script>
		<!-- <script src="<?php echo( base_url("assets/app/dashboard/js/jquery.mCustomScrollbar.concat.min.js") ); ?>"></script> -->
	</head>
	<body>
		<div class="ty-container">
			<div class="ty-header">
				<?php if( $this->session->flashdata('form_error') == true ){ ?>
	                <!-- <div class="message_template template_error">
	                    <button class="close" data-dismiss="alert"></button> <?php echo $this->session->flashdata('form_error'); ?>
	                </div> -->
	            <?php } ?>
	            <?php if( $this->session->flashdata('form_success') == true ){ ?>
	                <!-- <div class="message_template template_success">
	                    <button class="close" data-dismiss="alert"></button> <?php echo $this->session->flashdata('form_success'); ?>
	                </div> -->
	            <?php } ?>
				<div class="ty-add-project-header">
					<a href="<?php echo base_url('app/dashboard'); ?>" class="account-links">Dashboard</a>
					<!-- <a href="" class="account-links">Tasks <span class="assigned-by">Assigned by You</span></a> -->
					<a href="<?php echo base_url('app/logout'); ?>" class="account-links">Logout</a>
					<a class="account-links">Welcome - <?php echo $this->uauth->getuser()['user_name']; ?></a>
					<a href="#ex1" class="addtask" rel="modal:open">Add Task List</a>
				</div>
	        </div>
			<div id="ex1" style="display:none;">
				<form action="<?php echo( isset($formUrl) ? $formUrl : "" ); ?>" method="post">
					<a href="#" rel="modal:close" class="ty-modal-close"><img src="<?php echo base_url("assets/app/dashboard/images/cross.png"); ?>"></a>
					<input type="text" if="ty-fc-1" required class="ty-form-control-medium ty-project-input" name="name" placeholder="Task List Name"/>
					<br>
					<input placeholder="Buddy's Email" required class="ty-form-control-medium" name="email" />
					<p class="error-message">Account with this email doesn't exists.</p>
					<button class="ty-btn ty-btn-inline ty-btn-inline-outline add-task-submit">Add</button>
					<a class="ty-btn ty-btn-inline" rel="modal:close">Back</a>
				</form>
			</div>
<script>
	$(document).ready(function(e){
		console.log('data');
		$(document).on('click', '.add-task-submit', function(e){
			e.preventDefault();
			$('.error-message').css('visibility', 'hidden');
			var submit = true;
			if( $.trim($('input[name="name"]').val()) == '' ){
				submit = false;
			}
			if( $.trim($('input[name="email"]').val()) == '' ){
				submit = false;
			}
			if(submit){
				var name = $.trim($('input[name="name"]').val());
				var email = $.trim($('input[name="email"]').val());
				console.log(name + ' ' + email);
				$.ajax({
					url : '<?php echo base_url('app/addtasklist'); ?>',
					data : { listname : name, buddyemail : email },
					type : 'post',
					success : function(data, status, jqxhr){
						var dat = JSON.parse(data);
						console.log(dat);
						if( dat.status == 'success' ){
							window.location.reload();
						}else{
							$('.error-message').text(dat.message).css('visibility', 'visible');
						}
					},
					error : function(jqxhr, status, error){
						console.log(error);
					}
				});
			}else{
				$('.error-message').text('all fields are mandatory').css('visibility', 'visible');
			}

		})
	});
</script>