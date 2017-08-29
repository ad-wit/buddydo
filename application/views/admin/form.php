<html>
	<head>
		<title>Image Manipulations</title>
	</head>
	<body>
		<form action="<?php echo base_url("upload/upload"); ?>" enctype="multipart/form-data" method="post">
			<input type="file" name="image" />
			<input type="submit">
		</form>
		<?php foreach ($content as $key => $value) { ?>
			<!-- <img src="<?php echo base_url("uploads/$value"); ?>" alt=""> -->
		<?php } ?>
	</body>
</html>