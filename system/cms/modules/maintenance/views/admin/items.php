

<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title"><?php echo lang('maintenance:list_label') ?></h3>
            </div>
            <div class="box-body">

						<?php if ( ! empty($folders)): ?>
							 <table id="standard_data_table" class="table table-bordered">
								<thead>
									<tr>
										<th style='width:20%'><?php echo lang('name_label') ?></th>
										<th class="align-center"><?php echo lang('maintenance:count_label') ?></th>
										<th style='width:40%'></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($folders as $folder): ?>
									<tr>
										<td><?php echo $folder['name'] ?></td>
										<td class="align-center"><?php echo $folder['count'] ?></td>
										<td class="buttons buttons-small align-center actions">
											<?php if ($folder['count'] > 0) echo anchor('admin/maintenance/cleanup/'.$folder['name'], lang('global:empty'), array('class'=>'btn btn-flat bg-white')) ?>
											<?php if ( ! $folder['cannot_remove']) echo anchor('admin/maintenance/cleanup/'.$folder['name'].'/1', lang('global:remove'), array('class'=>'btn btn-flat bg-red')) ?>
										</td>
									</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						<?php else: ?>
							<div class="blank-slate">
								<h2><?php echo lang('maintenance:no_items') ?></h2>
							</div>
						<?php endif;?>
  
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Other modules</h3>
            </div>
            <div class="box-body">
						<?php if ( ! empty($extra_maintenance)): ?>
							 <table id="" class="table table-bordered">
								<thead>
									<tr>
										<th style='width:20%'>Module</th>
										<th class="align-center">Name</th>
										<th>Description</th>
										<th style='width:40%'></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($extra_maintenance as $item): ?>
									<tr>
										<td><?php echo $item['module'] ?></td>
										<td class=""><?php echo $item['name'] ?></td>
										<td class="align-center"><?php echo $item['description'] ?></td>
										<td class="buttons buttons-small align-center actions">
											<a class='btn btn-flat bg-orange' href='<?php echo $item['action'];?>'><?php echo $item['button_text']; ?></a>
										</td>
									</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						<?php else: ?>
							<div class="blank-slate">
								<h2><?php echo lang('maintenance:no_items') ?></h2>
							</div>
						<?php endif;?>
            </div>
        </div>
    </div>
</div>