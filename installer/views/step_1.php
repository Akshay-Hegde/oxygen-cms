
  <div class="box-header with-border">
    <h3 class="box-title">{header}!</h3>
    <p>{intro_text}</p>
  </div>
  <div class="box-body">

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>
	<h3>{db_settings}</h3>
	<p>{db_text}</p>
	<?php if (!$this->installer_lib->mysql_available()): ?>
		<p class="result fail">{db_missing}</p>
	<?php endif; ?>

	<table class='table'>
		<tr>
			<td>
				<label for="database">{database}</label>
			</td>
			<td>
				<input type="text" id="database" class="input_text" name="database" placeholder='Database Name' value="<?php echo set_value('database'); ?>" />
			</td>			
		</tr>
		<tr>
			<td>
				<label for="create_db">{db_create}</label>
			</td>
			<td>
				<input type="checkbox" name="create_db" value="true" id="create_db" checked="checked" <?php if($this->input->post('create_db') == 'true') { echo ' checked="checked"'; } ?> />
				<small>({db_notice})</small>
			</td>			
		</tr>
		<tr>
			<td>
				<label for="hostname">{server}</label>
			</td>
			<td>
				<input type="text" id="hostname" class="input_text" name="hostname" placeholder='localhost' value="<?php echo set_value('hostname'); ?>" />
			</td>			
		</tr>
		<tr>
			<td>
				<label for="port">{portnr}</label>
			</td>
			<td>
				<input type="text" id="port" class="input_text" name="port" placeholder='3306' value="<?php echo set_value('port'); ?>" />				
			</td>			
		</tr>
		<tr>
			<td>
				<label for="username">{username}</label>
			</td>
			<td>
				<?php echo form_input(array('id' => 'username', 'name' => 'username'), set_value('username','')," placeholder='' "); ?>
			</td>			
		</tr>
		<tr>
			<td>
				<label for="password">{password}</label>
			</td>
			<td>
				<?php echo form_password(array('id' => 'password', 'name' => 'password'), set_value('password')," placeholder='' "); ?>
			</td>			
		</tr>
		<tr>
			<td>
				<label for="password">{httpserver}</label>
			</td>
			<td>
				<?php echo form_dropdown('http_server', $server_options, set_value('http_server'), 'id="http_server"'); ?><br/>
				<small>({httpserver_text})</small>
			</td>			
		</tr>
		<tr>
			<td>

			</td>
			<td>
				<input type="hidden" name="installation_step" value="step_1"/>
				<input type="submit" id="next_step" value="{step2}" class="btn btn-flat bg-blue"/>
			</td>			
		</tr>
	</table>

<?php echo form_close(); ?>
</div>