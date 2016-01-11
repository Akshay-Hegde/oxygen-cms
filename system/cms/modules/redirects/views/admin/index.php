<div class="row">
	<div class="col-xs-12">

		<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
			<a class="btn btn-primary btn-block margin-bottom" href="admin/redirects/add">
				<i class=''></i>  Add Redirect
			</a>
		</div>

	   <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">

        	<div class="box box-solid">
            <div class="box-header">
              	<h3 class="box-title"><?php echo lang('redirects:list_title') ?></h3>
            </div>
        	<div class="box-body">


				<?php if ($redirects): ?>

					<section class="item">
						<div class="content">

					    <?php echo form_open('admin/redirects/delete') ?>
					    
						<table class="table">
						    <thead>
								<tr>
									<th width="15"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
									<th width="25"><?php echo lang('redirects:type');?></th>
									<th width="25%"><?php echo lang('redirects:from');?></th>
									<th><?php echo lang('redirects:to');?></th>
									<th width="200"></th>
								</tr>
						    </thead>
							<tfoot>
								<tr>
									<td colspan="5">
										<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
									</td>
								</tr>
							</tfoot>
						    <tbody>
							<?php foreach ($redirects as $redirect): ?>
							    <tr>
								<td><?php echo form_checkbox('action_to[]', $redirect->id) ?></td>
								<td><?php echo $redirect->type;?></td>
								<td><?php echo str_replace('%', '*', $redirect->from);?></td>
								<td><?php echo $redirect->to;?></td>
								<td class="align-center">
									<div class="actions">
									    <?php echo anchor('admin/redirects/edit/' . $redirect->id, lang('redirects:edit'), 'class="btn btn-flat bg-blue edit"');?>
										<?php echo anchor('admin/redirects/delete/' . $redirect->id, lang('redirects:delete'), array('class'=>'btn btn-flat bg-red confirm delete'));?>
									</div>
								</td>
							    </tr>
							<?php endforeach ?>
						    </tbody>
						</table>
					
						<div class="table_action_buttons">
							<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
						</div>
					    <?php echo form_close() ?>
						
						</div>
					</section>

				<?php else: ?>
					<section class="item">
						<div class="content">
							<div class="no_data"><?php echo lang('redirects:no_redirects');?></div>
						</div>
					</section>
				<?php endif ?>

			</div>
		</div>
	</div>
</div>
</div>