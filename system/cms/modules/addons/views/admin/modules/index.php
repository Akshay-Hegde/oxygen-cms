<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
			    <div class="box-header">
			      	<h3 class="box-title"><?php echo lang('addons:modules:addon_list');?></h3>
			    </div> 
                <div class="box-body">
						<?php if ($addon_modules): ?>
							 <table id="standard_data_table" class="table table-bordered">
								<thead>
									<tr>
										<th style='width:20%'><?php echo lang('name_label');?></th>
										<th style='width:40%'><span><?php echo lang('desc_label');?></span></th>
										<th style='width:10%'><?php echo lang('version_label');?></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($addon_modules as $module): ?>
									<tr>
										<td class=""><?php echo ($module['is_backend'] and ($module['installed'] AND $module['enabled']) )? anchor('admin/'.$module['slug'], $module['name']) : $module['name'] ?></td>
						
										<td><?php echo $module['description'] ?></td>
										<td class="align-center"><?php echo $module['version'] ?></td>
										<td class="actions">
											<?php if ($module['installed']): ?>
												<?php if ($module['enabled']): ?>
													<?php echo anchor('admin/addons/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm btn btn-xs text-warning', 'title'=>lang('addons:modules:confirm_disable'))) ?>
												<?php else: ?>
													<?php echo anchor('admin/addons/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm btn btn-xs text-success', 'title'=>lang('addons:modules:confirm_enable'))) ?>
												<?php endif ?>
												<?php if ($module['is_current']): ?>
													<?php echo anchor('admin/addons/modules/uninstall/'.$module['slug'], lang('global:uninstall'), array('class'=>'confirm btn btn-xs btn-flat bg-red', 'title'=>lang('addons:modules:confirm_uninstall'))) ?>
												<?php else: ?>
													<?php echo anchor('admin/addons/modules/upgrade/'.$module['slug'], lang('global:upgrade'), array('class'=>'confirm btn btn-xs btn-flat btn-link', 'title'=>lang('addons:modules:confirm_upgrade'))) ?>
												<?php endif ?>
											<?php else: ?>
												<?php echo anchor('admin/addons/modules/install/'.$module['slug'], lang('global:install'), array('class'=>'confirm btn btn-xs btn-flat btn-link', 'title'=>lang('addons:modules:confirm_install'))) ?>
											<?php endif ?>
										</td>
									</tr>
								<?php endforeach ?>
								</tbody>
								</table>
											
						<?php endif ?>
				</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-danger">
			    <div class="box-header">
			      	<h3 class="box-title"><?php echo lang('addons:modules:core_list');?></h3>
			    </div> 
                <div class="box-body">
         
                		<p><?php echo lang('addons:modules:core_introduction') ?></p>

						<?php if ($core_modules): ?>

							 <table id="standard_data_table" class="table table-bordered">			
									<thead>
										<tr>
											<th style='width:20%'><?php echo lang('name_label');?></th>
											<th style='width:40%'><span><?php echo lang('desc_label');?></span></th>
											<th style='width:10%'><?php echo lang('version_label');?></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($core_modules as $module): ?>
									<?php //if ($module['slug'] === 'addons') continue ?>
										<tr>
											<td><?php echo $module['is_backend'] ? anchor('admin/'.$module['slug'], $module['name']) : $module['name'] ?></td>
											<td><?php echo $module['description'] ?></td>
											<td class="align-center"><?php echo $module['version'] ?></td>
											<td class="actions">

											<?php if ( ! in_array($module['slug'], ['addons','settings','users','groups','store']) ): ?>

												<?php if ($module['installed']): ?>

													<?php if ($module['enabled']): ?>
														<?php echo anchor('admin/addons/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm btn btn-xs text-warning', 'title'=>lang('addons:modules:confirm_disable'))) ?>
													<?php else: ?>
														<?php echo anchor('admin/addons/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm btn btn-xs text-success', 'title'=>lang('addons:modules:confirm_enable'))) ?>
													<?php endif ?>

													<?php if ($module['is_current']): ?>
														<?php if(isset($module['module']->auto_install) AND $module['module']->auto_install==false):?>
														<?php echo anchor('admin/addons/modules/uninstall/'.$module['slug'].'/1', lang('global:uninstall'), array('class'=>'confirm btn btn-xs btn-flat bg-red', 'title'=>lang('addons:modules:confirm_upgrade'))) ?>
													<?php endif;?>

													<?php else: ?>
														<?php echo anchor('admin/addons/modules/upgrade/'.$module['slug'], lang('global:upgrade'), array('class'=>'confirm btn btn-xs btn-flat bg-orange', 'title'=>lang('addons:modules:confirm_upgrade'))) ?>
													<?php endif ?>

												<?php else: ?>

													<?php echo anchor('admin/addons/modules/install/'.$module['slug'].'/1', lang('global:install'), array('class'=>'confirm btn btn-xs btn-link', 'title'=>lang('addons:modules:confirm_install'))) ?>
												<?php endif ?>
											<?php endif ?>

											</td>
										</tr>
									<?php endforeach ?>
									</tbody>
								</table>
											
						<?php endif ?>

				</div>
        </div>
    </div>
</div>