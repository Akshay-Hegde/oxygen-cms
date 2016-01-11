<?php echo form_open('admin/navigation/groups/create', 'class="crud"') ?>

<div class="box">
		<div class="box-body">
			<div class="row">

					<div class="col-xs-12">

				    	<h4><?php echo lang('nav:group_create_title');?></h4>

				    	<table class='table'>
				    		<tr>
				    			<td><label for="title"><?php echo lang('global:title');?> <span>*</span></label></td>
				    			<td><div class="input"><?php echo form_input('title', $navigation_group['title'], 'class="text"') ?></div></td>
				    		</tr>
				    		<tr>
				    			<td><label for="url"><?php echo lang('global:slug');?> <span>*</span></label></td>
				    			<td><div class="input"><?php echo form_input('slug', $navigation_group['slug'], 'class="text"') ?></div></td>
				    		</tr>				    		
				    	</table>

				
					    <div class="buttons padding-top">       
						    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
					    </div>
        

			    	</div>

			   </div>
		</div>
</div>
<?php echo form_close() ?>



    



