<?php 
	switch(ENVIRONMENT)
	{
		case 'development':
			$theme_color = 'blue';
			break;
		case 'staging':
			$theme_color = 'green';
			break;
		case 'production':
			$theme_color = 'red';
			break;
	}						
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $template['title'].' - '.lang('cp:admin_title') ?></title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<base href="<?php echo base_url(); ?>" />

		<?php echo Asset::favicon('favicon.ico','link'); ?>

		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/bootstrap.min.css"  />
		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/AdminLTE.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/global.css" />		
		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/skins/skin-<?php echo $theme_color;?>-light.min.css" />

		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/jquery/jquery.tagsinput.css" />

		<?php
			echo Asset::render_css('profile_header');
			echo Asset::render_css();	
		?>

		<script type="text/javascript" src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<script type="text/javascript" src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/jQueryUI/jquery-ui-1.10.3.js"></script>
		<script type="text/javascript" src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/o2/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/chartjs/Chart.js"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/jquery/jquery.tagsinput.js" type="text/javascript"></script>
		<?php echo Asset::render_js('profile_header');?>			
		<?php file_partial('o2/metadata'); ?>
		<?php file_partial('o2/environment/'.ENVIRONMENT); ?>	
	</head>

	<body class="skin-<?php echo $theme_color;?>-light sidebar-mini ">

		<div class="wrapper">

			<?php file_partial('o2/modals/modals'); ?>			
			<?php file_partial('o2/header_bar'); ?>
			<?php file_partial('o2/sidebar_left'); ?>

			  <!-- Content Wrapper. Contains page content -->
			  <div class="content-wrapper">
							
					
						<?php file_partial('o2/shortcuts'); ?>
					

					<section class="content">
						<?php file_partial('o2/notices'); ?>
						<?php echo $template['body']; ?>
					</section>

			  </div>
			  
			<?php file_partial('o2/footer'); ?>

			<?php file_partial('o2/sidebar_right'); ?>

			<!-- Add the sidebar's background. This div must be placed
			immediately after the control sidebar -->
			<div class='control-sidebar-bg'></div>
		</div>

		<!-- Page script begins -->
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/livequery/livequery.js" type="text/javascript"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/jquery/jquery.cooki.js" type="text/javascript"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/debounce/debounce.js" type="text/javascript"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/o2/app.js" type="text/javascript"></script>
		<?php echo Asset::js_inline(';jQuery.noConflict();'); ?>

		<?php
		echo "\n<!-- START CSS-FOOTER PROFILE -->\n";
		echo Asset::render_css('profile_footer');
		echo "\n<!-- END CSS-FOOTER PROFILE -->\n";	
		echo Asset::render_js('endscripts');

		?>


		<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/flot/jquery.flot.js" type="text/javascript"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/flot/jquery.flot.pie.js" type="text/javascript"></script>
		<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/plugins/flot/jquery.flot.categories.js" type="text/javascript"></script>
		
		<?php 
			echo Asset::render_js('profile_footer');
			echo Asset::render_js('endscripts');
			echo Asset::render_js();
		?>
	</body>
</html>