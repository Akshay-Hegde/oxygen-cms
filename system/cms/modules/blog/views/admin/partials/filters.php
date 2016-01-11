<div class="row">
	<fieldset id="filters">
		<?php echo form_open('', '', array('f_module' => $module_details['slug'])) ?>
		    <div class="col-xs-12">
		
        		<label for="f_status"><?php echo lang('blog:status_label') ?></label>
        		<?php echo form_dropdown('f_status', array(0 => lang('global:select-all'), 'draft'=>lang('blog:draft_label'), 'live'=>lang('blog:live_label')),null,'class="form-control"') ?>

        		<label for="f_category"><?php echo lang('blog:category_label') ?></label>
       			<?php echo form_dropdown('f_category', array(0 => lang('global:select-all')) + $categories,null,'class="form-control"') ?>


				<label for="f_category"><?php echo lang('global:keywords') ?></label>
				<?php echo form_input('f_keywords', '', 'style="width: 55%;" class="form-control"') ?>
				<br>
				<?php echo anchor(current_url() . '#', lang('buttons:cancel'), 'class="btn btn-flat btn-default"') ?>
			</div>
		<?php echo form_close() ?>
	</fieldset>
</div>
