
<table id="standard_data_table" class="table">

		<thead>
			<tr>
				<th style='width:20%'><?php echo lang('name_label');?></th>
				<th style='width:40%'><span><?php echo lang('desc_label');?></span></th>
				<th style='width:10%'><?php echo lang('version_label');?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($plugins as $plugin): ?>
			<tr>
				<td width="30%"><?php echo $plugin['name'] ?></td>
				<td width="60%"><?php echo $plugin['description'] ?></td>
				<td><?php echo $plugin['version'] ?></td>
				<td>
					<?php if ($plugin['self_doc']): ?>
						<button 
							type="button" 
							class="btn btn-info btn-sm" 
							data-toggle="modal" 
							data-target="#plugin-doc-<?php echo strtolower($plugin['slug']) ?>">
							<i class='fa fa-search'></i>
						</button>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>

</table>