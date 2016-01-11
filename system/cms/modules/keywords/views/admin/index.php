<div class="row">
		<div class='col-xs-12'>

		    <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
		    	<a class="btn btn-primary btn-block margin-bottom as_modal" href="admin/keywords/add">Add Keyword</a>
		    </div>

			<div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
				<div class="box box-solid">
				    <div class="box-header">
				      	<h3 class="box-title"><?php echo $module_details['name'] ?></h3>
				    </div> 			
			        <div class="box-body">



					<?php if ($keywords): ?>
					    <table class="table table-striped" cellspacing="0">
							<thead>
								<tr>
									<th width="40%"><?php echo lang('keywords:name');?></th>
									<th width="200"></th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="3">
										<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
									</td>
								</tr>
							</tfoot>
							<tbody>
							<?php foreach ($keywords as $keyword):?>
								<tr>
									<td><?php echo $keyword->name ?></td>
									<td class="pull-right">
										<?php echo anchor('admin/keywords/edit/'.$keyword->id, lang('global:edit'), 'class="btn btn-flat bg-blue edit"') ?>
										<?php if ( ! in_array($keyword->name, array('user', 'admin'))): ?>
											<?php echo anchor('admin/keywords/delete/'.$keyword->id, lang('global:delete'), 'class="btn btn-flat bg-red confirm delete"') ?>
										<?php endif ?>
									</td>
								</tr>
							<?php endforeach;?>
							</tbody>
					    </table>

					<?php else: ?>
						<div class="no_data"><?php echo lang('keywords:no_keywords');?></div>
					<?php endif;?>



	            	</div>
	        </div>
	    </div>
	</div>
</div>