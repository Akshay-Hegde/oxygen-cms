<?php echo form_open('admin/pages/types/delete');?>
<div class="row">
		<div class='col-xs-12'>
			<div class="box box-solid">
			    <div class="box-header">
			      	<h3 class="box-title"><?php echo lang('page_types:list_title') ?></h3>
			    </div> 			
		        <div class="box-body">


					<?php if ( ! empty($page_types)): ?>
				        <table class="table table-striped">
							<thead>
								<tr>
		                            <th width="20%"><?php echo lang('global:title');?></th>
		                            <th width="50%"><?php echo lang('global:description');?></th>
		                            <th width="30%"></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="4">
										<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
									</td>
								</tr>
							</tfoot>
							<tbody>
								<?php foreach ($page_types as $page_type): ?>
									<tr>
										<td><?php echo $page_type->title;?></td>
		                                <td><?php echo $page_type->description;?></td>
										<td class="actions">
											<div style='float:right'>

												<?php if ($page_type->save_as_files == 'y' and $page_type->needs_sync): ?>
												<?php echo anchor('admin/pages/types/sync/'.$page_type->id, lang('page_types:sync_files'), array('class'=>"btn bg-blue btn-flat edit"));?> 
												<?php endif; ?>
				
												<?php //echo anchor('admin/pages/types/edit/' . $page_type->id, lang('global:edit'), array('class'=>"btn bg-blue btn-flat edit"));?>
												<?php echo anchor('admin/pages/types/view/' . $page_type->id, lang('global:edit'), array('class'=>"btn bg-blue btn-flat edit"));?>
												<?php if ($page_type->hidden): ?>

												<?php else: ?>

												<?php if ($page_type->allow_create ==1): ?>
													<?php //echo anchor("admin/pages/create?page_type={$page_type->id}", lang('pages:create_title'), array('class'=>"btn bg-blue btn-flat edit"));?> 
												<?php endif; ?>										
													<?php //echo anchor('admin/pages/types/fields/'.$page_type->id, lang('global:fields'), array('class'=>"btn bg-blue btn-flat edit"));?> 
													 
													<?php if ($page_type->allow_create ==1): ?>
														<?php if ($page_type->slug != 'default'): ?>
															<?php echo anchor('admin/pages/types/delete/' . $page_type->id, lang('global:delete'), array('class'=>"confirm btn bg-red btn-flat edit"));?>
														<?php endif; ?>
													<?php endif; ?>

												<?php endif; ?>

											</div>


										</td>
									</tr>
								<?php endforeach; ?>

							</tbody>
						</table>
					<?php else:?>
						<div class="no_data"><?php echo lang('page_types:no_pages');?></div>
					<?php endif; ?>	
				</div>
			</div>
		</div>
</div>
<?php echo form_close(); ?>