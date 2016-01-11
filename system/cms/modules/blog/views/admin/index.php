<div class="row">
	<div class='col-xs-12'>

	    <div class="col-sm-3 col-xs-12">
			<div class="box box-solid">
			    <div class="box-header">
			      	<h3 class="box-title">Filters</h3>
			    </div> 			
		        <div class="box-body">
					<?php echo $this->load->view('admin/partials/filters') ?>
		        </div>
	        </div>
	    </div>

		<div class='col-sm-9 col-xs-12'>
			<div class="box box-solid">
			    <div class="box-header">
			      	<h3 class="box-title"><?php echo lang('blog:posts_title') ?></h3>
			    </div> 			
		        <div class="box-body">

					    <div class="box-header">
					      	<h3 class="box-title"><?php echo lang('blog:posts_title') ?></h3>
					    </div> 

		                <div class="box-body">

						<?php if ($blog) : ?>
							
				
							<?php echo form_open('admin/blog/action') ?>
								<div id="filter-stage">
									<?php echo $this->load->view('admin/tables/posts') ?>
								</div>
							<?php echo form_close() ?>
						<?php else : ?>
							<div class="no_data"><?php echo lang('blog:currently_no_posts') ?></div>
						<?php endif ?>

		        </div>
	        </div>
		</div>
	</div>
</div>




