
			<!-- START O2-METADATA -->
			<script type="text/javascript">
		
				if (typeof(oxy) == 'undefined') {
					var oxy = { 'lang' : {} };
				}
			/*
				if (typeof(oxy.lang) == 'undefined') {
					var oxy.lang = {};
				}
				*/				
				var oxy = { 'lang' : {} };
				var APPPATH_URI						= "<?php echo APPPATH_URI;?>";
				var SITE_URL						= "<?php echo rtrim(site_url(), '/').'/';?>";
				var BASE_URL						= "<?php echo BASE_URL;?>";
				var BASE_URI						= "<?php echo BASE_URI;?>";
				var SITE_DIR						= "<?php echo SITE_DIR;?>";
				var DEFAULT_TITLE					= "<?php echo addslashes($this->settings->site_name); ?>";
				oxy.admin_theme_url					= "<?php echo BASE_URL . $this->admin_theme->path; ?>";
				oxy.apppath_uri						= "<?php echo APPPATH_URI; ?>";
				oxy.base_uri						= "<?php echo BASE_URI; ?>";
				oxy.lang.remove						= "<?php echo lang('global:remove'); ?>";
				oxy.lang.dialog_message 			= "<?php echo lang('global:dialog:generic_confirm_message'); ?>";
				oxy.lang.dialog_delete_message 		= "<?php echo lang('global:dialog:delete_message'); ?>";
				oxy.lang.dialog_message_logout 		= "<?php echo lang('global:dialog:logout_message'); ?>";
				oxy.lang.dialog_confirm_message 	= "<?php echo lang('global:dialog:confirm_message'); ?>";
				oxy.csrf_cookie_name				= "<?php echo config_item('cookie_prefix').config_item('csrf_cookie_name'); ?>";

			</script>
			<!-- END O2-METADATA -->	
			<script src="<?php echo site_url(); ?>system/cms/themes/oxygen_admin/js/o2/oxyobject.js" type="text/javascript"></script>


			<?php

				echo "\n<!-- START JS-METAPROFILE -->\n";
				echo Asset::render_js('metascript');
				echo "<!-- END JS-METAPROFILE -->\n\n"; 

		
				echo "\n<!-- START MODULE-METADATA -->\n";
				echo $template['metadata'];
				echo "<!-- END MODULE-METADATA -->\n\n";

				echo "<!-- START-LOCAL RENDER -->\n\n";
				echo Asset::render_js();
				echo "<!-- END-LOCAL RENDER -->\n\n";
			?>