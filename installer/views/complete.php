
<div class="box-header with-border">
	<h3 class="box-title"><h3>{congrats}, {user_firstname} {user_lastname}!</h3></h3>
</div>
<div class="box-body">

		<section class="item">
		<p>{intro_text}</p>

		<p>
			<strong>{email}:</strong> {user_email}
		</p>
		<p class="password-reveal" style='display:none'>
			<strong>{password}:</strong> <span class="password">{user_password}</span>
		</p>
		<p><a class="button show-pass" href="#"> {show_password}</a></p>

		<p><?php echo lang('outro_text'); ?></p>

		<p>
			<?php echo anchor($website_url, lang('go_website'), 'class="btn btn-flat bg-blue go_to_site"'); ?>
			<?php echo anchor($control_panel_url, lang('go_control_panel'), 'class="btn btn-flat bg-blue go_to_site"'); ?>
		</p>
		<?php
		/*
			<script>
				jQuery(function( $ ) {

					$(function(){
						$.get("<?php echo site_url('ajax/statistics');?>");
						$(document).on('click','a.show-pass',function(e){
							$(this).fadeOut();
							$('.password-reveal').delay(400).fadeIn();
							e.preventDefault();
						});
					});
				});
			</script>
		*/
		?>
		</section>
</div>