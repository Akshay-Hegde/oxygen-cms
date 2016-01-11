      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              	<h4 class="modal-title">

            		<?php if( $current_action == 'add'): ?>
            			Add Widget
            		<?php else: ?>
            			Edit Widget
            		<?php endif; ?>

	
              	</h4>
            </div>

            <div class="modal-body">

            		<?php

            		if( $current_action == 'add') {
						$post_url = site_url('admin/widgets/instances_add_postback/'.$widget->slug);
            		} else {
            			$post_url = site_url('admin/widgets/instances_edit_postback/'.$widget->instance_id);
            		}
					

            		?>
					<?php //echo form_open(site_url('admin/widgets/instances_add_postback/'.$widget->slug), 'class="crud"') ?>
					<?php echo form_open($post_url, 'class="crud"') ?>
						<?php echo form_hidden('current_action', $current_action) ?>
						<?php echo form_hidden('widget_id', $widget->id) ?>
						<?php echo form_hidden('add_action', 'save') ?>



						
												
						<?php echo isset($widget->instance_id) ? form_hidden('widget_instance_id', $widget->instance_id) : null ?>
						<?php echo isset($error) && $error ? $error : null ?>

						<table class='table'>
							

							<tr>
								<td width='30%'>
									<label>Area:</label>
								</td>
								<td>
									<?php echo form_dropdown('area_id', $areas,$area_id,'class="form-control"');?>
									<span class="required-icon tooltip"><?php echo lang('required_label') ?></span>
								</td>
							</tr>
							<tr>
								<td width='30%'>
									<label>Name:</label>
								</td>
								<td>
									<?php echo form_input('name', set_value('name', isset($widget->instance_name) ? $widget->instance_name : ''),"class='form-control'") ?>
									<span class="required-icon tooltip"><?php echo lang('required_label') ?></span>
								</td>
							</tr>
							<tr>
								<td>
									<label><?php echo lang('widgets:instance_title') ?>:</label>
								</td>
								<td>									
									<?php echo form_input('title', set_value('title', isset($widget->instance_title) ? $widget->instance_title : ''),"class='form-control'") ?>
									<span class="required-icon tooltip"><?php echo lang('required_label') ?></span>
								</td>
							</tr>
							<tr>
								<td>
									<label><?php echo lang('widgets:show_title') ?>:</label>
								</td>
								<td>										
									<?php echo form_checkbox('show_title', true, isset($widget->options['show_title']) ? $widget->options['show_title'] : false,"class='form-control'") ?>
								</td>
							</tr>							
						</table>

						<?php echo $form ? $form : null ?>

						<div id="instance-actions" class="align-right padding-bottom padding-right buttons buttons-small">
							<?php $this->load->view('admin/partials/buttons', array('buttons' => ['save'] )) ?>
						</div>
					<?php echo form_close() ?>
			</div>
		</div>
	</div>

