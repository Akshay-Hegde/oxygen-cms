
<div class="row">
    <div class="col-xs-12">
        <div class="box box-danger">

            <div class="box-header">
              <h3 class="box-title">Set permissions for : <?php echo $group->description ?> (Group)</h3>
            </div>
            <div class="box-body">

				<?php echo form_open(uri_string(), array('class'=> 'crud', 'id'=>'edit-permissions')) ?>
					<table class="table" >
						<thead>
							<tr>
								<th><?php echo form_checkbox(array('id'=>'check-all', 'name' => 'action_to_all', 'class' => 'check-all', 'title' => lang('permissions:checkbox_tooltip_action_to_all'))) ?></th>
								<th><?php echo lang('permissions:module') ?></th>
								<th><?php echo lang('permissions:roles') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($permission_modules as $module): ?>
							<tr style='border:1px solid #eee'>
								<td width="10px">
									<?php echo form_checkbox(array(
										'id'=> $module['slug'],
										'class' => 'select-row',
										'value' => true,
										'name'=>'modules['.$module['slug'].']',
										'checked'=> array_key_exists($module['slug'], $edit_permissions),
										'title' => sprintf(lang('permissions:checkbox_tooltip_give_access_to_module'), $module['name']),
									)) ?>
								</td>
								<td width="150px">
										<?php echo $module['name'] ?>
								</td>
								<td>
									<?php if ( ! empty($module['roles'])): ?>
										<table class='table'>
										<?php foreach ($module['roles'] as $role): ?>
										<tr>
											<td width="10px">
												<?php echo form_checkbox(array(
													'class' => 'select-rule',
													'name' => 'module_roles['.$module['slug'].']['.$role.']',
													'value' => true,
													'checked' => isset($edit_permissions[$module['slug']]) AND array_key_exists($role, (array) $edit_permissions[$module['slug']])
												)) ?>
											</td>
											<td>
												<span class='pull-left'><?php echo lang($module['slug'].':role_'.$role) ?></span>
											</td>										
										</tr>
										<?php endforeach ?>
										</table>
									<?php endif ?>
								</td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					<div class="buttons float-right padding-top">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
					</div>
				<?php echo form_close() ?>

			</div>
		</div>
	</div>
</div>

