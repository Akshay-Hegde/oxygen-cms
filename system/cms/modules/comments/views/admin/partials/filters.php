<fieldset id="filters">
	
		<?php echo form_open('') ?>
		<?php echo form_hidden('f_module', $module_details['slug']) ?>

			<?php if (Settings::get('moderate_comments')): ?>
					Status:<br><br>
					<?php echo form_dropdown('f_active', array('all' =>'All Comments',0 =>lang('comments:inactive_title'), 1 => lang('comments:active_title')), (int) $comments_active,'class="form-control"') ?>	<br>
			<?php endif ?>
	
            	Type:<br><br>
            	<?php echo form_dropdown('f_module', array(0 => lang('global:select-all')) + $module_list,null,'class="form-control"') ?>
				<br>
				<?php echo anchor(current_url() . '#', lang('buttons:cancel'), 'class="btn btn-flat btn-default cancel"') ?>
		
		<?php echo form_close() ?>
	
</fieldset>
