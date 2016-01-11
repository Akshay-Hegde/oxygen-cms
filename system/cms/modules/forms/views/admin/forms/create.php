<div class="row">
    <div class="col-xs-3">

        <div class="box box-primary">

            <div class="box-header with-border">
                <h3 class="box-title">
					Create new form
                </h3>
            </div>

            <div class="box-body">
            <?php echo form_open(uri_string(), 'class="crud"'); ?>

				<div class="form_inputs">


							<label for="stream_name">
								<?php echo lang('forms:name'); ?> <span>*</span>
							</label>
							<div class="input">
								<?php echo form_input('stream_name', $stream->stream_name, 'placeholder="Form name" class="form-control" maxlength="60" autocomplete="off" id="stream_name"'); ?>
							</div>
					
				
							<label for="stream_slug">Form Slug <span>*</span>
								<small>The slug for the new form.</small>
							</label>
							<div class="input">
								<?php echo form_input('stream_slug', $stream->stream_slug, 'class="form-control" placeholder="form-slug" maxlength="60" id="stream_slug"'); ?>
							</div>
	
							<label for="about"><?php echo lang('streams:about_stream'); ?><small><?php echo lang('streams:about_instructions'); ?></small></label>
							<div class="input"><?php echo form_input('about', $stream->about, 'class="form-control" placeholder="Describe the Form" maxlength="255"'); ?></div>
								

							<label for="notify_email">
								Send Email
							</label>
							<div class="input">
								<?php echo form_checkbox('notify_email', 'notify_email', TRUE, 'class=""'); ?>
							</div>


							<label for="form_email">
								Email address
							</label>
							<div class="input">
								<?php //echo form_input('email', '', 'placeholder="Email address" class="form-control" autocomplete="off" id="email"'); ?>
								<input type='email' id='email' name='email' placeholder='your@email.com' class="form-control" autocomplete="off">
							</div>

						<br>
							

					<div class="float-right buttons">
						<button type="submit" name="btnAction" value="save" class="btn btn-flat btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	
						<a href="<?php echo site_url('admin/forms/forms'); ?>" class="btn btn-flat btn-default"><?php echo lang('buttons:cancel'); ?></a>
					</div>
						
				</div>

			<?php echo form_close();?>	
            </div>
        </div>
    </div>
</div>