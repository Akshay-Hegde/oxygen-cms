				<div class='tab-pane active' id="page-layout-basic">
				
					<fieldset>
						
								<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
								<div class="input">
									<?php echo form_input('title', $page_type->title, 'class="form-control" id="text" maxlength="60"'); ?>
								</div>

								<label for="title"><?php echo lang('global:slug');?> <span>*</span></label>
								<div class="input">
									<?php if ($this->method == 'create'): ?>
										<?php echo form_input('slug', $page_type->slug, 'class="form-control" id="slug" maxlength="60"'); ?>
									<?php else: ?>
										<em><?php echo $page_type->slug; ?></em>
									<?php endif; ?>
								</div>

                                <label for="description"><?php echo lang('global:description');?></label>
                                <div class="input">
                                	<?php echo form_input('description', $page_type->description, 'class="form-control" id="description"'); ?>
                                </div>
                     
		
							<?php if ($this->method == 'edit'): ?>
								<?php echo form_hidden('old_slug', $page_type->slug); ?>
							<?php endif; ?>
		
							<?php if ($this->method == 'create'): ?>
									<?php //echo form_dropdown('stream_id', array('new' => lang('page_types:auto_create_stream')) + $streams_dropdown, isset($page_type->stream_slug) ? $page_type->stream_slug : false); ?>
									<?php //echo form_dropdown('stream_id', array('new' => lang('page_types:auto_create_stream')) ); ?>
									<input type='hidden' value='new' name='stream_id'>
							<?php else: ?>
									<div class="input">
										<label for="stream_slug"><?php echo lang('page_types:select_stream');?> <span>*</span>
										<?php if ($this->method == 'new'): ?><br>
											<small><?php echo lang('page_types:stream_instructions'); ?></small><?php endif; ?></label>		
										<p><em><?php echo $this->db->limit(1)->select('stream_name')->where('id', $page_type->stream_id)->get(STREAMS_TABLE)->row()->stream_name; ?></em></p>
									</div>
							<?php endif; ?>
							
					
								<label for="theme_layout"><?php echo lang('page_types:theme_layout_label');?> <span>*</span></label>
								<div class="input"><?php echo form_dropdown('theme_layout', $theme_layouts, $page_type->theme_layout ? $page_type->theme_layout : 'default','class="form-control"'); ?></div>

								<label for="theme_layout">Page Sublayout <span>*</span>
									<br>
									<small>The list is showing all available sub-layouts within your active public theme.</small>
								</label>
								<div class="input">
									<?php echo form_dropdown('theme_struct', [''=>'No structure'] + $theme_layouts_structs, $page_type->theme_struct ? $page_type->theme_struct : 'default','class="form-control"'); ?>
								</div>

								<label for="save_as_files"><?php echo lang('page_types:save_as_files');?>
									<br>
									<small><?php echo lang('page_types:saf_instructions'); ?></small>
								</label>
								<div class="input">
									<?php echo form_checkbox('save_as_files', 'y', $page_type->save_as_files == 'y' ? true : false, 'id="save_as_files"'); ?>
								</div>

								<label for="content_label"><?php echo lang('page_types:content_label');?><br><small><?php echo lang('page_types:content_label_instructions'); ?></small></label>
								<div class="input"><?php echo form_input('content_label', $page_type->content_label, 'class="form-control" id="content_label" maxlength="60"'); ?></div>
	
								<label for="title_label"><?php echo lang('page_types:title_label');?><br><small><?php echo lang('page_types:title_label_instructions'); ?></small></label>
								<div class="input"><?php echo form_input('title_label', $page_type->title_label, 'class="form-control" id="title_label" maxlength="100"'); ?></div>
			

							<div class="input"><?php echo form_hidden('hidden', (isset($page_type->hidden)) ? $page_type->hidden : '0'); ?></div>
					
			
						
					</fieldset>
				
				</div>