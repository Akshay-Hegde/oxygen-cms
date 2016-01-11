<div class="row">

		<div class="col-md-3">
		    <a class="btn btn-primary btn-block margin-bottom" href="admin/email/templates/create">Create Template</a>
		    <?php echo $this->load->view('admin/partials/common_sidebar',null,true);?>
		</div><!-- /.col -->

		<div class="col-md-9">
        	<div class="box box-solid">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('templates:default_title') ?></h3>
                </div>
				<?php if(empty($templates)): ?>
						<div class="box-body">
					 		<p><?php echo lang('templates:currently_no_templates') ?></p>
					 	</div>
				<?php else: ?>

						<div class="box-body">
		 
							    <?php echo form_open('admin/email/templates/action') ?>
							
							    <table id="standard_data_table" class="table table-bordered">

							        <thead>
							            <tr>
							                <th style='width:5%'></th>
							                <th style='width:15%'><?php echo lang('name_label') ?></th>
							                <th style='width:15%'>Slug</th>
							                <th><?php echo lang('global:description') ?></th>
							                <th style='width:5%'><?php echo lang('templates:language_label') ?></th>
							                <th style='width:20%'></th>
							            </tr>
							        </thead>
							        <tbody>
									    <?php foreach ($templates as $template): ?>
											<?php if($template->is_default): ?>
									            <tr>
													<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
									                <td><?php echo $template->name ?></td>
									                <td><?php echo $template->slug ?></td>
									                <td class=""><?php echo $template->description ?></td>
									                <td class=""><?php echo $template->lang ?></td>
									                <td class="actions">
													<div class="buttons buttons-small align-center">
														<?php echo anchor('admin/email/templates/preview/' . $template->id, lang('buttons:preview'), 'class="btn btn-flat bg-blue preview as_modal"') ?>
									                    <?php echo anchor('admin/email/templates/edit/' . $template->id, lang('buttons:edit'), 'class="btn btn-flat bg-blue  edit"') ?>
														<?php echo anchor('admin/email/templates/create_copy/' . $template->id, lang('buttons:clone'), 'class="btn btn-flat bg-yellow clone"') ?>
													</div>
									                </td>
									            </tr>
											<?php endif ?>
									    <?php endforeach ?>
								</tbody>
								</table>
							    <?php echo form_close() ?>
							 
							 	<div class="table_action_buttons">
									<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
								</div>
						</div>
				<?php endif; ?>
 			</div>

	        <div class="box box-solid">

	                <div class="box-header">
	                  <h3 class="box-title"><?php echo lang('templates:user_defined_title') ?></h3>
	                </div>

					<?php if(empty($templates)): ?>
							<div class="box-body">
						 		<p><?php echo lang('templates:currently_no_templates') ?></p>
						 	</div>
					<?php else: ?>

							<div class="box-body">

										<?php echo form_open('admin/email/templates/delete') ?>
										   

											<table id="standard_data_table" class="table table-bordered">
										        <thead>
										            <tr>
										                <th style='width:5%'><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
										                <th style='width:15%'><?php echo lang('name_label') ?></th>
										                <th style='width:15%'>Slug</th>
										                <th><?php echo lang('global:description') ?></th>
										                <th style='width:5%'><?php echo lang('templates:language_label') ?></th>
										                <th style='width:20%'></th>
										            </tr>
										        </thead>
											
											        <tbody>
												
											    <?php foreach ($templates as $template): ?>
													<?php if(!$template->is_default): ?>
											            <tr>
															<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
											                <td><?php echo $template->name ?></td>
											                <td><?php echo $template->slug ?></td>
											                <td><?php echo $template->description ?></td>
											                <td><?php echo $template->lang ?></td>
											                <td class="actions">
															<div class="buttons buttons-small align-center">
																<?php echo anchor('admin/email/templates/preview/' . $template->id, lang('buttons:preview'), 'class="button preview as_modal"') ?>
											                    <?php echo anchor('admin/email/templates/edit/' . $template->id, lang('buttons:edit'), 'class="button edit"') ?>
																<?php echo anchor('admin/email/templates/delete/' . $template->id, lang('buttons:delete'), 'class="button delete"') ?>
															</div>
											                </td>
											            </tr>
													<?php endif ?>
											    <?php endforeach ?>
												
												
											        </tbody>
											    </table>
											

													<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>

											
											    <?php echo form_close() ?>
			                </div>

					<?php endif ?>

	        </div>
	    </div><!-- /.col -->

</div><!-- /.row -->