
<div class="row">
    <div class='col-xs-12'>

        <div class="col-sm-3 col-xs-12">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('global:filters') ?></h3>
                </div>          
                <div class="box-body">
            		<?php echo $this->load->view('admin/partials/filters') ?>
            		<?php echo form_open('admin/comments/action');?>
            		<?php echo form_hidden('redirect', uri_string()) ?>
    	

                </div>
            </div>
        </div>

        <div class='col-sm-9 col-xs-12'>
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('comments:title') ?></h3>
                </div>          
                <div class="box-body">

					<div id="filter-stage">
						<?php echo $this->load->view('admin/tables/comments') ?>
					</div>
					
					<?php  if (Settings::get('moderate_comments')): 
						if ( ! $comments_active): 
							echo $this->load->view('admin/partials/buttons', array('buttons' => array('approve','delete')), true);
						else:
							echo $this->load->view('admin/partials/buttons', array('buttons' => array('unapprove','delete')),true);
						endif;
					else:
						echo $this->load->view('admin/partials/buttons', array('buttons' => array('delete')));
					endif;
					echo form_close(); ?>
						
			</div>
		</div>
	</div>
</div>