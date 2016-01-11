<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $template['title'].' - '.lang('cp:admin_title') ?></title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<base href="<?php echo base_url(); ?>" />

		<?php echo Asset::favicon('favicon.ico','link'); ?>

		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/bootstrap.min.css"  />
		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/global.css" />		
		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/jquery/jquery.tagsinput.css" />

		<?php
			// Load up the CSS Profile files
			echo "\n<!-- START-CSS_PROFILE-->\n";
			echo Asset::render_css('profile_header');
			echo "<!-- END-CSS_PROFILE-->\n\n";	

			echo Asset::render_css();	
		?>

		<script type="text/javascript" src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<!--script type="text/javascript" src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/jQueryUI/jquery-ui-1.10.3.js"></script-->
		<script type="text/javascript" src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/o2/bootstrap.min.js"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/livequery/livequery.js" type="text/javascript"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/jquery/jquery.tagsinput.js" type="text/javascript"></script>
	

		<?php
			// Load up the CSS Profile files
			echo "\n<!-- START JS-PROFILE-->\n";
			echo Asset::render_js('profile_header');
			echo "<!-- END JS-PROFILE-->\n\n";		
		?>			

		<?php file_partial('o2/metadata'); ?>

		


	</head>

	<body>

		<div class="wrapper">

			<?php file_partial('o2/modals/modals'); ?>			

			  <!-- Content Wrapper. Contains page content -->
			  <div class="content-wrapper">		
					<?php //file_partial('o2/shortcuts2'); ?>
					<section class="content">
						<?php file_partial('o2/notices'); ?>
						<?php echo $template['body']; ?>
					</section>
			  </div>


		</div>


		<!-- Page script begins -->
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/jquery/jquery.cooki.js" type="text/javascript"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/debounce/debounce.js" type="text/javascript"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/o2/app.js" type="text/javascript"></script>
		<?php echo Asset::js_inline(';jQuery.noConflict();'); ?>

	<?php 
		echo Asset::render_js('profile_footer');
		echo Asset::render_js('endscripts');
		echo Asset::render_js();
	?>
	    <script>

		    //wait until jQ is fully loaded
		    (function($) {
		        $(function(){

		        });
		    })(jQuery);     

		</script>

	</body>
</html>