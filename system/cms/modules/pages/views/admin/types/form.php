<?php echo form_open(); ?>
<input type='hidden' name='body' value='{{title}}'>
<div class="box box-solid">
    <div class="box-header">
      	<h3 class="box-title"><?php echo lang('page_types:list_title'); ?> : <?php echo ($this->method == 'create')?lang('page_types:create_title') : sprintf(lang('page_types:edit_title'), $page_type->title); ?></h3>
    </div> 
	<div class="box-body">
			
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
			      <?php $this->load->view('pages/admin/type_tabs/tabs');?>
			</ul>
			<div class="tab-content">
				<?php $this->load->view('pages/admin/type_tabs/basic');?>
				<?php $this->load->view('pages/admin/type_tabs/meta');?>
				<?php $this->load->view('pages/admin/type_tabs/css');?>
				<?php $this->load->view('pages/admin/type_tabs/script');?>
				<?php if (($this->method == 'edit') OR ($this->method == 'view')): ?>
					<?php $this->load->view('pages/admin/type_tabs/fields');?>
				<?php endif; ?>		
			</div>
		</div>

		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
		</div>

	</div>
</div>
<?php echo form_close(); ?>