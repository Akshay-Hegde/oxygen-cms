<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>OxygenCMS | Log in</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<base href="<?php echo base_url(); ?>" />
		<?php echo Asset::favicon('favicon.ico','link'); ?>	
		<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/css/bootstrap.min.css"  />	
		<?php
			//Asset::clear_cache('now');
			//Asset::css('bootstrap.min.css');
			Asset::css('AdminLTE.css');
			//Asset::css('global.css');

			if(ENVIRONMENT == 'production'):
				Asset::css('skins/skin-red-light.min.css');
			else:
				Asset::css('skins/skin-blue-light.min.css');
			endif;

			echo Asset::render_css();

			Asset::js('plugins/jQuery/jQuery-2.1.4.min.js');
			Asset::js('o2/bootstrap.min.js');
			echo Asset::render_js();
		 ?>
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-page">

		<div class="login-box">

			<div class="login-box-body">
				<div class="login-logo">
					<a href="#"><b>Oxygen</b>CMS</a>
				</div>

				<div class='text-center'>
					<img class='text-center' src='<?php echo theme_image('logo.png',null,'path'); ?>' style='width:70px;'>
					<br>
				</div>
				<br>

				<?php $this->load->view('admin/partials/o2/notices') ?>

				<p class="login-box-msg">
					Sign in to start your session
				</p>
				<?php echo form_open('admin/login'); ?>
					<div class="form-group has-feedback">
						<input type="text" name="email" class='form-control' placeholder="<?php echo lang('global:email_or_username'); ?>"/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>

					<div class="form-group has-feedback">
						<input type="password" name="password" class='form-control' placeholder="<?php echo lang('global:password'); ?>"/>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>

					<div class="row padding">
						<div class="col-xs-8">    
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" id="remember-check" checked /> <?php echo lang('user:remember'); ?>
								</label>
							</div>                        
						</div>
						<div class="col-xs-4">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>

			<div class='text-center' style='color:#a2a4ae'>
				<br>
				<small>
					Copyright 2014-2015 Oxygen-cms.com.
				</small>
				<br>
				<small>
					<?php echo $this->settings->site_name;?>
					<small>
						| <?php echo ucfirst(ENVIRONMENT);?>
					</small>
				</small>
				
			</div>  
		</div>

		<?php 
			Asset::js('plugins/bootbox/bootbox.min.js');
			echo Asset::render_js();
		?>
	</body>

</html>
