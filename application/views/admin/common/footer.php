		</div>
	</body>
	<script>
        var tags = [<?php echo( isset($autoSuggestTags) ? $autoSuggestTags : "" ); ?>];
        var dtUrl = "<?php echo( isset($dtUrl) ? $dtUrl : "" ); ?>";
    </script>
	<script src="<?php echo base_url("assets/js/script.js") ?>"></script>
</html>