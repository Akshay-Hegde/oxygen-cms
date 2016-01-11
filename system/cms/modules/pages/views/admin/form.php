	<?php $parent = ($parent_id) ? '&parent='.$parent_id : null ?>
	<?php echo form_open_multipart(uri_string().'?page_type='.$this->input->get('page_type').$parent, 'id="page-form" data-mode="'.$this->method.'"') ?>
	<?php echo form_hidden('parent_id', empty($page->parent_id) ? 0 : $page->parent_id) ?>

<div class="row">

	<div class='col-xs-12 col-md-3 col-lg-2'>
			<div class="box box-solid">
				<div class="box-body">
					<?php $this->load->view('pages/admin/form_tabs/details');?>
				</div>
		</div>
	</div>

	<div class='col-xs-12 col-md-9 col-lg-10'>
		<div class="box box-solid">
		    <div class="box-header">
		      	<h3 class="box-title">
					<?php if ($this->method == 'create'): ?>
						<?php echo lang('pages:create_title') ?>
					<?php else: ?>
						<?php echo sprintf(lang('pages:edit_title'), $page->title) ?>
					<?php endif ?>	
		      	</h3>
		    </div> 			
	        <div class="box-body">


					<div class="nav-tabs-custom">

						<ul class="nav nav-tabs">
						    <?php $this->load->view('pages/admin/form_tabs/tabs');?>
						</ul>
						<div class="tab-content">

							<?php if ($stream_fields): ?>
							<div class="tab-pane active" id="page-content">
								<fieldset>
									<?php 
										foreach ($stream_fields as $field) {
											//dump($field);
											//echo $field['input'];
											echo $this->load->view('admin/partials/streams/form_single_display', ['field' => $field], true);
										}
									?>
								</fieldset>			
							</div>
							<?php endif ?>


							<?php if ($this->method != 'create'): ?>
							<div class="tab-pane" id="page-public">
								<?php $this->load->view('pages/admin/form_tabs/preview');?>
							</div>
							<?php endif;?>

							<div class="tab-pane <?php echo ($stream_fields)?'':'active'; ?>" id="page-meta">
								<?php $this->load->view('pages/admin/form_tabs/meta');?>
							</div>		

							<div class="tab-pane" id="page-options">
								<?php $this->load->view('pages/admin/form_tabs/options');?>
							</div>	

							<div class="tab-pane" id="page-security">
								<?php $this->load->view('pages/admin/form_tabs/security');?>
							</div>	

							<div class="tab-pane" id="page-design">
								<?php $this->load->view('pages/admin/form_tabs/design');?>
							</div>	

							<div class="tab-pane" id="page-script">
								<?php $this->load->view('pages/admin/form_tabs/script');?>
							</div>	

						</div>
					</div>
					
								        
					<input type="hidden" name="row_edit_id" value="<?php if ($this->method != 'create'): echo $page->entry_id; endif; ?>" />
				
					<div class="buttons align-right padding-top">
							<?php
							if($this->config->item('pages:button_mode')=='advanced')
							{
								$this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit','publish_save', 'publish', 'pull_down', 'preview', 'cancel') ));
							}
							else
							{
								$this->load->view('admin/partials/buttons', array('buttons' => array('publish_save', 'cancel') ));
							}

							?>

						<br>
						<br>
					</div>
			</div>
		</div>
		
	</div>

</div>



</div>

<?php echo form_close() ?>