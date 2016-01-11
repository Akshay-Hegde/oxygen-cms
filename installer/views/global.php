<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OxygenCMS Installer</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url(); ?>assets/css/o2/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/o2/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/o2/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />

    </head>

    <style>
    .logoimg {
    	background:url(<?php echo base_url(); ?>assets/images/logo.png) no-repeat;
    	width:150px;
    }
    </style>

    <body class="skin-blue layout-top-nav">

        <div class="wrapper">

            <header class="main-header">   
                <nav class="navbar navbar">

                    <div class="container">

                        <div class="navbar-header">
                          <a href="#" class="navbar-brand logoimg"></a>
                        </div>

                        <!-- Navbar Menu -->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                        		<?php foreach($language_nav as $lang => $info):?>
                                <li class="">
                                    <a href="<?php echo $info['action_url']; ?>" title="<?php echo $info['name']; ?>">
                                    	<img src="<?php echo $info['image_url']; ?>" alt="<?php echo $info['name']; ?>"/>
                                    </a>
                                </li>
                        		<?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

            <div class="content-wrapper">

                <div class="container">

                    <section class="content-header">
                        <h1>
                          <small></small>
                        </h1>
                        <ol class="breadcrumb">
                    		<li class="<?php echo $this->uri->segment(2, '') == '' ? 'active' : '' ?>"><a href="#"><?php echo lang('intro'); ?></a></li>
                            <li class="<?php echo $this->uri->segment(2, '') == 'step_1' ? 'active' : '' ?>"><a href="#"><?php echo lang('step1'); ?></a></li>
                            <li class="<?php echo $this->uri->segment(2, '') == 'step_2' ? 'active' : '' ?>"><a href="#"><?php echo lang('step2'); ?></a></li>
                            <li class="<?php echo $this->uri->segment(2, '') == 'step_3' ? 'active' : '' ?>"><a href="#"><?php echo lang('step3'); ?></a></li>
                            <li class="<?php echo $this->uri->segment(2, '') == 'step_4' ? 'active' : '' ?>"><a href="#"><?php echo lang('step4'); ?></a></li>
                            <li class="<?php echo $this->uri->segment(2, '') == 'complete' ? 'active' : '' ?>"><a href="#"><?php echo lang('final'); ?></a></li>
                        </ol>
                    </section>

                    <section class="content">

                        <!-- Message type 1 (flashdata) -->
                        <?php if($this->session->flashdata('message')): ?>
                            <div class="callout callout-info">
                              <h4>Message Response</h4>
                              <?php echo $this->session->flashdata('message');?>
                            </div>
                        <?php endif; ?>

                        <!-- Message type 2 (validation errors) -->
                        <?php if ( validation_errors() ): ?>
                            <div class="callout callout-danger">
                              <h4>Warning!</h4>
                              <p><?php echo validation_errors(); ?></p>
                            </div>				
                        <?php endif; ?>

                        <!-- Message type 3 (data for the same page load) -->
                        <?php if($this->messages): ?>
                        	<?php foreach (array_keys($this->messages) as $type): ?>
                        		
                        			<?php foreach ($this->messages as $key => $message): ?>
                        				<?php if ($key === $type): ?>
                        					
                        		            <div class="callout callout-danger">
                        		              <h4>Message</h4>
                        		              <?php echo $message; ?>
                        		            </div>

                        				<?php endif; ?>
                        			<?php endforeach; ?>
                        		
                        	<?php endforeach; ?>
                        <?php endif; ?>


                        <div class="box box-solid">
            				<?php echo $page_output . PHP_EOL; ?>
                        </div>
                    </section>
                </div>
            </div>

            <footer class="main-footer">
                <div class="container">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> <?php echo CMS_VERSION; ?>
                    </div>
                    <strong>Copyright &copy; 2014-2015 <a href="http://oxygen-cms.com">Oxygen-CMS.com</a>.</strong> All rights reserved.
                </div><!-- /.container -->
            </footer>

        </div>

        <script src="<?php echo base_url(); ?>assets/js/o2/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/o2/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/o2/app.min.js" type="text/javascript"></script>

        <!--legacy-->
        <script type="text/javascript">
        	var base_url = '<?php echo base_url(); ?>',
        	pass_match = ['<?php echo lang('installer.passwords_match'); ?>','<?php echo lang('installer.passwords_dont_match'); ?>'];
        </script>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.complexify.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/installer.js"></script>
    </body>
</html>