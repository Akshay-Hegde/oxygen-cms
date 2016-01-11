<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title"><?php echo sprintf(lang('templates:clone_title'), $template_name) ?></h3>
                </div>
				<div class="box-body">
					<?php echo form_open(current_url(), 'class="crud"') ?>

					    <label for="lang"><?php echo lang('templates:choose_lang_label') ?></label>
					    <?php echo form_dropdown('lang', $lang_options) ?>

						<div class="buttons alignright padding-top">
							<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
						</div>
					<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>