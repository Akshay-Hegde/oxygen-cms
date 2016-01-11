<div class="box box-solid">
	<div class="box-header">
		<h3 class="box-title">
		<?php echo $module_details['name'] ?></h3>
		<p><?php echo lang('permissions:introduction') ?></p>
	</div>
	<div class="box-body table-responsive">

		<?php if ($groups): ?>
			<table class="table table-striped">
					<thead>
						<tr>
							<?php if($this->current_user->group == 'admin'): ?>
								<th style="width: 10%"># <?php echo lang('groups:id') ?></th>
							<?php endif; ?>
							<th style="width: 30%"><?php echo lang('groups:name') ?></th>
							<th style="width: 10%"><?php echo lang('groups:short_name');?></th>
							<th><?php echo lang('groups:authority') ?></th>
							<th style="width: 30%"><div style='float:right'>Actions</div></th>
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
						<?php foreach ($groups as $group):?>
							<?php $cond =(($this->current_user->group_data->authority < $group->authority) OR $this->current_user->group == 'admin'); ?>
							<tr>
								<?php if($this->current_user->group == 'admin'): ?>
									<td>
										<code><?php echo $group->id ?></code>
									</td>
								<?php endif; ?>
								<td>
									<?php echo anchor_if($cond, 'admin/groups/edit/'.$group->id, $group->description, 'class=" "'); ?>
								</td>
								<td>
									<?php echo anchor_if($cond, 'admin/groups/edit/'.$group->id, $group->name, 'class=" "'); ?>
								</td>
								<td>
									<?php echo $group->authority;?>
								</td>											
								<td class="actions">
									<div style='float:right'>
										<?php 
											if($this->current_user->group_data->authority < $group->authority):
												echo anchor('admin/groups/edit/'.$group->id, lang('buttons:edit'), 'class="btn btn-sm bg-blue btn-flat edit"').' ';

												if ( ! in_array($group->name, array('user', 'admin')) AND ($this->current_user->group_data->authority < $group->authority)): 
													echo anchor('admin/groups/delete/'.$group->id, lang('buttons:delete'), 'class="confirm btn-sm btn bg-red btn-flat delete"').' ';
												endif;

												if ( ! in_array($group->name, array('admin'))):
													echo anchor('admin/permissions/group/'.$group->id, lang('permissions:edit').' &rarr;', 'class="btn btn-sm bg-blue btn-flat edit"').' ';
												endif; 
											endif; 
										?>
									</div>
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
			</table>
		<?php else: ?>
			<section class="title">
				<p><?php echo lang('groups:no_groups');?></p>
			</section>
		<?php endif;?>
	</div>
</div>