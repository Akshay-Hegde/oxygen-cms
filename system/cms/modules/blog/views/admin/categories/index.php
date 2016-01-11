<div class='row'>

	<div class="col-md-12">

		<div class="box box-solid">
			
			<div class="box-body">

				<h3><?php echo lang('blog:list_title') ?></h3>


						<?php if ($categories): ?>

							<?php echo form_open('admin/blog/categories/delete') ?>

							<table id="standard_data_table" class="table table-bordered">
								<thead>
								<tr>
									<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
									<th><?php echo lang('cat:category_label') ?></th>
									<th><?php echo lang('global:slug') ?></th>
									<th width=""></th>
								</tr>
								</thead>
								<tbody>
									<?php foreach ($categories as $category): ?>
									<tr>
										<td><?php echo form_checkbox('action_to[]', $category->id) ?></td>
										<td><?php echo $category->title ?></td>
										<td><?php echo $category->slug ?></td>
										<td class="">
											<div class='pull-right'>
												<?php echo anchor('admin/blog/categories/edit/'.$category->id, lang('global:edit'), 'class="btn btn-flat btn-primary edit"') ?>
												<?php echo anchor('admin/blog/categories/delete/'.$category->id, lang('global:delete'), 'class="btn btn-flat btn-danger confirm delete"') ;?>
											</div>
										</td>
									</tr>
									<?php endforeach ?>
								</tbody>
							</table>

							<?php $this->load->view('admin/partials/pagination') ?>

							<div class="table_action_buttons">
							<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
							</div>

							<?php echo form_close() ?>

						<?php else: ?>
							<div class="no_data"><?php echo lang('cat:no_categories') ?></div>
						<?php endif ?>

	        </div>

	    </div>

	</div>

</div>