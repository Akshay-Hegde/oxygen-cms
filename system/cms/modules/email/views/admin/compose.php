<style>

</style>
<?php echo form_open(current_url());?>
<div class="row">


	<div class="col-md-3">
	    <a class="btn btn-primary btn-block margin-bottom" href="admin/email/templates/create">Create Template</a>
	    <?php echo $this->load->view('admin/partials/common_sidebar',null,true);?>
	</div><!-- /.col -->


	<div class="col-md-9">
	  
		<div class="box box-solid">
				<div class="box-header with-border">
				  <h3 class="box-title">Compose New Message</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
				  <div class="form-group">
					<input id='to' name='to' data-role='tagsinput' class="form-control" placeholder="To:">
				  </div>				  							  
				  <div class="form-group">
					<input name='subject' class="form-control" placeholder="Subject:">
				  </div>
				  <div class="form-group">
					  <textarea name='body' style='min-height:300px' placeholder="Message body..." class="form-control" id="compose-textarea"></textarea>
				  </div>
				</div><!-- /.box-body -->
				<div class="box-footer">
				  <div class="pull-right">
					<button class="btn btn-primary" type="submit"><i class="fa fa-envelope-o"></i> Send</button>
				  </div>
				</div>
		</div>
	</div>

</div>
<?php echo form_close();?>
<script>


</script>