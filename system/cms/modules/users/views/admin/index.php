<div class="row">
	<div class='col-xs-12'>

		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
	    
	    	<a class="btn btn-primary btn-block margin-bottom" href="admin/users/create">Create User</a>
			
			<div class="box box-solid">
			    <div class="box-header">
			      	<h3 class="box-title">Filters</h3>
			    </div> 			
		        <div class="box-body">
					<?php $this->load->view('admin/partials/filters'); ?>
		        </div>
	        </div>
	    </div>

		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
			<div class="box box-solid">
			    <div class="box-header">
			      	<h3 class="box-title"><?php echo lang('user:list_title') ?></h3>
			    </div> 			
		        <div class="box-body">
					<?php echo form_open('admin/users/action'); ?>
					
						<div id="filter-stage">
							<?php //template_partial('tables/users'); ?>
							<?php $this->load->view('admin/tables/users'); ?>
						</div>
					
						<div class="table_action_buttons">
							<?php $this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )) ?>
						</div>
				
					<?php echo form_close() ?>				
	           </div>
	        </div>
        </div>

    </div>
</div>
