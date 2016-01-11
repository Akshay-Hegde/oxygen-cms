		<fieldset>

				<label for="restricted_to[]">
					User group access to Page (Public facing site)
				</label>
				<div class="input">
					<?php 
						echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, $page->restricted_to, 'class="form-control" ') ?>
				</div>
				

				<label for="restricted_to[]">
					Per user access to Page 
				</label>
				<div class="input">
					<table class='table'>
						<tr>
							<td>
								User
							</td>
							<td>
								Public Access
							</td>
							<td>
								Admin (edit) Access
							</td>							
						</tr>					
					<?php foreach($system_users as $s_user): ?>
						<tr>
							<td>
								<?php echo $s_user->display_name;?>
							</td>
							<td>
								<input type='checkbox' name='direct_public_access[<?php echo $s_user->id;?>]' <?php echo ($s_user->has_dpa)?' checked ':'';?> value=''>
							</td>
							<td>
								<input type='checkbox' name='direct_admin_access[<?php echo $s_user->id;?>]' <?php echo ($s_user->has_daa)?' checked ':'';?> value=''>
							</td>							
						</tr>
					<?php endforeach;?>
					</table>
				</div>						
		</fieldset>