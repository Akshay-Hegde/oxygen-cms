<?php echo form_open_multipart() ?>
<div class='row'>
	<div class="col-md-12">
		<div class="box box-primary">
		    <div class="box-header">
		      	<h3 class="box-title">
				<?php if ($this->method == 'create'): ?>
					<?php echo lang('blog:create_title') ?>
				<?php else: ?>
					<?php echo sprintf(lang('blog:edit_title'), $post->title) ?>
				<?php endif ?>
				</h3>
		    </div> 

			<div class="box-body">

	            <!-- Custom Tabs -->
	            <div class="col-md-4">

	                <div class="">

					 	<div id="blog-content-tab" class="tab-pane active">
			
								<label for="title">
									<?php echo lang('global:title') ?> <span>*</span>
								</label>
								<div class="input">
									<?php echo form_input('title', htmlspecialchars_decode($post->title), 'class="form-control" maxlength="100" id="title"') ?>
								</div>

								<label for="slug">
									<?php echo lang('global:slug') ?> <span>*</span>
								</label>
								<div class="input">
									<?php echo form_input('slug', $post->slug, 'maxlength="100" class="form-control"') ?>
								</div>

								<label for="status">
									<?php echo lang('blog:status_label') ?>
								</label>
								<div class="input">
									<?php echo form_dropdown('status', array('draft' => lang('blog:draft_label'), 'live' => lang('blog:live_label')), $post->status,'class="form-control"') ?>
								</div>

								<?php echo form_hidden('preview_hash', $post->preview_hash)?>

				
								<label for="category_id">
									<?php echo lang('blog:category_label') ?>
								</label>
								<div class="input">
								<?php echo form_dropdown('category_id', array(lang('blog:no_category_select_label')) + $categories, @$post->category_id,'class="form-control"') ?>
									[ <?php echo anchor('admin/blog/categories/create', lang('blog:new_category_label'), 'target="_blank"') ?> ]
								</div>

								<?php if ( ! module_enabled('keywords')): ?>
									<?php echo form_hidden('keywords'); ?>
								<?php else: ?>

									<label for="keywords">
										<?php echo lang('global:keywords') ?>
									</label>
									<div class="input">
										<?php echo form_input('keywords', $post->keywords, 'class="form-control" id="keywords"') ?>
									</div>

								<?php endif; ?>


								<label><?php echo lang('blog:date_label') ?></label>
				
								<div class="input datetime_input">
									<?php echo form_input('created_on', date('Y-m-d', $post->created_on), 'maxlength="10" id="datepicker" class="text width-20"') ?> &nbsp;
									<?php echo form_dropdown('created_on_hour', $hours, date('H', $post->created_on)) ?> :
									<?php echo form_dropdown('created_on_minute', $minutes, date('i', ltrim($post->created_on, '0'))) ?>
								</div>
						
						
									<?php if ( ! module_enabled('comments')): ?>
										<?php echo form_hidden('comments_enabled', 'no'); ?>
									<?php else: ?>
							
											<label for="comments_enabled"><?php echo lang('blog:comments_enabled_label');?></label>
											<div class="input">
												<?php echo form_dropdown('comments_enabled', array(
													'no' => lang('global:no'),
													'1 day' => lang('global:duration:1-day'),
													'1 week' => lang('global:duration:1-week'),
													'2 weeks' => lang('global:duration:2-weeks'),
													'1 month' => lang('global:duration:1-month'),
													'3 months' => lang('global:duration:3-months'),
													'always' => lang('global:duration:always'),
												), $post->comments_enabled ? $post->comments_enabled : '3 months','class="form-control"') ?>
											</div>
						
									<?php endif; ?>								

		                </div><!-- /.tab-pane -->
			        </div>

				</div>
				<div class="col-md-8">

					<fieldset>
						<?php if ($stream_fields): ?>
								<?php foreach ($stream_fields as $field) echo $this->load->view('admin/partials/streams/form_single_display', array('field' => $field), true) ?>
						<?php endif; ?>														
					</fieldset>

				</div>

				<input type="hidden" name="row_edit_id" value="<?php if ($this->method != 'create'): echo $post->id; endif; ?>" />

				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>

			</div>

		</div>

	</div>

</div>
<?php echo form_close() ?>