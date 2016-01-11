<?php echo form_open(uri_string(), 'class="crud"'); ?>
<div class="row">


	<div class='col-xs-12'>

		<div class="col-lg-4 col-md-4 col-xs-12">

	        <div class="box box-primary">

	            <div class="box-header with-border">
	                <h3 class="box-title">
						Edit form
	                </h3>
	            </div>

	            <div class="box-body">
	           
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
									<?php echo form_input('stream_slug', $stream->stream_slug, 'disabled="disabled" class="form-control" placeholder="form-slug" maxlength="60" id="stream_slug"'); ?>
								</div>
		
								<label for="about"><?php echo lang('streams:about_stream'); ?><small><?php echo lang('streams:about_instructions'); ?></small></label>
								<div class="input"><?php echo form_input('about', $stream->about, 'class="form-control" placeholder="Describe the Form" maxlength="255"'); ?></div>
									

								<label for="notify_email">
									Send Email
								</label>
								<div class="input">
									<?php echo form_checkbox('notify_email', 'notify_email', $metadata->notify_email, 'class=""'); ?>
								</div>


								<label for="form_email">
									Email address
								</label>
								<div class="input">
									<?php echo form_input('email', $metadata->email, 'placeholder="Email address" class="form-control" autocomplete="off" id="email"'); ?>
								</div>
						<br>
						<div class="float-right buttons">
							<button type="submit" name="btnAction" value="save" class="btn btn-flat btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	
							<button type="submit" name="btnAction" value="save_exit" class="btn btn-flat btn-primary"><span><?php echo lang('buttons:save_exit'); ?></span></button>	
							<a href="<?php echo site_url('admin/forms/forms'); ?>" class="btn btn-flat btn-default"><?php echo lang('buttons:cancel'); ?></a>
						</div>	
					</div>

				
	            </div>
	        </div>
	    </div>

	    <div class="col-lg-8 col-md-8 col-xs-12">

	        <div class="box box-primary">

	            <div class="box-header with-border">
	                <h3 class="box-title">
						Form metadata
	                </h3>
	            </div>


			    <div class="nav-tabs-custom" style="cursor: move;">
		            <!-- Tabs within a box -->
		            <ul class="nav nav-tabs ui-sortable-handle">
		                  <li class="active"><a aria-expanded="true" href="#tabcontent-redirect" data-toggle="tab">On Success</a></li>
		                  <li><a aria-expanded="false" href="#tabcontent-messages" data-toggle="tab">On Error</a></li>
		                  <li><a aria-expanded="false" href="#tabcontent-viewoptions" data-toggle="tab">View Options</a></li>
		                  <?php if(group_has_role('forms','manage')):?>
		                  	<li><a aria-expanded="false" href="#tabcontent-fields" data-toggle="tab">Other Options</a></li>
		                  <?php endif;?>



		            </ul>

		            <div class="tab-content no-padding">

		                <div class="tab-pane active"id="tabcontent-redirect" >
				 			<?php echo $this->load->view('admin/partials/redirect_tab');?>
						</div>

		                <div class="tab-pane" id="tabcontent-messages" >
				 			<?php echo $this->load->view('admin/partials/messages_tab');?>
						</div>

		                <div class="tab-pane" id="tabcontent-viewoptions" >
				 			<?php echo $this->load->view('admin/partials/viewoptions_tab');?>
						</div>

						<?php if(group_has_role('forms','manage')):?>
			                <div class="tab-pane" id="tabcontent-fields" >
			                	<div class="box-body">
									<?php echo anchor('admin/forms/admin_fields/listing/' . $stream->stream_slug, 'Fields', 'class="btn btn-flat bg-blue"');?> 
									<?php echo anchor('admin/forms/forms/delete/' . $stream->stream_slug, 'Delete', 'class="confirm btn btn-flat bg-red"');?> 
					 			</div>
							</div>
						<?php endif;?>
						
						
					</div>
				</div>

	        </div>
	    </div> 

    </div>

</div>
<?php echo form_close();?>	