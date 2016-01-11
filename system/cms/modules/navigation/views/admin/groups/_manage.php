<div class="row">
    <div class='col-xs-12'>

        <div class="col-sm-3 col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Actions</h3>
                </div>          
                <div class="box-body">

					<?php if ( ! empty($groups)): ?>

						<?php foreach ($groups as $group): ?>
				
					             <li><?php echo $group->id. " - ".$group->slug . '-' . $group->title;?></li>

					     <?php endforeach ?>
					 <?php endif ?>
                </div>
            </div>
        </div>

        <div class='col-sm-9 col-xs-12'>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo lang('comments:title') ?></h3>
                </div>          
                <div class="box-body">



					<?php if ( ! empty($groups)): ?>

						<?php foreach ($groups as $group): ?>
						
								<div class="box"  rel="<?php echo $group->id ?>" >

						            <div class="box-header with-border">
						              <h3 class="box-title"  class="tooltip" title="<?php echo lang('nav:slug_label').': '.$group->slug ?>" ><?php echo $group->title;?></h3>
						              <div class="box-tools pull-right">
						                <a href='<?php echo 'admin/navigation/groups/create/'.$group->id;?>' title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="<?php echo lang('nav:link_create_title');?>"><i class="fa fa-minus"></i></a>
						              </div>
						            </div>

										<?php if ( ! empty($navigation[$group->id])): ?>

								            <div class="box-body" style="display: block;">
								            	<div id="" class="">
									             	
									             	<?php echo lang('navs.tree_explanation') ?>
								             	</div>		            	
								            	<div id="link-details" class="group-<?php echo $group->id ?>">
														<div id="link-list">
															<ul class="sortable">
																<?php echo tree_builder($navigation[$group->id], '<li id="link_{{ id }}"><div><a href="#" rel="'.$group->id.'" alt="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>
															</ul>
														</div>
												
											
														<div id="link-details" class="group-<?php echo $group->id ?>">

															<p>
																<?php echo lang('navs.tree_explanation') ?>
															</p>

														</div>
								             	</div>
								            </div><!-- /.box-body -->


										<?php else:?>

								            <div class="box-body" style="display: block;">
								            	<div id="" class="">
									             	<?php echo lang('nav:group_no_links');?>
									             	<?php echo lang('navs.tree_explanation') ?>
								             	</div>		            	
								            	<div id="link-details" class="group-<?php echo $group->id ?>">

								             	</div>
								            </div><!-- /.box-body -->


										<?php endif ?>

							            <div class="box-footer" style="display: block;">
							            	<div class='pull-right'>
							            	<a href='<?php echo base_url().'admin/navigation/create/'.$group->id;?>' title="" id='create_nav' class="as_modal btn bg-green btn-flat"><i class="fa fa-plus"></i> Add Link</a>
							              	<a href='<?php echo base_url().'admin/navigation/groups/delete/'.$group->id;?>'    class="confirm btn btn-danger btn-flat" data-toggle="tooltip"  data-original-title="<?php echo lang('nav:group_delete_confirm');?>"><i class="fa fa-times"></i> Delete <?php echo $group->title;?></a>
							              	</div>
							            </div><!-- /.box-footer-->		

							
								</div>
							
						<?php endforeach ?>


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
