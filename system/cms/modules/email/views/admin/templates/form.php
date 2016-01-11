
<div class="row">

	<div class="col-xs-12">

		<div class="col-md-3">
		    <a class="btn btn-primary btn-block margin-bottom" href="admin/email/templates/create">Create Template</a>
		    <?php echo $this->load->view('admin/partials/common_sidebar',null,true);?>
		</div><!-- /.col -->

	    <div class="col-xs-9">
	        <div class="box box-solid">

	                <div class="box-header">
	                  <h3 class="box-title">
							<?php if($this->method == 'edit' and ! empty($email_template)): ?>
							<?php echo sprintf(lang('templates:edit_title'), $email_template->name) ?>
							<?php else: ?>
							<?php echo lang('templates:create_title') ?>
							<?php endif ?>
	                  </h3>
	                </div>

					<div class="box-body">



							<?php echo form_open(current_url(), 'class="crud"') ?>
							
								<div class="form_inputs">
								

									
										<?php if ( ! $email_template->is_default): ?>

											<label for="name"><?php echo lang('name_label') ?> <span>*</span></label>
											<div class="input"><?php echo form_input('name', $email_template->name,'class="form-control"') ?></div>

											<label for="slug"><?php echo lang('templates:slug_label') ?> <span>*</span></label>
											<div class="input"><?php echo form_input('slug', $email_template->slug,'class="form-control"') ?></div>

											<label for="lang"><?php echo lang('templates:language_label') ?></label>
											<div class="input"><?php echo form_dropdown('lang', $lang_options, array($email_template->lang),'class="form-control"') ?>

											<label for="description"><?php echo lang('desc_label') ?> <span>*</span></label>
											<div class="input"><?php echo form_input('description', $email_template->description,'class="form-control"') ?></div>

							
										<?php endif ?>



											<label for="subject"><?php echo lang('templates:subject_label') ?> <span>*</span></label>
											<div class="input"><?php echo form_input('subject', $email_template->subject,'class="form-control"') ?></div>

											<label for="lang">Master Template</label>
											<div class="input"><?php echo form_dropdown('master_template', $master_templates, $email_template->master_template,'class="form-control"') ?>

											<label for="body"><?php echo lang('templates:body_label') ?> <span>*</span></label>
											<br style="clear:both" />
											<?php echo form_textarea('body', $email_template->body, 'class="templates wysiwyg-advanced"') ?>

								
									<div class="buttons padding-top">
										<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
									</div>
							
								</div>
										
							<?php echo form_close() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

