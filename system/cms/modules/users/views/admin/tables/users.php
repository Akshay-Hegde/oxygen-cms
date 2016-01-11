

				<?php if (!empty($users)): ?>
			
				 	<table id="standard_data_table" class="table">
						<thead>
							<tr>
								<th with="30" class="align-center"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
								<th><?php echo lang('user:name_label');?></th>
								<th class="hidden-xs hidden-sm"><?php echo lang('user:email_label');?></th>
								<th><?php echo lang('user:group_label');?></th>
								<th class="hidden-xs hidden-sm"><?php echo lang('user:active') ?></th>
								<th class="hidden-xs hidden-sm"><?php echo lang('user:joined_label');?></th>
								<th class=""><?php echo lang('user:last_visit_label');?></th>
								<th width="200"></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="8">
									<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
								</td>
							</tr>
						</tfoot>
						<tbody>
							<?php $link_profiles = Settings::get('enable_profiles') ?>
							<?php foreach ($users as $member): ?>
								<tr>
									<td class="align-center"><?php echo form_checkbox('action_to[]', $member->id) ?></td>
									<td>
									<?php if ($link_profiles) : ?>
										<?php echo anchor('admin/users/preview/' . $member->id, $member->display_name, 'target="_blank" class="as_modal"') ?>
									<?php else: ?>
										<?php echo $member->display_name ?>
									<?php endif ?>
									</td>
									<td class="hidden-xs hidden-sm"><?php echo mailto($member->email) ?></td>
									<td><?php echo $member->group_name ?></td>
									<td class="hidden-xs hidden-sm"><?php echo $member->active ? lang('global:yes') : lang('global:no')  ?></td>
									<td class="hidden-xs hidden-sm"><?php echo format_date($member->created_on) ?></td>
									<td class=""><?php echo ($member->last_login > 0 ? format_date($member->last_login) : lang('user:never_label')) ?></td>
									<td class="actions">
										<span style="float:right;">
											<?php
											$this->load->helper('dropmenu');
											?>
												<?php
										
													$items = [];
													$items[] = dropdownMenuStandard(site_url('admin/permissions/user/'.$member->user_id), false, 'Permissions', false, "");
													$items[] = dropdownMenuStandard(site_url('admin/users/timeline/'.$member->user_id), false, 'Timeline', false, "");																					
													$items[] = dropdownMenuStandard(site_url('admin/users/edit/'.$member->user_id), false, lang('global:edit'), false, "edit");																	
													$items[] = dropdownMenuStandard(site_url('admin/users/adminprofile/edit/'.$member->user_id), false, lang('global:edit') . ' Admin Profile', false, "edit");																	




													$items[] = dropdownMenuStandard(site_url('admin/users/delete/' . $member->user_id), true, lang('global:delete'), true, "minus");
													echo dropdownMenuListSplit($items,'Edit','admin/users/edit/'.$member->user_id);
											?>
										</span>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				
				<?php endif ?>