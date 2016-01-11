<style>
.keepwidth {
	width:50px !important;
}
</style>

<div class="row">
	<div class="col-xs-12">
	
			<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
				<a class="btn btn-primary btn-block margin-bottom" href="admin/redirects/add">
					<i class=''></i>  Add Redirect
				</a>
			</div>

		    <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">

	        	<div class="box box-primary">

		            <div class="box-header">
		              	<h3 class="box-title">
							<?php if($this->method == 'add'): ?>
							<?php echo lang('redirects:add_title');?>
							<?php else: ?>
							<?php echo lang('redirects:edit_title');?>
							<?php endif ?>
		              	</h3>
		            </div>

		        	<div class="box-body">

							<div class="">
								<?php echo form_open(uri_string(), 'class="crud"') ?>


									<?php echo lang('redirects:type');?>
									<div class="input-group">
						                <span class="input-group-addon"><i class="fa fa-share-alt "></i></span>
						                <?php echo form_dropdown('type', array('301' => lang('redirects:301'), '302' => lang('redirects:302')), !empty($redirect['type']) ? $redirect['type'] : '302','class="form-control"');?>
						             </div>
										
										<br>

									<?php echo lang('redirects:from');?>
									<div class="input-group">
						                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
						                <?php echo form_input('from', str_replace('%', '*', $redirect['from']),'class="form-control"');?>
						             </div>

						             <br>

									<?php echo lang('redirects:to');?>
									<div class="input-group">
						                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
						                <?php echo form_input('to', str_replace('%', '*', $redirect['to']),'class="form-control"');?>
						             </div>             
							
									<hr>
							
									<div class="buttons">
										<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
									</div>

								<?php echo form_close() ?>
							</div>
					</div>

				</div>

		</div>
	</div>
</div>

