<div class="row">

	<div class='col-xs-12'>

	    <div class='col-sm-3 col-xs-12'>

			<a href='<?php echo base_url().'admin/navigation/create/'.$navigation->id;?>/' 			title="" id='create_nav' class="as_modal btn btn-block btn-primary "><i class="fa fa-plus"></i> Internal (Sitelink)</a>
	    	<a href='<?php echo base_url().'admin/navigation/create/'.$navigation->id;?>/external' 	title="" id='create_nav' class="as_modal btn btn-block btn-primary "><i class="fa fa-plus"></i> External Link</a>
	    	<a href='<?php echo base_url().'admin/navigation/create/'.$navigation->id;?>/module' 	title="" id='create_nav' class="as_modal btn btn-block btn-primary "><i class="fa fa-plus"></i> Link to Module</a>
	    	<a href='<?php echo base_url().'admin/navigation/create/'.$navigation->id;?>/page' 		title="" id='create_nav' class="as_modal btn btn-block btn-primary "><i class="fa fa-plus"></i> Link to Page</a>

	    	<a href='<?php echo site_url() . 'admin/navigation/';?>' class='btn btn-block btn-warning'>Back to groups</a>


	    	<?php $others = 'btn btn-default btn-block ';?>
	    	<?php $current = 'btn btn-default btn-block text-success';?>
	    	<br>

	    	<div class="box box-default">

	    	<div class="box-body">

				<?php foreach ($groups as $group): ?>

					<?php $class = ($group->id == $navigation->id)?$current:$others;?>

							<a href='<?php echo site_url() . 'admin/navigation/links/'.$group->id;?>' class='<?php echo $class;?>'><?php echo $group->title;?></a>

				<?php endforeach;?>

			</div>
			</div>
	    </div>

	    <div class='col-sm-9 col-xs-12'>

	            <div class="box box-solid">

	            	<div class="box-header">	   
	                	<?php echo $navigation->title;?>  
	                </div>

	                <div class="box-body">	                
						<?php if ( ! empty($groups)): ?>
				            <div class="box-body" style="display: block;">
        	
				            	<div id="link-details" class="group-<?php echo $navigation->id ?>">
										<div id="link-list">
											<ul class="sortable">
												<?php echo tree_builder($navigation->links, '<li id="link_{{ id }}"><div><a href="#" rel="'.$navigation->id.'" alt="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>
											</ul>
										</div>
								
							
										<div id="link-details" class="group-<?php echo $navigation->id ?>">

											<p>
												<?php echo lang('navs.tree_explanation') ?>
											</p>

										</div>
				             	</div>
				            </div><!-- /.box-body -->
						<?php else: ?>
							<div class="blank-slate">
								<p><?php echo lang('nav:no_groups');?></p>
							</div>
						<?php endif ?>
					</div>

				</div>
		</div>

	</div>


</div>
