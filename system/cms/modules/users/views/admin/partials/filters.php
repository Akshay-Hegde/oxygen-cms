
<fieldset id="filters">
<?php
	echo form_open('');
	echo form_hidden('f_module', $module_details['slug']); 
	echo lang('user:active', 'f_active'); 
	echo form_dropdown('f_active', array(0 => lang('global:select-all'), 1 => lang('global:yes'), 2 => lang('global:no') ), array(0),'class="form-control"'); 
	echo lang('user:group_label', 'f_group'); 
	echo form_dropdown('f_group', array(0 => lang('global:select-all')) + $groups_select,null,'class="form-control"'); 
	echo "Keywords";
	echo form_input('f_keywords',null,'class="form-control"');
	echo '<br>';
	echo anchor(current_url(), lang('buttons:cancel'), 'class="btn btn-default btn-flat cancel"');

	echo form_close();
?>
</fieldset>