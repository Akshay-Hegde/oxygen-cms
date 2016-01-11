<div class="row">
    <div class="col-xs-12 col-md-6">

        <div class="box box-solid">

            <div class="box-header with-border">
                <h3 class="box-title">
					<?php echo ucfirst($method); ?> List
                </h3>
            </div>

            <div class="box-body">
            <?php echo form_open(uri_string(), 'class="crud"'); ?>

				<div class="form_inputs">


							<label for="stream_name">
								<?php echo lang('lists:name'); ?> <span>*</span>
							</label>
							<div class="input">
								<?php echo form_input('stream_name', $stream->stream_name, 'placeholder="List name" class="form-control" maxlength="60" autocomplete="off" id="stream_name"'); ?>
							</div>
					
				
							<label for="stream_slug"><?php echo lang('streams:stream_slug'); ?> <span>*</span><small><?php echo lang('streams:slug_instructions'); ?></small></label>
							<div class="input">
								<?php echo form_input('stream_slug', $stream->stream_slug, 'class="form-control" placeholder="List-slug" maxlength="60" id="stream_slug"'); ?>
							</div>
	
							<label for="about"><?php echo lang('streams:about_stream'); ?><small><?php echo lang('streams:about_instructions'); ?></small></label>
							<div class="input">
								<?php echo form_textarea('about', $stream->about, 'class="form-control" placeholder="Describe the List" maxlength="255"'); ?>
							</div>
												
							<?php if( $method == 'edit' ): ?>

								<label for="title_column"><?php echo lang('streams:title_column');?></label>
								<div class="input"><?php echo form_dropdown('title_column', $fields, $stream->title_column); ?></div>
						
								<label for="sorting"><?php echo lang('streams:sort_method');?></label>
								<div class="input"><?php echo form_dropdown('sorting', array('title'=>lang('streams:by_title_column'), 'custom'=>lang('streams:manual_order')), $stream->sorting); ?></div>
						
							<?php endif; ?>

						<br>
							
		
					<div class="float-right buttons">
						<button type="submit" name="btnAction" value="save" class="btn btn-flat btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	
						<a href="<?php echo site_url('admin/lists/lists'); ?>" class="btn btn-flat btn-default"><?php echo lang('buttons:cancel'); ?></a>
					</div>
						
				</div>

			<?php echo form_close();?>	
            </div>
        </div>
    </div>
</div>