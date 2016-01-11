 
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header">
                  <i class="fa fa-upload"></i>
                  <h3 class="box-title"><?php echo lang('addons:themes:upload_title');?></h3>
            </div>
			<div class="box-body">
				<?php echo form_open_multipart('admin/addons/themes/upload', array('class' => 'crud')) ?>
				
					<h4><?php echo lang('addons:themes:upload_desc') ?></h4>

					<input type="file" name="userfile" class="input" />
					<br>

					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload'))) ?>
					<br>
					
				<?php echo form_close() ?>
            </div>            

		</div>
	</div>
</div>