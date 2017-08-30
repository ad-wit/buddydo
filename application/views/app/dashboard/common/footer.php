		</div>
	</body>
	<script src="<?php echo base_url("assets/app/dashboard/js/modal.js"); ?>"></script>
	<script src="<?php echo base_url("assets/app/dashboard/js/app.js"); ?>"></script>
	<script>
		var url = "<?php echo base_url(); ?>";
		$.modal.defaults = {
			closeExisting: true,    // Close existing modals. Set this to false if you need to stack multiple modal instances.
			escapeClose: true,      // Allows the user to close the modal by pressing `ESC`
			clickClose: true,       // Allows the user to close the modal by clicking the overlay
			closeText: 'Close',     // Text content for the close <a> tag.
			closeClass: '',         // Add additional class(es) to the close <a> tag.
			showClose: false,        // Shows a (X) icon/link in the top-right corner
			modalClass: "modal",    // CSS class added to the element being displayed in the modal.
			spinnerHtml: null,      // HTML appended to the default spinner during AJAX requests.
			showSpinner: true,      // Enable/disable the default spinner during AJAX requests.
			fadeDuration: 50,     // Number of milliseconds the fade transition takes (null means no transition)
			fadeDelay: 1.0          // Point during the overlay's fade-in that the modal begins to fade in (.5 = 50%, 1.5 = 150%, etc.)
		};

		$(document).ready(function(){
			$(".ty-project-task").perfectScrollbar();
		});
	</script>
</html>