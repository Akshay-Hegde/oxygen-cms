
<?php if ($this->settings->ga_tracking_id): ?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];
		a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		<?php 
			if($this->current_user):
				$gacode = "ga('create', 'UA-XXXXX-Y', 'auto', {'userId': '%s'});";
				echo sprintf($gacode, $this->current_user->id);
			else: 
				$gacode = "ga('create', 'UA-XXXXX-Y', 'auto');";
				echo sprintf($gacode);
			endif; 
		?>
		ga('send', 'pageview');
	</script>
<?php endif; ?>