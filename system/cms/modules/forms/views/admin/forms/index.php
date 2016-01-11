<div class="row">
	<div class="col-xs-12">



		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<a class="btn btn-primary btn-block margin-bottom" href="admin/forms/forms/create">
				<i class=''></i>	Create new Form
			</a>
	    </div>

		<div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">

        	<div class="box box-solid">
            <div class="box-header">
              	<h3 class="box-title"><?php echo $module_details['name']; ?></h3>
            </div>
        	<div class="box-body">

					<?php if (!empty($flows)): ?>			
					<table class="table">
						<thead>
							<tr>
								<th><?php echo lang('forms:id');?></th>
							    <th><?php echo lang('forms:name');?></th>
							    <th><?php echo lang('forms:slug');?></th>
							    <th><?php echo lang('forms:total_entries');?></th>
							    <th></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($flows as $flow):?>

						<?php
						
						// Does this table exist?
						if($this->db->table_exists($flow->stream_prefix.$flow->stream_slug)):
						
							$table_exists = true;
							echo '<tr>';
						
						else:

							$table_exists = false;
							echo '<tr class="inactive">';
						
						endif;
						
						?>
								<td><?php echo $flow->id; ?></td>
								<td><?php echo $flow->stream_name; ?></td>
								<td>
									<code>
										<?php echo anchor('admin/forms/forms/syntax/' . $flow->stream_slug, $flow->stream_slug, 'class="as_modal"');?> 
									</code>
								</td>
								<td>
									<?php 
										if($table_exists): 
												echo number_format($this->streams_m->count_stream_entries($flow->stream_slug, $flow->stream_namespace)); 
										endif; 
									?>
								</td>
								
								<td class="actions">
									<?php echo anchor('admin/forms/entries/view/' . $flow->stream_slug, 'Entries', 'class="btn btn-flat bg-olive"');?> 

									<?php if(group_has_role('forms','manage')):?>
										<?php echo anchor('admin/forms/forms/edit/' . $flow->id, 'Edit', 'class="btn btn-flat bg-olive"');?>
										<?php echo anchor('admin/forms/forms/delete/' . $flow->stream_slug, 'Delete', 'class="confirm btn btn-flat bg-red"');?> 
									<?php endif;?>

								</td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
					<?php echo $pagination['links']; ?>
					<?php else: ?>
						<div class="no_data">
						<?php 
						
							if ( ! group_has_role('flows', 'admin_flows'))
							{
								echo lang('streams:start.no_streams_yet');
							}
							else
							{
								echo ' There are no forms yet, start by '.anchor('admin/forms/forms/create', lang('streams:start.adding_one')).'.';
							}
								
						?>
						</div>
					<?php endif;?>
			</div>

		</div>
	</div>
</div>
