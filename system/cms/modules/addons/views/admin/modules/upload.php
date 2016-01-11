<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
		    <div class="box-header">
		      	<h3 class="box-title"><?php echo lang('addons:modules:upload_title');?></h3>
		    </div> 
            <div class="box-body">
				<?php echo form_open_multipart('admin/addons/modules/upload', array('class' => 'crud'));?>
					<label for="userfile"><?php echo lang('addons:modules:upload_desc');?></label><br>
					<input type="file" name="userfile" class="form-control" />
					<br>
					
					<div class="buttons float-right padding-top">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload') )) ?>
					</div>

				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>