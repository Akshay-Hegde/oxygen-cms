	<div class="box-header with-border">
		<h3 class="box-title">{header}!</h3>
		<p>{intro_text}</p>                
	</div>
	<div class="box-body">
		<?php echo form_open(uri_string(), 'id="install_frm"'); ?>
			<input type="hidden" id="site_ref" name="site_ref" value="default" />
			<h3>{default_user}</h3>
			<table class='table'>
				<tr>
					<td>
						<label for="user_name">{user_name}</label>
					</td>
					<td>
						<?php echo form_input(array('id' => 'user_name', 'name' => 'user_name', 'value' => set_value('user_name',''))); ?>
					</td>
				</tr>
				<tr>
					<td>
						<label for="user_firstname">{first_name}</label>
					</td>
					<td>
						<?php echo form_input(array('id' => 'user_firstname', 'name' => 'user_firstname', 'value' => set_value('user_firstname',''))); ?>
					</td>
				</tr>	

				<tr>
					<td>
						<label for="user_lastname">{last_name}</label>
					</td>
					<td>
						<?php echo form_input(array('id' => 'user_lastname', 'name' => 'user_lastname', 'value' => set_value('user_lastname',''))); ?>
					</td>
				</tr>

				<tr>
					<td>
						<label for="user_email">{email}</label>
					</td>
					<td>
						<?php echo form_input(array('id' => 'user_email', 'name' => 'user_email', 'value' => set_value('user_email',''))); ?>
					</td>
				</tr>

				<tr>
					<td>
						<label for="user_password">{password}</label>
					</td>
					<td>
						<?php echo form_password(array('id' => 'user_password', 'name' => 'user_password', 'value' => set_value('user_password'))); ?>
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
					<td>
						<div class='col-md-6'>
						<div class="progress progress-xs">
			                    <div id="progressbar" style="width:0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar" class="progress-bar progress-bar-aqua progress-bar-striped">
			                      <span class="sr-only" id="progress"><span id="complexity">0% Complex</span></span>
			                    </div>
			            </div>
		            </div>
					</td>
				</tr>											
			</table>
			<hr />
			<input class="btn btn-flat bg-blue" id="next_step" type="submit" id="submit" value="<?php echo lang('finish'); ?>" />
		<?php echo form_close(); ?>
	</div>