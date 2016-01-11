      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              	<h4 class="modal-title">
					<?php echo ucfirst($this->method). ' Area';?>
              	</h4>
            </div>
            <div class="modal-body">

					<?php echo form_open(uri_string(), 'class="crud"') ?>

						<table class='table'>
							<tr>
								<td width='30%'>
									<label>Name of area:</label>
								</td>
								<td>
									<?php echo form_input('widget_name', set_value('widget_name', (isset($name))?$name:'' ),"id='widget_name' class='form-control'") ?>
									<span class="required-icon tooltip"><?php echo lang('required_label') ?></span>
								</td>
							</tr>
							<tr>
								<td width='30%'>
									<label>Area slug:</label>
								</td>
								<td>
									<?php echo form_input('widget_slug', set_value('widget_slug', (isset($slug))?$slug:''),"id='widget_slug' class='form-control'") ?>
									<span class="required-icon"><?php echo lang('required_label') ?></span>
								</td>
							</tr>														
						</table>

						<div id="instance-actions" class="align-right padding-bottom padding-right buttons buttons-small">
							<?php $this->load->view('admin/partials/buttons', array('buttons' => ['save'] )) ?>
							<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancel</button>
						</div>
					<?php echo form_close() ?>

			</div>
		</div>
	</div>

