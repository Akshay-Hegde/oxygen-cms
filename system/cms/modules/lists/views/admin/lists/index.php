<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">

                <div class="box-header">
                  <h3 class="box-title">All Lists</h3>
                </div>
                <div class="box-body">



					<?php if (!empty($lists)): ?>			
					<table class="table">
						<thead>
							<tr>
								<th><?php echo lang('lists:id');?></th>
							    <th><?php echo lang('lists:name');?></th>
							    <th><?php echo lang('lists:slug');?></th>
							    <th><?php echo lang('lists:total_entries');?></th>
							    <th></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($lists as $list):?>

						<?php
						
						// Does this table exist?
						if($this->db->table_exists($list->stream_prefix.$list->stream_slug)):
						
							$table_exists = true;
							echo '<tr>';
						
						else:

							$table_exists = false;
							echo '<tr class="inactive">';
						
						endif;
						
						?>
								<td><?php echo $list->id; ?></td>
								<td>
									<?php echo anchor('admin/lists/entries/view/' . $list->stream_slug, $list->stream_name, 'class=""');?> 
								</td>
								<td><?php echo $list->stream_slug; ?></td>
								<td>
									<?php 
										if($table_exists): 
											echo number_format($this->streams_m->count_stream_entries($list->stream_slug, $list->stream_namespace)); 
										endif; 
									?>
								</td>
								<td class="actions">
									<?php echo anchor('admin/lists/entries/view/' . $list->stream_slug, 'Select', 'class="btn btn-flat bg-olive"');?> 
									<?php if(group_has_role('lists','manage')):?>
										<?php echo anchor('admin/lists/manage/delete/' . $list->stream_slug, 'Delete', 'class="confirm btn btn-flat bg-red"');?> 
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
						
							if ( ! group_has_role('lists', 'admin_lists'))
							{
								echo lang('streams:start.no_streams_yet');
							}
							else
							{
								echo ' There are no lists yet, start by '.anchor('admin/lists/lists/create', lang('streams:start.adding_one')).'.';
							}
								
						?>
						</div>
					<?php endif;?>




			</div>
		</div>
	</div>
</div>
