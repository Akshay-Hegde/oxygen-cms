<div class='row'>
		<div class="col-md-12">
		  <div class="box box-primary">
			    <div class="box-body">

					<?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
					<h3><?php echo sprintf(lang('cat:edit_title'), $category->title);?></h3>
					<?php else: ?>
					<h3><?php echo lang('cat:create_title');?></h3>
					<?php endif ?>

					<?php echo form_open($this->uri->uri_string(), 'class="crud'.((isset($mode)) ? ' '.$mode : '').'" id="categories"') ?>


					<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
					<div class="input"><?php echo  form_input('title', $category->title) ?></div>
					<label for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>
					<div class="input"><?php echo  form_input('slug', $category->slug) ?></div>
					<?php echo  form_hidden('id', $category->id) ?>
					<br>



					<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?></div>

					<?php echo form_close() ?>
					<br>
			</div>
		</div>
	</div>
</div>
