<div class="row">
	<div class="col-xs-12">

		<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
			<a class="btn btn-primary btn-block margin-bottom as_modal" href="admin/groups/add">Create Group</a>
		</div>

	    <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">

        	<div class="box box-solid">
            <div class="box-header">
              	<h3 class="box-title"><?php echo $module_details['name'] ?></h3>
              	<p><?php echo lang('permissions:introduction') ?></p>
            </div>
            <div class="box-body">
				<?php if ($groups): ?>

			              <table class="table table-striped">
				              	<thead>
					                <tr>
					                  <th style="width: 10%"># <?php echo lang('groups:id') ?></th>
					                  <th style="width: 50%"><?php echo lang('groups:name') ?></th>
					                  <th style="width: 10%"><?php echo lang('groups:short_name');?></th>
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
										<tr>
											<td><?php echo $group->id ?></td>
											<td><?php echo $group->description ?></td>
											<td>
												
												<?php echo $group->name;?>
											</td>
											<td class="actions">
												<div style='float:right'>
													<?php echo anchor('admin/groups/edit/'.$group->id, lang('buttons:edit'), 'class="btn bg-blue btn-flat edit"') ?>
													<?php if ( ! in_array($group->name, array('user', 'admin'))): ?>
														<?php echo anchor('admin/groups/delete/'.$group->id, lang('buttons:delete'), 'class="confirm btn bg-red btn-flat delete"') ?>
													<?php endif ?>
													<?php if ( ! in_array($group->name, array('admin'))): ?>
														<?php echo anchor('admin/permissions/group/'.$group->id, lang('permissions:edit').' &rarr;', 'class="btn bg-blue btn-flat edit"') ?>
													<?php endif ?>
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
    	</div>
    </div>
</div>


