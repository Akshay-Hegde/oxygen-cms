<style>
	label {width:175px !important;}
	ul.setting {list-style-type: none;}
</style>
<br>

	<?php if ($this->method == 'create'): ?>
		<div class="" id="title-value-<?php echo $link->navigation_group_id ?>">
			<?php echo lang('nav:link_create_title');?>
		</div>
	<?php else: ?>
		<div class="" id="title-value-<?php echo $link->navigation_group_id ?>">
			<?php echo sprintf(lang('nav:link_edit_title'), $link->title);?>
		</div>
	<?php endif ?>
	
	<?php echo form_open(uri_string(), 'id="nav-' . $this->method . '" class="form_inputs"') ?>
	
		<ul class='setting'>
			
			<?php if ($this->method == 'edit'): ?>
						<?php echo form_hidden('link_id', $link->id) ?>
			<?php endif ?>

			<?php echo form_hidden('current_group_id', $link->navigation_group_id) ?>
			
			<li class="">
				<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
				<?php echo form_input('title', $link->title, 'maxlength="50" class="text"') ?>
			</li>
			
			<?php if ($this->method == 'edit'): ?>
				<li class="">
					<label for="navigation_group_id"><?php echo lang('nav:group_label');?></label>
					<?php echo form_dropdown('navigation_group_id', $groups_select, $link->navigation_group_id) ?>
				</li>
			<?php else: ?>
				<?php echo form_hidden('navigation_group_id', $link->navigation_group_id) ?>
			<?php endif ?>
	
			<input type='hidden' name='link_type' value='url'>

			<li class="">
	
				<p style="<?php echo ! empty($link->link_type) ? 'display:none' : '' ?>">
					<?php echo lang('nav:link_type_desc') ?>
				</p>
	
				<div id="navigation-url" style="">
					<label for="url"><?php echo lang('nav:url_label');?></label>
					<input type="text" id="url" name="url" value="<?php echo empty($link->url) ? 'http://' : $link->url ?>" />
				</div>
				
			</li>

			<li class="<?php echo alternator('', 'even') ?>">
				<label for="target"><?php echo lang('nav:target_label') ?></label>
				<?php echo form_dropdown('target', array(''=> lang('nav:link_target_self'), '_blank' => lang('nav:link_target_blank')), $link->target) ?>
			</li>

			<li class="<?php echo alternator('even', '') ?>">
				<label for="restricted_to[]"><?php echo lang('nav:restricted_to');?></label>
				<?php echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, (strpos($link->restricted_to, ",") ? explode(",", $link->restricted_to) : $link->restricted_to), 'size="'.(($count = count($group_options)) > 1 ? $count : 2).'"') ?>
			</li>
	
			<li class="<?php echo alternator('', 'even') ?>">
				<label for="class"><?php echo lang('nav:class_label') ?></label>
				<?php echo form_input('class', $link->class) ?>
			</li>

			<li class="<?php echo alternator('', 'even') ?>">
				<label for="data"><?php echo lang('nav:data_label') ?></label>
				<?php echo form_input('data', $link->data) ?>
			</li>	
			<li class="<?php echo alternator('', 'even') ?>">
				<label for="icon"><?php echo lang('nav:icon_label') ?></label>
				<?php echo form_input('icon',  isset($link->icon)?$link->icon:'') ?>
			</li>						
		</ul>
	
	    <div class="modal-footer">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
			<button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
        </div>

	<?php echo form_close() ?>

